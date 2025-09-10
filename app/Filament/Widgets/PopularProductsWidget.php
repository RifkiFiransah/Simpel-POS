<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\TransactionItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PopularProductsWidget extends BaseWidget
{
    protected static ?string $heading = 'Produk Terpopuler';
    
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->select('products.*')
                    ->selectRaw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold')
                    ->selectRaw('COALESCE(SUM(transaction_items.subtotal), 0) as total_revenue')
                    ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
                    ->leftJoin('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                    ->whereNull('transactions.deleted_at')
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->width(40)
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('success')
                    ->default('Tanpa Kategori'),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state <= 5 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),
                    
                Tables\Columns\TextColumn::make('total_sold')
                    ->label('Terjual')
                    ->badge()
                    ->color('info')
                    ->suffix(' pcs')
                    ->default(0),
                    
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Total Pendapatan')
                    ->money('IDR')
                    ->color('success')
                    ->weight('bold')
                    ->default(0),
            ])
            ->defaultSort('total_sold', 'desc')
            ->paginated(false);
    }
}
