<x-guest-layout>

    <div class="min-h-screen w-full flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('storage/images/auth-bg.jpg')">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Conteneur principal --}}
        <div class="relative w-full max-w-4xl mx-auto flex bg-white/10 backdrop-blur-xl 
                    rounded-3xl shadow-2xl overflow-hidden border border-white/20">

            {{-- Zone gauche décorative --}}
            <div class="hidden md:block w-1/2 bg-cover bg-center opacity-90"
                 style="background-image: url('storage/images/auth-bg.jpg')">
            </div>

            {{-- FORM Login --}}
            <div class="w-full md:w-1/2 p-10">

                {{-- Logo --}}
                <div class="flex justify-center mb-6">
                    <img src="storage/images/bellyimmo-logo.png" alt="BellyImmo" class="h-16">
                </div>

                <h2 class="text-4xl font-bold text-white text-center mb-8">Connexion</h2>

                <!-- Status Session -->
                <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label class="text-white font-semibold">Email</label>
                        <input type="email" name="email" required autofocus
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white 
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400">
                        <x-input-error :messages="$errors->get('email')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Mot de passe</label>
                        <input type="password" name="password" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400">
                        <x-input-error :messages="$errors->get('password')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Mot de passe oublié --}}
                    <div class="flex justify-end mt-2">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-white/90 hover:underline text-sm">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    {{-- Bouton --}}
                    <button class="w-full mt-8 py-3 text-white font-semibold text-lg rounded-xl
                                   bg-gradient-to-r from-red-600 to-red-500 hover:opacity-90 transition">
                        Se connecter →
                    </button>

                    <p class="text-center text-white mt-6 text-sm">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="font-semibold hover:underline">S'inscrire</a>
                    </p>

                </form>
            </div>

        </div>
    </div>

</x-guest-layout>
