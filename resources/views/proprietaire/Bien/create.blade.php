<x-app-layout>
<div class="container mx-auto p-6">
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">
<h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
Ajouter un Nouveau Bien Immobilier 🏡
</h1>

<form action="{{ route('proprietaire.Bien.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
            <input type="text" id="titre" name="titre" 
                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('titre') border-red-500 @enderror" 
                   value="{{ old('titre') }}" placeholder="Ex: Belle villa 4 chambres" required>
            @error('titre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-2">
            <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (FCFA)</label>
            <input type="number" id="prix" name="prix" 
                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('prix') border-red-500 @enderror" 
                   value="{{ old('prix') }}" required>
            @error('prix') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label for="adresse" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse Complète</label>
        <input type="text" id="adresse" name="adresse" 
               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('adresse') border-red-500 @enderror" 
               value="{{ old('adresse') }}" placeholder="Ex: 12 Rue de la Liberté, Dakar" required>
        @error('adresse') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="space-y-2">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description Détaillée</label>
        <textarea id="description" name="description" rows="5" 
                      class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror" 
                      placeholder="Décrivez les caractéristiques, les avantages et l'environnement du bien.">{{ old('description') }}</textarea>
        @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Bien</label>
            <select id="type" name="type" 
                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('type') border-red-500 @enderror" 
                  required>
                <option value="">-- Sélectionnez un type --</option>
                {{-- Utilisation des valeurs TypeBien ENUM --}}
                <option value="APPARTEMENT" {{ old('type') == 'APPARTEMENT' ? 'selected' : '' }}>Appartement</option>
                <option value="MAISON" {{ old('type') == 'MAISON' ? 'selected' : '' }}>Maison</option>
                <option value="VILLA" {{ old('type') == 'VILLA' ? 'selected' : '' }}>Villa</option>
                <option value="TERRAIN" {{ old('type') == 'TERRAIN' ? 'selected' : '' }}>Terrain</option>
                <option value="COMMERCIAL" {{ old('type') == 'COMMERCIAL' ? 'selected' : '' }}>Local Commercial</option>
            </select>
            @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-2">
            <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut de l'Annonce</label>
            <select id="statut" name="statut" 
                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('statut') border-red-500 @enderror" 
                  required>
                <option value="">-- Sélectionnez un statut --</option>
                {{-- Utilisation des valeurs StatutBien ENUM --}}
                <option value="disponible" {{ old('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="loue" {{ old('statut') == 'loue' ? 'selected' : '' }}>Loué</option>
                <option value="vendu" {{ old('statut') == 'vendu' ? 'selected' : '' }}>Vendu</option>
                <option value="reserve" {{ old('statut') == 'reserve' ? 'selected' : '' }}>Réservé</option>
            </select>
            @error('statut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-2 border-t pt-6 border-gray-200 dark:border-gray-700">
        <label for="images" class="block text-lg font-bold text-gray-800 dark:text-gray-100">Ajouter les photos du Bien</label>
        <input type="file" id="images" name="images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-400 dark:text-gray-400 @error('images') border-red-500 @enderror">
        <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images simultanément.</p>
        @error('images.*') <p class="text-xs text-red-500 mt-1">Une des images n'est pas valide ou dépasse la taille maximale.</p> @enderror
    </div>

    <div class="pt-4 flex justify-end">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
            💾 Enregistrer le Bien
        </button>
    </div>
</form>


</div>
</div>
</x-app-layout>