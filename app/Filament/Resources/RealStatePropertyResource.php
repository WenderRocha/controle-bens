<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\RealStatePropertyResource\Pages;
use App\Filament\Resources\RealStatePropertyResource\RelationManagers;
use App\Models\MovablePropertys;
use App\Models\RealStateProperty;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;

class RealStatePropertyResource extends Resource
{
    protected static ?int $navigationSort = 3;
    protected static ?string $model = RealStateProperty::class;
    protected static ?string $navigationIcon = 'heroicon-o-library';

    protected static ?string $modelLabel = 'Bem iMóvel';

    protected static ?string $pluralModelLabel = 'Bens iMóveis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(4)->schema([

                    Forms\Components\DatePicker::make('acquisition_data')
                        ->label('Data da aquisição')
                        ->required(),

                    Forms\Components\Select::make('secretary_id')
                        ->label('Secretária')
                        ->relationship('secretary', 'name')
                        ->required(),

                    Forms\Components\Select::make('acquisition_type_id')
                        ->label('Tipo de aquisição')
                        ->relationship('acquisition_type', 'name')
                        ->required(),

                    Forms\Components\TextInput::make('value')
                        ->label('Valor')
                        ->required()
                        ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'R$', thousandsSeparator: ',', decimalPlaces: 2))
                ]),


                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),


                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('address')
                        ->label('Endereço')
                        ->required()
                        ->maxLength(255)->columnSpanFull(),

                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('acquisition_data')
                    ->label('Data da aquisição')->date('d/m/Y'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descriçaõ do Bem')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('secretary.name')
                    ->searchable()
                    ->sortable()
                    ->label('Unidade Administrativa'),

                Tables\Columns\TextColumn::make('acquisition_type.name')
                    ->searchable()
                    ->sortable()
                    ->label('Tipo de aquisição'),


                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                ->label('Endereço'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')->money('brl'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime()->date('d/m/Y'),
            ])
            ->filters([

                SelectFilter::make('secretary_id')
                    ->relationship('secretary', 'name')->label('Unidade Administrativa'),

                SelectFilter::make('acquisition_type')
                    ->relationship('acquisition_type', 'name')->label('Tipo de Aquisição'),

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
                FilamentExportHeaderAction::make('Exportar')->extraViewData(fn ($action) => [
                    'recordCount' => $action->getRecords()->count(),
                    'date' => now()->format('d/m/Y H:i'),
                    'sum' => self::sumActiveFilters($action)
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRealStateProperties::route('/'),
        ];
    }

    public static function sumActiveFilters($action)
    {
        $query = RealStateProperty::query();

        if (!is_null($action->getTable()->getLivewire()->tableFilters['secretary_id']['value'])) {
            $query->where('secretary_id', '=', (int)$action->getTable()->getLivewire()->tableFilters['secretary_id']['value']);
        }

        if (!is_null($action->getTable()->getLivewire()->tableFilters['acquisition_type']['value'])) {
            $query->where('acquisition_type_id', '=', (int)$action->getTable()->getLivewire()->tableFilters['acquisition_type']['value']);
        }

        if (!is_null($action->getTable()->getLivewire()->tableFilters['acquisition_data']['created_from']) && !is_null($action->getTable()->getLivewire()->tableFilters['acquisition_data']['created_until'])) {

            $startDate = $action->getTable()->getLivewire()->tableFilters['acquisition_data']['created_from'];
            $endDate = $action->getTable()->getLivewire()->tableFilters['acquisition_data']['created_until'];

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $value = $query->sum('value');

        return number_format($value, 2, ',', '.');
    }
}
