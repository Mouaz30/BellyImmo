<x-app-layout>

    {{-- ===== Carrousel principal ===== --}}
    <div id="custom-flowbite-carousel" class="relative w-full mt-16" data-carousel="slide">
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96" style="height: 600px;">
            <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                <img src="{{ asset('storage/images/image1.png') }}" class="absolute block w-full h-full object-cover" alt="Image 1">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('storage/images/image2.png') }}" class="absolute block w-full h-full object-cover" alt="Image 2">
            </div>
        </div>

        {{-- Boutons du carrousel --}}
        <button type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    {{-- ===== Section Biens en vedette ===== --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900">Biens Immobiliers en Vedette</h2>
                <p class="mt-2 text-gray-600">
                    Découvrez notre sélection de propriétés soigneusement choisies pour leur qualité et leur emplacement privilégié.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($biens as $bien)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden">
                        
                        {{-- ===== Image principale ===== --}}
                        <div class="relative">
                            @php
                                $image = $bien->illustrations->first();
                            @endphp

                            @if ($image && $image->image_url)
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $bien->titre }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <img src="{{ asset('images/default.png') }}" 
                                     alt="Image par défaut" 
                                     class="w-full h-48 object-cover">
                            @endif

                            {{-- ===== Badge du statut ===== --}}
                            <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                                @if($bien->statut === \App\Enums\StatutBien::DISPONIBLE) bg-blue-600 text-white
                                @elseif($bien->statut === \App\Enums\StatutBien::LOUE) bg-green-500 text-white
                                @elseif($bien->statut === \App\Enums\StatutBien::VENDU) bg-gray-500 text-white
                                @elseif($bien->statut === \App\Enums\StatutBien::RESERVE) bg-yellow-500 text-white
                                @else bg-gray-400 text-white @endif">
                                {{ $bien->statut->label() }}
                            </span>
                        </div>

                        {{-- ===== Contenu de la carte ===== --}}
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $bien->titre }}</h3>
                            <p class="text-gray-600 text-sm mt-1 truncate">
                                {{ strip_tags($bien->description) }}
                            </p>

                            <p class="text-blue-600 font-bold text-xl mt-3">
                                {{ number_format($bien->prix, 0, ',', ' ') }} 
                                @if($bien->statut === \App\Enums\StatutBien::LOUE) CFA/mois 
                                @else CFA 
                                @endif
                            </p>

                            <p class="text-gray-500 text-sm mt-1">{{ $bien->adresse }}</p>

                            <div class="mt-4 flex gap-2">
                                <a href="#" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                                    Voir détails
                                </a>
                                <a href="#" class="flex-1 text-center bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                                    Contacter
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</x-app-layout>
