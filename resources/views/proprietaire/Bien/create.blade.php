<x-app-layout>
    <br><br><br><br><br>
    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">
            <h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
                Ajouter un Nouveau Bien Immobilier 🏡
            </h1>

            <form action="{{ route('proprietaire.Bien.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- TITRE + PRIX --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                        <input type="text" name="titre"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                   rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                   @error('titre') border-red-500 @enderror"
                            value="{{ old('titre') }}" required placeholder="Ex : Belle villa 4 chambres">
                        @error('titre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (FCFA)</label>
                        <input type="number" name="prix"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                   rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                   @error('prix') border-red-500 @enderror"
                            value="{{ old('prix') }}" required>
                        @error('prix') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- ADRESSE --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse Complète</label>
                    <input type="text" name="adresse"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                               rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                               @error('adresse') border-red-500 @enderror"
                        value="{{ old('adresse') }}" required placeholder="Ex : 12 Rue de la Liberté, Dakar">
                    @error('adresse') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TYPE + STATUT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Type de bien --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Bien</label>
                        <select name="type"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                   rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                   @error('type') border-red-500 @enderror"
                            required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="APPARTEMENT" {{ old('type')=='APPARTEMENT' ? 'selected' : '' }}>Appartement</option>
                            <option value="MAISON" {{ old('type')=='MAISON' ? 'selected' : '' }}>Maison</option>
                            <option value="VILLA" {{ old('type')=='VILLA' ? 'selected' : '' }}>Villa</option>
                            <option value="TERRAIN" {{ old('type')=='TERRAIN' ? 'selected' : '' }}>Terrain</option>
                            <option value="COMMERCIAL" {{ old('type')=='COMMERCIAL' ? 'selected' : '' }}>Local Commercial</option>
                        </select>
                        @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Statut actuel du bien --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut du Bien</label>
                        <select name="statut"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                   rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                                   @error('statut') border-red-500 @enderror"
                            required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="disponible" {{ old('statut')=='disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="loue" {{ old('statut')=='loue' ? 'selected' : '' }}>Loué</option>
                            <option value="vendu" {{ old('statut')=='vendu' ? 'selected' : '' }}>Vendu</option>
                            <option value="reserve" {{ old('statut')=='reserve' ? 'selected' : '' }}>Réservé</option>
                        </select>
                        @error('statut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- MODE TRANSACTION --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mode de Transaction *</label>
                    <select name="mode_transaction"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                               rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                               @error('mode_transaction') border-red-500 @enderror"
                        required>
                        <option value="">-- Choisir --</option>
                        <option value="location" {{ old('mode_transaction')=='location' ? 'selected' : '' }}>Location</option>
                        <option value="vente" {{ old('mode_transaction')=='vente' ? 'selected' : '' }}>Vente</option>
                    </select>
                    @error('mode_transaction') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="5"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                               rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 
                               @error('description') border-red-500 @enderror"
                        placeholder="Décrivez le bien ici...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- IMAGES --}}
                <div class="space-y-2 border-t pt-6 border-gray-200 dark:border-gray-700">
                    <label class="block text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">
                        Photos du Bien
                        <span class="text-sm font-normal text-gray-500">(Plusieurs images autorisées)</span>
                    </label>

                    <div class="flex items-center justify-center w-full">
                        <label for="images"
                               class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 
                                      border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 
                                      hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="text-gray-500 text-lg"><strong>Cliquez</strong> ou glissez-déposez</p>
                                <p class="text-sm text-gray-400">PNG, JPG, JPEG, WEBP (2Mo max)</p>
                            </div>
                            <input id="images" name="images[]" type="file" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                        </label>
                    </div>

                    <div id="image-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden"></div>

                    @error('images.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ACTIONS --}}
                <div class="pt-4 flex justify-end space-x-4">
                    <a href="{{ route('proprietaire.Bien.list') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow">
                        ↩ Retour
                    </a>

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                        💾 Enregistrer le Bien
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT PREVIEW IMAGES --}}
    <script>
        function previewImages(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (input.files.length > 0) {
                preview.classList.remove('hidden');

                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border">
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</x-app-layout>
