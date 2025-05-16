<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Rapat;
use Carbon\Carbon;

class TotalRapatWidget extends ChartWidget
{
    protected static ?string $heading = 'Statistik Rapat';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($days) {
            return [
                'date' => Carbon::now()->subDays($days)->format('d M'),
                'total' => Rapat::whereDate('tanggal_rapat', Carbon::now()->subDays($days))->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Rapat',
                    'data' => $data->pluck('total')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
