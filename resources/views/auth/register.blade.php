<x-guest-layout>

    <div class="min-h-screen w-full flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('storage/images/auth-bg.jpg')">

        {{-- Overlay sombre + blur pour effet premium --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Conteneur principal --}}
        <div class="relative w-full max-w-4xl mx-auto flex bg-white/10 backdrop-blur-xl 
                    rounded-3xl shadow-2xl overflow-hidden border border-white/20">

            {{-- Image décorative à gauche --}}
            <div class="hidden md:block w-1/2 bg-cover bg-center opacity-90"
                 style="background-image: url('storage/images/auth-bg.jpg')">
            </div>

            {{-- Formulaire --}}
            <div class="w-full md:w-1/2 p-10">

                {{-- Logo BellyImmo --}}
                <div class="flex justify-center mb-6">
                    <img src="storage/images/bellyimmo-logo.png" alt="BellyImmo" class="h-16">
                </div>

                {{-- Titre --}}
                <h2 class="text-4xl font-bold text-white text-center mb-8">
                    Créer un compte
                </h2>

                {{-- Message succès --}}
                @if(session('success'))
                    <div class="mb-4 text-green-300">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Prénom --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Prénom</label>
                        <input type="text" name="prenom" :value="old('prenom')" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white 
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400" />
                        <x-input-error :messages="$errors->get('prenom')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Nom --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Nom</label>
                        <input type="text" name="nom" :value="old('nom')" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400" />
                        <x-input-error :messages="$errors->get('nom')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Email</label>
                        <input type="email" name="email" :value="old('email')" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white 
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400" />
                        <x-input-error :messages="$errors->get('email')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Rôle --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Rôle</label>
                        <select name="role" required
                                class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white 
                                       border border-white/30 focus:ring-2 focus:ring-red-400">
                            <option value="" class="text-black">Choisir un rôle</option>
                            <option value="client" class="text-black"
                                {{ old('role') === 'client' ? 'selected' : '' }}>
                                Client
                            </option>
                            <option value="proprietaire" class="text-black"
                                {{ old('role') === 'proprietaire' ? 'selected' : '' }}>
                                Propriétaire
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-4">
                        <label class="text-white font-semibold">Mot de passe</label>
                        <input type="password" name="password" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400" />
                        <x-input-error :messages="$errors->get('password')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Confirmation --}}
                    <div class="mb-6">
                        <label class="text-white font-semibold">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full mt-2 px-4 py-3 rounded-xl bg-white/20 text-white
                               placeholder-white/70 border border-white/30 focus:ring-2 focus:ring-red-400" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-300 mt-2" />
                    </div>

                    {{-- Bouton --}}
                    <button class="w-full py-3 text-white font-semibold text-lg rounded-xl
                                   bg-gradient-to-r from-red-600 to-red-500 hover:opacity-90 transition">
                        S’inscrire →
                    </button>

                    <p class="text-center text-white mt-6 text-sm">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}" class="font-semibold hover:underline">Se connecter</a>
                    </p>

                </form>
            </div>

        </div>
    </div>

</x-guest-layout>
