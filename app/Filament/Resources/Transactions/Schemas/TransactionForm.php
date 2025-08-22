<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Customer;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Transaction Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                ComponentsGrid::make(4)
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Product')
                                            ->options(Product::where('is_active', true)->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if ($state) {
                                                    $product = Product::find($state);
                                                    $set('price', $product?->price ?? 0);
                                                    $quantity = $get('quantity') ?? 1;
                                                    $set('subtotal', ($product?->price ?? 0) * $quantity);
                                                }
                                            }),

                                        TextInput::make('quantity')
                                            ->label('Quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                $price = $get('price') ?? 0;
                                                $set('subtotal', $price * $state);
                                            }),


                                        TextInput::make('price')
                                            ->label('Price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                                $quantity = $get('quantity') ?? 1;
                                                $set('subtotal', $state * $quantity);
                                            }),

                                        TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->disabled()
                                            ->dehydrated(true),
                                    ]),
                            ])
                            ->columns(1)
                            ->addActionLabel('Add Product')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->cloneable()
                            ->minItems(1)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                // Calculate total when items change
                                $total = 0;
                                if (is_array($state)) {
                                    foreach ($state as $item) {
                                        $total += ($item['subtotal'] ?? 0);
                                    }
                                }
                                $set('total', $total);
                                $payment = $get('payment') ?? 0;
                                $set('change', $payment - $total);
                            }),
                    ])
                    ->columnSpanFull(),

                ComponentsSection::make('Payment Information')
                    ->schema([
                        ComponentsGrid::make(3)
                            ->schema([
                                Select::make('method')
                                    ->label('Payment Method')
                                    ->options([
                                        'cash' => 'Cash',
                                        'transfer' => 'Bank Transfer',
                                        'qris' => 'QRIS',
                                        'debit' => 'Debit Card',
                                    ])
                                    ->default('cash')
                                    ->required(),

                                TextInput::make('payment')
                                    ->label('Payment Amount')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $total = $get('total') ?? 0;
                                        $set('change', $state - $total);
                                    }),

                                TextInput::make('change')
                                    ->label('Change')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(true),
                            ]),

                        TextInput::make('total')
                            ->label('Total Amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $payment = $get('payment') ?? 0;
                                $set('change', $payment - $state);
                            }),
                    ]),
                    
                ComponentsSection::make('Transaction Information')
                    ->schema([
                        ComponentsGrid::make(2)
                            ->schema([
                                TextInput::make('invoice_number')
                                    ->label('Invoice Number')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Auto Generated'),

                                Select::make('customer_id')
                                    ->label('Customer')
                                    ->options(Customer::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                            ]),
                    ]),
            ]);
    }
}
