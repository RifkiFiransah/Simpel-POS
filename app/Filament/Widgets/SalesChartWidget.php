<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Penjualan';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get current month's daily sales
        $currentMonth = Carbon::now();
        $daysInMonth = $currentMonth->daysInMonth;
        
        $dailySales = [];
        $labels = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($currentMonth->year, $currentMonth->month, $day);
            $sales = Transaction::whereDate('created_at', $date)->sum('total');
            
            $dailySales[] = $sales;
            $labels[] = $day;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Harian (Rp)',
                    'data' => $dailySales,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
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
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }",
                    ],
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
            'tooltips' => [
                'callbacks' => [
                    'label' => "function(context) { return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID'); }",
                ],
            ],
        ];
    }
}
