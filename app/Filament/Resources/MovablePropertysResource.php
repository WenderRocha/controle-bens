<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\MovablePropertysResource\Pages;
use App\Filament\Resources\MovablePropertysResource\RelationManagers;
use App\Filament\Resources\MovablePropertysResource\Widgets\StatsReportsOverview;
use App\Models\MovablePropertys;
use App\Tables\Columns\FileDocument;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use PhpParser\Node\Expr\Cast\Bool_;
use Filament\Forms\Components\TextInput;

class MovablePropertysResource extends Resource
{
    protected static ?int $navigationSort = 2;

    protected static ?string $model = MovablePropertys::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $modelLabel = 'Bem Móvel';

    protected static ?string $pluralModelLabel = 'Bens Móveis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('overturning_number')
                            ->label('Tombamento N.º')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('acquisition_data')
                            ->label('Data da aquisição')
                            ->required(),

                        Forms\Components\FileUpload::make('fiscal_note')
                            ->acceptedFileTypes(['application/pdf'])
                            ->enableDownload()
                            ->label('Nota Fiscal')

                    ]),




                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),


                Grid::make(3)->schema([
                    Forms\Components\Select::make('local_id')
                        ->label('Local')
                        ->relationship('local', 'name'),


                    Forms\Components\Select::make('secretary_id')
                        ->label('Unidade Administrativa')
                        ->relationship('secretary', 'name')
                        ->required(),

                    Forms\Components\Select::make('departament_id')
                        ->label('Departamento')
                        ->relationship('departament', 'name'),
                ]),



                Grid::make(3)
                    ->schema([

                        Forms\Components\Select::make('conservation_type_id')
                            ->label('Estado de Conservação')
                            ->relationship('conservation_type', 'name')
                            ->required(),

                        Forms\Components\Select::make('acquisition_type_id')
                            ->label('Tipo de Aquisição')
                            ->relationship('acquisition_type', 'name')
                            ->required(),



                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->label('Valor do item')
                            ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'R$', thousandsSeparator: ',', decimalPlaces: 2))

                    ]),




            ]);
    }

    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('overturning_number')
                    ->label('Tombamento N.º')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('acquisition_data')
                    ->date('d/m/Y')
                    ->label('Data da aquisição'),

                FileDocument::make('fiscal_note')
                    ->label('Nota Fiscal'),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descrição do Bem'),


                Tables\Columns\TextColumn::make('secretary.name')
                    ->label('Unidade Administrativa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('local.name')
                    ->label('Local')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departament.name')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conservation_type.name')
                    ->label('Condição')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acquisition_type.name')
                    ->label('Tipo de Aquisição')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')->money('brl')->label('Valor do Item'),
            ])
            ->filters([


                SelectFilter::make('local_id')
                    ->relationship('local', 'name')
                    ->label('Local')
                    ->searchable(),

                SelectFilter::make('departament_id')
                    ->relationship('departament', 'name')->label('Departamento'),

                SelectFilter::make('secretary_id')
                    ->relationship('secretary', 'name')
                    ->label('Unidade Administrativa')
                    ->searchable(),

                SelectFilter::make('acquisition_type')
                    ->relationship('acquisition_type', 'name')->label('Tipo de Aquisição'),

                SelectFilter::make('conservation_type')
                    ->relationship('conservation_type', 'name')->label('Condição'),

                Filter::make('acquisition_data')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Criado a partir de'),
                        Forms\Components\DatePicker::make('created_until')->label('Até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->headerActions([

               // $local_id = (isset($_GET['tableFilters[local_id][value]'] ) && !empty($_GET['tableFilters[local_id][value]'])),


                FilamentExportHeaderAction::make('Exportar')->extraViewData(fn ($action) => [
                    'recordCount' => $action->getRecords()->count(),
                    'date' => now()->format('d/m/Y H:i'),
                   // 'sum' => (isset($_GET['tableFilters'])) ? number_format(MovablePropertys::query()->where('local_id', '=', (int)$_GET['tableFilters']['local_id']['value'])->sum('value'), 2, ',', '.')   : number_format(MovablePropertys::query()->sum('value'), 2, ',', '.')

                    'sum' => (!is_null($action->getTable()->getLivewire()->tableFilters['local_id']['value'])) ? number_format(MovablePropertys::query()->where('local_id', '=', (int)$action->getTable()->getLivewire()->tableFilters['local_id']['value'])->sum('value'), 2, ',', '.') : number_format(MovablePropertys::query()->sum('value'), 2, ',', '.')
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMovablePropertys::route('/'),
        ];
    }


}
