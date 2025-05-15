<x-filament-panels::page>
    <div class="mb-4">
        <h2 class="text-xl font-bold text-white">
            Agenda Rapat: {{ \App\Models\Rapat::find($record)->agenda_rapat }}
        </h2>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
