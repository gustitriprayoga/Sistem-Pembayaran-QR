<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = now()->format('Y-m-d');

        $pendapatanHariIni = Pesanan::whereDate('created_at', $today)
            ->where('status_bayar', 'lunas')
            ->sum('total_bayar');

        $pesananHariIni = Pesanan::whereDate('created_at', $today)->count();

        $pesananBaru = Pesanan::where('status_pesanan', 'baru')->count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni))
                ->description('Total pendapatan yang sudah lunas')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),
            Stat::make('Total Pesanan Hari Ini', $pesananHariIni)
                ->description('Semua pesanan yang masuk hari ini')
                ->color('primary')
                ->icon('heroicon-o-shopping-cart'),
            Stat::make('Pesanan Baru Perlu Diproses', $pesananBaru)
                ->description('Pesanan yang menunggu untuk dibuat')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}
