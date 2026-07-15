<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('kontak'),
                TextInput::make('email')
                    ->email(),
                TextInput::make('jumlah_cat_disupply')
                    ->numeric()
                    ->default(0),
                Textarea::make('alamat')
                    ->columnSpanFull(),
            ]);
    }
}
