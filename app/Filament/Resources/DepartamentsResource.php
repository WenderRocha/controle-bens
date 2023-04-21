<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartamentsResource\Pages;
use App\Filament\Resources\DepartamentsResource\RelationManagers;
use App\Models\Departaments;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartamentsResource extends Resource
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $model = Departaments::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Departamento';

    protected static ?string $pluralModelLabel = 'Departamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('secretary_id')
                    ->relationship('secretary', 'name')
                    ->label('Unidade Administrativa')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('secretary.name')
                    ->label('Secretária')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Departamento')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')->searchable()->sortable()
                    ->dateTime()->date('d/m/Y'),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageDepartaments::route('/'),
        ];
    }
}
