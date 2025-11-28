<x-app-layout>
    <br><br><br>
    <div class="max-w-6xl mx-auto mt-12 p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Demandes de visite reçues</h1>

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @forelse($visites as $visite)
            <div class="mb-4 border rounded-lg p-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                <div>
                    <h2 class="font-semibold text-lg">{{ $visite->bien->titre }}</h2>
                    <p class="text-sm text-gray-600">{{ $visite->bien->adresse }}</p>
                </div>

                <div>
                    <p><strong>Client :</strong> {{ $visite->client->nom ?? '—' }} {{ $visite->client->prenom ?? '—' }}</p>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($visite->date_visite)->format('d/m/Y') }}</p>
                    <p><strong>Heure :</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $visite->heure_visite)->format('H:i') ?? $visite->heure_visite }}</p>
                </div>

                <div class="text-right space-y-2">
                    <a href="{{ route('proprietaire.visites.show', $visite->id) }}" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Détails</a>

                    @if($visite->statut === \App\Enums\StatutVisite::EN_ATTENTE->value ?? 'EN_ATTENTE')
                        <form action="{{ route('proprietaire.visites.accept', $visite->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Accepter</button>
                        </form>

                        <form action="{{ route('proprietaire.visites.reject', $visite->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Confirmer le refus ?')">Refuser</button>
                        </form>
                    @else
                        <span class="inline-block px-3 py-1 rounded {{ $visite->statut === (\App\Enums\StatutVisite::VALIDEE->value ?? 'VALIDEE') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ \App\Enums\StatutVisite::from($visite->statut)->label() ?? $visite->statut }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p>Aucune demande de visite pour l'instant.</p>
        @endforelse

        <div class="mt-6">
            {{ $visites->links() }}
        </div>
    </div>
</x-app-layout>
