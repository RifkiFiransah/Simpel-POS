<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Models\Product;
use App\Models\Supplier;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PurchaseForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('Purchase Items')
          ->schema([
            Repeater::make('items')
              ->relationship('items')
              ->schema([
                Grid::make(5)
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
                          $set('stock', $product?->stock ?? 0);
                        }
                      }),

                    TextInput::make('stock')
                      ->label('Stock')
                      ->dehydrated(false)
                      ->disabled(),

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
                      ->readOnly()
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
                  ])
              ])
              ->columns(1)
              ->addActionLabel('Add Item')
              ->collapsible()
              ->reorderableWithButtons()
              ->cloneable()
              ->live()
              ->minItems(1)
              ->afterStateUpdated(function ($state, callable $get, callable $set) {
                $total = 0;
                if (is_array($state)) {
                  foreach ($state as $item) {
                    $total += ($item['price'] * ($item['quantity'] ?? 0));
                  }
                }
                $set('total', $total);
                $payment = $get('payment') ?? 0;
                $set('change', $payment - $total);
              }),
          ])
          ->columnSpanFull(),

        Section::make('Payment Information')
          ->schema([
            Grid::make(2)
              ->schema([
                Select::make('method')
                  ->label('Payment Method')
                  ->options([
                    'cash' => 'Cash',
                    'transfer' => 'Transfer',
                    'qris' => 'QRIS',
                    'debit' => 'Debit Card',
                  ])
                  ->required()
                  ->default('cash'),

                TextInput::make('payment')
                  ->label('Payment Amount')
                  ->numeric()
                  ->prefix('Rp')
                  ->required()
                  ->minValue(1)
                  ->live(onBlur: true)
                  ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    $total = $get('total') ?? 0;
                    $set('change', $state - $total);
                    $set('total', $total);
                  }),

                TextInput::make('change')
                  ->label('Change')
                  ->prefix('Rp')
                  ->numeric()
                  ->readOnly()
                  ->dehydrated(true),

                TextInput::make('total')
                  ->label('Total')
                  ->prefix('Rp')
                  ->numeric()
                  ->readOnly()
                  ->dehydrated(true)
                  ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    $payment = $get('payment') ?? 0;
                    $set('change', $payment - $state);
                  }),
              ])
              ->afterStateUpdated(function ($state, callable $get, callable $set) {
                logger()->info('Current Form State:', [
                  'payment' => $get('payment'),
                  'total'   => $get('total'),
                  'items'   => $get('items'),
                ]);
              }),
          ]),

        Section::make('Supplier Information')
          ->schema([
            Grid::make(2)
              ->schema([
                Select::make('supplier_id')
                  ->label('Supplier')
                  ->options(Supplier::where('is_active', true)->pluck('name', 'id'))
                  ->searchable()
                  ->preload()
                  ->required(),

                TextInput::make('invoice_number')
                  ->label('Invoice Number')
                  ->disabled()
                  ->dehydrated(false)
                  ->placeholder('Auto-generated invoice number')
              ])
          ])
      ]);
  }
}
