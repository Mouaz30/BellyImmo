<x-app-layout>
    <br><br><br>
    <div class="max-w-4xl mx-auto mt-12 p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Détail de la demande de visite</h1>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">{{ $visite->bien->titre }}</h2>
            <p class="text-sm text-gray-600">{{ $visite->bien->adresse }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Client :</strong> {{ $visite->client->name ?? '—' }}</p>
                <p><strong>Email :</strong> {{ $visite->client->email ?? '—' }}</p>
                <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($visite->date_visite)->format('d/m/Y') }}</p>
                <p><strong>Heure :</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $visite->heure_visite)->format('H:i') ?? $visite->heure_visite }}</p>
            </div>

            <div>
                <p><strong>Message :</strong></p>
                <div class="mt-2 p-3 bg-gray-50 rounded">{{ $visite->message ?? 'Aucun message' }}</div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            @if($visite->statut === \App\Enums\StatutVisite::EN_ATTENTE->value ?? 'EN_ATTENTE')
                <form action="{{ route('proprietaire.visites.accept', $visite->id) }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 text-white rounded">Accepter</button>
                </form>

                <form action="{{ route('proprietaire.visites.reject', $visite->id) }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-red-600 text-white rounded" onclick="return confirm('Refuser la visite ?')">Refuser</button>
                </form>
            @endif

            <a href="{{ route('proprietaire.visites.index') }}" class="px-4 py-2 bg-gray-200 rounded">Retour</a>
        </div>
    </div>
</x-app-layout>
