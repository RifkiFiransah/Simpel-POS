<?php

namespace App\Filament\Resources\Purchases\Tables;

use App\Filament\Resources\Purchases\PurchaseResource;
use App\Models\Purchase;
use App\Traits\HasResourcePermissions;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PurchasesTable
{
    use HasResourcePermissions;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->sortable()
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Manajer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('items_count')
                    ->label('Jumlah')
                    ->sortable()
                    ->searchable()
                    ->counts('items')
                    ->badge()
                    ->color('success'),

                TextColumn::make('total')
                    ->label('Total Amount')
                    ->money('IDR')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('method')
                    ->label('Payment Method')
                    ->badge()
                    ->colors([
                        'success' => 'cash',
                        'primary' => 'transfer',
                        'warning' => 'qris',
                        'info' => 'debit',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('print_invoice')
                    ->label('Print')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Purchase $record) : string => route('invoice.purchase.print', $record))
                    ->openUrlInNewTab(),
                Action::make('download_invoice')
                    ->label('Download')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Purchase $record) : string => route('invoice.purchase.pdf', $record))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->visible(fn($record) => PurchaseResource::canEdit($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
