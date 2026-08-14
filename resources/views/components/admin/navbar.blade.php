<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">


    <h1 class="text-xl font-semibold text-slate-900">

        {{ $title ?? 'Dashboard' }}

    </h1>



    <span class="px-4 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs">

        {{ $appConfig?->nom_app ?? 'Noubti' }} QueueFlow

    </span>


</header>