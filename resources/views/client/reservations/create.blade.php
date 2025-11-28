<x-app-layout>
<br><br><br> 

<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">

        <h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
            Réserver : {{ $bien->titre }}
        </h1>

        <form action="{{ route('client.reservations.store', $bien->id) }}" method="POST">
            @csrf

            {{-- Infos Bien --}}
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Informations du bien</h4>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Prix :</span>
                        <span class="font-semibold text-green-600">
                            {{ number_format($bien->prix,0,',',' ') }} FCFA
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Type :</span>
                        <span class="font-semibold">{{ $bien->type->label() }}</span>
                    </div>

                    <div class="col-span-2">
                        <span class="text-gray-600 dark:text-gray-400">Adresse :</span>
                        <span class="font-semibold">{{ $bien->adresse }}</span>
                    </div>

                    <div class="col-span-2">
                        <span class="text-gray-600 dark:text-gray-400">Mode de transaction :</span>
                        <span class="font-semibold text-indigo-600">
                            {{ ucfirst($bien->mode_transaction->value) }}
                        </span>
                    </div>

                    <div class="col-span-2">
                        <span class="text-gray-600 dark:text-gray-400">Statut :</span>
                        <span class="font-semibold {{ $bien->statut === \App\Enums\StatutBien::DISPONIBLE ? 'text-green-600' : 'text-red-600' }}">
                            {{ $bien->statut->label() }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- Si pas disponible --}}
            @if($bien->statut !== \App\Enums\StatutBien::DISPONIBLE)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <strong>Attention :</strong> Ce bien n’est pas disponible pour réservation.
                </div>
            @else

                {{-- Date --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Date de réservation *</label>
                    <input type="datetime-local" name="dateReservation"
                           value="{{ old('dateReservation', now()->format('Y-m-d\TH:i')) }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           class="w-full border-gray-300 rounded-lg p-2"
                           required>
                </div>

                {{-- Méthode Paiement --}}
                <div class="space-y-2 mt-4">
                    <label class="block text-sm font-medium text-gray-700">Méthode de paiement *</label>
                    <select name="methode_paiement" class="w-full border-gray-300 rounded-lg p-2" required>
                        <option value="">Sélectionnez une méthode</option>
                        @foreach($methodesPaiement as $methode)
                            <option value="{{ $methode->value }}">{{ $methode->label() }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Paiement --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-5">
                    <h4 class="font-semibold text-blue-900 mb-3">Informations de paiement</h4>

                    @if($bien->mode_transaction->value === 'location')
                        <p><strong>Montant à payer :</strong>
                            {{ number_format($bien->prix,0,',',' ') }} FCFA
                            <span class="text-gray-500">(Location)</span>
                        </p>
                    @else
                        <p><strong>Acompte (10 %) :</strong>
                            {{ number_format($bien->prix * 0.1,0,',',' ') }} FCFA
                            <span class="text-gray-500">(Vente)</span>
                        </p>
                    @endif
                </div>

                {{-- Boutons --}}
                <div class="pt-4 flex justify-end space-x-4">
                    <a href="{{ route('biens.show', $bien->id) }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white py-3 px-8 rounded-lg">
                        Annuler
                    </a>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white py-3 px-8 rounded-lg">
                        Confirmer et Payer
                    </button>
                </div>
            @endif

        </form>
    </div>
</div>

</x-app-layout>
