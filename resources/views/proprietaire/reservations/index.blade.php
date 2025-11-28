<x-app-layout>
    <br><br><br>
    <div class="container mx-auto p-6">
        <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">

            <h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
                Gestion des Réservations
            </h1>

            {{-- STATISTIQUES --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                {{-- En attente --}}
                <x-stat-card 
                    label="En attente"
                    count="{{ $reservations->where('statut', \App\Enums\StatutReservation::EN_ATTENTE)->count() }}"
                    color="blue" />

                {{-- Confirmées --}}
                <x-stat-card 
                    label="Confirmées"
                    count="{{ $reservations->where('statut', \App\Enums\StatutReservation::CONFIRMEE)->count() }}"
                    color="green" />

                {{-- Annulées --}}
                <x-stat-card 
                    label="Annulées"
                    count="{{ $reservations->where('statut', \App\Enums\StatutReservation::ANNULEE)->count() }}"
                    color="red" />

                {{-- Total --}}
                <x-stat-card 
                    label="Total"
                    count="{{ $reservations->count() }}"
                    color="gray" />

            </div>

            {{-- LISTE DES RÉSERVATIONS --}}
            @if ($reservations->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Bien & Client</th>
                                <th class="px-6 py-3 text-left">Type & Prix</th>
                                <th class="px-6 py-3 text-left">Paiement</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y dark:divide-gray-700">

                            @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                                    {{-- Bien + Client --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">

                                            @php
                                                $image = $reservation->bienImmobilier->illustrations->first();
                                            @endphp

                                <img 
                                    src="{{ $reservation->bienImmobilier->illustrations->first()?->image_url ?? asset('images/default.png') }}"
                                    class="h-20 w-32 object-cover rounded-lg shadow-md border"
                                />

                                            <div class="ml-3">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $reservation->bienImmobilier->titre }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Client : {{ $reservation->client->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Type / Prix --}}
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <p>{{ $reservation->type->label() }}</p>
                                        <p class="text-gray-500">
                                            {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                                        </p>
                                    </td>

                                    {{-- Paiement --}}
                                    <td class="px-6 py-4 text-sm">

                                        @if($reservation->paiement)
                                            <p class="font-semibold text-blue-600">
                                                {{ $reservation->paiement->methode->label() }}
                                            </p>

                                            <span class="px-2 py-1 rounded-full text-xs 
                                                @if($reservation->paiement->statut === \App\Enums\StatutPaiement::PAYE) bg-green-100 text-green-800
                                                @elseif($reservation->paiement->statut === \App\Enums\StatutPaiement::EN_ATTENTE) bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $reservation->paiement->statut->label() }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">Aucun paiement</span>
                                        @endif

                                    </td>

                                    {{-- Statut --}}
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE) bg-yellow-100 text-yellow-800
                                            @elseif($reservation->statut === \App\Enums\StatutReservation::CONFIRMEE) bg-green-100 text-green-800
                                            @elseif($reservation->statut === \App\Enums\StatutReservation::ANNULEE) bg-red-100 text-red-800
                                            @else bg-gray-200 text-gray-900 @endif">
                                            {{ $reservation->statut->label() }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex space-x-3">

                                            <a href="{{ route('proprietaire.reservations.show', $reservation->id) }}"
                                               class="text-blue-600 hover:text-blue-800">
                                                Détails
                                            </a>

                                            {{-- Accepter / Refuser uniquement si paiement espèces --}}
                                            @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE 
                                                && $reservation->paiement 
                                                && $reservation->paiement->methode === \App\Enums\MethodePaiement::ESPECES)

                                                <form method="POST"
                                                      action="{{ route('proprietaire.reservations.accept', $reservation->id) }}">
                                                    @csrf
                                                    <button class="text-green-600 hover:text-green-800">Accepter</button>
                                                </form>

                                                <form method="POST"
                                                      action="{{ route('proprietaire.reservations.reject', $reservation->id) }}">
                                                    @csrf
                                                    <button class="text-red-600 hover:text-red-800">Refuser</button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            @else
                <p class="text-center py-10 text-gray-500">Aucune réservation trouvée.</p>
            @endif

        </div>
    </div>
</x-app-layout>





