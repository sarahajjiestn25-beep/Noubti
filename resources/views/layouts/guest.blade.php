<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Noubti</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">

    <div class="w-full max-w-6xl grid md:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- LEFT SIDE -->
        <div class="hidden md:flex flex-col justify-center bg-slate-900 text-white p-14">

            <img src="{{ asset('images/logo.png') }}"
                 class="w-28 mb-8">

            <h1 class="text-4xl font-bold leading-tight mb-6">
                Gestion intelligente des files d’attente
            </h1>

            <p class="text-slate-300 leading-7">
                Digitalisez vos réservations via QR Code, gérez vos services
                et réduisez le temps d’attente de vos clients.
            </p>

        </div>

        <!-- RIGHT SIDE -->
        <div class="p-10 md:p-14 bg-white">

            {{ $slot }}

        </div>

    </div>

</body>
</html>