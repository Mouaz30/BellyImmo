<x-app-layout>
    {{-- Conteneur Principal --}}
   
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb" class="mb-8">
                <br>
                <br>
                <ol role="list" class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-500 transition font-medium">
                            Accueil
                        </a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-900 font-bold truncate">{{ $bien->titre }}</li>
                </ol>
            </nav>
<br>
<br>
<br>
            {{-- Contenu Principal (Grille 2 Colonnes) --}}
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                
                {{-- Colonne Gauche: GALERIE D'IMAGES DYNAMIQUE --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- GALERIE D'IMAGES (Style Catalogue) --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @forelse($bien->illustrations as $index => $illustration)
                            @php
                                // La première image prend deux colonnes sur mobile/tablette, sinon une
                                $grid_class = $index === 0 ? 'col-span-2' : 'col-span-1'; 
                                // La première image est plus haute
                                $height_class = $index === 0 ? 'h-96 sm:h-[400px]' : 'h-64 sm:h-72';
                            @endphp
                            
                            {{-- Carte Image avec effet de zoom --}}
                            <div class="{{ $grid_class }} rounded-xl shadow-md overflow-hidden bg-white group cursor-pointer">
                                <img src="{{ $illustration->image_url }}" 
                                    alt="{{ $bien->titre }} - Image {{ $index + 1 }}" 
                                    class="w-full {{ $height_class }} object-cover 
                                           group-hover:scale-105 transition-transform duration-500 ease-in-out">
                            </div>
                        @empty
                            {{-- Placeholder si aucune image --}}
                            <div class="col-span-3 h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                                <span class="text-gray-500 text-lg">Aucune image disponible</span>
                            </div>
                        @endforelse
                    </div>

                    {{-- Description --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">
                            Description du bien
                     </h2>
                    <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">
                         {{ $bien->description }}
                     </p>
                    </div>


                    {{-- Caractéristiques --}}
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">Informations Clés</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                            {{-- Assurez-vous que ces attributs existent sur votre modèle $bien --}}
                            <div class="flex justify-between sm:block text-black">
                                <dt class="font-semibold text-gray-500">Type de bien</dt>
                                <dd class="font-bold text-gray-900 capitalize">{{ $bien->type }}</dd>
                            </div>
                            <div class="flex justify-between sm:block text-black">
                                <dt class="font-semibold text-gray-500">Adresse</dt>
                                <dd class="font-bold text-gray-900">{{ $bien->adresse }}</dd>
                            </div>
                            {{-- Ajoutez d'autres champs si votre modèle le supporte (ex: surface, chambres) --}}
                            
                        </dl>
                    </div>

                </div>

                {{-- Colonne Droite: FICHE PRIX ET CONTACT --}}
                <div class="mt-10 lg:mt-0">       
                    {{-- Card Prix et Statut (Sticky pour rester visible) --}}
                    <div class="bg-white rounded-xl shadow-2xl p-6 sticky top-8 border-t-4 border-orange-500">
                        
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $bien->titre }}</h1>

                        <div class="mb-4">
                            <p class="text-gray-700 font-black text-orange-600">
                                {{ number_format($bien->prix, 0, ',', ' ') }} 
                                <span class="text-gray-700">CFA</span>
                                @if($bien->statut === \App\Enums\StatutBien::LOUE)
                                    <span class="text-base text-gray-600 font-normal">/mois</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-5 pb-4 border-b border-gray-100">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider
                                @if($bien->statut === \App\Enums\StatutBien::LOUE)
                                    bg-green-600 text-gray-700
                                @else
                                    bg-orange-500 text-gray-700
                                @endif">
                                {{ $bien->statut }}
                            </span>
                        </div>


                        {{-- Boutons d'action VIFS --}}
                        <div class="space-y-3">
                            <button class="w-full bg-orange-600 hover:bg-orange-700 text-white text-lg font-bold py-3 px-4 rounded-lg shadow-xl transition transform hover:scale-[1.01] duration-300 uppercase">
                                Contacter l'agence
                            </button>
   
                        </div><br>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold py-3 px-4 rounded-lg transition duration-200">
                              Réserver
                        </button>

                    </div>
                </div>
            </div>

           {{-- Biens Similaires (AVEC LE STYLE DE LA CAPTURE D'ÉCRAN) --}}
           @if(isset($biensSimilaires) && $biensSimilaires->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-orange-500 inline-block pb-1">Biens similaires</h2>
                    
                    {{-- GRILLE D'AFFICHAGE EN 2 OU 3 COLONNES, COMME SUR LA CAPTURE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($biensSimilaires as $similaire)
                            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">

                                {{-- Image principale --}}
                                <div class="relative">
                                    @php $image = $similaire->illustrations->first(); @endphp

                                    {{-- Badge du statut (en haut à gauche) --}}
                                    <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                                        @if($similaire->statut === 'disponible') bg-blue-600 text-white
                                        @elseif($similaire->statut === 'loue') bg-green-500 text-white
                                        @elseif($similaire->statut === 'vendu') bg-gray-500 text-white
                                        @elseif($similaire->statut === 'reserve') bg-yellow-500 text-white
                                        @else bg-gray-400 text-white @endif">
                                        {{ $similaire->statut }}
                                    </span>

                                    <img src="{{ $image?->image_url ?? asset('images/default.png') }}" 
                                         alt="{{ $similaire->titre }}" 
                                         class="w-full h-48 object-cover"> {{-- Hauteur fixe pour l'image --}}
                                </div>

                                {{-- Contenu de la carte --}}
                                <div class="p-4">
                                    {{-- Prix et type de transaction (à droite) --}}
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-blue-600 font-bold text-xl">
                                            {{ number_format($similaire->prix, 0, ',', ' ') }}
                                            @if($similaire->statut === 'loue') <span class="text-sm text-gray-700 font-normal">CFA/mois</span>
                                            @else <span class="text-sm text-gray-700 font-normal">CFA</span> @endif
                                        </p>

                                        {{-- Type de Transaction (Vente/Location) --}}
                                        <p class="bg-gray-100 text-sm px-2 py-1 rounded text-gray-800">
                                            @if($similaire->statut === 'loue') Location
                                            @else Vente @endif
                                        </p>
                                    </div>

                                    {{-- Titre --}}
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $similaire->titre }}</h3>

                                    {{-- Adresse --}}
                                    <p class="text-gray-500 text-sm mb-3">{{ $similaire->adresse }}</p>

                                    {{-- Description (tronquée, comme sur la capture) --}}
                                    <div class="text-sm text-gray-600 mb-4 line-clamp-3"> {{-- Limite à 3 lignes --}}
                                        {{ Str::limit(strip_tags($similaire->description), 100) }} 
                                    </div>

                                    {{-- Boutons --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('biens.show', $similaire->id) }}" 
                                           class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors">
                                            Voir détails
                                        </a>
                                        <a href="#" {{-- Remplacez "#" par la route de contact si elle existe --}}
                                           class="flex-1 text-center bg-gray-100 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">
                                            Contacter
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-16 text-center">
                    <p class="text-gray-500">Aucun bien similaire n'a été trouvé pour le moment.</p>
                </div>
            @endif


        </div>
    </div>
</x-app-layout>