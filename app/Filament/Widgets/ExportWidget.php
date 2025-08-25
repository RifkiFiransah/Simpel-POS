<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Transaction;

class ExportWidget extends Widget
{
    protected string $view = 'filament.widgets.export-widget';
    
    protected static ?int $sort = 7;

    public function getViewData(): array
    {
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total');
        $lastWeekTransactions = Transaction::where('created_at', '>=', now()->subWeek())->count();
        
        return [
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'lastWeekTransactions' => $lastWeekTransactions,
        ];
    }
}
