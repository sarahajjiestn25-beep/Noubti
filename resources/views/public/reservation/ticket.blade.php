<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $reservation->numero }} — Noubti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "SF Pro Display", sans-serif;
            background-color: #F8FAFC;
        }

        .font-mono-num {
            font-family: 'JetBrains Mono', monospace;
            font-feature-settings: "tnum";
        }

        .hero-glow {
            box-shadow: 0 0 50px -10px rgba(37, 99, 235, 0.25);
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .card-interaction {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card-interaction:hover {
            transform: translateY(-2px);
            border-color: rgba(37, 99, 235, 0.3);
            box-shadow: 0 12px 24px -8px rgba(37, 99, 235, 0.08), 0 2px 6px -1px rgba(15, 23, 42, 0.04);
        }
    </style>
</head>
<body class="min-h-full text-slate-900 antialiased select-none flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden">

    <!-- Ambient Radial Gradient Background (No Visible Grid) -->
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[650px] bg-gradient-to-tr from-blue-600/10 via-indigo-500/5 to-transparent rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed top-0 right-1/4 w-[350px] h-[350px] bg-blue-400/10 rounded-full blur-[110px] pointer-events-none"></div>
    <div class="fixed bottom-0 left-1/4 w-[400px] h-[400px] bg-sky-400/10 rounded-full blur-[130px] pointer-events-none"></div>

    <!-- Production-Ready Noubti Ticket Card -->
    <main class="w-full max-w-[580px] bg-white rounded-[24px] border border-slate-200/90 shadow-[0_24px_48px_-12px_rgba(15,23,42,0.07),0_4px_16px_-4px_rgba(37,99,235,0.03)] overflow-hidden relative z-10 my-auto transition-all duration-300">
        
        <!-- Header -->
        <header class="px-6 py-4.5 border-b border-slate-100/90 glass-header flex items-center justify-between gap-4 relative z-20">
            <!-- Noubti Brand & Service -->
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#2563EB] to-[#1D4ED8] p-0.5 shadow-md shadow-blue-500/20 flex items-center justify-center shrink-0 transition-transform duration-200 hover:scale-[1.03]">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Noubti Logo" 
                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=N&background=2563eb&color=ffffff';"
                        class="w-full h-full object-cover rounded-[13px] bg-white"
                    >
                </div>
                <div class="min-w-0">
                    <span class="text-base font-extrabold text-slate-900 tracking-tight block leading-none">Noubti</span>
                    <p class="text-xs font-semibold text-slate-500 truncate mt-1">
                        {{ $service->nom_service ?? $reservation->service->nom_service ?? 'Service Client' }}
                    </p>
                </div>
            </div>

            <!-- Stripe/Linear Inspired Status Badge -->
            <div class="shrink-0">
                @php
                    $statusStr = strtolower((string)($reservation->statut ?? ''));
                    
                    if (in_array($statusStr, ['en cours', 'in_progress', 'calling'])) {
                        $badgeStyle = 'bg-blue-50/90 text-blue-700 border-blue-200/80 shadow-xs';
                        $iconName = 'radio';
                        $dotStyle = 'bg-blue-600';
                    } elseif (in_array($statusStr, ['terminé', 'finished', 'completed'])) {
                        $badgeStyle = 'bg-emerald-50/90 text-emerald-700 border-emerald-200/80 shadow-xs';
                        $iconName = 'check-circle-2';
                        $dotStyle = 'bg-emerald-600';
                    } elseif (in_array($statusStr, ['annulé', 'cancelled'])) {
                        $badgeStyle = 'bg-rose-50/90 text-rose-700 border-rose-200/80 shadow-xs';
                        $iconName = 'x-circle';
                        $dotStyle = 'bg-rose-600';
                    } else {
                        // Default / En attente
                        $badgeStyle = 'bg-amber-50/90 text-amber-700 border-amber-200/80 shadow-xs';
                        $iconName = 'clock';
                        $dotStyle = 'bg-amber-500';
                    }
                @endphp

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-xs font-bold transition-all duration-200 {{ $badgeStyle }}">
                    <i data-lucide="{{ $iconName }}" class="w-3.5 h-3.5"></i>
                    <span>{{ $reservation->statut }}</span>
                </span>
            </div>
        </header>

        <!-- Main Ticket Body -->
        <div class="p-6 space-y-6">
            
            <!-- Hero Section: Premium Gradient Ticket Number -->
            <section class="relative bg-gradient-to-b from-[#2563EB] to-[#1D4ED8] rounded-[20px] py-7 px-6 text-center text-white overflow-hidden hero-glow">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
                
                <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-widest text-blue-100 bg-white/15 backdrop-blur-md border border-white/20 px-3 py-0.5 rounded-full">
                    <i data-lucide="ticket" class="w-3 h-3 text-blue-100"></i>
                    Votre Numéro
                </span>
                
                <div class="font-mono-num text-7xl sm:text-8xl font-black tracking-tight leading-none my-2 drop-shadow-md text-white">
                    #{{ $reservation->numero }}
                </div>
                
                <p class="text-xs font-medium text-blue-100/90 max-w-xs mx-auto">
                    Veuillez patienter jusqu'à l'appel de votre numéro.
                </p>
            </section>

            <!-- Revolut / Apple Wallet Inspired Info Grid -->
            <section class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                
                <!-- Client Card -->
                <div class="card-interaction bg-slate-50/80 border border-slate-200/70 rounded-[16px] p-3 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider">Client</span>
                        <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-900 truncate mt-2">
                        {{ $reservation->nom_client ?? $reservation->user->nom ?? 'Visiteur' }}
                    </span>
                </div>

                <!-- Phone Card -->
                <div class="card-interaction bg-slate-50/80 border border-slate-200/70 rounded-[16px] p-3 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider">Téléphone</span>
                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-900 truncate mt-2">
                        {{ $reservation->telephone ?? $reservation->telephone_client ?? $reservation->user->telephone ?? 'N/A' }}
                    </span>
                </div>

                <!-- Service Card -->
                <div class="card-interaction bg-slate-50/80 border border-slate-200/70 rounded-[16px] p-3 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider">Service</span>
                        <i data-lucide="layers" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-900 truncate mt-2">
                        {{ $service->nom_service ?? $reservation->service->nom_service ?? 'Service' }}
                    </span>
                </div>

                <!-- Created At Card -->
                <div class="card-interaction bg-slate-50/80 border border-slate-200/70 rounded-[16px] p-3 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider">Créé à</span>
                        <i data-lucide="calendar-clock" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <span class="font-mono-num text-xs font-bold text-slate-900 truncate mt-2">
                        {{ \Carbon\Carbon::parse($reservation->heure_reservation)->format('H:i') }}
                    </span>
                </div>

            </section>

            <!-- Primary Waiting Statistics Section -->
            <section class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                
                <!-- Personnes Avant Vous -->
                <div class="card-interaction bg-white border border-slate-200/80 rounded-[18px] p-4.5 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white shrink-0 shadow-sm">
                            <i data-lucide="users" class="w-4.5 h-4.5 text-white"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Personnes avant vous</span>
                            <span class="text-[11px] text-slate-500 font-semibold">Position dans la file</span>
                        </div>
                    </div>
                    <span class="font-mono-num text-3xl font-extrabold text-slate-900">
                        {{ $waitingBefore }}
                    </span>
                </div>

                <!-- Temps Estimé -->
                <div class="card-interaction bg-gradient-to-br from-blue-50/70 to-indigo-50/30 border border-blue-200/70 rounded-[18px] p-4.5 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#2563EB] flex items-center justify-center text-white shrink-0 shadow-md shadow-blue-500/20">
                            <i data-lucide="timer" class="w-4.5 h-4.5 text-white"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-blue-900/70">Temps estimé</span>
                            <span class="text-[11px] text-blue-600/80 font-semibold">Attente approximative</span>
                        </div>
                    </div>
                    <span class="font-mono-num text-3xl font-extrabold text-[#2563EB]">
                        @if ((int) $estimatedTime === 0)
                            0<span class="text-xs font-bold text-blue-600/70 ml-0.5">min</span>
                        @else
                            ~{{ $estimatedTime }}<span class="text-xs font-bold text-blue-600/70 ml-0.5">min</span>
                        @endif
                    </span>
                </div>

            </section>

        </div>

        <!-- Clean Footer -->
        <footer class="px-6 py-3.5 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-1.5 text-xs text-slate-400 font-medium">
            <div class="flex items-center gap-2">
                <span class="font-extrabold text-slate-800">Noubti</span>
                <span class="text-slate-300">•</span>
                <span class="font-mono-num text-slate-500">Réf: #{{ $reservation->id ?? $reservation->numero }}</span>
            </div>
            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                <span>{{ \Carbon\Carbon::parse($reservation->heure_reservation)->format('d/m/Y H:i') }}</span>
                <span class="text-slate-300">•</span>
                <span>&copy; {{ date('Y') }} Noubti Inc.</span>
            </div>
        </footer>

    </main>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>