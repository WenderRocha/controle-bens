<?php

namespace App\Filament\Resources\MovablePropertysResource\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\MovablePropertysResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMovablePropertysbackup extends ManageRecords
{
    protected static string $resource = MovablePropertysResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            FilamentExportBulkAction::make('Export'),
        ];
    }

}
