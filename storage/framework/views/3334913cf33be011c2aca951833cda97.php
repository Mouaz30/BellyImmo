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
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel avec contenu superposé</title>
    <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div id="custom-flowbite-carousel" class="relative w-full mt-16" data-carousel="slide">
        <!-- Conteneur du carrousel -->
        <div class="relative h-96 md:h-[600px] overflow-hidden rounded-lg">
            <!-- Élément 1 du carrousel -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                <img src="<?php echo e(asset('storage/images/carroussel0.jpg')); ?>" 
                     class="absolute inset-0 w-full h-full object-cover" 
                     alt="Image 1">
            </div>
            
            <!-- Élément 2 du carrousel -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="<?php echo e(asset('storage/images/image0.jpg')); ?>" 
                     class="absolute inset-0 w-full h-full object-cover" 
                     alt="Image 2">
            </div>
        </div>

        <!-- Contenu superposé (texte + formulaire) - positionné ABSOLUMENT par rapport au carrousel -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center z-30 px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white">
                Trouvez la propriété
                <span class="block text-orange-500">de vos rêves</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mt-4">
                Découvrez les meilleures opportunités immobilières au Sénégal. 
                Achat, vente, location — nous vous accompagnons dans tous vos projets.
            </p>

            <!-- Formulaire de recherche -->
            <div class="mt-8 w-full max-w-4xl bg-white/80 backdrop-blur-sm rounded-lg p-6 shadow-lg">
                <form class="flex flex-col md:flex-row gap-4">
                    <select class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                        <option disabled selected>Type de bien</option>
                        <option>Appartement</option>
                        <option>Maison</option>
                        <option>Villa</option>
                        <option>Bureau</option>
                    </select>

                    <select class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                        <option disabled selected>Choisir une ville</option>
                        <option>Dakar</option>
                        <option>Thiès</option>
                        <option>Saint-Louis</option>
                        <option>Mbour</option>
                    </select>

                    <input type="number" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-gray-700" placeholder="Prix maximum">

                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>

        <!-- Boutons de navigation -->
        <button type="button" class="absolute top-1/2 left-0 z-40 flex items-center justify-center h-10 w-10 transform -translate-y-1/2 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        </button>
        <button type="button" class="absolute top-1/2 right-0 z-40 flex items-center justify-center h-10 w-10 transform -translate-y-1/2 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700/30 group-hover:bg-gray-900/50">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </button>
    </div>
</body>
</html>



    
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900">Biens Immobiliers en Vedette</h2> <br>
                <p class="mt-2 text-gray-600 text-align-center">
                    Découvrez notre sélection de propriétés exceptionnelles, soigneusement choisies <br>
                    pour leur qualité et leur emplacement privilégié.
                </p>
            </div>
            <br>
            <br>
            <br>

            <?php if($biens->isEmpty()): ?>
                <p class="text-center text-gray-500">Aucun bien immobilier disponible pour le moment.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $biens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden">

                            
                            <div class="relative">
                                <?php
                                    $image = $bien->illustrations->first();
                                ?>
                                
                                <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                                    <?php if($bien->statut === \App\Enums\StatutBien::DISPONIBLE): ?> bg-blue-600 text-white
                                    <?php elseif($bien->statut === \App\Enums\StatutBien::LOUE): ?> bg-green-500 text-white
                                    <?php elseif($bien->statut === \App\Enums\StatutBien::VENDU): ?> bg-gray-500 text-white
                                    <?php elseif($bien->statut === \App\Enums\StatutBien::RESERVE): ?> bg-yellow-500 text-white
                                    <?php else: ?> bg-gray-400 text-white <?php endif; ?>">
                                    <?php echo e($bien->statut->label()); ?>

                                </span>
                                <img src="<?php echo e($image?->image_url ?? asset('images/default.png')); ?>" 
                                     alt="<?php echo e($bien->titre); ?>" 
                                     class="w-full h-48 object-cover">   
                            </div>

                            
                            <div class="p-4">
                           <div class="flex items-center justify-between mb-2">
                                <p class="text-blue-600 font-bold text-xl">
                                    <?php echo e(number_format($bien->prix, 0, ',', ' ')); ?> 
                                    <?php if($bien->statut === \App\Enums\StatutBien::LOUE): ?> CFA/mois 
                                    <?php else: ?> CFA 
                                    <?php endif; ?>
                                </p>

                                <p class="bg-gray-100 text-sm px-2 py-1 rounded text-gray-800">
                                    <?php if($bien->statut === \App\Enums\StatutBien::LOUE): ?>
                                    Location
                                    <?php else: ?>
                                    Vente
                                    <?php endif; ?>
                                </p>
                            </div>

                                
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($bien->titre); ?></h3>

                                
                                <p class="text-gray-500 text-sm mb-4"><?php echo e($bien->adresse); ?></p>

                                
                                <div class="text-sm text-gray-600 mb-4">
                                    <?php echo e(strip_tags($bien->description)); ?>

                                </div>

                                
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('biens.show', $bien->id)); ?>" class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors">
                                        Voir détails
                                    </a>
                                    <a href="#" class="flex-1 text-center bg-gray-100 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">
                                        Contacter
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\ProjetImmobilier\resources\views/front/home.blade.php ENDPATH**/ ?>