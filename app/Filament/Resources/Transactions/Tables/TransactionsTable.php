<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Models\Transaction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Walk-in Customer'),

                TextColumn::make('user.name')
                    ->label('Cashier')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->badge()
                    ->color('info'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
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
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (Transaction $record): string => route('invoice.print', $record))
                    ->openUrlInNewTab(),
                Action::make('download_pdf')
                    ->label('Unduh')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->url(fn (Transaction $record): string => route('invoice.pdf', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
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
