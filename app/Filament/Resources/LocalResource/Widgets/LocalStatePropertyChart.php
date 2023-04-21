<?php

namespace App\Filament\Resources\LocalResource\Widgets;

use App\Models\Local;
use Filament\Widgets\DoughnutChartWidget;
use Illuminate\Support\Facades\DB;

class LocalStatePropertyChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $locals = Local::all()->pluck('name')->toArray();

        $data = DB::table('movable_propertys')
            ->selectRaw('locals.name, COUNT(*) as movable_propertys_count')
            ->join('locals', 'movable_propertys.local_id', '=', 'locals.id')
            ->groupBy('locals.name')
            ->pluck('movable_propertys_count', 'name')
            ->toArray();

        $data = array_values($data);





        return [
            'datasets' => [
                [
                    'labels' => $locals,
                    'data' => $data,
                ],
            ],
        ];
    }
}
