<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\Role;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Role')
                    ->description('Atur nama dan deskripsi role')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Role (Sistem)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('admin, kasir, manajer')
                                    ->helperText('Huruf kecil, tanpa spasi. Digunakan sistem internal.')
                                    ->disabled(fn(?Role $record) => $record && in_array($record->name, ['admin', 'kasir', 'manajer'])),

                                TextInput::make('display_name')
                                    ->label('Nama Tampilan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Administrator, Kasir, Manajer')
                                    ->helperText('Nama yang ditampilkan ke user.'),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('Jelaskan tanggung jawab role ini...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Hak Akses (Permissions)')
                    ->description('Pilih hak akses yang dimiliki role ini')
                    ->schema([
                        Tabs::make('Permission Groups')
                            ->tabs([
                                Tab::make('Dashboard & Transaksi')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->label('Dashboard & Analytics')
                                            ->options(Role::PERMISSIONS['Dashboard & Analytics'])
                                            ->columns(2)
                                            ->gridDirection('row'),

                                        CheckboxList::make('permissions')
                                            ->label('Transaksi Penjualan')
                                            ->options(Role::PERMISSIONS['Transaksi Penjualan'])
                                            ->columns(2)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Produk & Kategori')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->label('Manajemen Produk')
                                            ->options(Role::PERMISSIONS['Manajemen Produk'])
                                            ->columns(2)
                                            ->gridDirection('row'),

                                        CheckboxList::make('permissions')
                                            ->label('Kategori Produk')
                                            ->options(Role::PERMISSIONS['Kategori Produk'])
                                            ->columns(2)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Customer & Supplier')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->label('Manajemen Customer')
                                            ->options(Role::PERMISSIONS['Manajemen Customer'])
                                            ->columns(2)
                                            ->gridDirection('row'),

                                        CheckboxList::make('permissions')
                                            ->label('Manajemen Supplier')
                                            ->options(Role::PERMISSIONS['Manajemen Supplier'])
                                            ->columns(2)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Pembelian & Laporan')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->label('Pembelian & Procurement')
                                            ->options(Role::PERMISSIONS['Pembelian & Procurement'])
                                            ->columns(2)
                                            ->gridDirection('row'),

                                        CheckboxList::make('permissions')
                                            ->label('Laporan & Export')
                                            ->options(Role::PERMISSIONS['Laporan & Export'])
                                            ->columns(2)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('User & Sistem')
                                    ->schema([
                                        CheckboxList::make('permissions')
                                            ->label('Pilih Hak Akses')
                                            ->options(self::getAllPermissionsGrouped())
                                            ->columns(1)
                                            ->searchable()
                                            ->bulkToggleable()
                                            ->gridDirection('row'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    private static function getAllPermissionsGrouped(): array
    {
        $grouped = [];

        foreach (Role::PERMISSIONS as $group => $permissions) {
            foreach ($permissions as $key => $label) {
                $grouped["--- {$group} ---"] = "--- {$group} ---";
                $grouped = array_merge($grouped, $permissions);
                break; // Only add group header once
            }
        }

        // Remove duplicate group headers and flatten
        $result = [];
        $currentGroup = null;

        foreach (Role::PERMISSIONS as $group => $permissions) {
            $result["group_header_{$group}"] = "=== {$group} ===";
            foreach ($permissions as $key => $label) {
                $result[$key] = "   {$label}";
            }
        }

        return $result;
    }
}
