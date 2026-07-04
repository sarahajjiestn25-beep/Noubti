<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Ticket - Noubti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border-t-8 border-green-500 text-center">
        <h1 class="text-xl font-bold text-gray-800">TICKET DE RÉSERVATION</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $reservation->service->nom_service ?? 'Service' }}</p>
        
        <div class="my-8 bg-green-50 py-6 rounded-xl border border-green-200">
            <span class="text-xs font-bold text-green-700 tracking-widest uppercase">Votre Numéro</span>
            <div class="text-6xl font-black text-green-600 mt-2">#{{ $reservation->numero }}</div>
        </div>

        <div class="space-y-3 text-sm text-gray-700 border-b border-dashed pb-6">
            <div class="flex justify-between">
                <span class="text-gray-400">Client :</span>
                <span class="font-bold">{{ $reservation->nom_client ?? $reservation->user->nom ?? 'Visiteur' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Téléphone :</span>
                <span class="font-bold">{{ $reservation->telephone ?? $reservation->user->telephone ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Statut :</span>
                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 font-bold rounded text-xs">{{ $reservation->statut }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Heure de prise :</span>
                <span class="font-mono">{{ \Carbon\Carbon::parse($reservation->heure_reservation)->format('H:i') }}</span>
            </div>
        </div>

        <div class="mt-6 space-y-1">
            <p class="text-xs text-gray-400">Personnes avant vous : <strong class="text-gray-700 text-sm">{{ $peopleAhead }}</strong></p>
            <p class="text-xs text-gray-400">Temps d'attente estimé : <strong class="text-green-600 text-sm">~{{ $estimatedWaitTime }} min</strong></p>
        </div>

        <div class="mt-8 text-[10px] text-gray-400">
            Veuillez conserver cette page ouverte pour suivre l'avancement en direct.
        </div>
    </div>
</body>
</html>