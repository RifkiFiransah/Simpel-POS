<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class PaymentMethodChartWidget extends ChartWidget
{
    protected ?string $heading = 'Metode Pembayaran';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Get payment method data from current month
        $paymentMethods = Transaction::selectRaw('method, COUNT(*) as count, SUM(total) as total_amount')
            ->whereMonth('created_at', now()->month)
            ->groupBy('method')
            ->get();

        $labels = [];
        $data = [];
        $backgroundColor = [];
        
        $colors = [
            'cash' => 'rgba(34, 197, 94, 0.8)',      // Green
            'transfer' => 'rgba(59, 130, 246, 0.8)', // Blue
            'qris' => 'rgba(245, 158, 11, 0.8)',     // Amber
            'debit' => 'rgba(99, 102, 241, 0.8)',    // Indigo
        ];

        foreach ($paymentMethods as $method) {
            $labels[] = ucfirst($method->method);
            $data[] = $method->total_amount;
            $backgroundColor[] = $colors[$method->method] ?? 'rgba(156, 163, 175, 0.8)';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan (Rp)',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => array_map(function($color) {
                        return str_replace('0.8', '1', $color);
                    }, $backgroundColor),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
