<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatut;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'role',
        'statut',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
        'statut' => UserStatut::class,
    ];

    // ==================== FILAMENT ====================

    public function getFilamentName(): string
    {
        return $this->nom_complet;
    }

    public function getUserName(): string
    {
        return $this->nom_complet ?: $this->email ?: 'Utilisateur';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdministrateur() || $this->isProprietaire();
    }

    // ==================== ACCESSORS ====================

    public function getNomCompletAttribute(): string
    {
        $prenom = trim($this->prenom ?? '');
        $nom = trim($this->nom ?? '');
        $nomComplet = trim("$prenom $nom");

        return $nomComplet !== '' ? $nomComplet : ($this->email ?? 'Utilisateur');
    }

    public function getInitialesAttribute(): string
    {
        $initials = '';
        if (!empty($this->prenom)) $initials .= mb_substr($this->prenom, 0, 1);
        if (!empty($this->nom)) $initials .= mb_substr($this->nom, 0, 1);
        return $initials ? strtoupper($initials) : 'U';
    }

    // ==================== RELATIONS ====================

    public function biensProprietaire(): HasMany
    {
        return $this->hasMany(BienImmobilier::class, 'proprietaire_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function visitesClient(): HasMany
    {
        return $this->hasMany(Visite::class, 'client_id');
    }

    public function contratsClient(): HasMany
    {
        return $this->hasMany(Contrat::class, 'client_id');
    }

    public function contratsAdministrateur(): HasMany
    {
        return $this->hasMany(Contrat::class, 'administrateur_id');
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class, 'client_id');
    }

    // ==================== SCOPES ====================

    public function scopeClients($query)
    {
        return $query->where('role', UserRole::CLIENT);
    }

    public function scopeProprietaires($query)
    {
        return $query->where('role', UserRole::PROPRIETAIRE);
    }

    public function scopeAdministrateurs($query)
    {
        return $query->where('role', UserRole::ADMINISTRATEUR);
    }

    public function scopeActifs($query)
    {
        return $query->where('statut', UserStatut::ACTIF);
    }

    public function scopeInactifs($query)
    {
        return $query->where('statut', UserStatut::INACTIF);
    }

    public function scopeSuspendus($query)
    {
        return $query->where('statut', UserStatut::SUSPENDU);
    }

     
    public function getFullNameAttribute(): string
    {
      return $this->nom . ' ' . $this->prenom;
    }

    public function isAdministrateur(): bool
    {
        return $this->role === UserRole::ADMINISTRATEUR;
    }

    public function isProprietaire(): bool
    {
        return $this->role === UserRole::PROPRIETAIRE;
    }

    public function isClient(): bool
    {
        return $this->role === UserRole::CLIENT;
    }

    public function isActif(): bool
    {
        return $this->statut === UserStatut::ACTIF;
    }

    public function isInactif(): bool
    {
        return $this->statut === UserStatut::INACTIF;
    }

    public function isSuspendu(): bool
    {
        return $this->statut === UserStatut::SUSPENDU;
    }

    public function peutGererBiens(): bool
    {
        return $this->isAdministrateur() || $this->isProprietaire();
    }

    public function peutAccederAdmin(): bool
    {
        return $this->isAdministrateur();
    }

    /**
     * ✅ Méthode pour s'assurer que nom/prenom ne restent jamais vides
     */
    public function remplirChampsNomParDefaut(): void
    {
        if (empty($this->prenom)) {
            $this->prenom = 'Utilisateur';
        }
        if (empty($this->nom)) {
            $this->nom = substr($this->email, 0, strpos($this->email, '@')) ?: 'Temp';
        }
        $this->save();
    }
}
