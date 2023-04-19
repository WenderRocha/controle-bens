<?php

namespace App\Filament\Resources\RealStatePropertyResource\Pages;

use App\Filament\Resources\RealStatePropertyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRealStateProperties extends ManageRecords
{
    protected static string $resource = RealStatePropertyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
