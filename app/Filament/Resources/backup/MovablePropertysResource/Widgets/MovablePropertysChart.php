<?php

namespace App\Filament\Resources\MovablePropertysResource\Widgets;

use App\Models\MovablePropertys;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MovablePropertysChartbckup extends LineChartWidget
{
    protected static ?string $heading = 'Bens Moveis';

    public ?string $filter = 'today';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        //dump($activeFilter);

        $data = Trend::model(MovablePropertys::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('value');

        return [
            'datasets' => [
                [
                    'label' => 'Bens Moveis',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
