<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BienImmobilierResource\Pages;
use App\Models\BienImmobilier;
use App\Models\User;
use App\Enums\TypeBien;
use App\Enums\StatutBien;
use App\Enums\ModeTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class BienImmobilierResource extends Resource
{
    protected static ?string $model = BienImmobilier::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Gestion Immobilière';
    protected static ?string $navigationLabel = 'Biens';
    protected static ?string $pluralLabel = 'Biens immobiliers';

    /* ========================= FORM ========================= */
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('titre')
                ->label('Titre du bien')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('prix')
                ->label('Prix')
                ->numeric()
                ->prefix('FCFA')
                ->required(),

            Forms\Components\Textarea::make('adresse')
                ->label('Adresse')
                ->rows(3)
                ->required(),

            // TYPE DE BIEN (ENUM)
            Forms\Components\Select::make('type')
                ->label('Type de bien')
                ->options(array_combine(
                    array_map(fn($e) => $e->value, TypeBien::cases()),
                    array_map(fn($e) => $e->label(), TypeBien::cases())
                ))
                ->required(),

            // MODE DE TRANSACTION (ENUM)
            Forms\Components\Select::make('mode_transaction')
                ->label('Mode de transaction')
                ->options(array_combine(
                    array_map(fn($e) => $e->value, ModeTransaction::cases()),
                    array_map(fn($e) => $e->label(), ModeTransaction::cases())
                ))
                ->required(),

            // STATUT (ENUM)
            Forms\Components\Select::make('statut')
                ->label('Statut')
                ->options(array_combine(
                    array_map(fn($e) => $e->value, StatutBien::cases()),
                    array_map(fn($e) => $e->label(), StatutBien::cases())
                ))
                ->default(StatutBien::DISPONIBLE->value)
                ->required(),

            // PROPRIÉTAIRE
            Forms\Components\Select::make('proprietaire_id')
                ->label('Propriétaire')
                ->options(
                    User::where('role', 'proprietaire')
                        ->get()
                        ->mapWithKeys(fn($user) => [$user->id => $user->prenom.' '.$user->nom])
                )
                ->searchable()
                ->required(),

            Forms\Components\RichEditor::make('description')
                ->label('Description')
                ->columnSpanFull(),

            // IMAGES
            Repeater::make('illustrations')
                ->label('Photos du bien')
                ->relationship('illustrations')
                ->schema([
                    TextInput::make('libelle')
                        ->label('Libellé')
                        ->required(),

                    FileUpload::make('image_url')
                        ->label('Image')
                        ->image()
                        ->directory('biens/illustrations')
                        ->preserveFilenames()
                        ->visibility('public')
                        ->required()
                ])
                ->columnSpanFull()
                ->minItems(0)
                ->maxItems(10),
        ]);
    }

    /* ========================= TABLE ========================= */
    public static function table(Table $table): Table
    {
        return $table->columns([

            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            Tables\Columns\TextColumn::make('titre')
                ->label('Titre')
                ->searchable(),

            // TYPE BIEN
            Tables\Columns\TextColumn::make('type')
                ->label('Type')
                ->formatStateUsing(function ($state) {
                    return $state instanceof TypeBien
                        ? $state->label()
                        : TypeBien::from($state)->label();
                })
                ->sortable(),

            // MODE TRANSACTION (FIX SÉCURISÉ)
            Tables\Columns\TextColumn::make('mode_transaction')
                ->label('Transaction')
                ->formatStateUsing(function ($state) {
                    return $state instanceof ModeTransaction
                        ? $state->label()
                        : ModeTransaction::from($state)->label();
                })
                ->badge()
                ->color(function ($state) {
                    $value = $state instanceof ModeTransaction ? $state->value : $state;
                    return $value === 'location' ? 'info' : 'success';
                })
                ->sortable(),

            // STATUT BIEN
            Tables\Columns\TextColumn::make('statut')
                ->label('Statut')
                ->formatStateUsing(fn ($state) =>
                    $state instanceof StatutBien
                        ? $state->label()
                        : StatutBien::from($state)->label()
                )
                ->badge()
                ->color(function ($state) {
                    $value = $state instanceof StatutBien ? $state->value : $state;
                    return match ($value) {
                        'disponible' => 'success',
                        'reserve'    => 'warning',
                        'loue', 'vendu' => 'danger',
                        default      => 'gray',
                    };
                })
                ->sortable(),

            // PRIX
            Tables\Columns\TextColumn::make('prix')
                ->label('Prix (FCFA)')
                ->numeric()
                ->sortable(),

            // PROPRIÉTAIRE
            Tables\Columns\TextColumn::make('proprietaire.nom')
                ->label('Propriétaire')
                ->formatStateUsing(fn($record) =>
                    $record->proprietaire?->prenom .' '. $record->proprietaire?->nom
                )
                ->searchable(),

            // IMAGES MULTIPLES (fonctionne avec ton accessor)
            ImageColumn::make('illustrations.image_url')
                ->label('Photos')
                ->size(70)
                ->stacked()
                ->limit(3),

        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBienImmobiliers::route('/'),
            'create' => Pages\CreateBienImmobilier::route('/create'),
            'edit'   => Pages\EditBienImmobilier::route('/{record}/edit'),
        ];
    }
}
