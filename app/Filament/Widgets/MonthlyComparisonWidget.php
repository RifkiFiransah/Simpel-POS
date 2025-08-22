<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class MonthlyComparisonWidget extends ChartWidget
{
    protected ?string $heading = 'Perbandingan Penjualan Bulanan';
    
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        $months = [];
        $currentYearData = [];
        $lastYearData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $months[] = Carbon::create($currentYear, $month, 1)->format('M');
            
            // Current year data
            $currentSales = Transaction::whereYear('created_at', $currentYear)
                                    ->whereMonth('created_at', $month)
                                    ->sum('total');
            $currentYearData[] = $currentSales;
            
            // Last year data
            $lastSales = Transaction::whereYear('created_at', $lastYear)
                                  ->whereMonth('created_at', $month)
                                  ->sum('total');
            $lastYearData[] = $lastSales;
        }

        return [
            'datasets' => [
                [
                    'label' => $currentYear,
                    'data' => $currentYearData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 3,
                    'fill' => false,
                    'tension' => 0.4,
                ],
                [
                    'label' => $lastYear,
                    'data' => $lastYearData,
                    'backgroundColor' => 'rgba(156, 163, 175, 0.1)',
                    'borderColor' => 'rgb(156, 163, 175)',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4,
                    'borderDash' => [5, 5],
                ],
            ],
            'labels' => $months,
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
                    'display' => true,
                    'position' => 'top',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Perbandingan penjualan tahun ini dengan tahun lalu',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return 'Rp ' + (value/1000000).toFixed(1) + 'M'; }",
                    ],
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
        ];
    }
}
