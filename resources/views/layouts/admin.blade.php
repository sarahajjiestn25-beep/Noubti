<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $title ?? 'Admin Dashboard' }}
    </title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <x-admin />


    {{-- Content --}}
    <main class="flex-1 ml-64">

        <div class="p-8">

            {{ $slot }}

        </div>

    </main>

</div>


</body>
</html>