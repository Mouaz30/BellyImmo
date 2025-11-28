<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisiteResource\Pages;
use App\Models\Visite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VisiteResource extends Resource
{
    protected static ?string $model = Visite::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Visites';
    protected static ?string $pluralLabel = 'Visites';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('bien_immobilier_id')
                    ->relationship('bien', 'titre')
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('date_visite')->required(),
                Forms\Components\TimePicker::make('heure_visite')->required(),

                Forms\Components\Textarea::make('message')
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\Select::make('statut')
                    ->options([
                        'EN_ATTENTE' => 'En attente',
                        'VALIDEE' => 'Validée',
                        'REFUSEE' => 'Refusée',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bien.titre')
                    ->label('Bien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_visite')
                    ->date()
                    ->label('Date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('heure_visite')
                    ->label('Heure'),

                Tables\Columns\BadgeColumn::make('statut')
                    ->colors([
                        'warning' => 'EN_ATTENTE',
                        'success' => 'VALIDEE',
                        'danger'  => 'REFUSEE',
                    ])
                    ->label('Statut'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('statut')->options([
                    'EN_ATTENTE' => 'En attente',
                    'VALIDEE' => 'Validée',
                    'REFUSEE' => 'Refusée',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('accept')
                    ->label('Accepter')
                    ->color('success')
                    ->visible(fn (Visite $record) => $record->statut === 'EN_ATTENTE')
                    ->action(function (Visite $record) {
                        $record->update(['statut' => 'VALIDEE']);
                        $record->client->notify(new \App\Notifications\VisiteStatusChanged($record));
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Refuser')
                    ->color('danger')
                    ->visible(fn (Visite $record) => $record->statut === 'EN_ATTENTE')
                    ->action(function (Visite $record) {
                        $record->update(['statut' => 'REFUSEE']);
                        $record->client->notify(new \App\Notifications\VisiteStatusChanged($record));
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVisites::route('/'),
            'create' => Pages\CreateVisite::route('/create'),
            'edit'   => Pages\EditVisite::route('/{record}/edit'),
        ];
    }
}
