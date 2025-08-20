<?php

namespace App\Filament\Resources\Customers\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sosial_media')
                    ->label('Media Sosial')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    ForceDeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    RestoreBulkAction::make()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
