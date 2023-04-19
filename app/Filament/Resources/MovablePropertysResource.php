<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovablePropertysResource\Pages;
use App\Filament\Resources\MovablePropertysResource\RelationManagers;
use App\Filament\Resources\MovablePropertysResource\Widgets\StatsReportsOverview;
use App\Models\MovablePropertys;
use App\Tables\Columns\FileDocument;
use Filament\Forms;
use Filament\Forms\Components\Grid;
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

class MovablePropertysResource extends Resource
{
    protected static ?int $navigationSort = 2;

    protected static ?string $model = MovablePropertys::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $modelLabel = 'Ben Móvel';

    protected static ?string $pluralModelLabel = 'Bens Móveis';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('overturning_number')
                            ->label('Tombamento N')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('acquisition_data')
                            ->label('Data da aquisição')
                            ->required(),


                        Forms\Components\FileUpload::make('fiscal_note')
                            ->acceptedFileTypes(['application/pdf'])
                            ->enableDownload()
                            ->preserveFilenames()
                            ->label('Nota Fiscal')
                            ->required()

                    ]),




                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),


                Forms\Components\Select::make('secretary_id')
                    ->label('Unidade Administrativa')
                    ->relationship('secretary', 'name')
                    ->required(),

                Forms\Components\Select::make('departament_id')
                    ->label('Departamento')
                    ->relationship('departament', 'name')
                    ->required(),



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
                            ->label('Valor do item')

                    ]),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('overturning_number')
                    ->label('Tombamento N')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('acquisition_data')
                    ->date('d/m/Y')
                    ->label('Data da aquisição'),

                FileDocument::make('fiscal_note')
                    ->label('Nota Fiscal'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição do Bem')
                    ->limit(30),


                Tables\Columns\TextColumn::make('secretary.name')
                    ->label('Unidade Administrativa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departament.name')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conservation_type.name')
                    ->label('Estado de Conservação')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acquisition_type.name')
                    ->label('Tipo de Aquisição')
                    ->searchable()
                    ->sortable(),




                Tables\Columns\TextColumn::make('value')->money('brl')->label('Valor do Item'),
            ])
            ->filters([
                SelectFilter::make('departament_id')
                    ->relationship('departament', 'name')->label('Departamento'),

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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMovablePropertys::route('/'),
        ];
    }

}
