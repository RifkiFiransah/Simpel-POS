<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shop_name')
                                    ->label('Store Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('shop_phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(50),
                            ]),
                        Textarea::make('shop_address')
                            ->label('Store Address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shop_email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('shop_website')
                                    ->label('Website')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Branding')
                    ->schema([
                        FileUpload::make('shop_logo')
                            ->label('Store Logo')
                            ->image()
                            ->directory('shop-logos')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ]),

                Section::make('Business Settings')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('tax_number')
                                    ->label('Tax Number / NPWP')
                                    ->maxLength(255),
                                TextInput::make('tax_percentage')
                                    ->label('Tax Percentage (%)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Select::make('currency')
                                    ->label('Currency')
                                    ->options([
                                        'IDR' => 'Indonesian Rupiah (IDR)',
                                        'USD' => 'US Dollar (USD)',
                                        'EUR' => 'Euro (EUR)',
                                        'SGD' => 'Singapore Dollar (SGD)',
                                        'MYR' => 'Malaysian Ringgit (MYR)',
                                    ])
                                    ->default('IDR')
                                    ->required(),
                                Select::make('timezone')
                                    ->label('Timezone')
                                    ->options([
                                        'Asia/Jakarta' => 'Asia/Jakarta (WIB)',
                                        'Asia/Makassar' => 'Asia/Makassar (WITA)',
                                        'Asia/Jayapura' => 'Asia/Jayapura (WIT)',
                                    ])
                                    ->default('Asia/Jakarta')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Invoice Settings')
                    ->schema([
                        Textarea::make('invoice_footer')
                            ->label('Invoice Footer Text')
                            ->placeholder('Thank you for your business!')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
