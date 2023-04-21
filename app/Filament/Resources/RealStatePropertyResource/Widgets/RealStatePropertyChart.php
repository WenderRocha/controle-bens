<?php

namespace App\Filament\Resources\RealStatePropertyResource\Widgets;

use App\Models\MovablePropertys;
use App\Models\RealStateProperty;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RealStatePropertyChart extends LineChartWidget
{
    protected static ?string $heading = 'Bens Imóveis';

    protected function getData(): array
    {

        $data = Trend::model(RealStateProperty::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('value');

        return [
            'datasets' => [
                [
                    'label' => 'Bens Imoveis',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

}
