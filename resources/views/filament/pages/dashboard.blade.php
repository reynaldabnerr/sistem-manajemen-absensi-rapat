<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Welcome Section --}}
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Selamat Datang di Sistem Manajemen Absensi Rapat
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Pantau dan kelola rapat Anda dengan mudah melalui dashboard ini.
            </p>
        </div>

        {{-- Widgets Section --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="lg:col-span-2">
                {{ $this->table }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
