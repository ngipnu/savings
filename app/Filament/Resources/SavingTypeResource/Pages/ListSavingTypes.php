<?php

namespace App\Filament\Resources\SavingTypeResource\Pages;

use App\Filament\Resources\SavingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSavingTypes extends ListRecords
{
    protected static string $resource = SavingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
