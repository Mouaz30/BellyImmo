<!-- SCRIPT GLOBAL DARK/LIGHT (corrigé, mode clair fonctionne) -->
<script>
    const storedTheme = localStorage.getItem('theme');

    if (storedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } 
    else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
</script>

<nav 
    x-data="{
        open: false,
        isDark: localStorage.getItem('theme') === 'dark',

        toggleTheme() {
            this.isDark = !this.isDark;

            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }"

    class="fixed top-0 left-0 w-full z-50 bg-white dark:bg-darkmode/90 border-b border-gray-200 dark:border-gray-700 shadow-sm"
>

    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- LEFT : LOGO + LINKS -->
            <div class="flex items-center space-x-10">

                <!-- LOGO (Airbnb style) -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <img 
                        src="{{ asset('storage/images/bellyimmo-logo.png') }}"
                        alt="BellyImmo"
                        class="object-contain hover:opacity-90 transition"
                        style="height: 81px; width: auto;"
                    >
                </a>

                <!-- DESKTOP LINKS -->
                <div class="hidden sm:flex items-center space-x-6">

                    <x-nav-link 
                        :href="route('home')" 
                        :active="request()->routeIs('home')"
                        class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition"
                    >
                        Accueil
                    </x-nav-link>

                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                      class="hover:text-orange-500 dark:hover:text-orange-400">
                     Contact
                    </x-nav-link>


                    @auth
                        @if(Auth::user()->isClient())
                            <x-nav-link 
                                :href="route('client.dashboard')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Dashboard
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('client.reservations.index')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Mes Réservations
                            </x-nav-link>

                            
                        
                        @elseif(Auth::user()->isProprietaire())
                            <x-nav-link 
                                :href="route('proprietaire.dashboard')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Dashboard
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('proprietaire.Bien.list')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Biens
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('proprietaire.reservations.index')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Réservations
                            </x-nav-link>

                            <x-nav-link 
                                :href="route('proprietaire.visites.index')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Demandes de Visites
                            </x-nav-link>


                        @elseif(Auth::user()->isAdministrateur())
                            <x-nav-link 
                                :href="url('/admin')" 
                                class="font-medium hover:text-primary dark:hover:text-primary"
                            >
                                Admin Panel
                            </x-nav-link>
                        @endif
                    @endauth

                </div>
            </div>

            <!-- RIGHT : ACTIONS -->
            <!-- RIGHT : ACTIONS -->
<div class="hidden sm:flex items-center space-x-6">

    <!-- Dark Mode Button -->
    <button 
        @click="toggleTheme()" 
        class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
    >
        <!-- Soleil (light mode) -->
        <svg x-cloak x-show="!isDark" xmlns="http://www.w3.org/2000/svg" 
             class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M6.343 6.343 4.929 4.929m12.728 0-1.414 1.414M6.343 17.657l-1.414 1.414M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>

        <!-- Lune (dark mode) -->
        <svg x-cloak x-show="isDark" xmlns="http://www.w3.org/2000/svg" 
             class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd"
                  d="M17.293 14.293a8 8 0 01-9.586-9.586A1 1 0 006.707 3.707a10 10 0 1013.586 13.586 1 1 0 00-1.414-1.414z"
                  clip-rule="evenodd" />
        </svg>
    </button>

    <!-- PROFILE -->
    @auth
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center space-x-2 font-medium text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary">
                    <span>{{ Auth::user()->nom_complet }}</span>

                    <!-- Nouvelle icône fixée -->
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-300"
                         xmlns="http://www.w3.org/2000/svg" 
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Se déconnecter
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>

    @else
        <x-nav-link :href="route('login')" class="hover:text-primary dark:hover:text-primary">
            Connexion
        </x-nav-link>

        <x-nav-link :href="route('register')" class="hover:text-primary dark:hover:text-primary">
            Inscription
        </x-nav-link>
    @endauth

</div>


            <!-- MOBILE BURGER -->
            <button @click="open = !open"
                class="sm:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor">
                    <path x-show="!open" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden bg-white dark:bg-darkmode border-t border-gray-200 dark:border-gray-700 py-4">

        <x-responsive-nav-link :href="route('home')">Accueil</x-responsive-nav-link>

        @auth
            <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link 
                    :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Se déconnecter
                </x-responsive-nav-link>
            </form>

        @else
            <x-responsive-nav-link :href="route('login')">Connexion</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">Inscription</x-responsive-nav-link>
        @endauth

    </div>

</nav>
