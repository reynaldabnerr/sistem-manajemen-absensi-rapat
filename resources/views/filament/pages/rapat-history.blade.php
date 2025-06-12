<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Riwayat Rapat
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Daftar rapat yang sudah berlalu. Anda dapat melihat kehadiran dan mengekspor daftar hadir.
            </p>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>