<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Information Customer')
                    ->label('Customer Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Customer')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('phone')
                            ->label('No. Telepon')
                            ->maxLength(15)
                            ->numeric()
                            ->required(),
                        TextInput::make('sosial_media')
                            ->label('Media Sosial')
                            ->maxLength(100),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->maxLength(255)
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
