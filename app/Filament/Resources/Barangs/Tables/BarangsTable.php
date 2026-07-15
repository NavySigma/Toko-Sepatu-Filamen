<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('nama')
                    ->label('Nama Sepatu')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('merk.nama')
                    ->label('Merk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kategori')
                    ->badge()
                    ->searchable(),

                TextColumn::make('ukuran')
                    ->label('Ukuran'),

                TextColumn::make('warna')
                    ->label('Warna'),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'Sneakers' => 'Sneakers',
                        'Formal' => 'Formal',
                        'Boots' => 'Boots',
                        'Sandal' => 'Sandal',
                        'Sport' => 'Sport',
                        'Casual' => 'Casual',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
