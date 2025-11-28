<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaiementResource\Pages;
use App\Models\Paiement;
use App\Enums\MethodePaiement;
use App\Enums\StatutPaiement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaiementResource extends Resource
{
    protected static ?string $model = Paiement::class;

    protected static ?string $navigationGroup = 'Gestion Immobilière';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Paiements';
    protected static ?string $pluralLabel = 'Paiements';

    /* ------------------------------ */
    /*             FORMULAIRE         */
    /* ------------------------------ */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->label('Réservation')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('montant')
                    ->label('Montant')
                    ->numeric()
                    ->prefix('FCFA')
                    ->required(),

                Forms\Components\Select::make('methode')
                    ->label('Méthode')
                    ->options(
                        collect(MethodePaiement::cases())->mapWithKeys(
                            fn($e) => [$e->value => $e->label()]
                        )
                    )
                    ->required(),

                Forms\Components\Select::make('statut')
                    ->label('Statut')
                    ->options(
                        collect(StatutPaiement::cases())->mapWithKeys(
                            fn($e) => [$e->value => $e->label()]
                        )
                    )
                    ->required(),
            ]);
    }

    /* ------------------------------ */
    /*             TABLEAU            */
    /* ------------------------------ */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reservation.bienImmobilier.titre')
                    ->label('Bien')
                    ->searchable(),

                Tables\Columns\TextColumn::make('montant')
                    ->label('Montant')
                    ->money('XOF')
                    ->sortable(),

                /* MÉTHODE DE PAIEMENT (ENUM FIXÉE) */
                Tables\Columns\TextColumn::make('methode')
                    ->label('Méthode')
                    ->formatStateUsing(function ($state) {
                        return $state instanceof MethodePaiement
                            ? $state->label()
                            : MethodePaiement::from($state)->label();
                    })
                    ->badge()
                    ->sortable(),

                /* STATUT PAIEMENT (ENUM FIXÉE) */
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->formatStateUsing(function ($state) {
                        return $state instanceof StatutPaiement
                            ? $state->label()
                            : StatutPaiement::from($state)->label();
                    })
                    ->badge()
                    ->color(function ($state) {
                        $value = $state instanceof StatutPaiement ? $state->value : $state;

                        return match ($value) {
                            'paye' => 'success',
                            'en_attente' => 'warning',
                            default => 'gray',
                        };
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_paiement')
                    ->label('Date paiement')
                    ->dateTime()
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

    /* ------------------------------ */
    /*             RELATIONS          */
    /* ------------------------------ */
    public static function getRelations(): array
    {
        return [];
    }

    /* ------------------------------ */
    /*             PAGES              */
    /* ------------------------------ */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaiements::route('/'),
            'create' => Pages\CreatePaiement::route('/create'),
            'edit' => Pages\EditPaiement::route('/{record}/edit'),
            'view' => Pages\ViewPaiement::route('/{record}'),
        ];
    }
}
