<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tableau de bord - Client
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Bienvenue, {{ Auth::user()->nom_complet }} !
            </h3>
            <p class="mt-4 text-gray-600 dark:text-gray-300">
                Ceci est votre tableau de bord client. Ici vous pourrez voir vos réservations, visites et contrats.
            </p>
        </div>
    </div>
</x-app-layout>
