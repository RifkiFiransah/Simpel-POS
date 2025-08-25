<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\User;

class QuickExportWidget extends Widget
{
    protected string $view = 'filament.widgets.quick-export-widget';
    
    protected static ?int $sort = 8;
    
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $stats = [
            'total' => Transaction::count(),
            'today' => Transaction::whereDate('created_at', today())->count(),
            'week' => Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month' => Transaction::whereMonth('created_at', now()->month)->count(),
            'revenue' => Transaction::sum('total'),
            
            // Master data counts
            'products' => Product::count(),
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'categories' => Category::count(),
            'users' => User::count(),
        ];
        
        return compact('stats');
    }
}
