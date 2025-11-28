<x-app-layout>
    <br><br><br><br><br>
    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">
            <h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
                Modifier le Bien : {{ $bien->titre }}
            </h1>

            <form action="{{ route('proprietaire.Bien.update', $bien->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf 
                @method('PUT')

                {{-- TITRE + PRIX --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                        <input type="text" name="titre" 
                               value="{{ old('titre', $bien->titre) }}" 
                               class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                      rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (FCFA)</label>
                        <input type="number" name="prix" 
                               value="{{ old('prix', $bien->prix) }}" 
                               class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                      rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>

                {{-- ADRESSE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse Complète</label>
                    <input type="text" name="adresse" 
                           value="{{ old('adresse', $bien->adresse) }}" 
                           class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                  rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                {{-- TYPE DU BIEN + STATUT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Bien</label>
                        <select name="type"
                                class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                                required>
                            <option value="APPARTEMENT" {{ $bien->type->value=='APPARTEMENT' ? 'selected' : '' }}>Appartement</option>
                            <option value="MAISON" {{ $bien->type->value=='MAISON' ? 'selected' : '' }}>Maison</option>
                            <option value="VILLA" {{ $bien->type->value=='VILLA' ? 'selected' : '' }}>Villa</option>
                            <option value="TERRAIN" {{ $bien->type->value=='TERRAIN' ? 'selected' : '' }}>Terrain</option>
                            <option value="COMMERCIAL" {{ $bien->type->value=='COMMERCIAL' ? 'selected' : '' }}>Local Commercial</option>
                        </select>
                    </div>

                    {{-- Statut --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <select name="statut"
                                class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                                required>
                            <option value="disponible" {{ $bien->statut->value=='disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="loue" {{ $bien->statut->value=='loue' ? 'selected' : '' }}>Loué</option>
                            <option value="vendu" {{ $bien->statut->value=='vendu' ? 'selected' : '' }}>Vendu</option>
                            <option value="reserve" {{ $bien->statut->value=='reserve' ? 'selected' : '' }}>Réservé</option>
                        </select>
                    </div>
                </div>

                {{-- MODE TRANSACTION --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mode de Transaction *</label>
                    <select name="mode_transaction"
                            class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                            required>
                        <option value="location" {{ $bien->mode_transaction=='location' ? 'selected' : '' }}>Location</option>
                        <option value="vente" {{ $bien->mode_transaction=='vente' ? 'selected' : '' }}>Vente</option>
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="5"
                              class="w-full p-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                     rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        {{ old('description', $bien->description) }}
                    </textarea>
                </div>

                {{-- IMAGES EXISTANTES --}}
                <hr class="my-6 border-gray-300 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Images Existantes</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    @foreach($bien->illustrations as $img)
                        <div class="relative group">
                            <img src="{{ $bien->illustrations->first()->image_url }}">
                            <!-- <img src="{{ Storage::url($img->image_url) }}"  -->
                                 class="w-full h-32 object-cover rounded-lg border shadow">
                        </div>
                    @endforeach
                </div>

                {{-- AJOUT NOUVELLES IMAGES --}}
                <hr class="my-6 border-gray-300 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Ajouter de Nouvelles Images</h3>

                <label for="images"
                       class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed 
                              border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 
                              hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="text-gray-500">Cliquez ou glissez-déposez ici</span>
                    <input type="file" id="images" name="images[]" multiple class="hidden" onchange="previewNewImages(this)">
                </label>

                <div id="preview-images" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden"></div>

                {{-- ACTIONS --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('proprietaire.Bien.list') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg shadow">
                        Retour
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewNewImages(input) {
            const container = document.getElementById('preview-images');
            container.innerHTML = "";

            if (input.files.length > 0) {
                container.classList.remove('hidden');

                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border">
                        `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>

</x-app-layout>
