<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MovablePropertysResource\Widgets\MovablePropertysOverview;
use App\Filament\Resources\MovablePropertysResource\Widgets\StatsReportsOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Relatórios';

    protected static ?string $title = 'Relatórios';

    protected static ?string $slug = 'reports';

    protected static string $view = 'filament.pages.reports';

    protected function getFormSchema(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'reviewing' => 'Reviewing',
                        'published' => 'Published',
                    ]),
                DatePicker::make('start_date'),
                DatePicker::make('end_date')
            ])
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsReportsOverview::class,
        ];
    }
}
