<?php

namespace App\Filament\Resources\Exports\Pages;

use App\Filament\Resources\Exports\ExportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables;

class ListExports extends ListRecords
{
    protected static string $resource = ExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('stats')
            //     ->label('Data Statistics')
            //     ->color('info')
            //     ->icon('heroicon-o-chart-bar')
            //     ->modal()
            //     ->modalHeading('System Statistics & Analytics')
            //     ->modalDescription('Overview of your POS system data and performance metrics')
            //     ->modalContent(function () {
            //         $totalTransactions = Transaction::count();
            //         $totalRevenue = Transaction::sum('total') ?? 0;
            //         $thisMonth = Transaction::whereMonth('created_at', now()->month)
            //             ->whereYear('created_at', now()->year)
            //             ->count();
            //         $thisWeek = Transaction::whereBetween('created_at', [
            //             now()->startOfWeek(), 
            //             now()->endOfWeek()
            //         ])->count();
                    
            //         return view('filament.modals.export-stats', [
            //             'totalTransactions' => $totalTransactions,
            //             'totalRevenue' => $totalRevenue,
            //             'thisMonth' => $thisMonth,
            //             'thisWeek' => $thisWeek,
            //             'totalProducts' => Product::count(),
            //             'totalCustomers' => Customer::count(),
            //             'totalSuppliers' => Supplier::count(),
            //             'totalUsers' => User::count(),
            //         ]);
            //     })
            //     ->modalSubmitAction(false)
            //     ->modalCancelActionLabel('Close')
            //     ->modalWidth('7xl'),

            // Actions\Action::make('quick_excel')
            //     ->label('Excel Export')
            //     ->color('success')
            //     ->icon('heroicon-o-document-arrow-down')
            //     ->url(fn () => route('export.transactions.excel'))
            //     ->openUrlInNewTab(),

            // Actions\Action::make('quick_pdf')
                // ->label('PDF Export')
                // ->color('danger')
                // ->icon('heroicon-o-document-text')
                // ->url(fn () => route('export.transactions.pdf'))
                // ->openUrlInNewTab(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->whereRaw('1 = 0'))
            ->columns([])
            ->emptyStateIcon('heroicon-o-document-arrow-down')
            ->emptyStateHeading('Export Data Center')
            ->emptyStateDescription('Choose from the options below to export your data in various formats')
            ->emptyStateActions([
                // Transaction Export Cards (Large)
                Actions\Action::make('transactions_excel_card')
                    ->label('📊 Export All Transactions (Excel)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-lg bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 border-2 border-green-200 text-green-800 rounded-xl p-6 min-w-[320px] shadow-lg hover:shadow-xl transition-all duration-200'
                    ])
                    ->size('lg')
                    ->url(fn () => route('export.transactions.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('transactions_pdf_card')
                    ->label('📄 Export All Transactions (PDF)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-lg bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 border-2 border-red-200 text-red-800 rounded-xl p-6 min-w-[320px] shadow-lg hover:shadow-xl transition-all duration-200'
                    ])
                    ->size('lg')
                    ->url(fn () => route('export.transactions.pdf'))
                    ->openUrlInNewTab(),

                // Purchase Export Cards (Medium)
                Actions\Action::make('purchases_excel_card')
                    ->label('🛒 Export Purchases (Excel)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 border-2 border-indigo-200 text-indigo-800 rounded-lg p-4 min-w-[260px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.purchases.excel'))
                    ->openUrlInNewTab(),

                Actions\Action::make('purchases_pdf_card')
                    ->label('📋 Export Purchases (PDF)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200 border-2 border-pink-200 text-pink-800 rounded-lg p-4 min-w-[260px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.purchases.pdf'))
                    ->openUrlInNewTab(),

                // Master Data Export Cards
                Actions\Action::make('products_card')
                    ->label('📦 Products (' . Product::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 border-2 border-orange-200 text-orange-800 rounded-lg p-4 min-w-[240px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.products.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('customers_card')
                    ->label('👥 Customers (' . Customer::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200 text-blue-800 rounded-lg p-4 min-w-[240px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.customers.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('suppliers_card')
                    ->label('🏢 Suppliers (' . Supplier::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border-2 border-purple-200 text-purple-800 rounded-lg p-4 min-w-[240px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.suppliers.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('categories_card')
                    ->label('🏷️ Categories (' . Category::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-yellow-50 to-yellow-100 hover:from-yellow-100 hover:to-yellow-200 border-2 border-yellow-200 text-yellow-800 rounded-lg p-4 min-w-[240px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.categories.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('users_card')
                    ->label('👤 Users (' . User::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border-2 border-gray-200 text-gray-800 rounded-lg p-4 min-w-[240px] shadow-md hover:shadow-lg transition-all duration-200'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.users.excel'))
                    ->openUrlInNewTab(),
            ]);
    }
}