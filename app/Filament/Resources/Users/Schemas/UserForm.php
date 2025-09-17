<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                
                Section::make('Status Akun')
                    ->description('Atur status akun')
                    ->schema([
                        Select::make('role_id')
                                ->label('Role')
                                ->relationship('role', 'display_name')
                                ->options(Role::where('is_active', true)->pluck('display_name', 'id'))
                                ->required()
                                ->searchable()
                                ->preload(),

                        Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->helperText('Inactive users cannot login to the system.'),
                    ]),
            ]);
    }
}
