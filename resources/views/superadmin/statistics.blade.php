
@extends('layouts.app')

@section('title','Statistiques')

@section('content')

<div class="min-h-screen bg-slate-100">

    <div class="max-w-7xl mx-auto px-8 py-8">

        {{-- Header --}}

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 mb-8">

            <div class="flex justify-between items-center">

                <div class="flex items-center gap-5">

                    <img src="{{ $appConfig?->logo ? asset('storage/' . $appConfig->logo) : asset('images/logo.png') }}"
                         class="w-16 h-16 object-contain">

                    <div>

                        <h1 class="text-4xl font-bold text-slate-800">

                            Statistiques

                        </h1>

                        <p class="text-slate-500 mt-1">

                            Analyse de la plateforme {{ $appConfig?->nom_app ?? 'Noubti' }}

                        </p>

                    </div>

                </div>

                <div class="text-right">

                    <p class="text-slate-400">

                        {{ now()->format('d/m/Y') }}

                    </p>

                    <a href="{{ route('superadmin.dashboard') }}"
                       class="inline-flex mt-3 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2 rounded-xl transition">

                        ← Dashboard

                    </a>

                </div>

            </div>

        </div>


        {{-- KPI --}}

        <div class="grid md:grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                <p class="text-slate-500">

                    Réservations

                </p>

                <h2 class="text-5xl font-bold text-slate-800 mt-4">

                    {{ $totalReservations }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                <p class="text-slate-500">

                    Aujourd'hui

                </p>

                <h2 class="text-5xl font-bold text-blue-600 mt-4">

                    {{ $todayReservations }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                <p class="text-slate-500">

                    Services

                </p>

                <h2 class="text-5xl font-bold text-slate-800 mt-4">

                    {{ $servicesCount }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                <p class="text-slate-500">

                    Utilisateurs

                </p>

                <h2 class="text-5xl font-bold text-slate-800 mt-4">

                    {{ $usersCount }}

                </h2>

            </div>

        </div>


        {{-- Status --}}

        <div class="grid md:grid-cols-4 gap-6 mb-10">

            <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-6">

                <p class="text-yellow-700">

                    En attente

                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $waiting }}

                </h2>

            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">

                <p class="text-blue-700">

                    En cours

                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $processing }}

                </h2>

            </div>

            <div class="bg-green-50 border border-green-100 rounded-2xl p-6">

                <p class="text-green-700">

                    Terminés

                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $finished }}

                </h2>

            </div>

            <div class="bg-red-50 border border-red-100 rounded-2xl p-6">

                <p class="text-red-700">

                    Annulés

                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $cancelled }}

                </h2>

            </div>

        </div>


        {{-- Charts --}}

        <div class="grid lg:grid-cols-2 gap-8">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">

                <h2 class="text-xl font-semibold mb-6">

                    Réservations par statut

                </h2>

                <canvas id="reservationChart"></canvas>

            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">

                <h2 class="text-xl font-semibold mb-6">

                    Répartition

                </h2>

                <canvas id="statusChart"></canvas>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('reservationChart'),{

type:'bar',

data:{

labels:['En attente','En cours','Terminés','Annulés'],

datasets:[{

data:[
{{ $waiting }},
{{ $processing }},
{{ $finished }},
{{ $cancelled }}
],

backgroundColor:[
'#FACC15',
'#3B82F6',
'#22C55E',
'#EF4444'
],

borderRadius:10

}]

},

options:{

plugins:{

legend:{

display:false

}

}

}

});

new Chart(document.getElementById('statusChart'),{

type:'doughnut',

data:{

labels:['En attente','En cours','Terminés','Annulés'],

datasets:[{

data:[
{{ $waiting }},
{{ $processing }},
{{ $finished }},
{{ $cancelled }}
],

backgroundColor:[
'#FACC15',
'#3B82F6',
'#22C55E',
'#EF4444'
]

}]

}

});

</script>

@endsection

