<?php

namespace App\Enums;

enum MethodePaiement: string
{
    case OM = 'OM';
    case WAVE = 'WAVE';
    case ESPECES = 'ESPECES';
    case CB = 'CB';

    public function label(): string
    {
        return match($this) {
            self::OM => 'Orange Money',
            self::WAVE => 'Wave',
            self::ESPECES => 'Espèces',
            self::CB => 'Carte Bancaire',
        };
    }
}