<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Rapat;
use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;

class UpcomingRapatWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $nextWeek = Carbon::today()->addWeek();

        $totalRapat = Rapat::count();
        $todayRapatCount = Rapat::whereDate('tanggal_rapat', $today)->count();
        $tomorrowRapatCount = Rapat::whereDate('tanggal_rapat', $tomorrow)->count();
        $nextWeekRapatCount = Rapat::whereBetween('tanggal_rapat', [$tomorrow, $nextWeek])->count();

        return [
            Stat::make('Rapat Hari Ini', $todayRapatCount)
                ->description('Jadwal rapat untuk hari ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Rapat Besok', $tomorrowRapatCount)
                ->description('Jadwal rapat untuk besok')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->chart([3, 5, 3, 4, 5, 6, 3, 5])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Rapat Minggu Ini', $nextWeekRapatCount)
                ->description('Jadwal rapat dalam seminggu ke depan')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info')
                ->chart([5, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }
}
