@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-4xl font-bold text-slate-800">
                    Dashboard Responsable
                </h1>

                <p class="text-slate-500 mt-2">
                    {{ $service->nom_service }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow px-6 py-4">

                <div class="text-sm text-slate-500">
                    Aujourd'hui
                </div>

                <div class="font-bold text-lg">
                    {{ now()->format('d/m/Y') }}
                </div>

            </div>

        </div>


        <div class="grid grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500">
                    En attente
                </p>

                <h2 class="text-4xl font-bold text-yellow-500 mt-3">
                    {{ $waitingCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500">
                    En cours
                </p>

                <h2 class="text-4xl font-bold text-blue-600 mt-3">
                    {{ $processingCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500">
                    Terminés
                </p>

                <h2 class="text-4xl font-bold text-green-600 mt-3">
                    {{ $finishedCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500">
                    Annulés
                </p>

                <h2 class="text-4xl font-bold text-red-600 mt-3">
                    {{ $cancelledCount }}
                </h2>

            </div>

        </div>


        <div class="grid lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-3xl shadow p-8">

                <h2 class="text-2xl font-bold mb-6">
                    File d'attente
                </h2>

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">Ticket</th>
                            <th class="text-left">Client</th>
                            <th class="text-left">Téléphone</th>
                            <th class="text-left">Statut</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($queue as $ticket)

                        <tr class="border-b hover:bg-slate-50">

                            <td class="py-4 font-bold">
                                {{ str_pad((int)preg_replace('/[^0-9]/','',$ticket->numero),2,'0',STR_PAD_LEFT) }}
                            </td>

                            <td>
                                {{ $ticket->nom_client }}
                            </td>

                            <td>
                                {{ $ticket->telephone_client }}
                            </td>

                            <td>

                                @if($ticket->statut=="En attente")

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                        En attente

                                    </span>

                                @elseif($ticket->statut=="En cours")

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                        En cours

                                    </span>

                                @elseif($ticket->statut=="Terminé")

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                        Terminé

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                        Annulé

                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" class="py-10 text-center text-slate-500">

                                Aucun ticket aujourd'hui.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div>

                <div class="bg-white rounded-3xl shadow p-8">

                    <h2 class="text-2xl font-bold mb-6">

                        Actions

                    </h2>

                    <form action="{{ route('responsable.ticket.suivant') }}" method="POST">

                        @csrf

                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl mb-4">

                            ▶ Appeler suivant

                        </button>

                    </form>

                    <form action="{{ route('responsable.ticket.terminer') }}" method="POST">

                        @csrf

                        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl mb-4">

                            ✔ Terminer

                        </button>

                    </form>

                    <form action="{{ route('responsable.ticket.annuler') }}" method="POST">

                        @csrf

                        <button class="w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-xl">

                            ✖ Annuler

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection