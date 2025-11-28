@props([
    // Pour la version simple
    'label' => null,
    'count' => null,
    'color' => 'gray',

    // Pour la version avancée
    'title' => null,
    'value' => null,
    'icon' => null,
])

{{-- ========================= --}}
{{--   VERSION 1 : STAT SIMPLE --}}
{{-- ========================= --}}
@if($label && $count !== null)
<div class="p-6 rounded-lg border shadow-sm 
    @if($color === 'blue') bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800
    @elseif($color === 'green') bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800
    @elseif($color === 'red') bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800
    @elseif($color === 'yellow') bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800
    @else bg-gray-50 border-gray-200 dark:bg-gray-900/20 dark:border-gray-800 
    @endif">

    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
        {{ $label }}
    </p>

    <p class="text-3xl font-bold mt-2 
        @if($color === 'blue') text-blue-800 dark:text-blue-100
        @elseif($color === 'green') text-green-800 dark:text-green-100
        @elseif($color === 'red') text-red-800 dark:text-red-100
        @elseif($color === 'yellow') text-yellow-800 dark:text-yellow-100
        @else text-gray-800 dark:text-gray-100
        @endif
    ">
        {{ $count }}
    </p>
</div>
@endif

{{-- ===================================== --}}
{{--   VERSION 2 : STAT AVEC ICÔNE (OPTION) --}}
{{-- ===================================== --}}
@if($title && $value)
<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
    <div class="flex items-center">

        @if($icon)
        <div class="p-3 rounded-full bg-opacity-20
            @if($color === 'blue') bg-blue-500
            @elseif($color === 'green') bg-green-500
            @elseif($color === 'red') bg-red-500
            @elseif($color === 'yellow') bg-yellow-500
            @else bg-gray-500
            @endif">
            {!! $icon !!}
        </div>
        @endif

        <div class="ml-4">
            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                {{ $title }}
            </h3>

            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $value }}
            </p>
        </div>
    </div>
</div>
@endif
