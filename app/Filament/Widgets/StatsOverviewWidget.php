<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Today's data
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();
        
        // This month's data
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        // Calculate stats
        $todaySales = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])->sum('total');
        $todayTransactions = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])->count();
        
        $monthSales = Transaction::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total');
        $monthTransactions = Transaction::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        
        $totalProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('is_active', true)->where('stock', '<=', 10)->count();
        
        $totalCustomers = Customer::count();
        
        // Calculate trends (compare with previous period)
        $yesterdaySales = Transaction::whereBetween('created_at', [
            Carbon::yesterday(),
            $todayStart
        ])->sum('total');
        
        $lastMonthSales = Transaction::whereBetween('created_at', [
            $monthStart->copy()->subMonth(),
            $monthStart
        ])->sum('total');
        
        // Calculate percentage changes
        $todayTrend = $yesterdaySales > 0 ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 : 0;
        $monthTrend = $lastMonthSales > 0 ? (($monthSales - $lastMonthSales) / $lastMonthSales) * 100 : 0;

        return [
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description($todayTrend >= 0 ? 'Naik ' . number_format(abs($todayTrend), 1) . '% dari kemarin' : 'Turun ' . number_format(abs($todayTrend), 1) . '% dari kemarin')
                ->descriptionIcon($todayTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($todayTrend >= 0 ? 'success' : 'danger')
                ->chart($this->getDailySalesChart()),

            Stat::make('Transaksi Hari Ini', $todayTransactions)
                ->description($todayTransactions . ' transaksi selesai')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($monthSales, 0, ',', '.'))
                ->description($monthTrend >= 0 ? 'Naik ' . number_format(abs($monthTrend), 1) . '% dari bulan lalu' : 'Turun ' . number_format(abs($monthTrend), 1) . '% dari bulan lalu')
                ->descriptionIcon($monthTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthTrend >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlySalesChart()),

            Stat::make('Produk Aktif', $totalProducts)
                ->description($lowStockProducts . ' produk stok rendah')
                ->descriptionIcon('heroicon-m-cube')
                ->color($lowStockProducts > 0 ? 'warning' : 'success'),

            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('Pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Transaksi Bulan Ini', $monthTransactions)
                ->description('Total transaksi bulan ini')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('secondary'),
        ];
    }

    private function getDailySalesChart(): array
    {
        // Get last 7 days sales data
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Transaction::whereDate('created_at', $date)->sum('total');
            $data[] = $sales;
        }
        
        return $data;
    }

    private function getMonthlySalesChart(): array
    {
        // Get last 12 months sales data
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $sales = Transaction::whereYear('created_at', $month->year)
                              ->whereMonth('created_at', $month->month)
                              ->sum('total');
            $data[] = $sales / 1000000; // Convert to millions for better chart display
        }
        
        return $data;
    }

    protected static ?int $sort = 1;
}
