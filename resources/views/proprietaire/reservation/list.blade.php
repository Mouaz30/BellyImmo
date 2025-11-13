<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-800">Liste des réservations</h3>
                    </div>

                    <!-- Tableau des réservations -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Bien
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Date de début
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Date de fin
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->bien->titre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->client->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->date_debut }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->date_fin }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $reservation->statut === 'confirmée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($reservation->statut) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('proprietaire.reservation.show', $reservation->id) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucune réservation trouvée.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
