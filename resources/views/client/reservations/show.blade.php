<x-app-layout>
<br><br><br>

<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">

        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white border-b pb-4 mb-6">
            Détails de la Réservation
        </h1>

        {{-- ================================ --}}
        {{--     INFORMATIONS DU BIEN        --}}
        {{-- ================================ --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                Bien concerné
            </h2>

            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $reservation->bienImmobilier->titre }}
            </p>

            <p class="text-gray-600 dark:text-gray-300 mt-1">
                {{ $reservation->bienImmobilier->adresse }}
            </p>

            {{-- Prix selon type --}}
            <p class="text-gray-700 dark:text-gray-200 mt-3">
                <strong>Montant :</strong>

                @if($reservation->bienImmobilier->mode_transaction->value === 'location')
                    {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                @else
                    {{ number_format($reservation->prix * 0.10, 0, ',', ' ') }} FCFA
                    <span class="text-sm text-gray-500">(Acompte 10%)</span>
                @endif
            </p>

            <p class="text-gray-700 dark:text-gray-200">
                <strong>Transaction :</strong>
                {{ ucfirst($reservation->bienImmobilier->mode_transaction->value) }}
            </p>
        </div>

        {{-- ================================ --}}
        {{--  INFOS RESERVATION              --}}
        {{-- ================================ --}}
        <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                Informations sur la réservation
            </h2>

            {{-- Statut réservation --}}
            <p>
                <strong>Statut :</strong>
                <span class="px-3 py-1 rounded-full text-sm font-bold
                    @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE)
                        bg-yellow-100 text-yellow-800
                    @elseif($reservation->statut === \App\Enums\StatutReservation::CONFIRMEE)
                        bg-green-100 text-green-800
                    @elseif($reservation->statut === \App\Enums\StatutReservation::ANNULEE)
                        bg-red-100 text-red-800
                    @endif">
                    {{ $reservation->statut->label() }}
                </span>
            </p>

            <p class="mt-2">
                <strong>Date prévue :</strong>
                {{ $reservation->dateReservation->format('d/m/Y H:i') }}
            </p>
        </div>

        {{-- ================================ --}}
        {{--            PAIEMENT             --}}
        {{-- ================================ --}}
        @if($reservation->paiement)
            <div class="bg-blue-50 dark:bg-gray-700 p-5 rounded-lg shadow mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Paiement
                </h2>

                {{-- Montant payé --}}
                <p>
                    <strong>Montant réglé :</strong>

                    @if($reservation->bienImmobilier->mode_transaction->value === 'location')
                        {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                    @else
                        {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} FCFA
                        <span class="text-sm text-gray-500">(Acompte)</span>
                    @endif
                </p>

                <p class="mt-1">
                    <strong>Méthode :</strong>
                    {{ $reservation->paiement->methode->label() }}
                </p>

                {{-- Statut paiement --}}
                <p class="mt-2">
                    <strong>Statut du paiement :</strong>
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        @if($reservation->paiement->statut === \App\Enums\StatutPaiement::PAYE)
                            bg-green-100 text-green-800
                        @elseif($reservation->paiement->statut === \App\Enums\StatutPaiement::EN_ATTENTE)
                            bg-yellow-100 text-yellow-800
                        @else
                            bg-gray-100 text-gray-800
                        @endif">
                        {{ $reservation->paiement->statut->label() }}
                    </span>
                </p>
            </div>
        @endif

        {{-- ================================ --}}
        {{--               ACTIONS           --}}
        {{-- ================================ --}}
        <div class="flex justify-end gap-4 mt-6">

            {{-- RETOUR --}}
            <a href="{{ route('client.reservations.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                Retour
            </a>

            {{-- BOUTON TOUJOURS VISIBLE (GET) --}}
            <form action="{{ route('client.reservations.paiement', $reservation->id) }}" method="GET">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg">
                    Accéder au paiement
                </button>
            </form>

            {{-- BOUTONS CONDITIONNELS --}}
            @if(
                $reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE 
                && $reservation->paiement 
                && $reservation->paiement->statut === \App\Enums\StatutPaiement::EN_ATTENTE
            )
                <form action="{{ route('client.reservations.paiement', $reservation->id) }}" method="GET">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Régler le paiement
                    </button>
                </form>

                <form action="{{ route('client.reservations.cancel', $reservation) }}" method="POST">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Voulez-vous annuler cette réservation ?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg">
                        Annuler
                    </button>
                </form>
            @endif

        </div>

    </div>
</div>
                <form action="{{ route('client.reservations.paiement', $reservation->id) }}" method="GET">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Régler le paiement
                    </button>
                </form>
</x-app-layout>
