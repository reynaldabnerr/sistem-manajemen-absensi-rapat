<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Charts\Chart;  // Ensure Chart is imported
use App\Models\Rapat;

class TotalRapatWidget extends ChartWidget
{
    protected static ?string $heading = 'Total Rapat';

    protected function getData(): array
    {
        // Get total count of rapat
        $totalRapat = \App\Models\Rapat::count();

        // Here we're creating the chart data in a format that Filament expects
        return [
            'labels' => ['Total Rapat'],  // The label for the bar chart
            'datasets' => [
                [
                    'label' => 'Jumlah Rapat',  // Name of the dataset (this is the label that appears on the chart)
                    'data' => [$totalRapat],  // Data to display in the chart
                    'backgroundColor' => '#4caf50',  // Background color for the bar
                    'borderColor' => '#388e3c',  // Border color for the bar
                    'borderWidth' => 1,  // Border width of the bar
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';  // Specifying that the chart type is 'bar'
    }
}
