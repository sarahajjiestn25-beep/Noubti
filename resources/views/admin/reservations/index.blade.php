<x-layouts.admin title="Réservations">

```
{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Réservations
        </h1>

        <p class="text-gray-500 mt-1">
            Consultez et suivez les réservations effectuées sur les services.
        </p>
    </div>

</div>


{{-- STATISTICS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- TOTAL --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <p class="text-sm font-medium text-gray-500">
            Total réservations
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-2">
            {{ $reservations->total() }}
        </h2>

    </div>


    {{-- EN ATTENTE --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <p class="text-sm font-medium text-gray-500">
            En attente
        </p>

        <h2 class="text-4xl font-bold text-amber-600 mt-2">
            {{ \App\Models\Reservation::where('statut', 'en attente')->count() }}
        </h2>

    </div>


    {{-- EN COURS --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <p class="text-sm font-medium text-gray-500">
            En cours
        </p>

        <h2 class="text-4xl font-bold text-indigo-600 mt-2">
            {{ \App\Models\Reservation::where('statut', 'en cours')->count() }}
        </h2>

    </div>

</div>


{{-- TABLE --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

    <div class="p-6 border-b border-gray-200">

        <h2 class="text-xl font-bold text-gray-900">
            Liste des réservations
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Toutes les réservations enregistrées dans le système.
        </p>

    </div>


    @if($reservations->count() > 0)

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Ticket
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Client
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Téléphone
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Service
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Heure
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                            Statut
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach($reservations as $reservation)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- TICKET --}}
                            <td class="px-6 py-4">

                              <span class="font-bold text-indigo-600">
    {{ $reservation->formatted_ticket }}
</span>

                            </td>


                            {{-- CLIENT --}}
                            <td class="px-6 py-4">

                                <p class="font-semibold text-gray-900">
                                    {{ $reservation->nom_client ?? 'Visiteur' }}
                                </p>

                            </td>


                            {{-- TELEPHONE --}}
                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $reservation->telephone_client ?? 'Non renseigné' }}

                            </td>


                            {{-- SERVICE --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">

                                    {{ $reservation->service->nom_service ?? 'Service #'.$reservation->id_service }}

                                </span>

                            </td>


                            {{-- HEURE --}}
                            <td class="px-6 py-4 text-sm text-gray-600">

                                @if($reservation->heure_reservation)

                                    {{ \Illuminate\Support\Carbon::parse($reservation->heure_reservation)->format('H:i') }}

                                @else

                                    --

                                @endif

                            </td>


                            {{-- STATUT --}}
                            <td class="px-6 py-4">

                                @if($reservation->statut === 'en attente')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold">
                                        En attente
                                    </span>

                                @elseif($reservation->statut === 'en cours')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                                        En cours
                                    </span>

                                @elseif($reservation->statut === 'termine')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                        Terminé
                                    </span>

                                @elseif($reservation->statut === 'annule')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                        Annulé
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold">
                                        {{ $reservation->statut ?? 'Inconnu' }}
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="p-6 border-t border-gray-200">

            {{ $reservations->links() }}

        </div>


    @else

        <div class="p-12 text-center">

            <div class="text-5xl mb-4">
                📅
            </div>

            <h3 class="text-lg font-bold text-gray-900">
                Aucune réservation
            </h3>

            <p class="text-gray-500 mt-1">
                Aucune réservation n'a encore été enregistrée.
            </p>

        </div>

    @endif

</div>

</x-layouts.admin>
