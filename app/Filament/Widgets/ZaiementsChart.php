<?php

namespace App\Filament\Widgets;

use App\Models\Paiement;
use Filament\Widgets\LineChartWidget;
use Carbon\Carbon;

class ZaiementsChart extends LineChartWidget
{
    protected static ?string $heading = 'Paiements mensuels';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);

            $labels[] = $mois->format('M Y');
            $data[] = Paiement::where('statut', 'paye')
                ->whereMonth('date_paiement', $mois->month)
                ->whereYear('date_paiement', $mois->year)
                ->sum('montant');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Montants payés',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
