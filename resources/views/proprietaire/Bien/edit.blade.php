<x-app-layout>
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
            Modifier le Bien : {{ $bien->titre }}
        </h1>

        <form action="{{ route('proprietaire.Bien.update', $bien->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre', $bien->titre) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix', $bien->prix) }}" class="w-full border p-2 rounded" required>
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse', $bien->adresse) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                    <select name="type" class="w-full border p-2 rounded" required>
                         <option value="Appartement" {{ old('type', $bien->type->value ?? $bien->type) == 'Appartement' ? 'selected' : '' }}>Appartement</option>
                         <option value="Maison/Villa" {{ old('type', $bien->type->value ?? $bien->type) == 'Maison/Villa' ? 'selected' : '' }}>Maison/Villa</option>
                         <option value="Terrain" {{ old('type', $bien->type->value ?? $bien->type) == 'Terrain' ? 'selected' : '' }}>Terrain</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                    <select name="statut" class="w-full border p-2 rounded" required>
                        <option value="A Vendre" {{ old('statut', $bien->statut->value ?? $bien->statut) == 'A Vendre' ? 'selected' : '' }}>À Vendre</option>
                        <option value="A Louer" {{ old('statut', $bien->statut->value ?? $bien->statut) == 'A Louer' ? 'selected' : '' }}>À Louer</option>
                        <option value="Vendu" {{ old('statut', $bien->statut->value ?? $bien->statut) == 'Vendu' ? 'selected' : '' }}>Vendu (hors ligne)</option>
                        <option value="Loué" {{ old('statut', $bien->statut->value ?? $bien->statut) == 'Loué' ? 'selected' : '' }}>Loué (hors ligne)</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" rows="5" class="w-full border p-2 rounded">{{ old('description', $bien->description) }}</textarea>
            </div>

            <hr class="my-6">

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Images du Bien</h3>
                
                <div class="mb-4">
                    <label class="block font-semibold">Images existantes (Affichage Corrigé)</label>
                    <div class="flex flex-wrap gap-3 p-2 border rounded-lg bg-gray-50 dark:bg-gray-700">
                        @forelse($bien->illustrations as $img)
                            <img src="{{ $img->image_url }}" alt="Illustration"
                                 class="w-24 h-24 object-cover rounded shadow-md border-2 border-white">
                        @empty
                            <p class="text-gray-500 text-sm">Aucune image n'a été ajoutée pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Ajouter de nouvelles images</label>
                    <input type="file" name="images[]" class="w-full border p-2 rounded" multiple>
                    <p class="text-sm text-gray-500 mt-1">Les nouvelles images seront ajoutées à celles existantes.</p>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold">
                Mettre à jour le Bien
            </button>
        </form>
    </div>
</div>
</x-app-layout>