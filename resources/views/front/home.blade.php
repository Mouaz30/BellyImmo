<x-app-layout>

    {{-- ============================= --}}
    {{--          SECTION HERO         --}}
    {{-- ============================= --}}
    <div class="relative w-full h-[650px] mt-16">

        {{-- CARROUSEL --}}
        <div id="custom-flowbite-carousel" class="relative h-full w-full" data-carousel="slide">

            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60 z-20"></div>

            @foreach ([
                'carroussel0.jpg',
                'image0.jpg',
                'carroussel4.jpg'
            ] as $img)
                <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('storage/images/' . $img) }}" 
                         class="absolute inset-0 w-full h-full object-cover">
                </div>
            @endforeach

            {{-- NAVIGATION --}}
            <button class="absolute top-1/2 left-6 z-40" data-carousel-prev>
                <span class="w-12 h-12 flex items-center justify-center bg-black/40 rounded-full text-white shadow-lg hover:bg-black/60">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </span>
            </button>

            <button class="absolute top-1/2 right-6 z-40" data-carousel-next>
                <span class="w-12 h-12 flex items-center justify-center bg-black/40 rounded-full text-white shadow-lg hover:bg-black/60">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </span>
            </button>

        </div>

        {{-- TEXTE & RECHERCHE --}}
        <div class="absolute inset-0 z-30 flex flex-col items-center justify-center text-center px-6">

            <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight drop-shadow-xl">
                Trouvez votre
                <span class="text-orange-500">bien immobilier idéal</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mt-4">
                Explorez les meilleures offres de location et de vente au Sénégal, en toute confiance.
            </p>

            {{-- FORMULAIRE --}}
            <div class="mt-10 w-full max-w-4xl bg-white/95 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-gray-200">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <select class="border rounded-lg px-3 py-3 text-gray-700">
                        <option disabled selected>Type de bien</option>
                        <option>Appartement</option>
                        <option>Maison</option>
                        <option>Villa</option>
                        <option>Bureau</option>
                    </select>

                    <select class="border rounded-lg px-3 py-3 text-gray-700">
                        <option disabled selected>Ville</option>
                        <option>Dakar</option>
                        <option>Thiès</option>
                        <option>Mbour</option>
                        <option>Saint-Louis</option>
                    </select>

                    <input type="number" class="border rounded-lg px-3 py-3 text-gray-700"
                           placeholder="Prix maximum">

                    <button class="bg-primary text-white rounded-lg px-4 py-3 font-semibold hover:bg-primary-700 shadow">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>

    </div>




    {{-- ============================= --}}
    {{--   SECTION CATÉGORIES BIENS   --}}
    {{-- ============================= --}}
    <section class="py-20 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <h2 class="text-4xl font-extrabold">Découvrez nos catégories</h2>
                <p class="text-gray-500 mt-2">Choisissez le type de bien adapté à votre projet</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

                @foreach([
                    ['Appartements', 'building-2'],
                    ['Maisons', 'home'],
                    ['Villas', 'landmark'],
                    ['Bureaux', 'briefcase']
                ] as [$label, $icon])

                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-10 text-center shadow-lg transition cursor-pointer group">
                    <i data-lucide="{{ $icon }}" class="w-12 h-12 mx-auto mb-4 text-primary group-hover:scale-110 transition"></i>
                    <p class="font-semibold text-lg">{{ $label }}</p>
                </div>

                @endforeach

            </div>

        </div>

    </section>




    {{-- ============================= --}}
    {{--    SECTION BIENS EN VEDETTE   --}}
    {{-- ============================= --}}
    <section class="py-20 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <h2 class="text-4xl font-extrabold">Biens en Vedette</h2>
                <p class="text-gray-500 mt-2">Nos meilleures opportunités du moment</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

                @foreach ($biens as $bien)

                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden">

                    {{-- IMAGE --}}
                    <div class="relative w-full h-56">
                        @php $image = $bien->illustrations->first(); @endphp

                        <img src="{{ $image?->image_url ?? asset('images/default.png') }}"
                             class="w-full h-full object-cover">

                        <div class="absolute top-3 left-3 bg-primary text-white text-xs px-3 py-1 rounded-full shadow">
                            {{ ucfirst($bien->mode_transaction->value) }}
                        </div>

                        <div class="absolute top-3 right-3 text-xs px-3 py-1 rounded-full shadow
                            @if($bien->statut->value === 'disponible') bg-green-600 text-white
                            @elseif($bien->statut->value === 'reserve') bg-yellow-500 text-white
                            @elseif($bien->statut->value === 'vendu') bg-gray-700 text-white
                            @elseif($bien->statut->value === 'loue') bg-blue-600 text-white
                            @endif">
                            {{ $bien->statut->label() }}
                        </div>
                    </div>

                    {{-- DETAILS --}}
                    <div class="p-6">

                        <p class="text-primary font-bold text-2xl">
                            {{ number_format($bien->prix, 0, ',', ' ') }} FCFA
                            @if($bien->mode_transaction->value === 'location') / mois @endif
                        </p>

                        <h3 class="text-xl font-semibold mt-2">{{ $bien->titre }}</h3>
                        <p class="text-gray-500 text-sm">{{ $bien->adresse }}</p>

                        <p class="text-gray-600 text-sm mt-3 line-clamp-2">
                            {{ Str::limit(strip_tags($bien->description), 100) }}
                        </p>

                        <div class="flex gap-3 mt-5">
                            <a href="{{ route('biens.show', $bien->id) }}"
                               class="flex-1 bg-primary text-white py-2 rounded-lg text-center hover:bg-primary-700 shadow">
                                Voir détails
                            </a>

                            <a href="#"
                               class="flex-1 bg-gray-100 text-gray-800 py-2 rounded-lg text-center hover:bg-gray-200 shadow">
                                Contacter
                            </a>
                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </section>




    {{-- ============================= --}}
    {{--  POURQUOI NOUS CHOISIR ?     --}}
    {{-- ============================= --}}
  <section class="py-24 bg-gradient-to-b from-white to-gray-50">

    <div class="max-w-7xl mx-auto px-6">

        {{-- Titre --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900">Pourquoi choisir BellyImmo ?</h2>
            <p class="text-gray-500 text-lg mt-3">Des services conçus pour vous offrir une expérience immobilière simple, rapide et fiable</p>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            @foreach([
                ['Service rapide', 'zap', 'Trouvez un bien en quelques heures, pas en plusieurs semaines.', 'bg-blue-100 text-blue-600'],
                ['Accompagnement personnalisé', 'user-check', 'Un expert immobilier vous guide à chaque étape.', 'bg-teal-100 text-teal-600'],
                ['Transparence totale', 'badge-check', 'Toutes nos offres sont vérifiées et 100% fiables.', 'bg-violet-100 text-violet-600']
            ] as [$title, $icon, $desc, $color])

            <div class="group bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100
                        hover:-translate-y-2">

                {{-- Icône dans un cercle coloré --}}
                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full {{ $color }} 
                            group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="{{ $icon }}" class="w-10 h-10"></i>
                </div>

                {{-- Titre --}}
                <h3 class="text-2xl font-bold text-gray-900 mt-8">{{ $title }}</h3>

                {{-- Description --}}
                <p class="text-gray-600 mt-4">{{ $desc }}</p>

            </div>

            @endforeach

        </div>

    </div>

</section>





    {{-- ============================= --}}
    {{--      SECTION TÉMOIGNAGES     --}}
    {{-- ============================= --}}
    <section class="py-20 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-4xl font-extrabold">Avis de nos clients</h2>
            <p class="text-gray-500 mt-2">La satisfaction est notre priorité</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-14">

                @foreach([
                    ['Amina Faye','Service exceptionnel ! J’ai trouvé un appartement à Dakar en 2 jours.', 'https://live.staticflickr.com/7266/7086192257_712b585109_z.jpg'],
                    ['Ousmane Ndiaye','Très professionnel, assistance parfaite du début à la fin.', 'https://i.pinimg.com/474x/43/d7/16/43d716925da061a194dc992feb4b34ed.jpg?nii=t'],
                    ['Fatou Sarr','Des offres fiables et transparentes, je recommande !','https://i.pinimg.com/originals/35/dc/6a/35dc6adbe37d1f606e1f6ab96118d06f.jpg']
                ] as [$name, $comment, $img])

                <div class="bg-white rounded-2xl p-10 shadow-lg border border-gray-100 hover:shadow-xl transition">
                    <p class="text-gray-700 italic text-lg">“{{ $comment }}”</p>

                    <div class="flex items-center gap-4 mt-6 justify-center">
                        <img src="{{ $img }}" class="w-14 h-14 rounded-full object-cover shadow">
                        <div>
                            <p class="font-bold">{{ $name }}</p>
                            <p class="text-orange-500 text-sm flex items-center gap-1">
                                <i data-lucide="star" class="w-4 h-4"></i> 5.0
                            </p>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>

        </div>

    </section>




    {{-- ============================= --}}
    {{--          CTA FINAL            --}}
    {{-- ============================= --}}
    <section class="py-20 text-center bg-white">

        <h2 class="text-4xl font-extrabold">Prêt à trouver votre futur bien ?</h2>
        <p class="text-gray-500 mt-3">Contactez-nous ou explorez nos offres dès maintenant.</p>

        <a href="{{ route('contact') }}"
           class="inline-block mt-6 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 shadow-lg">
            Contacter-nous
        </a>

    </section>

    <script>
        lucide.createIcons();
    </script>

</x-app-layout>
