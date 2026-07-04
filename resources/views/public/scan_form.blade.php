<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Noubti - Réservation</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-5">

<div class="w-full max-w-6xl grid md:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

    <!-- LEFT -->
    <div class="hidden md:flex flex-col justify-center bg-blue-700 text-white p-14">

        <img src="{{ asset('logo.png') }}"
             class="w-28 mb-8 object-contain">

        <h1 class="text-4xl font-bold leading-tight mb-6">
            Prenez votre ticket facilement
        </h1>

        <p class="text-blue-100 leading-8">
            Scannez, réservez et évitez les longues files d’attente.
            Une expérience plus rapide et plus intelligente.
        </p>

    </div>

    <!-- RIGHT -->
    <div class="p-10 md:p-14">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-slate-800">
                Réservation
            </h2>

            <p class="text-slate-500 mt-2">
                Service sélectionné
            </p>

        </div>

        <!-- SERVICE CARD -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-7">

            <h3 class="font-semibold text-blue-800 text-lg">
                {{ $service->nom_service }}
            </h3>

            <p class="text-slate-600 mt-2">
                Prenez votre ticket pour ce service.
            </p>

        </div>

        <!-- FORM -->
        <form method="POST"
              action="{{ route('public.service.store', $service->id_service) }}">

            @csrf

            <div class="mb-6">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Numéro de téléphone
                </label>

                <input
                    type="text"
                    name="telephone"
                    required
                    placeholder="06XXXXXXXX"
                    class="w-full border border-slate-300 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                @error('telephone')
                    <p class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <button
                type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-xl font-semibold transition">

                Obtenir mon ticket

            </button>

        </form>

        <div class="text-center mt-8 text-slate-400 text-sm">
            Noubti © 2026
        </div>

    </div>

</div>

</body>
</html>