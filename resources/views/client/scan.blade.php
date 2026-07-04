<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noubti - Ticket de File</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-6 text-center">
        <div class="flex flex-col items-center space-y-2">
            <span class="text-2xl font-bold tracking-tight text-indigo-600">Noubti</span>
            <p class="text-sm text-slate-500">Service: <span class="font-semibold text-slate-800">{{ $service->nom_service }}</span></p>
        </div>

        @if(!isset($ticket))
            <div class="space-y-4 text-left">
                <h2 class="text-xl font-bold text-slate-800 text-center">Rejoindre la file d'attente</h2>
                <p class="text-xs text-slate-400 text-center pb-2">Entrez vos informations pour obtenir votre numéro d'ordre.</p>
                @if ($errors->any())
    <div style="color:red; margin-bottom:20px;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
                
                <form action="{{ route('client.ticket.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_service" value="{{ $service->id_service }}">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nom / Prénom</label>
                        <input type="text" name="nom_client" required placeholder="Ex: Ahmed Alami" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Numéro de téléphone</label>
                        <input type="tel" name="telephone" required placeholder="Ex: 0612345678" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 text-sm">
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition duration-200 shadow-sm shadow-indigo-100 text-sm mt-2">
                        Prendre ma place dans la file
                    </button>
                </form>
            </div>
        @else
            <div class="space-y-6 py-4">
                <div class="inline-flex items-center justify-center bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                    ✓ Votre ticket est actif
                </div>
                
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Votre Numéro</p>
                    <h1 class="text-6xl font-extrabold tracking-tight text-slate-900">N°-{{ sprintf('%02d', $ticket->numero) }}</h1>
                    <p class="text-sm font-medium text-slate-500 pt-1">{{ $nom_client ?? 'Client Anonyme' }}</p>
                </div>

                <hr class="border-slate-100 my-4">

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Position actuelle</p>
                        <p class="text-lg font-bold text-slate-800 mt-1">
                            @if($waitingBefore == 0)
                                C'est votre tour !
                            @else
                                {{ $waitingBefore }} pers. avant
                            @endif
                        </p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Attente estimée</p>
                        <p class="text-lg font-bold text-indigo-600 mt-1">~{{ $estimatedTime }} min</p>
                    </div>
                </div>

                <p class="text-xs text-slate-400 pt-2">Vous pouvez rafraîchir cette page pour suivre l'avancement en temps réel.</p>
            </div>
        @endif

        <div class="text-[10px] text-slate-400">
            &copy; 2026 Noubti. Tous droits réservés.
        </div>
    </div>

</body>
</html>