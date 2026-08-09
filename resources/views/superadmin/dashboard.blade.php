@extends('layouts.app')

@section('title','SuperAdmin Dashboard')

@section('content')

<div class="min-h-screen bg-slate-100">

<div class="max-w-7xl mx-auto p-8">

{{-- HEADER MODERN --}}

<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 p-8 shadow-xl mb-10">

    <div class="absolute -right-10 -top-10 w-52 h-52 rounded-full bg-white/10"></div>
    <div class="absolute right-20 bottom-0 w-32 h-32 rounded-full bg-white/5"></div>

    <div class="relative flex flex-col lg:flex-row justify-between items-center">

        <div class="flex items-center gap-6">

            <div class="bg-white rounded-3xl p-4 shadow-lg">

                <img
                    src="{{ asset('images/logo.png') }}"
                    class="w-20 h-20 object-contain">

            </div>

            <div class="text-white">

                <h1 class="text-5xl font-black tracking-wide">
                    Noubti
                </h1>

                <p class="text-blue-100 text-xl mt-2">
                    Super Administration
                </p>

                <p class="text-blue-200 mt-2">
                    Gestion intelligente des files d'attente
                </p>

            </div>

        </div>

        <div class="mt-8 lg:mt-0">

            <div class="bg-white/15 backdrop-blur rounded-2xl px-7 py-5 text-white">

                <p class="text-sm uppercase tracking-widest opacity-80">
                    Aujourd'hui
                </p>

                <h2 class="text-3xl font-bold mt-1">
                    {{ now()->format('d / m / Y') }}
                </h2>

                <p class="mt-3 text-green-300 font-semibold">
                    ● Plateforme en ligne
                </p>

            </div>

        </div>

    </div>

</div>
 {{-- QUICK ACTIONS --}}

<div class="grid grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

<a href="{{ route('admin.services.index') }}"
class="group bg-white rounded-3xl p-6 border border-slate-200 hover:border-blue-500 hover:shadow-xl transition duration-300">

<div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition">

🏥

</div>

<h2 class="font-bold text-slate-800 text-lg">
Services
</h2>

<p class="text-slate-500 mt-2 text-sm">
Gérer les services
</p>

</a>

<a href="{{ route('superadmin.users.index') }}"
class="group bg-white rounded-3xl p-6 border border-slate-200 hover:border-violet-500 hover:shadow-xl transition">

<div class="w-16 h-16 rounded-2xl bg-violet-100 flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition">

👥

</div>

<h2 class="font-bold text-slate-800 text-lg">
Utilisateurs
</h2>

<p class="text-slate-500 mt-2 text-sm">
Comptes de la plateforme
</p>

</a>

<a href="{{ route('superadmin.statistics') }}"
class="group bg-white rounded-3xl p-6 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition">

<div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition">

📊

</div>

<h2 class="font-bold text-slate-800 text-lg">
Statistiques
</h2>

<p class="text-slate-500 mt-2 text-sm">
Rapports détaillés
</p>

</a>

<a href="{{ route('superadmin.export.excel') }}"
class="group bg-white rounded-3xl p-6 border border-slate-200 hover:border-orange-500 hover:shadow-xl transition">

<div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition">

⬇️

</div>

<h2 class="font-bold text-slate-800 text-lg">
Excel
</h2>

<p class="text-slate-500 mt-2 text-sm">
Exporter les données
</p>

</a>

<form method="POST" action="{{ route('logout') }}">

@csrf

<button
class="group w-full bg-white rounded-3xl p-6 border border-slate-200 hover:border-red-500 hover:shadow-xl transition">

<div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl mb-5 mx-auto group-hover:scale-110 transition">

🚪

</div>

<h2 class="font-bold text-slate-800 text-lg">
Déconnexion
</h2>

<p class="text-slate-500 mt-2 text-sm">
Quitter la session
</p>

</button>

</form>

</div>
{{-- STATISTIQUES --}}


<div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 mb-8">

<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">Services</p>

<h2 class="text-5xl font-black text-blue-700 mt-2">
{{ $servicesCount }}
</h2>

</div>

<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">Utilisateurs</p>

<h2 class="text-5xl font-black text-violet-700 mt-2">
{{ $usersCount }}
</h2>

</div>

<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">Admins</p>

<h2 class="text-5xl font-black text-green-600 mt-2">
{{ $adminsCount }}
</h2>

</div>

<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">Responsables</p>

<h2 class="text-5xl font-black text-orange-500 mt-2">
{{ $responsablesCount }}
</h2>

</div>

</div>

<div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 mb-10">

<div class="bg-yellow-50 rounded-3xl p-6">

<p class="text-yellow-700">
En attente
</p>

<h2 class="text-5xl font-black text-yellow-600 mt-2">
<span id="waiting-count">{{ $waitingCount }}</span>
</h2>

</div>

<div class="bg-blue-50 rounded-3xl p-6">

<p class="text-blue-700">
En cours
</p>

<h2 class="text-5xl font-black text-blue-600 mt-2">
<span id="processing-count">{{ $processingCount }}</span>
</h2>

</div>

<div class="bg-green-50 rounded-3xl p-6">

<p class="text-green-700">
Terminés
</p>

<h2 class="text-5xl font-black text-green-600 mt-2">
<span id="finished-count">{{ $finishedCount }}</span>
</h2>

</div>

<div class="bg-red-50 rounded-3xl p-6">

<p class="text-red-700">
Annulés
</p>

<h2 class="text-5xl font-black text-red-600 mt-2">
<span id="cancelled-count">{{ $cancelledCount }}</span>
</h2>

</div>

</div>

{{-- TABLEAU --}}

<div class="grid lg:grid-cols-3 gap-8">

<div class="lg:col-span-2">

<div class="bg-white rounded-3xl shadow">

<div class="p-6 border-b">

<h2 class="text-2xl font-bold">

Dernières réservations

</h2>

</div>

<div class="overflow-x-auto">

<table class="w-full">

<thead class="bg-slate-100">

<tr>

<th class="text-left p-4">Ticket</th>

<th>Client</th>

<th>Service</th>

<th>Statut</th>

</tr>

</thead>

<tbody>

@forelse($latestReservations as $reservation)

<tr class="border-t">

<td class="p-4">

{{ $reservation->numero }}

</td>

<td>

{{ $reservation->nom_client }}

</td>

<td>

{{ optional($reservation->service)->nom_service }}

</td>

<td>

{{ $reservation->statut }}

</td>

</tr>

@empty

<tr>

<td colspan="4" class="p-10 text-center">

Aucune réservation.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<div>

<div class="bg-white rounded-3xl shadow p-8">

<h2 class="text-2xl font-bold mb-8">

Aujourd'hui

</h2>

<div class="space-y-5">

<div class="flex justify-between">

<span>Réservations</span>

<b>{{ $todayReservations }}</b>

</div>

<div class="flex justify-between">

<span>Services</span>

<b>{{ $servicesCount }}</b>

</div>

<div class="flex justify-between">

<span>Utilisateurs</span>

<b>{{ $usersCount }}</b>

</div>

<div class="flex justify-between">

<span>Responsables</span>

<b>{{ $responsablesCount }}</b>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

@endsection