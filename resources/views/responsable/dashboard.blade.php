<x-app-layout>

<x-slot name="header">
    <h2 class="font-bold text-2xl text-slate-800">
        Dashboard Responsable
    </h2>
</x-slot>

<div class="py-8 px-6">

    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white p-6 rounded-2xl shadow">
            <p class="text-slate-500 text-sm">En attente</p>
            <h1 class="text-3xl font-bold mt-2">
                {{ $waitingCount }}
            </h1>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <p class="text-slate-500 text-sm">En cours</p>
            <h1 class="text-3xl font-bold mt-2">
                {{ $processingCount }}
            </h1>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <p class="text-slate-500 text-sm">Terminés</p>
            <h1 class="text-3xl font-bold mt-2">
                {{ $finishedCount }}
            </h1>
        </div>

    </div>


    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="text-xl font-semibold mb-5">
            File d’attente
        </h3>

        <table class="w-full">

            <thead>
                <tr class="border-b">
                    <th class="text-left py-3">Ticket</th>
                    <th class="text-left py-3">Statut</th>
                    <th class="text-left py-3">Action</th>
                </tr>
            </thead>

            <tbody>

            @foreach($queue as $reservation)

                <tr class="border-b">

                    <td class="py-4">
                        {{ $reservation->numero }}
                    </td>

                    <td>
                        {{ $reservation->statut }}
                    </td>

                    <td class="flex gap-2 py-4">

                        <form method="POST" action="{{ route('responsable.ticket.suivant') }}">
                            @csrf
                            <button class="bg-blue-600 text-white px-3 py-2 rounded-lg">
                                Appeler
                            </button>
                        </form>

                        <form method="POST" action="{{ route('responsable.ticket.terminer') }}">
                            @csrf
                            <button class="bg-green-600 text-white px-3 py-2 rounded-lg">
                                Terminer
                            </button>
                        </form>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>