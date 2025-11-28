<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Enums\TypeReservation;
use App\Enums\StatutReservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationLabel = 'Réservations';
    protected static ?string $navigationGroup = 'Gestion Immobilière';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    /* ===========================================================
     | FORMULAIRE
     ============================================================ */
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('bien_immobilier_id')
                ->label('Bien')
                ->relationship('bienImmobilier', 'titre')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Type de réservation')
                ->options(collect(TypeReservation::cases())->mapWithKeys(
                    fn ($case) => [$case->value => $case->label()]
                ))
                ->required(),

            Forms\Components\TextInput::make('prix')
                ->label('Montant')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('statut')
                ->label('Statut')
                ->options(collect(StatutReservation::cases())->mapWithKeys(
                    fn ($case) => [$case->value => $case->label()]
                ))
                ->required(),

            Forms\Components\DateTimePicker::make('dateReservation')
                ->label('Date de réservation')
                ->required(),
        ]);
    }

    /* ===========================================================
     | TABLEAU LISTE DES RÉSERVATIONS
     ============================================================ */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bienImmobilier.titre')
                    ->label('Bien')
                    ->searchable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable(),

                /* ------------ TYPE RÉSERVATION ------------ */
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(function ($state) {
                        return $state instanceof TypeReservation
                            ? $state->label()
                            : TypeReservation::from($state)->label();
                    })
                    ->badge()
                    ->color('info'),

                /* ------------ PRIX ------------ */
                Tables\Columns\TextColumn::make('prix')
                    ->label('Montant (FCFA)')
                    ->numeric()
                    ->sortable(),

                /* ------------ STATUT ------------ */
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->formatStateUsing(function ($state) {
                        return $state instanceof StatutReservation
                            ? $state->label()
                            : StatutReservation::from($state)->label();
                    })
                    ->badge()
                    ->color(function ($state) {
                        $value = $state instanceof StatutReservation ? $state->value : $state;

                        return match ($value) {
                            'en_attente' => 'warning',
                            'confirmee'  => 'success',
                            'annulee'    => 'danger',
                            default      => 'gray',
                        };
                    }),

                Tables\Columns\TextColumn::make('dateReservation')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /* ===========================================================
     | RELATIONS
     ============================================================ */
    public static function getRelations(): array
    {
        return [];
    }

    /* ===========================================================
     | PAGES
     ============================================================ */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit'   => Pages\EditReservation::route('/{record}/edit'),
            'view'   => Pages\ViewReservation::route('/{record}'),
        ];
    }
}
