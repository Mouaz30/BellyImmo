<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="container mx-auto p-6">
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl">
<h1 class="text-3xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 border-b pb-4">
Ajouter un Nouveau Bien Immobilier 🏡
</h1>

<form action="<?php echo e(route('proprietaire.Bien.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
            <input type="text" id="titre" name="titre" 
                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('titre')); ?>" placeholder="Ex: Belle villa 4 chambres" required>
            <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="space-y-2">
            <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (FCFA)</label>
            <input type="number" id="prix" name="prix" 
                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['prix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('prix')); ?>" required>
            <?php $__errorArgs = ['prix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="space-y-2">
        <label for="adresse" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse Complète</label>
        <input type="text" id="adresse" name="adresse" 
               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               value="<?php echo e(old('adresse')); ?>" placeholder="Ex: 12 Rue de la Liberté, Dakar" required>
        <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="space-y-2">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description Détaillée</label>
        <textarea id="description" name="description" rows="5" 
                      class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                      placeholder="Décrivez les caractéristiques, les avantages et l'environnement du bien."><?php echo e(old('description')); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Bien</label>
            <select id="type" name="type" 
                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                  required>
                <option value="">-- Sélectionnez un type --</option>
                
                <option value="APPARTEMENT" <?php echo e(old('type') == 'APPARTEMENT' ? 'selected' : ''); ?>>Appartement</option>
                <option value="MAISON" <?php echo e(old('type') == 'MAISON' ? 'selected' : ''); ?>>Maison</option>
                <option value="VILLA" <?php echo e(old('type') == 'VILLA' ? 'selected' : ''); ?>>Villa</option>
                <option value="TERRAIN" <?php echo e(old('type') == 'TERRAIN' ? 'selected' : ''); ?>>Terrain</option>
                <option value="COMMERCIAL" <?php echo e(old('type') == 'COMMERCIAL' ? 'selected' : ''); ?>>Local Commercial</option>
            </select>
            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="space-y-2">
            <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut de l'Annonce</label>
            <select id="statut" name="statut" 
                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                  required>
                <option value="">-- Sélectionnez un statut --</option>
                
                <option value="disponible" <?php echo e(old('statut') == 'disponible' ? 'selected' : ''); ?>>Disponible</option>
                <option value="loue" <?php echo e(old('statut') == 'loue' ? 'selected' : ''); ?>>Loué</option>
                <option value="vendu" <?php echo e(old('statut') == 'vendu' ? 'selected' : ''); ?>>Vendu</option>
                <option value="reserve" <?php echo e(old('statut') == 'reserve' ? 'selected' : ''); ?>>Réservé</option>
            </select>
            <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="space-y-2 border-t pt-6 border-gray-200 dark:border-gray-700">
        <label for="images" class="block text-lg font-bold text-gray-800 dark:text-gray-100">Ajouter les photos du Bien</label>
        <input type="file" id="images" name="images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-400 dark:text-gray-400 <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images simultanément.</p>
        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1">Une des images n'est pas valide ou dépasse la taille maximale.</p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="pt-4 flex justify-end">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
            💾 Enregistrer le Bien
        </button>
    </div>
</form>


</div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\ProjetImmobilier\resources\views/proprietaire/Bien/create.blade.php ENDPATH**/ ?>