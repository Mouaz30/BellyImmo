<x-app-layout>
<br><br><br>

<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">
        Tableau de Bord Propriétaire
    </h1>

    {{-- STAT CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <x-stat-card 
            title="Mes biens"
            value="{{ $biensCount }}"
            color="bg-indigo-500"
            icon='<svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg>'
        />

        <x-stat-card 
            title="Réservations reçues"
            value="{{ $reservationsTotal }}"
            color="bg-yellow-500"
            icon='<svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8h18"/></svg>'
        />

        <x-stat-card 
            title="En attente"
            value="{{ $reservationsEnAttente }}"
            color="bg-red-500"
            icon='<svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>'
        />

        <x-stat-card 
            title="Confirmées"
            value="{{ $reservationsConfirmees }}"
            color="bg-green-500"
            icon='<svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
        />

    </div>

    {{-- DERNIÈRES RÉSERVATIONS --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-10">

        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Dernières réservations reçues
        </h2>

        @if($derniereReservations->count() === 0)
            <p class="text-gray-400">Aucune réservation récente.</p>
        @else

        <div class="divide-y divide-gray-200 dark:divide-gray-700">

            @foreach($derniereReservations as $r)
                <div class="py-4 flex justify-between items-center">

                    <div>
                        <p class="text-gray-900 dark:text-white font-medium">
                            {{ $r->bienImmobilier->titre }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $r->client->name }}</p>
                        <p class="text-xs text-gray-400">{{ $r->dateReservation->format('d/m/Y H:i') }}</p>
                    </div>

                    <a href="{{ route('proprietaire.reservations.show', $r->id) }}"
                       class="text-blue-600 hover:underline">
                        Voir →
                    </a>

                </div>
            @endforeach

        </div>

        @endif
    </div>

    {{-- DERNIERS BIENS --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">

        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
            Mes derniers biens ajoutés
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($biensRecents as $b)
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow border">

                    <p class="font-semibold text-gray-900 dark:text-white">{{ $b->titre }}</p>
                    <p class="text-sm text-gray-500">{{ $b->adresse }}</p>

                    <p class="mt-2 text-green-600 font-bold">
                        {{ number_format($b->prix, 0, ',', ' ') }} FCFA
                    </p>

                    <a href="{{ route('proprietaire.Bien.edit', $b->id) }}"
                       class="text-blue-600 hover:underline text-sm mt-1 block">
                        Modifier →
                    </a>

                </div>
            @endforeach

        </div>

    </div>

</div>
</x-app-layout>
