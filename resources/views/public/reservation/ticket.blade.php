@extends('layouts.public')

@section('title','Mon ticket')

@section('content')

<div class="min-h-screen bg-slate-100 py-10">

    <div class="max-w-2xl mx-auto">

        <div class="text-center mb-8">

            <img
                src="{{ asset('images/logo.png') }}"
                class="w-24 h-24 rounded-full object-cover bg-white shadow-xl mx-auto"
                alt="Logo">

            <h1 class="text-5xl font-bold text-blue-700 mt-4">
                Noubti
            </h1>

            <p class="text-slate-500 mt-2">
                Votre ticket a été créé avec succès
            </p>

        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white text-center py-10">

                <p class="text-xl">
                    Votre numéro
                </p>

                <h2 class="text-8xl font-black tracking-wider mt-2">
                    {{ str_pad((int) preg_replace('/[^0-9]/','',$reservation->numero),2,'0',STR_PAD_LEFT) }}
                </h2>

            </div>

            <div class="p-8">

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <p class="text-slate-400 text-sm">Client</p>
                        <p class="font-bold text-xl">
                            {{ $reservation->nom_client }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm">Téléphone</p>
                        <p class="font-bold text-xl">
                            {{ $reservation->telephone_client }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm">Service</p>
                        <p class="font-bold text-xl">
                            {{ $service->nom_service }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm">Statut</p>

                        <span
                            class="inline-block mt-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold">

                            {{ $reservation->statut }}

                        </span>

                    </div>

                </div>

                <div class="grid grid-cols-2 gap-6 mt-8">

                    <div class="bg-blue-50 rounded-2xl p-6 text-center">

                        <div class="text-5xl font-bold text-blue-700">
                            {{ $waitingBefore }}
                        </div>

                        <div class="text-slate-500 mt-2">
                            Personnes avant vous
                        </div>

                    </div>

                    <div class="bg-green-50 rounded-2xl p-6 text-center">

                        <div class="text-5xl font-bold text-green-700">
                            {{ $estimatedTime }}
                        </div>

                        <div class="text-slate-500 mt-2">
                            Minutes estimées
                        </div>

                    </div>

                </div>

                <div class="mt-8">

                    <div class="rounded-2xl bg-blue-50 p-5 text-center">

                        <p class="text-slate-600">

                            Cette page se mettra à jour automatiquement lorsque votre tour approche.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection