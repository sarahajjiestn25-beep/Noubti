@extends('layouts.app')

@section('title', 'SuperAdmin Dashboard')

@section('content')

@php
    $configuration = \App\Models\Configuration::first();

    $appName = $configuration?->nom_app ?? 'Noubti';

    $logo = $configuration?->logo
        ? asset('storage/' . $configuration->logo)
        : asset('images/logo.png');
@endphp

<div class="min-h-screen bg-slate-100">

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="relative overflow-hidden rounded-3xl
                    bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500
                    p-8 shadow-xl mb-10">

            {{-- Decorative circles --}}
            <div class="absolute -right-10 -top-10
                        w-56 h-56 rounded-full bg-white/10">
            </div>

            <div class="absolute right-24 bottom-0
                        w-36 h-36 rounded-full bg-white/5">
            </div>

            <div class="relative flex flex-col lg:flex-row
                        justify-between items-center gap-8">

                {{-- LEFT --}}
                <div class="flex items-center gap-6">

                    {{-- LOGO --}}
                    <div class="bg-white rounded-3xl p-4
                                shadow-lg w-28 h-28
                                flex items-center justify-center">

                        <img
                            src="{{ $logo }}"
                            alt="{{ $appName }}"
                            class="w-20 h-20 object-contain">
                    </div>

                    {{-- APP INFO --}}
                    <div class="text-white">

                        <h1 class="text-5xl font-black tracking-wide">
                            {{ $appName }}
                        </h1>

                        <p class="text-blue-100 text-xl mt-2">
                            Super Administration
                        </p>

                        <p class="text-blue-200 mt-2">
                            Gestion intelligente des files d'attente
                        </p>

                    </div>

                </div>

                {{-- DATE --}}
                <div class="bg-white/15 backdrop-blur
                            rounded-2xl px-7 py-5
                            text-white min-w-[220px]">

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


        {{-- =========================================================
             QUICK ACTIONS
        ========================================================== --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

            {{-- SERVICES --}}
            <a
                href="{{ route('superadmin.services.index') }}"
                class="group bg-white rounded-3xl p-6
                       border border-slate-200
                       hover:border-blue-500
                       hover:shadow-xl
                       transition duration-300">

                <div class="w-16 h-16 rounded-2xl
                            bg-blue-100
                            flex items-center justify-center
                            text-3xl mb-5
                            group-hover:scale-110
                            transition">

                    🏥

                </div>

                <h2 class="font-bold text-slate-800 text-lg">
                    Services
                </h2>

                <p class="text-slate-500 mt-2 text-sm">
                    Gérer les services
                </p>

            </a>


            {{-- UTILISATEURS --}}
            <a
                href="{{ route('superadmin.users.index') }}"
                class="group bg-white rounded-3xl p-6
                       border border-slate-200
                       hover:border-violet-500
                       hover:shadow-xl
                       transition duration-300">

                <div class="w-16 h-16 rounded-2xl
                            bg-violet-100
                            flex items-center justify-center
                            text-3xl mb-5
                            group-hover:scale-110
                            transition">

                    👥

                </div>

                <h2 class="font-bold text-slate-800 text-lg">
                    Utilisateurs
                </h2>

                <p class="text-slate-500 mt-2 text-sm">
                    Comptes de la plateforme
                </p>

            </a>


            {{-- STATISTIQUES --}}
            <a
                href="{{ route('superadmin.statistics') }}"
                class="group bg-white rounded-3xl p-6
                       border border-slate-200
                       hover:border-emerald-500
                       hover:shadow-xl
                       transition duration-300">

                <div class="w-16 h-16 rounded-2xl
                            bg-green-100
                            flex items-center justify-center
                            text-3xl mb-5
                            group-hover:scale-110
                            transition">

                    📊

                </div>

                <h2 class="font-bold text-slate-800 text-lg">
                    Statistiques
                </h2>

                <p class="text-slate-500 mt-2 text-sm">
                    Rapports détaillés
                </p>

            </a>


            {{-- EXCEL --}}
            <a
                href="{{ route('superadmin.export.excel') }}"
                class="group bg-white rounded-3xl p-6
                       border border-slate-200
                       hover:border-orange-500
                       hover:shadow-xl
                       transition duration-300">

                <div class="w-16 h-16 rounded-2xl
                            bg-orange-100
                            flex items-center justify-center
                            text-3xl mb-5
                            group-hover:scale-110
                            transition">

                    ⬇️

                </div>

                <h2 class="font-bold text-slate-800 text-lg">
                    Excel
                </h2>

                <p class="text-slate-500 mt-2 text-sm">
                    Exporter les données
                </p>

            </a>


            {{-- DECONNEXION --}}
            <form
                method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="group w-full bg-white rounded-3xl p-6
                           border border-slate-200
                           hover:border-red-500
                           hover:shadow-xl
                           transition duration-300">

                    <div class="w-16 h-16 rounded-2xl
                                bg-red-100
                                flex items-center justify-center
                                text-3xl mb-5 mx-auto
                                group-hover:scale-110
                                transition">

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


        {{-- =========================================================
             MAIN CONTENT
        ========================================================== --}}
        <div class="grid lg:grid-cols-3 gap-8">


            {{-- =====================================================
                 DERNIÈRES RÉSERVATIONS
            ====================================================== --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    {{-- CARD HEADER --}}
                    <div class="p-6 border-b border-slate-100
                                flex items-center justify-between">

                        <div>

                            <h2 class="text-2xl font-bold text-slate-800">
                                Dernières réservations
                            </h2>

                            <p class="text-slate-500 mt-1 text-sm">
                                Les dernières demandes enregistrées
                            </p>

                        </div>

                        <div class="w-12 h-12 rounded-2xl
                                    bg-blue-100
                                    flex items-center justify-center
                                    text-xl">

                            🎟️

                        </div>

                    </div>


                    {{-- TABLE --}}
                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="text-left px-6 py-4
                                               text-sm font-bold
                                               text-slate-700">
                                        Ticket
                                    </th>

                                    <th class="text-left px-6 py-4
                                               text-sm font-bold
                                               text-slate-700">
                                        Client
                                    </th>

                                    <th class="text-left px-6 py-4
                                               text-sm font-bold
                                               text-slate-700">
                                        Service
                                    </th>

                                    <th class="text-left px-6 py-4
                                               text-sm font-bold
                                               text-slate-700">
                                        Statut
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($latestReservations as $reservation)

                                    <tr class="border-t border-slate-100
                                               hover:bg-slate-50
                                               transition">

                                        {{-- TICKET --}}
                                        <td class="px-6 py-5">

                                            <span class="font-black
                                                         text-slate-800
                                                         text-lg">

                                                {{ $reservation->numero }}

                                            </span>

                                        </td>


                                        {{-- CLIENT --}}
                                        <td class="px-6 py-5">

                                            <span class="text-slate-700
                                                         font-medium">

                                                {{ $reservation->nom_client }}

                                            </span>

                                        </td>


                                        {{-- SERVICE --}}
                                        <td class="px-6 py-5">

                                            <span class="text-slate-600">

                                                {{ optional($reservation->service)->nom_service ?? '-' }}

                                            </span>

                                        </td>


                                        {{-- STATUT --}}
                                        <td class="px-6 py-5">

                                            @if($reservation->statut === 'En attente')

                                                <span class="inline-flex
                                                             items-center gap-1
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-yellow-100
                                                             text-yellow-700
                                                             text-xs
                                                             font-bold">

                                                    ● En attente

                                                </span>

                                            @elseif($reservation->statut === 'En cours')

                                                <span class="inline-flex
                                                             items-center gap-1
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-blue-100
                                                             text-blue-700
                                                             text-xs
                                                             font-bold">

                                                    ● En cours

                                                </span>

                                            @elseif($reservation->statut === 'Terminé')

                                                <span class="inline-flex
                                                             items-center gap-1
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-green-100
                                                             text-green-700
                                                             text-xs
                                                             font-bold">

                                                    ● Terminé

                                                </span>

                                            @elseif($reservation->statut === 'Annulé')

                                                <span class="inline-flex
                                                             items-center gap-1
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-red-100
                                                             text-red-700
                                                             text-xs
                                                             font-bold">

                                                    ● Annulé

                                                </span>

                                            @else

                                                <span class="inline-flex
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-slate-100
                                                             text-slate-600
                                                             text-xs
                                                             font-bold">

                                                    {{ $reservation->statut }}

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="px-6 py-12 text-center">

                                            <div class="text-4xl mb-3">
                                                🎟️
                                            </div>

                                            <p class="font-semibold
                                                      text-slate-700">

                                                Aucune réservation

                                            </p>

                                            <p class="text-slate-400
                                                      text-sm mt-1">

                                                Aucune réservation récente.

                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 AUJOURD'HUI
            ====================================================== --}}
            <div>

                <div class="bg-white rounded-3xl shadow-xl p-7">

                    {{-- HEADER --}}
                    <div class="flex items-center
                                justify-between mb-8">

                        <div>

                            <h2 class="text-2xl font-bold
                                       text-slate-800">

                                Aujourd'hui

                            </h2>

                            <p class="text-slate-500 mt-1 text-sm">

                                Résumé de la plateforme

                            </p>

                        </div>

                        <div class="w-12 h-12 rounded-2xl
                                    bg-blue-100
                                    flex items-center justify-center
                                    text-xl">

                            📊

                        </div>

                    </div>


                    {{-- RESERVATIONS --}}
                    <div class="flex items-center
                                justify-between
                                bg-slate-50
                                rounded-2xl
                                p-4 mb-4">

                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl
                                        bg-blue-100
                                        flex items-center justify-center">

                                🎟️

                            </div>

                            <span class="text-slate-700
                                         font-medium">

                                Réservations

                            </span>

                        </div>

                        <strong class="text-xl text-slate-800">
                            {{ $todayReservations }}
                        </strong>

                    </div>


                    {{-- SERVICES --}}
                    <div class="flex items-center
                                justify-between
                                bg-slate-50
                                rounded-2xl
                                p-4 mb-4">

                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl
                                        bg-blue-100
                                        flex items-center justify-center">

                                🏥

                            </div>

                            <span class="text-slate-700
                                         font-medium">

                                Services

                            </span>

                        </div>

                        <strong class="text-xl text-slate-800">
                            {{ $servicesCount }}
                        </strong>

                    </div>


                    {{-- UTILISATEURS --}}
                    <div class="flex items-center
                                justify-between
                                bg-slate-50
                                rounded-2xl
                                p-4 mb-4">

                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl
                                        bg-violet-100
                                        flex items-center justify-center">

                                👥

                            </div>

                            <span class="text-slate-700
                                         font-medium">

                                Utilisateurs

                            </span>

                        </div>

                        <strong class="text-xl text-slate-800">
                            {{ $usersCount }}
                        </strong>

                    </div>


                    {{-- RESPONSABLES --}}
                    <div class="flex items-center
                                justify-between
                                bg-slate-50
                                rounded-2xl
                                p-4">

                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl
                                        bg-orange-100
                                        flex items-center justify-center">

                                👤

                            </div>

                            <span class="text-slate-700
                                         font-medium">

                                Responsables

                            </span>

                        </div>

                        <strong class="text-xl text-slate-800">
                            {{ $responsablesCount }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection