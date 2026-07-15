<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Sepatu')
                    ->required()
                    ->maxLength(255),

                Select::make('merk_id')
                    ->label('Merk / Brand')
                    ->relationship('merk', 'nama')
                    ->searchable()
                    ->required(),

                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Sneakers' => 'Sneakers',
                        'Formal' => 'Formal',
                        'Boots' => 'Boots',
                        'Sandal' => 'Sandal',
                        'Sport' => 'Sport',
                        'Casual' => 'Casual',
                    ])
                    ->required()
                    ->searchable(),

                TextInput::make('ukuran')
                    ->label('Ukuran')
                    ->required()
                    ->maxLength(10)
                    ->placeholder('Contoh: 42'),

                TextInput::make('warna')
                    ->label('Warna')
                    ->required()
                    ->maxLength(100),

                TextInput::make('harga')
                    ->label('Harga (Rp)')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0),

                TextInput::make('stok')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(1000),

                FileUpload::make('gambar')
                    ->label('Gambar Produk')
                    ->image()
                    ->disk('public')
                    ->directory('barangs')
                    ->maxSize(2048),
            ]);
    }
}
