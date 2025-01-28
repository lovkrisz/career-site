<?php

namespace App\Filament\Resources;

use App\Domain\Career\Models\Applicant;
use App\Filament\Resources\ApplicantResource\Pages;
use App\Filament\Resources\ApplicantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\Actions;
use Illuminate\Support\Str;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist->schema(function (Applicant $record) {

            $lines = [];


            $answers = json_decode($record->position_specific_questions, true);
            $questions = $record->position->position_specific_questions;

            foreach ($answers as $key => $answer) {
                foreach ($questions as $q) {
                    if ($q["name"] === $key) {
                        $lines[] = TextEntry::make($q["text"])->label($q["text"])->state($answer);
                    }
                }
            }
            $entries = [
                Section::make('Personal Information')->schema([
                    Grid::make()->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('mobile'),
                        TextEntry::make('position.title')->label('Position'),
                        TextEntry::make('wage')->money('HUF')->placeholder('The applicant has not provided a wage.'),
                        TextEntry::make('position.site.name')->label('Site'),
                        TextEntry::make('status'),
                        TextEntry::make('created_at'),
                        TextEntry::make('residence')->placeholder('The applicant has not provided a residence.'),
                        TextEntry::make('birthdate')->placeholder('The applicant has not provided a birthdate.'),
                    ])->columns(3),
                ]),
                Section::make('Introduction')->schema([
                    Grid::make()->schema([
                        TextEntry::make('introduction')->placeholder('The applicant has not provided an introduction.'),
                    ]),
                ]),
                Section::make('Position Specific Questions')->schema([
                    Grid::make()->schema([
                        ...$lines
                    ]),
                ]),
                Section::make('CV')->schema([
                    Grid::make()->schema([
                        Actions::make([
                            Action::make('CV')->label('Download CV')
                                ->icon('heroicon-m-arrow-down-tray')
                                ->requiresConfirmation()
                                ->url(
                                    fn(Applicant $record) => route('applicants.download', $record),
                                    shouldOpenInNewTab: true
                                )
                        ]),
                    ]),
                ]),
            ];

            return $entries;
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('mobile'),
                Forms\Components\Select::make('position_id')
                    ->relationship('position', 'title')
                    ->required(),
                Forms\Components\TextInput::make('wage'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'new' => 'New',
                        'reviewed' => 'Reviewed',
                        'rejected' => 'Rejected',
                        'hired' => 'Hired',
                    ])
                    ->default('pending'),
                Forms\Components\Select::make('site_id')
                    ->relationship('position.site', 'name')
                    ->label('Site')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('mobile'),
                Tables\Columns\TextColumn::make('position.title')->label('Position'),
                Tables\Columns\TextColumn::make('wage'),
                Tables\Columns\TextColumn::make('position.site.name')->label('Site'),
                Tables\Columns\SelectColumn::make('status')->options([
                    'pending' => 'Pending',
                    'new' => 'New',
                    'reviewed' => 'Reviewed',
                    'rejected' => 'Rejected',
                    'hired' => 'Hired',
                ])->default(fn($get) => $get('status') ?? 'pending'),
                Tables\Columns\TextColumn::make('created_at'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
            'view' => Pages\ViewApplicant::route('/{record}'),
        ];
    }
}
