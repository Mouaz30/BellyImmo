<x-app-layout>

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="mb-8 mt-10">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 font-medium transition">
                        Accueil
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-bold truncate">{{ $bien->titre }}</li>
            </ol>
        </nav>

        {{-- Contenu principal --}}
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            {{-- Colonne gauche --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Galerie d’images --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($bien->illustrations as $index => $illustration)
                        @php
                            $isFirst = $index === 0;
                            $grid = $isFirst ? 'col-span-2' : 'col-span-1';
                            $height = $isFirst ? 'h-96 sm:h-[400px]' : 'h-64 sm:h-72';
                        @endphp

                        <div class="{{ $grid }} rounded-2xl shadow-lg overflow-hidden bg-white group">
                            <img src="{{ $illustration->image_url }}"
                                 alt="{{ $bien->titre }}"
                                 class="w-full {{ $height }} object-cover group-hover:scale-[1.05] duration-500">
                        </div>
                    @empty
                        <div class="col-span-3 h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                            <span class="text-gray-500 text-lg">Aucune image disponible</span>
                        </div>
                    @endforelse
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl shadow-xl p-8 mt-6 border border-gray-100">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">
                        Description du bien
                    </h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line text-justify">
                        {{ $bien->description }}
                    </p>
                </div>

                {{-- Informations clés --}}
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">
                        Informations clés
                    </h2>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Type de bien</dt>
                            <dd class="font-bold text-gray-900">{{ $bien->type->value }}</dd>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Adresse</dt>
                            <dd class="font-bold text-gray-900">{{ $bien->adresse }}</dd>
                        </div>

                         <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Ville</dt>
                            <dd class="font-bold text-gray-900">{{ $bien->Ville }}</dd>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Prix</dt>
                            <dd class="font-bold text-gray-900">
                                {{ number_format($bien->prix, 0, ',', ' ') }} FCFA
                            </dd>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Statut</dt>
                            <dd class="font-bold text-gray-900">{{ $bien->statut->label() }}</dd>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-100">
                            <dt class="font-semibold text-gray-500">Mode de transaction</dt>
                            <dd class="font-bold text-gray-900">
                                {{ ucfirst($bien->mode_transaction->value) }}
                            </dd>
                        </div>

                    </dl>
                </div>

            </div>

            {{-- Carte prix --}}
            <div class="mt-10 lg:mt-0">
                <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-8 border-t-4 border-orange-600">

                    <h1 class="text-3xl font-extrabold text-gray-900">{{ $bien->titre }}</h1>

                    <p class="text-orange-600 font-extrabold text-3xl mt-4">
                        {{ number_format($bien->prix, 0, ',', ' ') }} FCFA
                    </p>

                    {{-- Badge statut --}}
                    <div class="mt-5 pb-5 border-b border-gray-200">
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider shadow-sm
                            @if($bien->statut === \App\Enums\StatutBien::DISPONIBLE)
                                bg-blue-600 text-white
                            @elseif($bien->statut === \App\Enums\StatutBien::LOUE)
                                bg-green-600 text-white
                            @elseif($bien->statut === \App\Enums\StatutBien::VENDU)
                                bg-gray-600 text-white
                            @else
                                bg-yellow-500 text-white
                            @endif
                        ">
                            {{ $bien->statut->label() }}
                        </span>
                    </div>

                    {{-- Bouton Contacter --}}
                    <button class="mt-6 w-full bg-orange-600 hover:bg-orange-700 text-white text-lg font-bold py-3 rounded-lg shadow-lg transition">
                        Contacter l'agence
                    </button>

                    {{-- Réservation --}}
                    <div class="mt-4">
                        @auth
                            @if(Auth::user()->isClient())
                                @if($bien->statut === \App\Enums\StatutBien::DISPONIBLE)
                                    <a href="{{ route('client.reservations.create', $bien->id) }}"
                                       class="block w-full text-center bg-green-600 hover:bg-green-700 
                                       text-white text-lg font-bold py-3 rounded-lg shadow-lg transition">
                                        Réserver ce bien
                                    </a>
                                    <br>
                                    <a href="{{ route('client.visites.create', $bien->id) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                        Demander une visite
                                    </a>

                                @else
                                    <button disabled class="w-full text-center bg-gray-400 text-white text-lg font-bold py-3 rounded-lg">
                                        Bien non disponible
                                    </button>
                                @endif
                            @endif
                        @else  
                            <a href="{{ route('login') }}"
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold py-3 rounded-lg shadow-lg transition">
                                Se connecter pour réserver
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

        </div>

        {{-- Biens similaires --}}
        @if($biensSimilaires->isNotEmpty())
        <div class="mt-20">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-orange-500 inline-block pb-1">
                Biens similaires
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @foreach($biensSimilaires as $similaire)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-gray-100">

                    <div class="relative">
                        @php $image = $similaire->illustrations->first(); @endphp

                        <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                            @if($similaire->statut === \App\Enums\StatutBien::DISPONIBLE) bg-blue-600 text-white
                            @elseif($similaire->statut === \App\Enums\StatutBien::LOUE) bg-green-600 text-white
                            @elseif($similaire->statut === \App\Enums\StatutBien::VENDU) bg-gray-500 text-white
                            @else bg-yellow-500 text-white @endif
                        ">
                            {{ $similaire->statut->label() }}
                        </span>

                        <img src="{{ $image?->image_url ?? asset('images/default.png') }}"
                             class="w-full h-48 object-cover">
                    </div>

                    <div class="p-5">

                        <p class="text-blue-600 font-extrabold text-xl">
                            {{ number_format($similaire->prix, 0, ',', ' ') }} FCFA
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $similaire->titre }}</h3>

                        <p class="text-gray-500 text-sm mb-3">{{ $similaire->adresse }}</p>

                        <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($similaire->description), 100) }}
                        </p>

                        <div class="flex gap-2">
                            <a href="{{ route('biens.show', $similaire->id) }}"
                               class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md transition">
                                Voir détails
                            </a>

                            <button class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded-lg shadow-sm transition">
                                Contacter
                            </button>
                        </div>

                    </div>

                </div>
                @endforeach

            </div>
        </div>
        @endif

    </div>
</div>

</x-app-layout>
