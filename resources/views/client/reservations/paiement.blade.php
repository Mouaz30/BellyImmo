<x-app-layout>
<br><br><br>

<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl">

        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6 border-b pb-4">
            Paiement
        </h1>

        {{-- ================================ --}}
        {{--       INFORMATIONS RÉSERVATION  --}}
        {{-- ================================ --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Réservation</h2>

            <p><strong>Bien :</strong> {{ $reservation->bienImmobilier->titre }}</p>
            <p><strong>Adresse :</strong> {{ $reservation->bienImmobilier->adresse }}</p>
            <p><strong>Date :</strong> {{ $reservation->dateReservation->format('d/m/Y H:i') }}</p>

            <p class="mt-2">
                <strong>Type de transaction :</strong>
                {{ ucfirst($reservation->bienImmobilier->mode_transaction->value) }}
            </p>
        </div>

        {{-- ================================ --}}
        {{--               PAIEMENT           --}}
        {{-- ================================ --}}
        <div class="bg-blue-50 dark:bg-gray-700 p-5 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold text-blue-900 dark:text-white mb-2">
                Montant à payer
            </h2>

            {{-- MONTANT AFFICHÉ SELON TRANSACTION --}}
            <p class="text-lg font-bold text-blue-700">
                @if($reservation->bienImmobilier->mode_transaction->value === 'location')
                    {{-- LOCATION : paiement du montant total --}}
                    {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                @else
                    {{-- VENTE : acompte de 10% --}}
                    {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} FCFA
                    <span class="text-sm text-gray-600">(Acompte 10%)</span>
                @endif
            </p>

            <p class="mt-2">
                <strong>Méthode :</strong>
                {{ $reservation->paiement->methode->label() }}
            </p>

            <p class="mt-1">
                <strong>Statut :</strong>
                {{ $reservation->paiement->statut->label() }}
            </p>
        </div>

        {{-- ================================ --}}
        {{--       BOUTON DE PAIEMENT        --}}
        {{-- ================================ --}}
        <form action="{{ route('client.reservations.processPaiement', $reservation->id) }}" method="POST">
            @csrf

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-lg font-bold">
                Procéder au paiement
            </button>
        </form>

        <div class="mt-4 text-right">
            <a href="{{ route('client.reservations.show', $reservation) }}" class="text-blue-600 hover:underline">
                Retour à la réservation
            </a>
        </div>

    </div>
</div>

</x-app-layout>
