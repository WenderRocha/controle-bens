<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocalResource\Pages;
use App\Filament\Resources\LocalResource\RelationManagers;
use App\Models\Local;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class LocalResource extends Resource
{
    protected static ?int $navigationSort = 3;

    protected static ?string $model = Local::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';

    protected static ?string $modelLabel = 'Local';

    protected static ?string $pluralModelLabel = 'Locais';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Local')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('secretary_id')
                    ->relationship('secretary', 'name')
                    ->label('Secretaria')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Local')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('secretary.name')
                    ->label('Secretária')
                    ->searchable()
                    ->sortable(),


            ])
            ->filters([
                SelectFilter::make('secretary')
                    ->relationship('secretary', 'name')->label('Unidade Administrativa'),
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
            'index' => Pages\ManageLocals::route('/'),
        ];
    }
}
