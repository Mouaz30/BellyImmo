<x-app-layout>
<br><br><br>
<div class="max-w-4xl mx-auto mt-12 p-6 bg-white dark:bg-gray-800 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6">Mes demandes de visite</h1>

    @forelse($visites as $visite)
        <div class="border p-4 rounded-lg mb-4">
            <h2 class="text-lg font-semibold">{{ $visite->bien->titre }}</h2>

            <p><strong>Date :</strong> {{ $visite->date_visite }}</p>
            <p><strong>Heure :</strong> {{ $visite->heure_visite }}</p>
            <p><strong>Statut :</strong> {{ $visite->statut }}</p>
        </div>

    @empty
        <p>Aucune demande de visite.</p>
    @endforelse

    {{ $visites->links() }}

</div>

</x-app-layout>
