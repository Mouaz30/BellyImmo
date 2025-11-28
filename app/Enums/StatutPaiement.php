<?php

namespace App\Enums;

enum StatutPaiement: string
{
    case EN_ATTENTE = 'en_attente';
    case PAYE = 'paye';
    case ECHEC = 'echec';
    case ANNULE = 'annule';

    public function label(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'En attente',
            self::PAYE => 'Payé',
            self::ECHEC => 'Échec',
            self::ANNULE => 'Annulé',
        };
    }
}

