<?php

namespace App\Filament\Resources\Merks;

use App\Filament\Resources\Merks\Pages\CreateMerk;
use App\Filament\Resources\Merks\Pages\EditMerk;
use App\Filament\Resources\Merks\Pages\ListMerks;
use App\Filament\Resources\Merks\Schemas\MerkForm;
use App\Filament\Resources\Merks\Tables\MerksTable;
use App\Models\Merk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MerkResource extends Resource
{
    protected static ?string $model = Merk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'nama';

    protected static string|\UnitEnum|null $navigationGroup = 'Toko Sepatu';

    public static function form(Schema $schema): Schema
    {
        return MerkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MerksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMerks::route('/'),
            'create' => CreateMerk::route('/create'),
            'edit' => EditMerk::route('/{record}/edit'),
        ];
    }
}
