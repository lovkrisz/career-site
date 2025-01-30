<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Actions\Career\NotifyApplicantAction;
use App\Filament\Resources\ApplicantResource\Pages;
use App\Models\Career\Applicant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist->schema(function (Applicant $record): array {

            $lines = [];

            $answers = json_decode($record->position_specific_questions, true);
            $questions = $record->position->position_specific_questions;

            foreach ($answers as $key => $answer) {
                foreach ($questions as $q) {
                    if ($q['name'] === $key) {
                        $lines[] = TextEntry::make($q['text'])->label($q['text'])->state($answer);
                    }
                }
            }

            return [
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
                        TextEntry::make('birthdate')->date()->placeholder('The applicant has not provided a birthdate.'),
                    ])->columns(3),
                ]),
                Section::make('Introduction')->schema([
                    Grid::make()->schema([
                        TextEntry::make('introduction')->placeholder('The applicant has not provided an introduction.'),
                    ]),
                ]),
                Section::make('Position Specific Questions')->schema([
                    Grid::make()->schema([
                        ...$lines,
                    ]),
                ]),
                Section::make('CV')->schema([
                    Grid::make()->schema([
                        Actions::make([
                            Action::make('CV')->label('Download CV')
                                ->icon('heroicon-m-arrow-down-tray')
                                ->requiresConfirmation()
                                ->url(
                                    fn (Applicant $record) => route('applicants.download', $record),
                                    shouldOpenInNewTab: true
                                ),
                            Action::make('judgement')->label('Judgement')
                                ->form([
                                    Forms\Components\Select::make('status')
                                        ->options([
                                            'pending' => 'Pending',
                                            'hired' => 'Hired',
                                            'rejected' => 'Rejected',
                                            'round_2' => 'Round 2',
                                            'rejected_01' => '01 - Rejected - Not enough experience',
                                            'rejected_02' => '02 - Rejected - Not enough knowledge',
                                            'rejected_03' => '03 - Rejected - Not enough skills',
                                            'rejected_04' => '04 - Rejected - Not enough motivation',
                                            'rejected_05' => '05 - Rejected - Not enough communication skills',
                                            'rejected_06' => '06 - Rejected - Not enough team player',
                                            'rejected_07' => '07 - Rejected - Not enough problem solving skills',
                                            'rejected_08' => '08 - Rejected - Not enough creativity',
                                            'rejected_09' => '09 - Rejected - Not enough leadership',
                                            'rejected_10' => '10 - Rejected - Not enough self-organization',
                                            'rejected_11' => '11 - Rejected - Not enough self-learning',
                                            'rejected_12' => '12 - Rejected - Not enough self-improvement',
                                            'rejected_13' => '13 - Rejected - Not enough self-motivation',
                                            'rejected_14' => '14 - Rejected - Not enough self-confidence',
                                            'rejected_15' => '15 - Rejected - Not enough self-awareness',
                                            'rejected_16' => '16 - Rejected - Not enough self-discipline',
                                            'rejected_17' => '17 - Rejected - Not enough self-control',
                                            'rejected_18' => '18 - Rejected - Not enough self-respect',
                                            'rejected_19' => '19 - Rejected - Not enough self-esteem',
                                            'rejected_20' => '20 - Rejected - Not enough self-love',
                                            'rejected_21' => '21 - Rejected - Not enough self-care',
                                            'rejected_22' => '22 - Rejected - Not enough self-acceptance',
                                            'rejected_23' => '23 - Rejected - Not enough self-forgiveness',
                                            'rejected_24' => '24 - Rejected - Not enough self-compassion',
                                            'rejected_25' => '25 - Rejected - Not enough self-empowerment',
                                            'rejected_26' => '26 - Rejected - Not enough self-fulfillment',
                                            'rejected_27' => '27 - Rejected - Not enough self-realization',
                                            'rejected_28' => '28 - Rejected - Not enough self-actualization',
                                            'rejected_29' => '29 - Rejected - Not enough self-transcendence',
                                            'rejected_30' => '30 - Rejected - Not enough self-awakening',
                                            'rejected_31' => '31 - Rejected - Not enough self-discovery',
                                            'rejected_32' => '32 - Rejected - Not enough self-expression',
                                        ])
                                        ->required()
                                        ->default('pending'),
                                ])
                                ->action(function (array $data, Applicant $record): void {
                                    $record->update([
                                        'status' => $data['status'],
                                    ]);
                                    (new NotifyApplicantAction)->handle($record);

                                    Notification::make()
                                        ->title('Status has been edited')
                                        ->body('The status of the applicant has been edited.')
                                        ->success()
                                        ->send();
                                }),

                        ]),
                    ]),
                ]),
            ];
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
                        'rejected' => 'Rejected',
                        'hired' => 'Hired',
                    ])
                    ->default('pending'),
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
                Tables\Columns\TextColumn::make('status'),
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
            ])
            ->defaultSort('created_at', 'desc');
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
