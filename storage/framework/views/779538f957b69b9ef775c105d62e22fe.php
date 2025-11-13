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
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
            Mes Biens Immobiliers 🏡
        </h1>
        <a href="<?php echo e(route('proprietaire.Bien.create')); ?>" 
           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-150 ease-in-out shadow-md">
            + Ajouter un bien
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if($biens->isEmpty()): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mt-8" role="alert">
            <p class="font-bold">Aucun bien immobilier trouvé.</p>
            <p>Cliquez sur "+ Ajouter un bien" pour commencer à les lister.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $biens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:scale-[1.02]">
                    
                    <div class="relative h-48 overflow-hidden">
                        <?php if($bien->illustrations->isNotEmpty()): ?>
                            <img src="<?php echo e($bien->illustrations->first()->image_url); ?>" alt="illustration_bien"
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                Pas d'image
                            </div>
                        <?php endif; ?>
                        
                        <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                            <?php echo e($bien->type->value ?? $bien->type); ?>

                        </span>
                        
                        <span class="absolute top-2 right-2 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md 
                            <?php echo e(($bien->statut === 'A Louer' || $bien->statut === 'A Vendre') ? 'bg-green-500' : 
                                (($bien->statut === 'Vendu' || $bien->statut === 'Loué') ? 'bg-red-600' : 'bg-gray-500')); ?>">
                            <?php echo e($bien->statut->value ?? $bien->statut); ?>

                        </span>
                    </div>

                    <div class="p-4 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 truncate" title="<?php echo e($bien->titre); ?>">
                            <?php echo e($bien->titre); ?>

                        </h3>
                        
                        <p class="text-2xl font-extrabold text-green-600 dark:text-green-400 mb-3">
                            <?php echo e(number_format($bien->prix, 0, ',', ' ')); ?> FCFA
                        </p>
                        
                        <p class="text-gray-600 dark:text-gray-300 text-sm flex items-center mb-4 flex-grow">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            <span class="truncate"><?php echo e($bien->adresse); ?></span>
                        </p>
                        
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 mt-auto flex justify-between items-center">
                            <a href="<?php echo e(route('proprietaire.Bien.edit', $bien->id)); ?>" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600">
                                Modifier
                            </a>
                            <form action="<?php echo e(route('proprietaire.Bien.destroy', $bien->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600" 
                                        onclick="return confirm('Confirmer la suppression de ce bien ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\ProjetImmobilier\resources\views/proprietaire/Bien/list.blade.php ENDPATH**/ ?>