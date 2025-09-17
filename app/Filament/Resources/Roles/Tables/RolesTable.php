<?php

namespace App\Filament\Resources\Roles\Tables;

use App\Models\Role;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('System Name')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'manajer' => 'success',
                        'kasir' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('-'),

                TextColumn::make('users_count')
                    ->label('Users Count')
                    ->sortable()
                    ->counts('users')
                    ->badge()
                    ->color('info'),

                TextColumn::make('permissions_count')
                    ->label('Total Permissions')
                    ->formatStateUsing(function ($state) {
                       return count($state ?? []) . ' permissions';
                    })
                    ->badge()
                    ->color('success'),
                
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Role $record): string => 'Detail Role: ' . $record->display_name)
                    ->modalContent(fn (Role $record) => view('filament.resources.roles.view', ['role' => $record])),

                EditAction::make(),

                DeleteAction::make()
                    ->before(function (Role $record) {
                        if ($record->users()->count() > 0) {
                            throw new \Exception('Tidak dapat menghapus role yang masih memiliki user.');
                        }
                        if (in_array($record->name, ['admin', 'kasir', 'manajer'])) {
                            throw new \Exception('Role default tidak dapat dihapus.');
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach($records as $record) {
                                if($record->users()->count() > 0) {
                                    throw new \Exception('Tidak dapat menghapus role yang masih memiliki user.');
                                }
                                if (in_array($record->name, ['admin', 'kasir', 'manajer'])) {
                                    throw new \Exception('Role default tidak dapat dihapus.');
                                }
                            }
                        }),
                ]),
            ]);
    }
}
