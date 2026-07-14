<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Models\Barang;
use App\Models\Transaksi;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Info Transaksi')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nomor_invoice')
                            ->label('Nomor Invoice')
                            ->default(fn () => Transaksi::generateInvoice())
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(ignoreRecord: true),

                        DateTimePicker::make('tanggal_transaksi')
                            ->label('Tanggal Transaksi')
                            ->default(now())
                            ->required(),

                        TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),

                        Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options([
                                'tunai' => 'Tunai',
                                'transfer' => 'Transfer Bank',
                                'qris' => 'QRIS',
                                'kartu_debit' => 'Kartu Debit',
                                'kartu_kredit' => 'Kartu Kredit',
                            ])
                            ->default('tunai')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('pending')
                            ->required(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Item Barang')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->label('')
                            ->columns(4)
                            ->schema([
                                Select::make('barang_id')
                                    ->label('Barang')
                                    ->options(Barang::query()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        if ($state) {
                                            $barang = Barang::find($state);
                                            if ($barang) {
                                                $set('harga_satuan', $barang->harga);
                                                $jumlah = $get('jumlah') ?: 1;
                                                $set('subtotal', $barang->harga * $jumlah);
                                            }
                                        }
                                    })
                                    ->columnSpan(1),

                                TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $harga = $get('harga_satuan') ?: 0;
                                        $set('subtotal', $harga * ($state ?: 1));
                                    })
                                    ->columnSpan(1),

                                TextInput::make('harga_satuan')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(1),

                                TextInput::make('subtotal')
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

                Section::make('Total')
                    ->schema([
                        Placeholder::make('total_display')
                            ->label('Total Harga')
                            ->content(function (Get $get): string {
                                $items = $get('items') ?? [];
                                $total = collect($items)->sum('subtotal');
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),

                        Hidden::make('total_harga'),
                    ]),
            ]);
    }
}
