<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -5;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Stok Barang', \App\Models\Barang::sum('stok') ?? 0)
                ->description('Keseluruhan stok sepatu di toko')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success'),
            Stat::make('Total Pendapatan', 'Rp ' . number_format(\App\Models\Transaksi::sum('total_harga') ?? 0, 0, ',', '.'))
                ->description('Dari ' . \App\Models\Transaksi::count() . ' transaksi penjualan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),
            Stat::make('Total Pengeluaran', 'Rp ' . number_format(\App\Models\Pembelian::sum('total_harga') ?? 0, 0, ',', '.'))
                ->description('Dari ' . \App\Models\Pembelian::count() . ' transaksi restock')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
            Stat::make('Total Pelanggan', \App\Models\Pelanggan::count())
                ->description('Pelanggan yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
