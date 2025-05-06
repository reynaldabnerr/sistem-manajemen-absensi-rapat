<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard as FilamentDashboard;
use App\Filament\Widgets\TotalRapatWidget;   // Pastikan widget ini ada
use App\Filament\Widgets\UpcomingRapatWidget;  // Pastikan widget ini ada
use App\Filament\Widgets\RecentRapatWidget;   // Pastikan widget ini ada

class Dashboard extends FilamentDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'Dashboard';
    
    protected static ?int $navigationSort = 1;
    
    protected static string $view = 'filament.pages.dashboard';
    
    // Menambahkan badge (opsional)
    public static function getNavigationBadge(): ?string
    {
        // Jika Anda ingin menambahkan badge, misalnya untuk menampilkan jumlah notifikasi
        return '3';  // Contoh jika ada 3 notifikasi
    }
    
    // Widget Header untuk Dashboard
    protected function getHeaderWidgets(): array
    {
        return [
            TotalRapatWidget::class,   // Widget untuk menampilkan total rapat
            UpcomingRapatWidget::class, // Widget untuk rapat yang akan datang
            RecentRapatWidget::class,  // Widget untuk rapat terbaru
        ];
    }
}
