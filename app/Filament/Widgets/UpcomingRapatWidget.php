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
    protected function getStats(): array
{
    $totalRapat = Rapat::count();
    $upcomingRapatCount = Rapat::where('tanggal_rapat', '>=', Carbon::today())->count();
    $completedRapatCount = Rapat::where('tanggal_rapat', '<', Carbon::today())->count();

    return [
        Stat::make('Total Rapat', $totalRapat)
            ->description('All meetings')
            ->icon('heroicon-o-calendar')
            ->color('primary'),
        Stat::make('Upcoming Rapat', $upcomingRapatCount)
            ->description('Meetings scheduled for today or in the future')
            ->icon('heroicon-o-calendar')
            ->color('success'),
        Stat::make('Completed Rapat', $completedRapatCount)
            ->description('Meetings that have already occurred')
            ->icon('heroicon-o-check-circle')
            ->color('danger'),
    ];
}

}
