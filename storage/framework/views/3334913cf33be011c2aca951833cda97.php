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

    
    <div id="custom-flowbite-carousel" class="relative w-full mt-16" data-carousel="slide">
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96" style="height: 600px;">
            <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                <img src="<?php echo e(asset('storage/images/image1.png')); ?>" class="absolute block w-full h-full object-cover" alt="Image 1">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="<?php echo e(asset('storage/images/image2.png')); ?>" class="absolute block w-full h-full object-cover" alt="Image 2">
            </div>
        </div>

        
        <button type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900">Biens Immobiliers en Vedette</h2>
                <p class="mt-2 text-gray-600">
                    Découvrez notre sélection de propriétés soigneusement choisies pour leur qualité et leur emplacement privilégié.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php $__currentLoopData = $biens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden">
                        
                        
                        <div class="relative">
                            <?php
                                $image = $bien->illustrations->first();
                            ?>

                            <?php if($image && $image->image_url): ?>
                                <img src="<?php echo e($image->image_url); ?>" 
                                     alt="<?php echo e($bien->titre); ?>" 
                                     class="w-full h-48 object-cover">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/default.png')); ?>" 
                                     alt="Image par défaut" 
                                     class="w-full h-48 object-cover">
                            <?php endif; ?>

                            
                            <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                                <?php if($bien->statut === \App\Enums\StatutBien::DISPONIBLE): ?> bg-blue-600 text-white
                                <?php elseif($bien->statut === \App\Enums\StatutBien::LOUE): ?> bg-green-500 text-white
                                <?php elseif($bien->statut === \App\Enums\StatutBien::VENDU): ?> bg-gray-500 text-white
                                <?php elseif($bien->statut === \App\Enums\StatutBien::RESERVE): ?> bg-yellow-500 text-white
                                <?php else: ?> bg-gray-400 text-white <?php endif; ?>">
                                <?php echo e($bien->statut->label()); ?>

                            </span>
                        </div>

                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?php echo e($bien->titre); ?></h3>
                            <p class="text-gray-600 text-sm mt-1 truncate">
                                <?php echo e(strip_tags($bien->description)); ?>

                            </p>

                            <p class="text-blue-600 font-bold text-xl mt-3">
                                <?php echo e(number_format($bien->prix, 0, ',', ' ')); ?> 
                                <?php if($bien->statut === \App\Enums\StatutBien::LOUE): ?> CFA/mois 
                                <?php else: ?> CFA 
                                <?php endif; ?>
                            </p>

                            <p class="text-gray-500 text-sm mt-1"><?php echo e($bien->adresse); ?></p>

                            <div class="mt-4 flex gap-2">
                                <a href="#" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                                    Voir détails
                                </a>
                                <a href="#" class="flex-1 text-center bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium">
                                    Contacter
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ProjetImmobilier\resources\views/front/home.blade.php ENDPATH**/ ?>