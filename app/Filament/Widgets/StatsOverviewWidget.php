<?php

namespace App\Filament\Widgets;

use App\Models\BienImmobilier;
use App\Models\Paiement;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [

            Card::make('Revenus totaux', number_format(Paiement::where('statut', 'paye')->sum('montant'), 0, ',', ' ') . ' FCFA')
                ->description('Paiements confirmés')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Card::make('Réservations', Reservation::count())
                ->description('Réservations totales')
                ->descriptionIcon('heroicon-o-calendar'),

            Card::make('Biens disponibles', BienImmobilier::where('statut', 'disponible')->count())
                ->description('Stock actif')
                ->color('info'),

            Card::make('Locations actives', BienImmobilier::where('mode_transaction', 'location')->count())
                ->color('warning'),

            Card::make('Biens en vente', BienImmobilier::where('mode_transaction', 'vente')->count())
                ->color('danger'),
        ];
    }
}
