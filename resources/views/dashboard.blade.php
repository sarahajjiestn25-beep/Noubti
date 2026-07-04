<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noubti - Tableau de bord Responsable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur-md shadow-sm">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="rounded-3xl bg-slate-900 px-4 py-2 text-base font-bold text-white shadow-sm">Noubti</div>
                        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm font-semibold text-slate-700">Service : {{ $service->nom_service ?? 'Aucun' }}</span>
                    </div>
                    <p class="mt-3 max-w-2xl text-sm text-slate-500">Tableau de bord guichet professionnel pour gérer les tickets et fluidifier l'attente.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="rounded-3xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm">Connecté comme {{ Auth::user()->nom }}</div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm text-emerald-800 shadow-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-sm text-red-800 shadow-sm">{{ session('error') }}</div>
            @endif

            <section class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
                <div class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">En attente</p>
                                    <p class="mt-4 text-4xl font-extrabold text-amber-600">{{ $waitingCount }}</p>
                                </div>
                                <div class="rounded-3xl bg-amber-100 p-3 text-amber-700 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0v4m0-4h4m-4 0H8" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">En cours</p>
                                    <p class="mt-4 text-4xl font-extrabold text-violet-600">{{ $processingCount }}</p>
                                </div>
                                <div class="rounded-3xl bg-violet-100 p-3 text-violet-700 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.656 0-3 1.344-3 3s1.344 3 3 3 3-1.344 3-3-1.344-3-3-3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m8-10h2M2 12H4m14.121 5.121l1.414 1.414M4.464 4.464l1.414 1.414m0 12.728l-1.414 1.414M19.657 4.343l-1.414 1.414" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Terminés</p>
                                    <p class="mt-4 text-4xl font-extrabold text-emerald-600">{{ $finishedCount }}</p>
                                </div>
                                <div class="rounded-3xl bg-emerald-100 p-3 text-emerald-700 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Contrôle du guichet</h2>
                                <p class="mt-1 text-sm text-slate-500">Actions rapides pour passer au ticket suivant, terminer ou annuler.</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-4 sm:grid-cols-3">
                            <form action="{{ route('responsable.ticket.suivant') }}" method="POST" class="rounded-3xl border border-indigo-200 bg-indigo-50 p-4 shadow-sm transition hover:shadow-md">
                                @csrf
                                <button type="submit" class="flex h-full w-full flex-col items-start justify-between rounded-3xl bg-indigo-600 px-5 py-6 text-left text-white transition hover:bg-indigo-700">
                                    <span class="text-sm font-semibold uppercase tracking-[0.24em]">Appeler le client suivant</span>
                                    <span class="mt-4 text-3xl font-extrabold">Suivant</span>
                                </button>
                            </form>

                            <form action="{{ route('responsable.ticket.terminer') }}" method="POST" class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm transition hover:shadow-md">
                                @csrf
                                <button type="submit" class="flex h-full w-full flex-col items-start justify-between rounded-3xl bg-emerald-600 px-5 py-6 text-left text-white transition hover:bg-emerald-700">
                                    <span class="text-sm font-semibold uppercase tracking-[0.24em]">Terminer le ticket actuel</span>
                                    <span class="mt-4 text-3xl font-extrabold">Terminer</span>
                                </button>
                            </form>

                            <form action="{{ route('responsable.ticket.annuler') }}" method="POST" class="rounded-3xl border border-red-200 bg-red-50 p-4 shadow-sm transition hover:shadow-md">
                                @csrf
                                <button type="submit" class="flex h-full w-full flex-col items-start justify-between rounded-3xl bg-red-600 px-5 py-6 text-left text-white transition hover:bg-red-700">
                                    <span class="text-sm font-semibold uppercase tracking-[0.24em]">Annuler / Absent</span>
                                    <span class="mt-4 text-3xl font-extrabold">Annuler</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">File d'attente active</h2>
                            <p class="mt-1 text-sm text-slate-500">Voir les tickets en attente et ceux en cours.</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ $queue->count() }} actifs</span>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">Ticket</th>
                                    <th class="px-4 py-3">Client</th>
                                    <th class="px-4 py-3">Téléphone</th>
                                    <th class="px-4 py-3">Pris à</th>
                                    <th class="px-4 py-3">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($queue as $item)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-4 font-semibold text-slate-900">#{{ $item->numero_ticket }}</td>
                                        <td class="px-4 py-4">{{ $item->nom_client ?? $item->user->nom ?? 'Visiteur' }}</td>
                                        <td class="px-4 py-4">{{ $item->telephone ?? $item->user->telephone ?? 'N/A' }}</td>
                                        <td class="px-4 py-4">{{ \Illuminate\Support\Carbon::parse($item->heure_reservation)->format('H:i') }}</td>
                                        <td class="px-4 py-4">
                                            @if($item->statut === 'en cours')
                                                <span class="inline-flex rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">En cours</span>
                                            @elseif($item->statut === 'en attente')
                                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">En attente</span>
                                            @elseif($item->statut === 'termine')
                                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Terminé</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $item->statut }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">Aucun ticket actif pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </aside>
            </section>
        </main>
    </div>
</body>
</html>
