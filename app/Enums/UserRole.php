<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMINISTRATEUR = 'administrateur';
    case PROPRIETAIRE = 'proprietaire';
    case CLIENT = 'client';
}
