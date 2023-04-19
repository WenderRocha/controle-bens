<?php

namespace App\Filament\Resources\ConservationStateResource\Pages;

use App\Filament\Resources\ConservationStateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConservationStates extends ManageRecords
{
    protected static string $resource = ConservationStateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
