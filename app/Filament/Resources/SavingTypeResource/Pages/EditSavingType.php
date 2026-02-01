<?php

namespace App\Filament\Resources\SavingTypeResource\Pages;

use App\Filament\Resources\SavingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSavingType extends EditRecord
{
    protected static string $resource = SavingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
