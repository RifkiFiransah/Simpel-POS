<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('category_information')
                    ->label('Informasi Kategori')
                    ->description('Masukkan informasi dasar kategori')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'update') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->maxLength(500),
                ]),

                Section::make('image_upload')
                    ->label('Unggah Gambar')
                    ->description('Unggah gambar untuk kategori ini')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Kategori')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('categories')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull()
                    ])
            ]);
    }
}
