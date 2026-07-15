<?php

namespace App\Filament\Resources\Merks\Pages;

use App\Filament\Resources\Merks\MerkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMerk extends EditRecord
{
    protected static string $resource = MerkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
