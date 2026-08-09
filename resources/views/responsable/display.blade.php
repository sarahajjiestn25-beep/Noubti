@extends('layouts.app')

@section('title', $service->nom_service ?? 'Queue Display')

@section('content')
<style>
    @keyframes ticketHeroCall {
        0% {
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.15);
            border-color: rgba(30, 41, 59, 0.9);
            transform: scale(1);
        }
        35% {
            box-shadow: 0 0 85px rgba(59, 130, 246, 0.6), inset 0 0 35px rgba(59, 130, 246, 0.25);
            border-color: rgba(59, 130, 246, 0.85);
            transform: scale(1.03);
        }
        100% {
            box-shadow: 0 0 60px rgba(0, 0, 0, 0.85);
            border-color: rgba(30, 41, 59, 0.9);
            transform: scale(1);
        }
    }

    @keyframes fadeUpNumber {
        0% {
            opacity: 0;
            transform: translateY(16px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeUpClient {
        0% {
            opacity: 0;
            transform: translateY(12px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes calmBreathing {
        0%, 100% {
            transform: scale(1);
            opacity: 0.85;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        }
        50% {
            transform: scale(1.05);
            opacity: 1;
            box-shadow: 0 0 35px rgba(59, 130, 246, 0.4);
        }
    }

    .animate-hero-call {
        animation: ticketHeroCall 3.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-fade-up-number {
        animation: fadeUpNumber 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-fade-up-client {
        animation: fadeUpClient 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
        opacity: 0;
    }

    .animate-calm-breath {
        animation: calmBreathing 4s ease-in-out infinite;
    }
</style>

<div class="relative min-h-screen flex flex-col justify-between bg-slate-950 text-slate-100 antialiased overflow-hidden select-none p-6 md:p-8 lg:p-10">
    
    <!-- Ambient Futuristic Glow & Tech Grid Background Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-950/90 via-slate-950 to-slate-950 pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#3b82f6_1.5px,transparent_1.5px)] [background-size:36px_36px] opacity-10 pointer-events-none"></div>
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-cyan-500/15 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Top Navigation Header -->
    <header class="relative z-10 flex items-center justify-between px-6 py-3.5 lg:px-8 lg:py-4 rounded-3xl bg-slate-900/50 border border-slate-800/90 backdrop-blur-3xl shadow-2xl">
        <div class="flex items-center gap-3.5 lg:gap-4">
            <div class="w-[56px] h-[56px] rounded-full bg-white p-1 flex items-center justify-center border-2 border-slate-100/90 shadow-[0_0_20px_rgba(59,130,246,0.4)] flex-shrink-0 transition-transform duration-300 hover:scale-105">
                <img 
                    src="{{ !empty($service->logo) ? asset($service->logo) : asset('images/logo.png') }}" 
                    alt="Logo" 
                    onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                    class="w-full h-full object-cover rounded-full"
                >
            </div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white drop-shadow-md leading-none">
                    {{ $service->nom_service }}
                </h1>
                @if(!empty($service->description))
                    <p class="text-xs lg:text-sm font-semibold text-slate-400/90 mt-1 tracking-wide leading-none">
                        {{ $service->description }}
                    </p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-6 lg:gap-8">
            <div class="hidden sm:flex items-center gap-3 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 backdrop-blur-2xl shadow-[0_0_20px_rgba(34,197,94,0.15)]">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-xs font-extrabold tracking-widest uppercase text-emerald-400">LIVE</span>
            </div>

            <div class="text-right">
                <div id="digital-clock" class="text-3xl lg:text-5xl font-black tracking-wider text-white font-mono drop-shadow-[0_0_15px_rgba(255,255,255,0.25)]">
                    00:00:00
                </div>
                <div id="current-date" class="text-xs font-bold tracking-widest uppercase text-blue-400 mt-0.5">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>
        </div>
    </header>

    <!-- Display Main Content (TV & Public Display Optimized Grid Layout) -->
    <main class="relative z-10 my-auto py-6 lg:py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- Primary Focus: Current Ticket Hero Card -->
        <section class="lg:col-span-7 flex flex-col justify-center">
            <div id="hero-card" class="relative group rounded-3xl bg-slate-900/60 border border-slate-800/90 backdrop-blur-3xl p-8 lg:p-12 shadow-[0_0_70px_rgba(0,0,0,0.9)] overflow-hidden transition-all duration-700 flex flex-col justify-between min-h-[520px]">
                
                <!-- Radiant Blue Center Glow -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[520px] h-[520px] bg-blue-600/25 rounded-full blur-[140px] pointer-events-none"></div>

                <!-- Status Badge Header -->
                <div class="flex items-center justify-between z-10">
                    <span class="text-xs lg:text-sm font-extrabold tracking-widest uppercase text-blue-400 px-5 py-2.5 rounded-full bg-blue-500/10 border border-blue-500/30 flex items-center gap-2.5 backdrop-blur-md shadow-inner">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Ticket En Cours
                    </span>
                    <div class="flex items-center gap-2.5 text-xs lg:text-sm font-bold uppercase tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-5 py-2 rounded-full shadow-[0_0_20px_rgba(34,197,94,0.15)]">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Appelé
                    </div>
                </div>

                <!-- Hero Ticket Display Container (Centered Vertically) -->
                <div class="text-center py-2 z-10 flex flex-col items-center justify-center my-auto">
                    <div id="current-ticket-container" class="w-full flex items-center justify-center">
                        @if(!empty($currentTicket?->numero))
                            <div id="current-ticket-number" class="animate-fade-up-number text-[160px] sm:text-[210px] lg:text-[240px] font-black leading-none tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-blue-200 drop-shadow-[0_0_75px_rgba(59,130,246,0.7)] font-mono transition-all duration-500 transform hover:scale-105">
                                {{ $currentTicket->numero }}
                            </div>
                        @else
                            <div id="current-ticket-number" class="animate-fade-up-number flex flex-col items-center justify-center py-1 my-auto">
                                <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-3xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center mb-3.5 transition-all animate-calm-breath">
                                    <svg class="w-10 h-10 lg:w-12 lg:h-12 text-blue-400 stroke-current" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl lg:text-3xl font-black text-white tracking-widest uppercase drop-shadow-md">AUCUN TICKET</span>
                                <span class="text-sm lg:text-base font-medium text-slate-400 mt-1">Aucun client n'est actuellement appelé.</span>
                                <span class="text-xs lg:text-sm font-semibold text-blue-400 mt-1">Veuillez patienter jusqu'au prochain appel.</span>
                            </div>
                        @endif
                    </div>

                    <!-- Client Name Banner -->
                    <div id="current-ticket-client" class="animate-fade-up-client mt-2 text-3xl sm:text-4xl lg:text-5xl font-black text-slate-100 truncate max-w-2xl mx-auto tracking-wide drop-shadow-md">
                        {{ $currentTicket?->nom_client ?? '' }}
                    </div>
                </div>

                <!-- Subtitle Guidance Banner -->
                <div class="text-center z-10 border-t border-slate-800/80 pt-5">
                    <p class="text-sm lg:text-base font-semibold text-blue-300/90 tracking-wide flex items-center justify-center gap-2.5">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Veuillez vous présenter au guichet dès que votre numéro est appelé.
                    </p>
                </div>

            </div>
        </section>

        <!-- Secondary Focus: Next Tickets Queue Sidebar -->
        <section class="lg:col-span-5 flex flex-col justify-between">
            <div class="rounded-3xl bg-slate-900/50 border border-slate-800/90 backdrop-blur-3xl p-6 lg:p-8 flex flex-col h-full shadow-[0_0_60px_rgba(0,0,0,0.8)] justify-between min-h-[520px]">
                
                <!-- Queue Section Header -->
                <div class="flex items-center justify-between pb-5 border-b border-slate-800/90">
                    <h2 class="text-xl font-black tracking-widest uppercase text-slate-200 flex items-center gap-3">
                        <span class="h-3.5 w-3.5 rounded-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.9)]"></span>
                        Tickets Suivants
                    </h2>
                    <span class="text-xs font-extrabold text-slate-500 uppercase tracking-widest">En Attente</span>
                </div>

                <!-- Next Tickets Container -->
                <div id="next-tickets-container" class="flex-1 flex flex-col gap-5 py-5 overflow-y-auto">
                    @forelse($nextTickets as $ticket)
                        <div class="flex items-center justify-between p-6 lg:p-7 rounded-3xl transition-all duration-300 backdrop-blur-md group shadow-2xl {{ $loop->first ? 'bg-slate-800/80 border-2 border-blue-500/60 shadow-[0_0_30px_rgba(59,130,246,0.25)] hover:border-blue-400' : 'bg-slate-800/40 border border-slate-700/50 hover:bg-slate-800/70 hover:border-slate-600' }} hover:scale-[1.015]">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl border flex items-center justify-center font-black text-2xl transition-all duration-300 {{ $loop->first ? 'bg-blue-600 border-blue-400 text-white shadow-[0_0_20px_rgba(59,130,246,0.5)]' : 'bg-blue-500/10 border-blue-500/30 text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.15)] group-hover:bg-blue-600 group-hover:text-white' }}">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <div class="text-4xl lg:text-5xl font-black text-white font-mono tracking-wider drop-shadow-sm">
                                        {{ $ticket->numero }}
                                    </div>
                                    @if(!empty($ticket->nom_client))
                                        <div class="text-base font-bold text-slate-300 mt-1">
                                            {{ $ticket->nom_client }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs lg:text-sm font-extrabold text-slate-300 bg-slate-900/90 px-4 py-2.5 rounded-2xl border border-slate-700/80 tracking-wide shadow-md">
                                En attente
                            </span>
                        </div>
                    @empty
                        <div class="flex-1 flex flex-col items-center justify-center py-12 text-slate-500">
                            <div class="p-5 rounded-3xl bg-slate-800/30 border border-slate-800 mb-3">
                                <svg class="w-16 h-16 opacity-30 text-blue-400 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-slate-400 tracking-wide">Aucun ticket en attente</span>
                            <span class="text-xs text-slate-600 mt-1">Les prochains numéros s'afficheront automatiquement ici</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- Elevated Footer Banner -->
    <footer class="relative z-10 pt-5 border-t border-slate-800/90 flex flex-col sm:flex-row items-center justify-between text-xs lg:text-sm text-slate-400 gap-4">
        <div class="flex items-center gap-3">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500 shadow-[0_0_12px_rgba(59,130,246,1)]"></span>
            <span class="font-black text-slate-100 tracking-wider uppercase">NOUBTI</span>
            <span class="text-slate-600">&bull;</span>
            <span class="font-medium text-slate-400/80 tracking-wide">Smart Queue Management Platform</span>
        </div>
        <div class="font-black text-slate-400/80 tracking-widest uppercase text-xs lg:text-sm">
            Powered by <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-cyan-400 font-black opacity-100">NOUBTI</span>
        </div>
    </footer>

</div>

<script>
    let lastTicketNumero = "{{ $currentTicket?->numero ?? '' }}";

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockElement = document.getElementById('digital-clock');
        if (clockElement) {
            clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }
    setInterval(updateClock, 1000);
    updateClock();

    function triggerHeroHighlight() {
        const heroCard = document.getElementById('hero-card');
        if (heroCard) {
            heroCard.classList.remove('animate-hero-call');
            void heroCard.offsetWidth; // Trigger reflow to restart animation
            heroCard.classList.add('animate-hero-call');
        }
    }

    function refreshDisplay() {
        fetch("{{ route('responsable.realtime') }}")
            .then(response => response.json())
            .then(data => {
                const currentTicketContainer = document.getElementById('current-ticket-container');
                const currentClientEl = document.getElementById('current-ticket-client');

                const newTicketNumero = (data && data.currentTicket && data.currentTicket.numero) ? data.currentTicket.numero : '';
                const isNewCall = newTicketNumero && newTicketNumero !== lastTicketNumero;

                if (currentTicketContainer) {
                    if (data && data.currentTicket && data.currentTicket.numero) {
                        currentTicketContainer.innerHTML = `
                            <div id="current-ticket-number" class="animate-fade-up-number text-[160px] sm:text-[210px] lg:text-[240px] font-black leading-none tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-blue-200 drop-shadow-[0_0_75px_rgba(59,130,246,0.7)] font-mono transition-all duration-500 transform hover:scale-105">
                                ${data.currentTicket.numero}
                            </div>
                        `;
                    } else {
                        currentTicketContainer.innerHTML = `
                            <div id="current-ticket-number" class="animate-fade-up-number flex flex-col items-center justify-center py-1 my-auto">
                                <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-3xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center mb-3.5 transition-all animate-calm-breath">
                                    <svg class="w-10 h-10 lg:w-12 lg:h-12 text-blue-400 stroke-current" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl lg:text-3xl font-black text-white tracking-widest uppercase drop-shadow-md">AUCUN TICKET</span>
                                <span class="text-sm lg:text-base font-medium text-slate-400 mt-1">Aucun client n'est actuellement appelé.</span>
                                <span class="text-xs lg:text-sm font-semibold text-blue-400 mt-1">Veuillez patienter jusqu'au prochain appel.</span>
                            </div>
                        `;
                    }
                }

                if (currentClientEl) {
                    currentClientEl.textContent = (data && data.currentTicket && data.currentTicket.nom_client) ? data.currentTicket.nom_client : '';
                    currentClientEl.classList.remove('animate-fade-up-client');
                    void currentClientEl.offsetWidth;
                    currentClientEl.classList.add('animate-fade-up-client');
                }

                if (isNewCall) {
                    triggerHeroHighlight();
                }

                lastTicketNumero = newTicketNumero;

                const nextContainer = document.getElementById('next-tickets-container');
                if (nextContainer && data && Array.isArray(data.queue)) {
                    const waitingTickets = data.queue
                        .filter(ticket => ticket.statut === "En attente")
                        .slice(0, 5);

                    if (waitingTickets.length === 0) {
                        nextContainer.innerHTML = `
                            <div class="flex-1 flex flex-col items-center justify-center py-12 text-slate-500">
                                <div class="p-5 rounded-3xl bg-slate-800/30 border border-slate-800 mb-3">
                                    <svg class="w-16 h-16 opacity-30 text-blue-400 stroke-current" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-slate-400 tracking-wide">Aucun ticket en attente</span>
                                <span class="text-xs text-slate-600 mt-1">Les prochains numéros s'afficheront automatiquement ici</span>
                            </div>
                        `;
                    } else {
                        let html = '';
                        waitingTickets.forEach((ticket, index) => {
                            const isFirst = index === 0;
                            const clientName = ticket.nom_client ? `<div class="text-base font-bold text-slate-300 mt-1">${ticket.nom_client}</div>` : '';
                            
                            const cardStyle = isFirst 
                                ? 'bg-slate-800/80 border-2 border-blue-500/60 shadow-[0_0_30px_rgba(59,130,246,0.25)] hover:border-blue-400' 
                                : 'bg-slate-800/40 border border-slate-700/50 hover:bg-slate-800/70 hover:border-slate-600';
                            
                            const badgeStyle = isFirst 
                                ? 'bg-blue-600 border-blue-400 text-white shadow-[0_0_20px_rgba(59,130,246,0.5)]' 
                                : 'bg-blue-500/10 border-blue-500/30 text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.15)] group-hover:bg-blue-600 group-hover:text-white';

                            html += `
                                <div class="flex items-center justify-between p-6 lg:p-7 rounded-3xl transition-all duration-300 backdrop-blur-md group shadow-2xl ${cardStyle} hover:scale-[1.015]">
                                    <div class="flex items-center gap-6">
                                        <div class="w-16 h-16 rounded-2xl border flex items-center justify-center font-black text-2xl transition-all duration-300 ${badgeStyle}">
                                            ${index + 1}
                                        </div>
                                        <div>
                                            <div class="text-4xl lg:text-5xl font-black text-white font-mono tracking-wider drop-shadow-sm">
                                                ${ticket.numero}
                                            </div>
                                            ${clientName}
                                        </div>
                                    </div>
                                    <span class="text-xs lg:text-sm font-extrabold text-slate-300 bg-slate-900/90 px-4 py-2.5 rounded-2xl border border-slate-700/80 tracking-wide shadow-md">
                                        En attente
                                    </span>
                                </div>
                            `;
                        });
                        nextContainer.innerHTML = html;
                    }
                }
            })
            .catch(error => console.error("Error refreshing display:", error));
    }

    setInterval(refreshDisplay, 3000);
</script>
@endsection