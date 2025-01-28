<?php

namespace App\Filament\Resources;

use App\Domain\Career\Models\Position;
use App\Domain\Career\Models\Site;
use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\Select::make('site_id')
                    ->relationship('site', 'name')
                    ->required(),
                Repeater::make('position_specific_questions')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make("text")->label('Question')->required(),
                        Select::make('format')
                            ->options([
                                'input-text' => 'Text',
                                'select' => 'Select',
                            ])
                            ->required()->live(),
                        TextInput::make('options')
                            ->label('Options (comma separated)')
                            ->visible(fn ($get): bool => $get('format') === 'select'),

                        Select::make('required')
                            ->options([
                                1 => 'Required',
                                0 => 'Optional',
                            ])
                            ->required(),
                    ])
                    ->label('Position Specific Questions')
                    ->minItems(0)
                    ->collapsible()->grid('1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('site.name')->label('Site Name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),

        ];
    }
}
