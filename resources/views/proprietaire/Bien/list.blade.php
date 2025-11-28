<x-app-layout>
<br><br><br><br><br>

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
            Mes Biens Immobiliers 🏡
        </h1>
        <a href="{{ route('proprietaire.Bien.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
            + Ajouter un bien
        </a>
    </div>

    {{-- MESSAGE SUCCESS --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- SI PAS DE BIENS --}}
    @if($biens->isEmpty())
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mt-8">
            <p class="font-bold">Aucun bien trouvé.</p>
            <p>Ajoutez un bien pour commencer.</p>
        </div>
    @else

    {{-- LISTE DES BIENS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($biens as $bien)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden flex flex-col hover:shadow-2xl transition hover:scale-[1.02]">

                {{-- IMAGE --}}
                <div class="relative h-48 overflow-hidden">
                    @if($bien->illustrations->isNotEmpty())
                        <img src="{{ $bien->illustrations->first()->image_url }}">
                        <!-- <img src="{{ Storage::url($bien->illustrations->first()->image_url) }}" -->
                    @else
                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            Pas d’image
                        </div>
                    @endif

                    {{-- TYPE (APPARTEMENT, MAISON, etc.) --}}
                    <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                        {{ $bien->type->label() }}
                    </span>

                    {{-- STATUT COULEUR --}}
                    @php
                            $color = match($bien->statut->value) {
                            'disponible' => 'bg-green-600',
                            'reserve' => 'bg-yellow-500',
                            'loue' => 'bg-red-600',
                            'vendu' => 'bg-gray-600',
                          default => 'bg-gray-500'
                        };
                    @endphp

                    <span class="absolute top-2 right-2 {{ $color }} text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                        {{ $bien->statut->label() }}
                    </span>
                </div>

                {{-- CONTENU --}}
                <div class="p-4 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 truncate">
                        {{ $bien->titre }}
                    </h3>

                    {{-- PRIX --}}
                    <p class="text-2xl font-extrabold text-green-600 dark:text-green-400 mb-3">
                        {{ number_format($bien->prix, 0, ',', ' ') }} FCFA
                    </p>

                    {{-- MODE DE TRANSACTION --}}
                    <p class="text-sm font-semibold mb-1">
                        <span class="text-gray-700 dark:text-gray-300">Transaction :</span>
                        <span class="text-indigo-600 dark:text-indigo-400 uppercase">{{ $bien->mode_transaction }}</span>
                    </p>

                    {{-- ADRESSE --}}
                    <p class="text-gray-600 dark:text-gray-300 text-sm flex items-center mb-4">
                        <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="truncate">{{ $bien->adresse }}</span>
                    </p>

                    {{-- ACTIONS --}}
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700 mt-auto flex justify-between items-center">
                        <a href="{{ route('proprietaire.Bien.edit', $bien->id) }}"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600">
                            Modifier
                        </a>

                        <form action="{{ route('proprietaire.Bien.destroy', $bien->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de ce bien ?')"
                                    class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

    @endif
</div>
</x-app-layout>
