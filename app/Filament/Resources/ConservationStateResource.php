<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConservationStateResource\Pages;
use App\Filament\Resources\ConservationStateResource\RelationManagers;
use App\Models\ConservationState;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConservationStateResource extends Resource
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $model = ConservationState::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $modelLabel = 'Estado de Conservação';

    protected static ?string $pluralModelLabel = 'Estados de Conservação';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Estado')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Estado')
                    ->searchable()
                    ->sortable()
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
            'index' => Pages\ManageConservationStates::route('/'),
        ];
    }
}
