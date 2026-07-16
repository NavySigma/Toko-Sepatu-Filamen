<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PenjualanChart extends ChartWidget
{
    protected int | string | array $columnSpan = 1;
    protected ?string $heading = 'Grafik Arus Kas (6 Bulan Terakhir)';
    protected static ?int $sort = -4; // Make it appear below the stats but above defaults

    protected function getData(): array
    {
        $penjualanData = [];
        $pembelianData = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');
            
            $penjualanData[] = \App\Models\Transaksi::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_harga') ?? 0;
                
            $pembelianData[] = \App\Models\Pembelian::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_harga') ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Penjualan)',
                    'data' => $penjualanData,
                    'borderColor' => '#10b981', // emerald-500
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Pengeluaran (Pembelian)',
                    'data' => $pembelianData,
                    'borderColor' => '#f59e0b', // amber-500
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
