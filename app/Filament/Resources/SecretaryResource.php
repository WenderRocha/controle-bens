<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecretaryResource\Pages;
use App\Filament\Resources\SecretaryResource\RelationManagers;
use App\Models\Secretary;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SecretaryResource extends Resource
{
    protected static ?int $navigationSort = 1;

    protected static ?string $model = Secretary::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';

    protected static ?string $modelLabel = 'Unidade Administrativa';

    protected static ?string $pluralModelLabel = 'Unidades Administrativas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->required()
                    ->maxLength(255),
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

                Tables\Columns\TextColumn::make('address')
                ->label('Endereço')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime('d/m/Y'),
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
            'index' => Pages\ManageSecretaries::route('/'),
        ];
    }
}
