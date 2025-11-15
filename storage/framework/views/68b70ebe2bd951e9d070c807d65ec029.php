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
    
   
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            
            <nav aria-label="Breadcrumb" class="mb-8">
                <br>
                <br>
                <ol role="list" class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-500 hover:text-orange-500 transition font-medium">
                            Accueil
                        </a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-900 font-bold truncate"><?php echo e($bien->titre); ?></li>
                </ol>
            </nav>
<br>
<br>
<br>
            
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                
                
                <div class="lg:col-span-2 space-y-6">
                    
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <?php $__empty_1 = true; $__currentLoopData = $bien->illustrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $illustration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                // La première image prend deux colonnes sur mobile/tablette, sinon une
                                $grid_class = $index === 0 ? 'col-span-2' : 'col-span-1'; 
                                // La première image est plus haute
                                $height_class = $index === 0 ? 'h-96 sm:h-[400px]' : 'h-64 sm:h-72';
                            ?>
                            
                            
                            <div class="<?php echo e($grid_class); ?> rounded-xl shadow-md overflow-hidden bg-white group cursor-pointer">
                                <img src="<?php echo e($illustration->image_url); ?>" 
                                    alt="<?php echo e($bien->titre); ?> - Image <?php echo e($index + 1); ?>" 
                                    class="w-full <?php echo e($height_class); ?> object-cover 
                                           group-hover:scale-105 transition-transform duration-500 ease-in-out">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                            <div class="col-span-3 h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                                <span class="text-gray-500 text-lg">Aucune image disponible</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">
                            Description du bien
                     </h2>
                    <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">
                         <?php echo e($bien->description); ?>

                     </p>
                    </div>


                    
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-4 border-b-2 border-orange-500 pb-2">Informations Clés</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                            
                            <div class="flex justify-between sm:block text-black">
                                <dt class="font-semibold text-gray-500">Type de bien</dt>
                                <dd class="font-bold text-gray-900 capitalize"><?php echo e($bien->type); ?></dd>
                            </div>
                            <div class="flex justify-between sm:block text-black">
                                <dt class="font-semibold text-gray-500">Adresse</dt>
                                <dd class="font-bold text-gray-900"><?php echo e($bien->adresse); ?></dd>
                            </div>
                            
                            
                        </dl>
                    </div>

                </div>

                
                <div class="mt-10 lg:mt-0">       
                    
                    <div class="bg-white rounded-xl shadow-2xl p-6 sticky top-8 border-t-4 border-orange-500">
                        
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2"><?php echo e($bien->titre); ?></h1>

                        <div class="mb-4">
                            <p class="text-gray-700 font-black text-orange-600">
                                <?php echo e(number_format($bien->prix, 0, ',', ' ')); ?> 
                                <span class="text-gray-700">CFA</span>
                                <?php if($bien->statut === \App\Enums\StatutBien::LOUE): ?>
                                    <span class="text-base text-gray-600 font-normal">/mois</span>
                                <?php endif; ?>
                            </p>
                        </div>

                        <div class="mb-5 pb-4 border-b border-gray-100">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider
                                <?php if($bien->statut === \App\Enums\StatutBien::LOUE): ?>
                                    bg-green-600 text-gray-700
                                <?php else: ?>
                                    bg-orange-500 text-gray-700
                                <?php endif; ?>">
                                <?php echo e($bien->statut); ?>

                            </span>
                        </div>


                        
                        <div class="space-y-3">
                            <button class="w-full bg-orange-600 hover:bg-orange-700 text-white text-lg font-bold py-3 px-4 rounded-lg shadow-xl transition transform hover:scale-[1.01] duration-300 uppercase">
                                Contacter l'agence
                            </button>
   
                        </div><br>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold py-3 px-4 rounded-lg transition duration-200">
                              Réserver
                        </button>

                    </div>
                </div>
            </div>

           
           <?php if(isset($biensSimilaires) && $biensSimilaires->isNotEmpty()): ?>
                <div class="mt-16">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-orange-500 inline-block pb-1">Biens similaires</h2>
                    
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $biensSimilaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">

                                
                                <div class="relative">
                                    <?php $image = $similaire->illustrations->first(); ?>

                                    
                                    <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                                        <?php if($similaire->statut === 'disponible'): ?> bg-blue-600 text-white
                                        <?php elseif($similaire->statut === 'loue'): ?> bg-green-500 text-white
                                        <?php elseif($similaire->statut === 'vendu'): ?> bg-gray-500 text-white
                                        <?php elseif($similaire->statut === 'reserve'): ?> bg-yellow-500 text-white
                                        <?php else: ?> bg-gray-400 text-white <?php endif; ?>">
                                        <?php echo e($similaire->statut); ?>

                                    </span>

                                    <img src="<?php echo e($image?->image_url ?? asset('images/default.png')); ?>" 
                                         alt="<?php echo e($similaire->titre); ?>" 
                                         class="w-full h-48 object-cover"> 
                                </div>

                                
                                <div class="p-4">
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-blue-600 font-bold text-xl">
                                            <?php echo e(number_format($similaire->prix, 0, ',', ' ')); ?>

                                            <?php if($similaire->statut === 'loue'): ?> <span class="text-sm text-gray-700 font-normal">CFA/mois</span>
                                            <?php else: ?> <span class="text-sm text-gray-700 font-normal">CFA</span> <?php endif; ?>
                                        </p>

                                        
                                        <p class="bg-gray-100 text-sm px-2 py-1 rounded text-gray-800">
                                            <?php if($similaire->statut === 'loue'): ?> Location
                                            <?php else: ?> Vente <?php endif; ?>
                                        </p>
                                    </div>

                                    
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($similaire->titre); ?></h3>

                                    
                                    <p class="text-gray-500 text-sm mb-3"><?php echo e($similaire->adresse); ?></p>

                                    
                                    <div class="text-sm text-gray-600 mb-4 line-clamp-3"> 
                                        <?php echo e(Str::limit(strip_tags($similaire->description), 100)); ?> 
                                    </div>

                                    
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('biens.show', $similaire->id)); ?>" 
                                           class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors">
                                            Voir détails
                                        </a>
                                        <a href="#" 
                                           class="flex-1 text-center bg-gray-100 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">
                                            Contacter
                                        </a>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="mt-16 text-center">
                    <p class="text-gray-500">Aucun bien similaire n'a été trouvé pour le moment.</p>
                </div>
            <?php endif; ?>


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
<?php endif; ?><?php /**PATH C:\laragon\www\ProjetImmobilier\resources\views/front/bien-show.blade.php ENDPATH**/ ?>