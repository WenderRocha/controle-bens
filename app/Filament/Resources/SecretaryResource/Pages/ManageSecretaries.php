<?php

namespace App\Filament\Resources\SecretaryResource\Pages;

use App\Filament\Resources\SecretaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSecretaries extends ManageRecords
{
    protected static string $resource = SecretaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
