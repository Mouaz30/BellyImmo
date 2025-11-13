<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-800">

        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-white selection:bg-blue-500 selection:text-white">

            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-700 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-700 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-600">Connexion</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-700 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-600">Inscription</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center mb-6">
                    <svg viewBox="0 0 62 65" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto text-blue-600">
                        <path d="M61.854 25.771...Z" fill="currentColor" />
                    </svg>
                </div>

                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Bienvenue sur notre plateforme immobilière</h1>
                    <p class="text-gray-600 mb-6">Découvrez les meilleures offres de location et d’achat de biens immobiliers.</p>

                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Se connecter</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-blue-700 transition">S’inscrire</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
