
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    {{ $title ?? 'Tableau de bord' }} - Noubti
</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


@php

$user = auth()->user();

$role = $user?->role?->nom_role ?? 'admin';

if ($role === 'superadmin') {

    $roleLabel = 'Super Administrateur';
    $initial = 'S';

} elseif ($role === 'admin') {

    $roleLabel = 'Administrateur';
    $initial = 'A';

} elseif ($role === 'responsable') {

    $roleLabel = 'Responsable';
    $initial = 'R';

} else {

    $roleLabel = 'Client';
    $initial = 'C';

}

@endphp


{{-- =========================================================
     PAGE WRAPPER
========================================================== --}}

<div class="min-h-screen bg-gray-50 flex">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen flex flex-col">


        {{-- =================================================
             LOGO
        ================================================== --}}

        <div class="px-6 py-5 border-b border-gray-200">

            <div class="flex items-center gap-3">

                @if(file_exists(public_path('images/logo.png')))

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Noubti"
                        class="w-12 h-12 object-contain"
                    >

                @else

                    <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center shadow-sm">

                        <span class="text-white font-bold text-xl">
                            N
                        </span>

                    </div>

                @endif


                <div>

                    <h1 class="font-bold text-xl leading-tight">
                        Noubti
                    </h1>

                    <p class="text-xs text-indigo-600 font-medium tracking-wide">
                        QUEUEFLOW
                    </p>

                </div>

            </div>

        </div>



        {{-- =================================================
             MENU
        ================================================== --}}

        <nav class="flex-1 px-3 py-5 space-y-2">


            {{-- =================================================
                 TABLEAU DE BORD
            ================================================== --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-indigo-50 text-indigo-600 font-semibold'
                    : 'text-gray-600 hover:bg-gray-50 transition' }}"
            >

                <span class="text-lg">
                    📊
                </span>

                <span>
                    Tableau de bord
                </span>

            </a>



            {{-- =================================================
                 SERVICES
            ================================================== --}}

                
         
                         <a
   href="{{ auth()->user()->role->nom_role === 'superadmin'
    ? route('superadmin.services.index')
    : route('admin.services.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl
    {{ request()->routeIs('admin.services.*') || request()->routeIs('superadmin.services.*')
        ? 'bg-indigo-50 text-indigo-600 font-semibold'
        : 'text-gray-600 hover:bg-gray-50 transition' }}"
>
    <span class="text-lg">⚙️</span>
    <span>Services</span>
</a>


            {{-- =================================================
                 RESERVATIONS
            ================================================== --}}

            <a
                href="{{ route('admin.reservations.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl
                {{ request()->routeIs('admin.reservations.*')
                    ? 'bg-indigo-50 text-indigo-600 font-semibold'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition' }}"
            >

                <span class="text-lg">
                    📅
                </span>

                <span>
                    Réservations
                </span>

            </a>



            {{-- =================================================
                 SUPERADMIN ONLY
            ================================================== --}}

            @if($role === 'superadmin')


                {{-- =================================================
                     UTILISATEURS
                ================================================== --}}

                <a
                    href="{{ route('superadmin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.users.*')
                        ? 'bg-indigo-50 text-indigo-600 font-semibold'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition' }}"
                >

                    <span class="text-lg">
                        👥
                    </span>

                    <span>
                        Utilisateurs
                    </span>

                </a>



                {{-- =================================================
                     STATISTIQUES
                ================================================== --}}

                <a
                    href="{{ route('superadmin.statistics') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.statistics')
                        ? 'bg-indigo-50 text-indigo-600 font-semibold'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition' }}"
                >

                    <span class="text-lg">
                        📈
                    </span>

                    <span>
                        Statistiques
                    </span>

                </a>



                {{-- =================================================
                     CONFIGURATION
                ================================================== --}}

                {{-- 
                    Pour le moment aucune route configuration
                    n'existe dans routes/web.php.
                    Donc on ne met pas de route() ici pour éviter
                    une erreur Laravel.
                --}}

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    text-gray-400 cursor-not-allowed"
                >

                    <span class="text-lg">
                        ⚙️
                    </span>

                    <span>
                        Configuration
                    </span>

                </a>


            @endif


        </nav>



        {{-- =====================================================
             USER / LOGOUT
        ====================================================== --}}

        <div class="p-4 border-t border-gray-200 bg-white">


            <div class="flex items-center gap-3">


                {{-- Avatar --}}

                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">

                    <span class="text-indigo-600 font-bold">
                        {{ $initial }}
                    </span>

                </div>



                {{-- User information --}}

                <div class="flex-1 min-w-0">

                    <p class="font-semibold text-sm truncate">
                        {{ $roleLabel }}
                    </p>

                    <p class="text-xs text-gray-500 truncate">
                        {{ $user?->email ?? '' }}
                    </p>

                </div>


            </div>



            {{-- =================================================
                 LOGOUT
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-3"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg
                           text-sm text-red-600
                           hover:bg-red-50 transition"
                >

                    Déconnexion

                </button>

            </form>


        </div>


    </aside>



    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="flex-1 min-w-0">


        {{-- =====================================================
             TOPBAR
        ====================================================== --}}

        <header
            class="h-20 bg-white border-b border-gray-200
                   flex items-center justify-between px-8"
        >


            {{-- Page title --}}

            <div>

                <p class="text-sm text-gray-500">
                    Administration
                </p>

                <h2 class="text-lg font-bold text-gray-900">
                    {{ $title ?? 'Tableau de bord' }}
                </h2>

            </div>



            {{-- Current user --}}

            <div class="flex items-center gap-3">


                <div class="text-right">

                    <p class="text-sm font-semibold text-gray-900">
                        {{ $roleLabel }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $user?->email ?? '' }}
                    </p>

                </div>



                {{-- Avatar --}}

                <div
                    class="w-10 h-10 rounded-full bg-indigo-600
                           flex items-center justify-center"
                >

                    <span class="text-white font-bold">
                        {{ $initial }}
                    </span>

                </div>


            </div>


        </header>



        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}

        <section class="p-8">

            {{ $slot }}

        </section>


    </main>


</div>

