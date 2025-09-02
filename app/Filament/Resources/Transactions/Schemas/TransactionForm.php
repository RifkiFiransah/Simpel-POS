<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Customer;
use App\Models\Product;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;

class TransactionForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema->components([
      Section::make('Transaction Items')
        ->schema([
          Repeater::make('items')
            ->relationship('items')
            ->schema([
              Grid::make(5)
                ->schema([
                  Select::make('product_id')
                    ->label('Product')
                    ->options(Product::where('is_active', true)
                      ->where('stock', '>', 0)
                      ->pluck('name', 'id'))
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
                    ->rule(function ($transaction, $get) {
                      $productId = $get('product_id');
                      if ($productId) {
                        $product = Product::find($productId);
                        if ($product) {
                          return 'max:' . $product->stock;
                        }
                      }
                      return '';
                    })
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                      $stock = $get('stock') ?? 0;
                      if ($state > $stock) {
                        $set('quantity', $stock);
                        Notification::make()
                          ->title('Quantity melebihi stok tersedia!')
                          ->danger()
                          ->send();
                      }
                      $price = $get('price') ?? 0;
                      $set('subtotal', $price * ($get('quantity') ?? 1));
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
                    ->readOnly()
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
                ->dehydrated(true)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                  $total = $get('total') ?? 0;
                  $set('change', $state - $total);
                  $set('total', $total);
                }),

              TextInput::make('total')
                ->label('Total')
                ->numeric()
                ->prefix('Rp')
                ->readOnly()
                ->required()
                ->minValue(1)
                ->dehydrated(true),

              TextInput::make('change')
                ->label('Change')
                ->numeric()
                ->prefix('Rp')
                ->required()
                ->readOnly()
                ->dehydrated(true),
            ])
            ->afterStateUpdated(function ($state, callable $get, callable $set) {
              logger()->info('Current Form State:', [
                'payment' => $get('payment'),
                'total'   => $get('total'),
                'items'   => $get('items'),
              ]);
            }),
        ]),

      Section::make('Transaction Information')
        ->schema([
          Grid::make(2)
            ->schema([
              TextInput::make('invoice_number')
                ->label('Invoice Number')
                ->disabled()
                ->dehydrated(true)
                ->placeholder('Auto Generated'),

              Select::make('customer_id')
                ->label('Customer')
                ->options(Customer::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),
            ]),
        ]),
    ]);
  }
}
