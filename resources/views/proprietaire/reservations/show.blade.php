<x-app-layout>
    <br><br><br>

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">

            {{-- HEADER --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                    Détails de la Réservation
                </h1>

                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($reservation->statut->value === 'en_attente') bg-yellow-100 text-yellow-800
                    @elseif($reservation->statut->value === 'confirmee') bg-green-100 text-green-800
                    @elseif($reservation->statut->value === 'annulee') bg-red-100 text-red-800
                    @else bg-gray-200 text-gray-900
                    @endif
                ">
                    {{ $reservation->statut->label() }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- INFORMATIONS RÉSERVATION --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informations de la Réservation
                    </h3>

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

                {{-- INFORMATIONS CLIENT --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informations du Client
                    </h3>

                    <p><strong>Nom :</strong> {{ $reservation->client->nom }} {{ $reservation->client->prenom }}</p>
                    <p><strong>Email :</strong> {{ $reservation->client->email }}</p>
                    <p><strong>Membre depuis :</strong> {{ $reservation->client->created_at->format('d/m/Y') }}</p>
                </div>

                {{-- BIEN IMMOBILIER --}}
                <div class="lg:col-span-2 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Bien Immobilier
                    </h3>

                    <div class="flex space-x-4">
                        <img class="h-20 w-20 rounded-lg object-cover"
                             src="{{ $reservation->bienImmobilier->illustrations->first()?->image_url ?? asset('images/default.png') }}">

                        <div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $reservation->bienImmobilier->titre }}
                            </p>

                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $reservation->bienImmobilier->adresse }}
                            </p>

                            <p class="font-semibold text-green-600 dark:text-green-400">
                                {{ number_format($reservation->bienImmobilier->prix, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>

                {{-- PAIEMENT --}}
                <div class="lg:col-span-2 bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg space-y-4">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200">
                        Informations de Paiement
                    </h3>

                    @if($reservation->paiement)

                        <p><strong>Méthode :</strong>
                            {{ $reservation->paiement->methode->label() }}
                        </p>

                        <p><strong>Montant :</strong>
                            {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} FCFA
                        </p>

                        <p><strong>Statut :</strong>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($reservation->paiement->statut === 'paye') bg-green-100 text-green-800
                                @elseif($reservation->paiement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                @endif
                            ">
                                {{ $reservation->paiement->statut }}
                            </span>
                        </p>

                        {{-- AFFICHER LE BOUTON CONFIRMER : SEULEMENT SI :
                            1. statut = en_attente
                            2. methode = ESPECES
                            3. paiement existe --}}
                        @if(
                            $reservation->statut->value === 'en_attente'
                            && $reservation->paiement
                            && $reservation->paiement->methode->value === 'ESPECES'
                        )
                            <div class="mt-5 flex space-x-4">

                                {{-- BOUTON ACCEPTER --}}
                                <form action="{{ route('proprietaire.reservations.accept', $reservation->id) }}"
                                      method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-semibold">
                                        Confirmer la réservation (Paiement Espèces)
                                    </button>
                                </form>

                                {{-- BOUTON REFUSER --}}
                                <form action="{{ route('proprietaire.reservations.reject', $reservation->id) }}"
                                      method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold">
                                        Refuser
                                    </button>
                                </form>
                            </div>
                        @endif

                    @else
                        <p class="text-gray-400 dark:text-gray-300">Aucun paiement enregistré.</p>
                    @endif

                </div>

            </div>

            {{-- BOUTONS BAS DE PAGE --}}
            <div class="flex justify-between pt-8">
                <a href="{{ route('proprietaire.reservations.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg">
                    ← Retour
                </a>

                <a href="{{ route('proprietaire.Bien.list') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg">
                    Voir mes biens
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
