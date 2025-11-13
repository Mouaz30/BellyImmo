<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Enums\UserStatut; 
use App\Enums\UserRole; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('prenom')
                    ->label('Prénom')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('nom')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('telephone')
                    ->label('Téléphone')
                    ->tel()
                    ->maxLength(25),

                Forms\Components\Select::make('role')
                    ->label('Rôle')
                    ->options([
                        UserRole::CLIENT->value => 'Client',
                        UserRole::PROPRIETAIRE->value => 'Propriétaire',
                        UserRole::ADMINISTRATEUR->value => 'Administrateur',
                    ])
                    ->required(),
                
                Forms\Components\Select::make('statut')
                    ->label('Statut')
                    ->options(UserStatut::class) 
                    ->default(UserStatut::ACTIF) 
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->same('passwordConfirmation')
                    ->label('Mot de passe'),

                Forms\Components\TextInput::make('passwordConfirmation')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(false)
                    ->label('Confirmer le mot de passe'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nom_complet')
                    ->label('Nom complet')
                    ->getStateUsing(fn ($record) => $record->nom_complet)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('email')->searchable(),

                Tables\Columns\TextColumn::make('telephone')->label('Téléphone'),
                
                Tables\Columns\BadgeColumn::make('statut')
                    ->label('Statut')
                    ->sortable()
                    ->colors([
                        'success' => UserStatut::ACTIF->value,
                        'danger'  => UserStatut::INACTIF->value,
                        'warning' => UserStatut::SUSPENDU->value,
                    ]),
                
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'success' => UserRole::PROPRIETAIRE->value,
                        'warning' => UserRole::CLIENT->value,
                        'danger'  => UserRole::ADMINISTRATEUR->value,
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(UserRole::class),
                Tables\Filters\SelectFilter::make('statut')
                    ->options(UserStatut::class)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    // ⚠️ Les méthodes canDelete() et canDeleteAny() sont retirées.
    // L'accès à la suppression est maintenant implicite pour quiconque peut voir cette page.

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}