<?php

namespace App\Enums;

enum StatutContrat: string
{
    case EN_ATTENTE = 'en_attente';
    case SIGNE = 'signe';
    case RESILIE = 'resilie';
    case EXPIRE = 'expire';

    public function label(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'En attente',
            self::SIGNE => 'Signé',
            self::RESILIE => 'Résilié',
            self::EXPIRE => 'Expiré',
        };
    }
}
