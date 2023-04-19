<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcquisitionTpeResource\Pages;
use App\Filament\Resources\AcquisitionTpeResource\RelationManagers;
use App\Models\AcquisitionTpe;
use App\Models\AcquisitionType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcquisitionTypeResource extends Resource
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $model = AcquisitionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';

    protected static ?string $modelLabel = 'Tipo de Aquisição';

    protected static ?string $pluralModelLabel = 'Tipos de Aquisições';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ManageAcquisitionTpes::route('/'),
        ];
    }
}
