<?php

namespace App\Filament\Resources\DepartamentsResource\Pages;

use App\Filament\Resources\DepartamentsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDepartaments extends ManageRecords
{
    protected static string $resource = DepartamentsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
