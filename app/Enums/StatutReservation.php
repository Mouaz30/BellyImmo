<?php

namespace App\Enums;

enum StatutReservation: string
{
    case EN_ATTENTE = 'en_attente';
    case CONFIRMEE = 'confirmee';
    case ANNULEE = 'annulee';
    case EXPIREE = 'expiree';

    public function label(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'En attente',
            self::CONFIRMEE => 'Confirmée',
            self::ANNULEE => 'Annulée',
            self::EXPIREE => 'Expirée',
        };
    }
}
