<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Informasi Produk')
                    ->description('Masukkan informasi dasar produk')
                    ->schema([
                        ComponentsGrid::make(2)
                            ->schema([
                                Placeholder::make('code_info')
                                    ->label('Kode Produk')
                                    ->content(function ($record) {
                                        if ($record && $record->code) {
                                            return $record->code;
                                        }
                                        return 'Otomatis (Format: PRD-CTG-XXX)';
                                    })
                                    ->extraAttributes(['class' => 'text-primary-600 font-medium'])
                                    ->columnSpan(1),

                                TextInput::make('name')
                                    ->label('Nama Produk')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    })
                                    ->columnSpan(1),
                            ]),

                        ComponentsGrid::make(2)
                            ->schema([
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version nama produk')
                                    ->readOnly()
                                    ->columnSpan(1),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->options(Category::where('is_active', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->columnSpan(1),
                            ]),

                        ComponentsGrid::make(2)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->columnSpan(1),

                                TextInput::make('stock')
                                    ->label('Stok')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->columnSpan(1),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                ComponentsSection::make('Media & Status')
                    ->description('Upload gambar dan atur status produk')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Produk')
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Produk yang tidak aktif tidak akan tampil di frontend')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
