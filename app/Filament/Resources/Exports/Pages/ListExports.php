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
            Actions\Action::make('stats')
                ->label('📊 Data Statistics')
                ->color('info')
                ->modalContent(fn () => view('filament.modals.export-stats', [
                    'totalTransactions' => Transaction::count(),
                    'totalRevenue' => Transaction::sum('total'),
                    'thisMonth' => Transaction::whereMonth('created_at', now()->month)->count(),
                    'thisWeek' => Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                    'totalProducts' => Product::count(),
                    'totalCustomers' => Customer::count(),
                    'totalSuppliers' => Supplier::count(),
                    'totalUsers' => User::count(),
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->whereRaw('1 = 0')) // Empty query
            ->columns([])
            ->actions([])
            ->bulkActions([])
            ->emptyStateIcon('heroicon-o-document-arrow-down')
            ->emptyStateHeading('Export Data Center')
            ->emptyStateDescription('')
            ->emptyStateActions([
                // Transaction Export Cards
                Actions\Action::make('transactions_excel_card')
                    ->label('📊 Export Transactions (Excel)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-lg bg-green-50 hover:bg-green-100 border-2 border-green-200 text-green-800 rounded-xl p-6 min-w-[300px]'
                    ])
                    ->size('lg')
                    ->url(fn () => route('export.transactions.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('transactions_pdf_card')
                    ->label('📄 Export Transactions (PDF)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-lg bg-red-50 hover:bg-red-100 border-2 border-red-200 text-red-800 rounded-xl p-6 min-w-[300px]'
                    ])
                    ->size('lg')
                    ->url(fn () => route('export.transactions.pdf'))
                    ->openUrlInNewTab(),
                    
                // Master Data Export Cards
                Actions\Action::make('products_card')
                    ->label('📦 Export Products (' . Product::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-orange-50 hover:bg-orange-100 border-2 border-orange-200 text-orange-800 rounded-lg p-4 min-w-[240px]'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.products.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('customers_card')
                    ->label('👥 Export Customers (' . Customer::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 text-blue-800 rounded-lg p-4 min-w-[240px]'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.customers.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('suppliers_card')
                    ->label('🏢 Export Suppliers (' . Supplier::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-purple-50 hover:bg-purple-100 border-2 border-purple-200 text-purple-800 rounded-lg p-4 min-w-[240px]'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.suppliers.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('categories_card')
                    ->label('🏷️ Export Categories (' . Category::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-yellow-50 hover:bg-yellow-100 border-2 border-yellow-200 text-yellow-800 rounded-lg p-4 min-w-[240px]'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.categories.excel'))
                    ->openUrlInNewTab(),
                    
                Actions\Action::make('users_card')
                    ->label('👤 Export Users (' . User::count() . ' items)')
                    ->extraAttributes([
                        'class' => 'fi-btn-size-md bg-gray-50 hover:bg-gray-100 border-2 border-gray-200 text-gray-800 rounded-lg p-4 min-w-[240px]'
                    ])
                    ->size('md')
                    ->url(fn () => route('export.users.excel'))
                    ->openUrlInNewTab(),
            ]);
    }
}
