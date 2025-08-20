<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->description('Masukkan informasi pengguna')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->maxLength(100)
                            ->string()
                            ->live(onBlur: true)
                            ->required(),

                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->email(),

                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'kasir' => 'Kasir',
                            ])
                            ->required(),
                    ]),
                Section::make('Password Akun')
                    ->description('Masukkan password akun')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->required()
                            ->minLength(5)
                            ->maxLength(100)
                            ->password()
                            ->live(onBlur: true),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->required()
                            ->same('password')
                            ->password()
                            ->live(onBlur: true),
                    ]),
            ]);
    }
}
