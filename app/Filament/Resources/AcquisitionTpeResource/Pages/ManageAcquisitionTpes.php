<?php

namespace App\Filament\Resources\AcquisitionTpeResource\Pages;

use App\Filament\Resources\AcquisitionTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAcquisitionTpes extends ManageRecords
{
    protected static string $resource = AcquisitionTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
