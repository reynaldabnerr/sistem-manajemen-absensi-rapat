@php
    use Illuminate\Support\Facades\Route;

    $isLoginPage = str_contains(Route::currentRouteName(), 'login');
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = $isLoginPage ? '4rem' : '2.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'flex' => ! $hasDarkModeBrandLogo,
        'flex dark:hidden' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'hidden dark:flex' => $hasDarkModeBrandLogo && $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
        <div
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}
        >
            {{ $logo }}
        </div>
    @elseif (filled($logo))
        <img
            alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
            src="{{ $logo }}"
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}
        />
    @else
        <div
            {{
                $attributes->class([
                    $getLogoClasses($isDarkMode),
                    'text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
                ])
            }}
        >
            {{ $brandName }}
        </div>
    @endif
@endcapture

@if ($isLoginPage)
    {{-- Logo untuk halaman LOGIN --}}
    {{ $content($brandLogo) }}

    @if ($hasDarkModeBrandLogo)
        {{ $content($darkModeBrandLogo, isDarkMode: true) }}
    @endif
@else
    {{-- Logo untuk halaman DASHBOARD --}}
    <div class="flex items-center gap-3">
        {{ $content($brandLogo) }}
        <span class="text-sm sm:text-base font-semibold tracking-wide text-gray-900 dark:text-white">
            MANAJEMEN RAPAT UNHAS
        </span>
    </div>

    @if ($hasDarkModeBrandLogo)
        <div class="flex items-center gap-3 hidden dark:flex">
            {{ $content($darkModeBrandLogo, isDarkMode: true) }}
            <span class="text-sm sm:text-base font-semibold tracking-wide text-white">
                MANAJEMEN RAPAT UNHAS
            </span>
        </div>
    @endif
@endif


