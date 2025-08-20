<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier Information')
                    ->description('Masukan informasi supplier')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Supplier')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('email')
                            ->label('Email')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->required(),

                        TextInput::make('phone')
                            ->label('Telepon')
                            ->maxLength(15)
                            ->numeric()
                            ->required(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(),
                    ]),

                Section::make('Media & Status')
                    ->description('Pengaturan media dan status supplier')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar')
                            ->disk('public')
                            ->directory('suppliers')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Tandai jika supplier aktif')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
