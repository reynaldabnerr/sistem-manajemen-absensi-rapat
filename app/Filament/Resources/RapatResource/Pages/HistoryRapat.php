<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use Filament\Resources\Pages\Page; // Pastikan menggunakan Page, bukan ListRecords atau lainnya

class HistoryRapat extends Page
{
    protected static string $resource = RapatResource::class;

    protected static string $view = 'filament.resources.rapat-resource.pages.history-rapat';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box'; // Ganti ikon sesuai keinginan
    protected static ?string $navigationLabel = 'History Rapat';

    // Anda juga bisa set secara eksplisit: protected static ?string $navigationGroup = 'Manajemen Rapat';
    protected static ?int $navigationSort = 2; // Urutan setelah daftar Rapat utama

    protected ?string $heading = 'History Rapat yang Telah Terlaksana'; // Judul halaman

    // Jika Anda memerlukan widget header tambahan di halaman ini (opsional)
    protected function getHeaderWidgets(): array
    {
        return [
            // Daftarkan widget header di sini
        ];
    }
}
