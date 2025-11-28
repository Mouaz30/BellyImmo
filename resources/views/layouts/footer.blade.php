<!-- ICONES Lucide -->
<script src="https://unpkg.com/lucide@latest"></script>

<footer class="bg-gray-900 text-gray-200 pt-14 pb-10 mt-20 border-t border-gray-800">

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">

        {{-- LOGO + DESCRIPTION --}}
        <div class="col-span-1 md:col-span-2">

            <div class="flex items-center gap-3">
                <img 
                    src="{{ asset('storage/images/bellyimmo-logo.png') }}"
                    alt="BellyImmo"
                    class="h-14 w-auto object-contain"
                >
            </div>

            <p class="mt-5 text-gray-300 text-sm leading-relaxed max-w-md">
                BellyImmo est votre plateforme moderne pour trouver, louer ou acheter des biens immobiliers en toute simplicité et transparence au Sénégal.
            </p>

        </div>

        {{-- LIENS DE NAVIGATION --}}
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i data-lucide="menu" class="w-5 h-5 text-orange-400"></i>
                Navigation
            </h3>

            <ul class="space-y-3">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="home" class="w-4 h-4 text-orange-400"></i>
                        Accueil
                    </a>
                </li>

                <li>
                    <a href="#" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="building-2" class="w-4 h-4 text-orange-400"></i>
                        Biens
                    </a>
                </li>

                <li>
                    <a href="#" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="phone" class="w-4 h-4 text-orange-400"></i>
                        Contact
                    </a>
                </li>

                <li>
                    <a href="#" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="info" class="w-4 h-4 text-orange-400"></i>
                        À propos
                    </a>
                </li>
            </ul>
        </div>

        {{-- CONTACT --}}
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i data-lucide="mail" class="w-5 h-5 text-orange-400"></i>
                Contact
            </h3>

            <ul class="space-y-3">
                <li class="flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4 text-orange-400"></i>
                    contact@bellyimmo.com
                </li>

                <li class="flex items-center gap-2">
                    <i data-lucide="phone-call" class="w-4 h-4 text-orange-400"></i>
                    +221 78 665 28 94
                </li>

                <li class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-orange-400"></i>
                    Dakar, Sénégal
                </li>
            </ul>
        </div>

    </div>

    <!-- BAS DE PAGE -->
    <div class="border-t border-gray-800 mt-12 pt-5 text-center text-gray-400 text-sm">
        © {{ date('Y') }} BellyImmo — Tous droits réservés.
    </div>

</footer>

<script>
    lucide.createIcons();
</script>
