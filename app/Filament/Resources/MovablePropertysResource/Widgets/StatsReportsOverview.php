<?php

namespace App\Filament\Resources\MovablePropertysResource\Widgets;

use App\Models\MovablePropertys;
use App\Models\RealStateProperty;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsReportsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [

            Card::make('Quantidade', MovablePropertys::all()->count())
                ->description('Bens Moveis')
                ->descriptionIcon('heroicon-o-cube'),

            Card::make('Valor total', number_format(MovablePropertys::query()->sum('value'), 2, ',', '.'))
                ->description('Bens Móveis')
                ->descriptionIcon('heroicon-o-cube')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Quantidade', RealStateProperty::all()->count())
                ->description('Bens Imóveis')
                ->descriptionIcon('heroicon-o-library'),

            Card::make('Valor total', number_format(RealStateProperty::query()->sum('value'),2, ',', '.'))
                ->description('Bens Imóveis')
                ->descriptionIcon('heroicon-o-library')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => '$emitUp("setStatusFilter", "processed")',
                ]),

        ];
    }
}
