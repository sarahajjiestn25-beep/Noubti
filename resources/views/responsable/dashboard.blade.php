@extends('layouts.app')

@section('title', 'Tableau de bord Responsable - ' . ($service->nom_service ?? 'Gestion de File'))

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #F6F8FC;
        color: #111827;
    }

    .font-mono-num {
        font-family: 'JetBrains Mono', monospace;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }

    @keyframes dashboardFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-dashboard {
        animation: dashboardFadeIn 0.4s ease-out forwards;
    }

    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.15); }
    }
    .animate-live-dot {
        animation: livePulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<div class="min-h-screen bg-[#F6F8FC] text-slate-900 p-4 sm:p-6 lg:p-8 animate-dashboard">
    <div class="max-w-[1600px] mx-auto space-y-6">

        <!-- ========================================================= -->
        <!-- HEADER / HERO CARD                                        -->
        <!-- ========================================================= -->
        <header class="relative overflow-hidden rounded-3xl bg-white border border-slate-200/80 p-6 sm:p-8 shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="absolute -right-10 -top-10 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-40 -bottom-20 w-80 h-80 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Left Side: Brand & Service Info -->
                <div class="flex items-center gap-5">
                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 p-1 shadow-md shadow-blue-500/20 flex items-center justify-center">
                            <img 
                                src="{{ !empty($service->logo) ? asset($service->logo) : asset('images/logo.png') }}" 
                                alt="NOUBTI" 
                                onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                                class="w-full h-full object-cover rounded-xl bg-white"
                            >
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                                {{ $service->nom_service ?? 'Service' }}
                            </h1>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                Dashboard Responsable
                            </span>
                        </div>
                        <p class="text-sm font-medium text-slate-500">
                            {{ $service->description ?? 'Système intelligent de gestion des files d\'attente' }}
                        </p>
                    </div>
                </div>

                <!-- Right Side: Time & Status Badge -->
                <div class="flex flex-wrap items-center gap-4 lg:gap-6 border-t lg:border-t-0 border-slate-100 pt-4 lg:pt-0">
                    <div class="flex items-center gap-3 px-4 py-2 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 relative">
                            <span class="absolute inset-0 rounded-full bg-emerald-400 animate-live-dot"></span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Service Actif</span>
                    </div>

                    <div class="text-left lg:text-right">
                        <div id="dash-clock" class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono-num tracking-tight">
                            00:00:00
                        </div>
                        <div id="dash-date" class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-0.5">
                            {{ now()->format('l, F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========================================================= -->
        <!-- STATISTICS OVERVIEW (4 Equal Premium Cards)                -->
        <!-- ========================================================= -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- Card 1: Waiting -->
            <div class="group relative rounded-3xl bg-white border border-slate-200/80 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">En Attente</p>
                        <h3 id="stat-attente" class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 font-mono-num">
                            {{ $waitingCount ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-amber-700 bg-amber-50/80 px-2.5 py-1 rounded-lg w-fit">
                    <span>Tickets dans la file</span>
                </div>
            </div>

            <!-- Card 2: Processing -->
            <div class="group relative rounded-3xl bg-white border border-slate-200/80 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border-l-4 border-l-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">En Cours</p>
                        <h3 id="stat-encours" class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 font-mono-num">
                            {{ $processingCount ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-blue-700 bg-blue-50/80 px-2.5 py-1 rounded-lg w-fit">
                    <span>Actuellement au guichet</span>
                </div>
            </div>

            <!-- Card 3: Finished -->
            <div class="group relative rounded-3xl bg-white border border-slate-200/80 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border-l-4 border-l-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Terminés</p>
                        <h3 id="stat-termines" class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 font-mono-num">
                            {{ $finishedCount ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50/80 px-2.5 py-1 rounded-lg w-fit">
                    <span>Aujourd'hui</span>
                </div>
            </div>

            <!-- Card 4: Cancelled -->
            <div class="group relative rounded-3xl bg-white border border-slate-200/80 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border-l-4 border-l-rose-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Annulés</p>
                        <h3 id="stat-annules" class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 font-mono-num">
                            {{ $cancelledCount ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-rose-700 bg-rose-50/80 px-2.5 py-1 rounded-lg w-fit">
                    <span>Non présent(s)</span>
                </div>
            </div>

        </section>

        <!-- ========================================================= -->
        <!-- MAIN WORKSPACE: CURRENT TICKET + ACTION PANEL             -->
        <!-- ========================================================= -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <!-- LEFT: Current Ticket Card (Col 8) -->
            <div class="lg:col-span-8 flex flex-col">
                <div class="relative flex-1 rounded-3xl bg-white border border-slate-200/80 p-6 sm:p-8 shadow-sm flex flex-col justify-between overflow-hidden">
                    
                    <!-- Top Info Strip -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-600 animate-pulse"></span>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Ticket Actuel</span>
                        </div>
                        <span id="current-badge-status" class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm {{ !empty($currentTicket) ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-500' }}">
                            {{ !empty($currentTicket) ? 'En traitement' : 'En attente d\'appel' }}
                        </span>
                    </div>

                    <!-- Center Area: Big Ticket Number OR Empty State -->
                    <div id="current-ticket-card-content" class="my-auto py-8 text-center flex flex-col items-center justify-center">
                        @if(!empty($currentTicket?->numero))
                            <div class="space-y-3">
                                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">
                                    Numéro Appelé
                                </span>
                                <h2 class="text-6xl sm:text-8xl lg:text-9xl font-black text-slate-900 tracking-tight font-mono-num drop-shadow-sm">
                                    {{ $currentTicket->numero }}
                                </h2>
                                @if(!empty($currentTicket->nom_client))
                                    <p class="text-xl sm:text-2xl font-bold text-slate-700 mt-2">
                                        {{ $currentTicket->nom_client }}
                                    </p>
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center space-y-4 max-w-sm mx-auto">
                                <div class="w-20 h-20 rounded-3xl bg-slate-50 border border-slate-200/80 flex items-center justify-center text-slate-400 shadow-inner">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800">Aucun Ticket en Cours</h3>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Cliquez sur <strong class="text-slate-700">"Appeler Suivant"</strong> pour faire passer le prochain client.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Info Footer -->
                    <div class="border-t border-slate-100 pt-4 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                        <span>Service: <strong class="text-slate-700">{{ $service->nom_service ?? 'Standard' }}</strong></span>
                        <span>Dernière mise à jour en temps réel</span>
                    </div>

                </div>
            </div>

            <!-- RIGHT: Action Panel (Col 4) -->
            <div class="lg:col-span-4 flex flex-col">
                <div class="rounded-3xl bg-white border border-slate-200/80 p-6 sm:p-8 shadow-sm flex flex-col justify-between h-full space-y-6">
                    <div>
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-500 border-b border-slate-100 pb-4">
                            Panneau de Contrôle
                        </h3>
                        <p class="text-xs text-slate-400 mt-2">
                            Gérez l'avancement de la file d'attente en un clic.
                        </p>
                    </div>

                    <div class="space-y-3.5 my-auto">
                        <!-- Appeler Suivant -->
                        <form action="{{ route('responsable.ticket.suivant') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full h-14 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base flex items-center justify-center gap-3 shadow-lg shadow-blue-600/25 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span>Appeler Suivant</span>
                            </button>
                        </form>

                        <!-- Terminer -->
                        <form action="{{ route('responsable.ticket.terminer') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full h-14 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base flex items-center justify-center gap-3 shadow-lg shadow-emerald-600/20 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none" {{ empty($currentTicket) ? 'disabled' : '' }}>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Terminer Ticket</span>
                            </button>
                        </form>

                        <!-- Annuler -->
                        <form action="{{ route('responsable.ticket.annuler') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full h-14 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-base flex items-center justify-center gap-3 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none" {{ empty($currentTicket) ? 'disabled' : '' }}>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Annuler Ticket</span>
                            </button>
                        </form>
                    </div>

                    <!-- External Screen Button -->
                    <div class="border-t border-slate-100 pt-4">
                        <a href="{{ route('responsable.display') }}" target="_blank" class="w-full h-12 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm flex items-center justify-center gap-2.5 shadow-md transition-all duration-200 hover:scale-[1.01]">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Ouvrir Écran Public</span>
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

        </section>

        <!-- ========================================================= -->
        <!-- QUEUE TABLE SECTION                                       -->
        <!-- ========================================================= -->
        <section class="rounded-3xl bg-white border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">File d'Attente Complète</h2>
                    <p class="text-xs text-slate-500">Liste en temps réel des tickets enregistrés aujourd'hui</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500">Total:</span>
                    <span id="queue-total-count" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-extrabold font-mono-num">
                        {{ isset($queue) ? count($queue) : 0 }}
                    </span>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto custom-scrollbar max-h-[480px]">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-slate-50/95 backdrop-blur-md z-10">
                        <tr class="border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-4 rounded-l-xl">N° Ticket</th>
                            <th class="py-3.5 px-4">Nom du Client</th>
                            <th class="py-3.5 px-4">Statut</th>
                            <th class="py-3.5 px-4 text-right rounded-r-xl">Heure</th>
                        </tr>
                    </thead>
                    <tbody id="queue-table-body" class="divide-y divide-slate-100 text-sm">
                        @forelse($queue ?? [] as $ticket)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                <td class="py-4 px-4 font-black font-mono-num text-slate-900 text-base">
                                    {{ $ticket->numero }}
                                </td>
                                <td class="py-4 px-4 font-semibold text-slate-700">
                                    {{ $ticket->nom_client ?? '—' }}
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $statusStr = strtolower($ticket->statut ?? '');
                                    @endphp
                                    @if(str_contains($statusStr, 'attente'))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            En attente
                                        </span>
                                    @elseif(str_contains($statusStr, 'cours') || str_contains($statusStr, 'appel'))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                            En cours
                                        </span>
                                    @elseif(str_contains($statusStr, 'termin'))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Terminé
                                        </span>
                                    @elseif(str_contains($statusStr, 'annul'))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Annulé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            {{ $ticket->statut }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right text-xs font-medium text-slate-400 font-mono-num">
                                    {{ isset($ticket->created_at) ? \Carbon\Carbon::parse($ticket->created_at)->format('H:i') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-table-row">
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <p class="text-base font-semibold text-slate-600">Aucun ticket dans la file</p>
                                        <p class="text-xs text-slate-400">Les nouveaux tickets générés apparaîtront automatiquement ici.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</div>

<!-- REAL-TIME CLOCK & FETCH SCRIPT -->
<script>
    function updateDashboardClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockEl = document.getElementById('dash-clock');
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }
    setInterval(updateDashboardClock, 1000);
    updateDashboardClock();

    function refreshResponsableData() {
        fetch("{{ route('responsable.realtime') }}")
            .then(res => res.json())
            .then(data => {
                if (!data) return;

                // 1. Update Stats Cards
                if (data.waitingCount !== undefined) {
                    const statAttente = document.getElementById('stat-attente');
                    if (statAttente) statAttente.textContent = data.waitingCount;
                } else if (data.queue && Array.isArray(data.queue)) {
                    const waiting = data.queue.filter(t => (t.statut || '').toLowerCase().includes('attente')).length;
                    const statAttente = document.getElementById('stat-attente');
                    if (statAttente) statAttente.textContent = waiting;
                }

                if (data.queue && Array.isArray(data.queue)) {
                    const totalEl = document.getElementById('queue-total-count');
                    if (totalEl) totalEl.textContent = data.queue.length;
                }

                if (data.processingCount !== undefined) {
                    const statEncours = document.getElementById('stat-encours');
                    if (statEncours) statEncours.textContent = data.processingCount;
                } else if (data.currentTicket !== undefined) {
                    const statEncours = document.getElementById('stat-encours');
                    if (statEncours) statEncours.textContent = data.currentTicket ? '1' : '0';
                }

                if (data.currentTicket !== undefined) {
                    const currentBadge = document.getElementById('current-badge-status');
                    if (currentBadge) {
                        currentBadge.textContent = data.currentTicket ? 'En traitement' : 'En attente d\'appel';
                        currentBadge.className = data.currentTicket 
                            ? 'px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm bg-blue-50 text-blue-700 border border-blue-200' 
                            : 'px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm bg-slate-100 text-slate-500';
                    }

                    const cardContent = document.getElementById('current-ticket-card-content');
                    if (cardContent) {
                        if (data.currentTicket && data.currentTicket.numero) {
                            const clientName = data.currentTicket.nom_client 
                                ? `<p class="text-xl sm:text-2xl font-bold text-slate-700 mt-2">${data.currentTicket.nom_client}</p>` 
                                : '';

                            cardContent.innerHTML = `
                                <div class="space-y-3">
                                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">
                                        Numéro Appelé
                                    </span>
                                    <h2 class="text-6xl sm:text-8xl lg:text-9xl font-black text-slate-900 tracking-tight font-mono-num drop-shadow-sm">
                                        ${data.currentTicket.numero}
                                    </h2>
                                    ${clientName}
                                </div>
                            `;
                        } else {
                            cardContent.innerHTML = `
                                <div class="flex flex-col items-center justify-center text-center space-y-4 max-w-sm mx-auto">
                                    <div class="w-20 h-20 rounded-3xl bg-slate-50 border border-slate-200/80 flex items-center justify-center text-slate-400 shadow-inner">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-800">Aucun Ticket en Cours</h3>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Cliquez sur <strong class="text-slate-700">"Appeler Suivant"</strong> pour faire passer le prochain client.
                                        </p>
                                    </div>
                                </div>
                            `;
                        }
                    }
                }

                if (data.finishedCount !== undefined || data.ticketsTerminesCount !== undefined) {
                    const el = document.getElementById('stat-termines');
                    if (el) el.textContent = data.finishedCount ?? data.ticketsTerminesCount;
                }

                if (data.cancelledCount !== undefined || data.ticketsAnnulesCount !== undefined) {
                    const el = document.getElementById('stat-annules');
                    if (el) el.textContent = data.cancelledCount ?? data.ticketsAnnulesCount;
                }

                // 2. Update Table
                const tbody = document.getElementById('queue-table-body');
                if (tbody && data.queue && Array.isArray(data.queue)) {
                    if (data.queue.length === 0) {
                        tbody.innerHTML = `
                            <tr id="empty-table-row">
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <p class="text-base font-semibold text-slate-600">Aucun ticket dans la file</p>
                                        <p class="text-xs text-slate-400">Les nouveaux tickets générés apparaîtront automatiquement ici.</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                    } else {
                        let html = '';
                        data.queue.forEach(ticket => {
                            const st = (ticket.statut || '').toLowerCase();
                            let badge = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">${ticket.statut}</span>`;

                            if (st.includes('attente')) {
                                badge = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>En attente</span>`;
                            } else if (st.includes('cours') || st.includes('appel')) {
                                badge = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60"><span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>En cours</span>`;
                            } else if (st.includes('termin')) {
                                badge = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Terminé</span>`;
                            } else if (st.includes('annul')) {
                                badge = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Annulé</span>`;
                            }

                            const timeStr = ticket.created_at ? ticket.created_at.substring(11, 16) : '—';
                            const clientName = ticket.nom_client ? ticket.nom_client : '—';

                            html += `
                                <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                    <td class="py-4 px-4 font-black font-mono-num text-slate-900 text-base">
                                        ${ticket.numero}
                                    </td>
                                    <td class="py-4 px-4 font-semibold text-slate-700">
                                        ${clientName}
                                    </td>
                                    <td class="py-4 px-4">
                                        ${badge}
                                    </td>
                                    <td class="py-4 px-4 text-right text-xs font-medium text-slate-400 font-mono-num">
                                        ${timeStr}
                                    </td>
                                </tr>
                            `;
                        });
                        tbody.innerHTML = html;
                    }
                }
            })
            .catch(err => console.error("Error updating dashboard:", err));
    }

    setInterval(refreshResponsableData, 3000);
</script>
@endsection