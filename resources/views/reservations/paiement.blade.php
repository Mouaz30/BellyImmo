<x-app-layout>
    <br><br><br>

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold">Détails de la Réservation</h1>

                <span class="px-4 py-1.5 rounded-full text-sm font-medium
                    @if($reservation->statut->value === 'en_attente') bg-yellow-100 text-yellow-800
                    @elseif($reservation->statut->value === 'confirmee') bg-green-100 text-green-800
                    @elseif($reservation->statut->value === 'annulee') bg-red-100 text-red-800
                    @endif">
                    {{ $reservation->statut->label() }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Infos réservation --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold">Informations Réservation</h3>

                    <p><strong>Type :</strong> {{ $reservation->type->label() }}</p>

                    <p><strong>Prix total :</strong>
                        {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                    </p>

                    <p><strong>Date :</strong>
                        {{ $reservation->dateReservation->format('d/m/Y H:i') }}
                    </p>

                    <p><strong>Référence :</strong>
                        #RES{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                {{-- Infos bien --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold">Bien Immobilier</h3>

                    <div class="flex space-x-4 items-start">
                        <img src="{{ $reservation->bienImmobilier->illustrations->first()?->image_url ?? asset('images/default.png') }}"
                             class="h-20 w-20 rounded-lg object-cover">

                        <div>
                            <p class="text-lg font-semibold">
                                {{ $reservation->bienImmobilier->titre }}
                            </p>

                            <p class="text-gray-600">
                                {{ $reservation->bienImmobilier->adresse }}
                            </p>

                            <p><strong>Prix :</strong>
                                {{ number_format($reservation->bienImmobilier->prix,0,',',' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Paiement --}}
                <div class="lg:col-span-2 bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg space-y-3">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200">
                        Paiement
                    </h3>

                    @if($reservation->paiement)

                        <p><strong>Montant :</strong>
                            {{ number_format($reservation->paiement->montant,0,',',' ') }} FCFA
                        </p>

                        <p><strong>Méthode :</strong>
                            {{ $reservation->paiement->methode->label() }}
                        </p>

                        <p><strong>Statut :</strong>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($reservation->paiement->statut === 'paye') bg-green-100 text-green-800
                                @elseif($reservation->paiement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $reservation->paiement->statut }}
                            </span>
                        </p>

                        {{-- Bouton payer si en attente --}}
                        @if($reservation->paiement->statut === 'en_attente')
                            <div class="mt-4">
                                <a href="{{ route('client.reservations.paiement', $reservation) }}"
                                   class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-bold">
                                    Procéder au Paiement
                                </a>
                            </div>
                        @endif

                    @else
                        <p class="text-gray-400">Aucun paiement enregistré.</p>
                    @endif

                </div>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('client.reservations.index') }}"
                   class="text-blue-600 hover:underline">
                    ← Retour à mes réservations
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
