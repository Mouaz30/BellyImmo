<x-app-layout>
<br><br><br>

<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">
        Tableau de Bord Client
    </h1>

    {{-- STATISTIQUES --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <x-stat-card 
            title="Réservations en attente"
            value="{{ $reservationsEnAttente }}"
            color="bg-yellow-500"
            icon='<svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />

        <x-stat-card 
            title="Réservations confirmées"
            value="{{ $reservationsConfirmees }}"
            color="bg-green-500"
            icon='<svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>'
        />

        <x-stat-card 
            title="Paiements en attente"
            value="{{ $paiementsEnAttente }}"
            color="bg-blue-500"
            icon='<svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c.265 0 .52.105.707.293l4 4a1 1 0 01-1.414 1.414L12 10.414V16a1 1 0 11-2 0V8z"/></svg>'
        />

    </div>

    {{-- DERNIÈRES RÉSERVATIONS --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">

        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">
            Dernières réservations
        </h2>

        @if($dernieresReservations->count() === 0)
            <p class="text-gray-500">Vous n’avez aucune réservation récente.</p>
        @else

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($dernieresReservations as $r)
                <div class="py-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $r->bienImmobilier->titre }}</p>
                        <p class="text-sm text-gray-500">{{ $r->dateReservation->format('d/m/Y à H:i') }}</p>
                    </div>

                    <a href="{{ route('client.reservations.show', $r->id) }}"
                       class="text-blue-600 hover:underline">
                        Voir
                    </a>
                </div>
            @endforeach
        </div>

        @endif

        <div class="mt-4">
            <a href="{{ route('client.reservations.index') }}"
               class="text-sm text-blue-600 hover:underline font-semibold">
                Voir toutes mes réservations →
            </a>
        </div>

    </div>

</div>
</x-app-layout>

