<x-app-layout>
<br><br><br><br><br>
    <div class="container mx-auto px-6 py-14">

        {{-- HEADER --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Mes Réservations
            </h1>
            <div class="mx-auto w-24 h-1 bg-primary rounded mt-3"></div>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">
                Consultez vos réservations, suivez vos paiements et accédez rapidement aux détails de vos biens.
            </p>
        </div>

        @if($reservations->count() > 0)

            {{-- GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

                @foreach($reservations as $reservation)

                    <div class="card card-hover animate-fade-slide relative overflow-hidden">

                        {{-- Bandeau statut --}}
                        <div class="absolute top-0 right-0 px-4 py-1 rounded-bl-2xl text-xs font-bold text-white shadow
                            @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE)
                                bg-warning
                            @elseif($reservation->statut === \App\Enums\StatutReservation::CONFIRMEE)
                                bg-success
                            @elseif($reservation->statut === \App\Enums\StatutReservation::ANNULEE)
                                bg-danger
                            @endif">
                            {{ $reservation->statut->label() }}
                        </div>

                        <div class="p-6 flex flex-col">

                            {{-- TITRE --}}
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $reservation->bienImmobilier->titre }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    {{ $reservation->bienImmobilier->adresse }}
                                </p>
                            </div>

                            {{-- INFO GRID --}}
                            <div class="grid grid-cols-2 gap-4 text-sm">

                                {{-- Mode transaction --}}
                                <div class="bg-surface-soft dark:bg-darkmode-soft p-3 rounded-xl shadow-sm">
                                    <p class="text-primary font-bold">Transaction</p>
                                    <p class="text-gray-800 dark:text-gray-100">
                                        {{ ucfirst($reservation->bienImmobilier->mode_transaction->value) }}
                                    </p>
                                </div>

                                {{-- Montant --}}
                                <div class="bg-surface-soft dark:bg-darkmode-soft p-3 rounded-xl shadow-sm">
                                    <p class="text-accent font-bold">Montant</p>

                                    @if($reservation->bienImmobilier->mode_transaction->value === 'location')
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ number_format($reservation->prix, 0, ',', ' ') }} FCFA
                                        </p>
                                    @else
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} FCFA
                                            <span class="text-xs text-gray-500">(Acompte 10%)</span>
                                        </p>
                                    @endif
                                </div>

                                {{-- Date --}}
                                <div class="bg-surface-soft dark:bg-darkmode-soft p-3 rounded-xl shadow-sm">
                                    <p class="text-violet-600 font-bold">Date</p>
                                    <p class="text-gray-800 dark:text-gray-100">
                                        {{ $reservation->dateReservation->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                {{-- Paiement statut --}}
                                <div class="bg-surface-soft dark:bg-darkmode-soft p-3 rounded-xl shadow-sm">
                                    <p class="text-warning font-bold">Paiement</p>

                                    @if($reservation->paiement)
                                        <span class="badge mt-1
                                            @if($reservation->paiement->statut === \App\Enums\StatutPaiement::PAYE)
                                                badge-success
                                            @elseif($reservation->paiement->statut === \App\Enums\StatutPaiement::EN_ATTENTE)
                                                badge-warning
                                            @else
                                                badge-danger
                                            @endif">
                                            {{ $reservation->paiement->statut->label() }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="mt-6 flex flex-col gap-3">

                                {{-- Voir détails --}}
                                <a href="{{ route('client.reservations.show', $reservation->id) }}"
                                   class="btn-primary-gradient w-full text-center">
                                    Voir Détails
                                </a>

                                {{-- Régler paiement --}}
                                @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE 
                                    && $reservation->paiement 
                                    && $reservation->paiement->statut === \App\Enums\StatutPaiement::EN_ATTENTE)
                                    <a href="{{ route('client.reservations.paiement', $reservation->id) }}"
                                       class="btn-success w-full text-center">
                                        Régler le paiement
                                    </a>
                                @endif

                                {{-- Annuler --}}
                                @if($reservation->statut === \App\Enums\StatutReservation::EN_ATTENTE)
                                    <form action="{{ route('client.reservations.cancel', $reservation) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Voulez-vous annuler cette réservation ?')"
                                                class="btn-danger w-full">
                                            Annuler
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>
                    </div>

                @endforeach

            </div>

            <div class="mt-12">
                {{ $reservations->links() }}
            </div>

        @else
            <p class="text-center text-gray-500 dark:text-gray-400 text-lg py-14">
                Aucune réservation trouvée.
            </p>
        @endif

    </div>

</x-app-layout>
