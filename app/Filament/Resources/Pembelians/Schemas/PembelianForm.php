<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PembelianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Info Pembelian')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('nomor_po')
                            ->label('Nomor PO')
                            ->unique(ignoreRecord: true)
                            ->required(),

                        \Filament\Forms\Components\Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'nama')
                            ->searchable()
                            ->required(),

                        \Filament\Forms\Components\DatePicker::make('tanggal_pembelian')
                            ->label('Tanggal Pembelian')
                            ->default(now())
                            ->required(),

                        \Filament\Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('selesai')
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->nullable(),
                    ]),

                \Filament\Schemas\Components\Section::make('Item Barang')
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->label('')
                            ->columns(4)
                            ->schema([
                                \Filament\Forms\Components\Select::make('barang_id')
                                    ->label('Barang')
                                    ->options(\App\Models\Barang::query()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                        if ($state) {
                                            $barang = \App\Models\Barang::find($state);
                                            if ($barang) {
                                                $set('harga_beli', $barang->harga * 0.7);
                                                $jumlah = $get('jumlah') ?: 1;
                                                $set('subtotal', ($barang->harga * 0.7) * $jumlah);
                                            }
                                        }
                                    })
                                    ->columnSpan(1),

                                \Filament\Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                        $harga = $get('harga_beli') ?: 0;
                                        $set('subtotal', $harga * ($state ?: 1));
                                    })
                                    ->columnSpan(1),

                                \Filament\Forms\Components\TextInput::make('harga_beli')
                                    ->label('Harga Beli Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) {
                                        $jumlah = $get('jumlah') ?: 1;
                                        $set('subtotal', ($state ?: 0) * $jumlah);
                                    })
                                    ->columnSpan(1),

                                \Filament\Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(1),
                            ])
                            ->addActionLabel('+ Tambah Barang')
                            ->minItems(1)
                            ->defaultItems(1),
                    ]),

                \Filament\Schemas\Components\Section::make('Total')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('total_display')
                            ->label('Total Harga')
                            ->content(function (\Filament\Schemas\Components\Utilities\Get $get): string {
                                $items = $get('items') ?? [];
                                $total = collect($items)->sum('subtotal');
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),

                        \Filament\Forms\Components\Hidden::make('total_harga')
                            ->dehydrateStateUsing(function (\Filament\Schemas\Components\Utilities\Get $get) {
                                $items = $get('items') ?? [];
                                return collect($items)->sum('subtotal');
                            }),
                    ]),
            ]);
    }
}
