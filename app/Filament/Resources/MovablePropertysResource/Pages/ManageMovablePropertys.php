<?php

namespace App\Filament\Resources\MovablePropertysResource\Pages;

use App\Filament\Resources\MovablePropertysResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMovablePropertys extends ManageRecords
{
    protected static string $resource = MovablePropertysResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
