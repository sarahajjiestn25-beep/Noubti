<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noubti - Rejoindre la file</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border-t-4 border-indigo-600 p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600">
                Noubti
            </h1>

            <p class="text-gray-500 mt-2">
                Bienvenue au service
            </p>

            <div class="mt-3 inline-block bg-indigo-50 text-indigo-700 px-4 py-2 rounded-full font-semibold text-sm">
                {{ $service->nom_service }}
            </div>
        </div>

        <!-- Affichage erreurs Laravel -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('public.service.store', $service->id_service) }}" method="POST" class="space-y-5">

            @csrf

            <!-- Nom (juste visuel, non envoyé DB si tu veux) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Votre Nom Complet
                </label>

                <input
                    type="text"
                    name="nom_client"
                    placeholder="Ex : Sara Hajji"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                >
            </div>

            <!-- Telephone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Numéro de Téléphone
                </label>

                <input
                    type="text"
                    name="telephone"
                    required
                    placeholder="Ex : 0612345678"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                >
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition"
            >
                Prendre un Ticket
            </button>

        </form>

    </div>

</body>
</html>