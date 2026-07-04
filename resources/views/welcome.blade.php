<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noubti — Connexion Guichet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-center">
                <div class="inline-flex items-center justify-center rounded-full bg-white/20 w-14 h-14 mb-4 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.93 0 1.83-.11 2.71-.32a6 6 0 01-3.71-5.68V5a6 6 0 1112 0v.01M3 20h18a2 2 0 002-2V9a2 2 0 00-2-2H3a2 2 0 00-2 2v9a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight">Noubti</h1>
                <p class="mt-2 text-indigo-100 text-sm">Système de gestion des files d'attente</p>
            </div>

            <div class="p-8">
                <h2 class="text-2xl font-semibold text-slate-900 mb-6">Connexion au Guichet</h2>

                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

              <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Adresse email</label>
                        <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="vous@entreprise.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Mot de passe</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full px-4 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">
                        Se connecter
                    </button>
                </form>
            </div>

            <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 text-center">
                <p class="text-xs text-slate-500">© {{ date('Y') }} Noubti. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html>
