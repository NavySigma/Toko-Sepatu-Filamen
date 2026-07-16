<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class StokMerekChart extends ChartWidget
{
    protected ?string $heading = 'Persentase Stok per Merek';
    protected static ?int $sort = -3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $merks = \App\Models\Merk::withSum('barangs', 'stok')->get();

        $labels = $merks->pluck('nama')->toArray();
        $data = $merks->pluck('barangs_sum_stok')->map(fn($v) => $v ?? 0)->toArray();
        
        $backgroundColors = [
            '#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Total Stok',
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColors, 0, max(count($data), 1)), // max ensures no error if 0 data
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
