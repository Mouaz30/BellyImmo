<x-app-layout>
    <br><br><br>
    <div class="max-w-xl mx-auto mt-16 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">

        <h1 class="text-2xl font-bold mb-4">Demander une visite pour : {{ $bien->titre }}</h1>

        <form action="{{ route('client.visites.store', $bien) }}" method="POST">
            @csrf

            <label class="block mt-4">Date souhaitée :</label>
            <input type="date" name="date_visite" class="w-full mt-1 p-2 border rounded" required>

            <label class="block mt-4">Heure :</label>
            <input type="time" name="heure_visite" class="w-full mt-1 p-2 border rounded" required>

            <label class="block mt-4">Message (optionnel) :</label>
            <textarea name="message" class="w-full mt-1 p-2 border rounded"></textarea>

            <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
                Envoyer la demande
            </button>
        </form>
    </div>
</x-app-layout>
