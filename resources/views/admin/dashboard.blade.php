<x-layouts.admin title="Tableau de bord">

```
{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Aperçu Général
        </h1>

        <p class="text-gray-500 mt-1">
            Statistiques et état des services en temps réel.
        </p>
    </div>

    <a
        href="{{ route('admin.services.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition"
    >
        + Nouveau Service
    </a>

</div>


{{-- STATISTIQUES --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- TOTAL SERVICES --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Total Services
                </p>

                <h2 class="text-4xl font-bold text-gray-900 mt-2">
                    {{ $totalServices }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                <span class="text-xl">📋</span>
            </div>

        </div>

    </div>


    {{-- SERVICES ACTIFS --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Services Actifs
                </p>

                <h2 class="text-4xl font-bold text-green-600 mt-2">
                    {{ $activeServices }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <span class="text-xl text-green-600">✓</span>
            </div>

        </div>

    </div>


    {{-- SERVICES INACTIFS --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Services Inactifs
                </p>

                <h2 class="text-4xl font-bold text-red-500 mt-2">
                    {{ $inactiveServices }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                <span class="text-xl text-red-500">!</span>
            </div>

        </div>

    </div>

</div>


{{-- SERVICES RÉCENTS --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

    <div class="p-6 border-b border-gray-200">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Services récents
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Les derniers services ajoutés au système.
                </p>
            </div>

            <a
                href="{{ route('admin.services.index') }}"
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-700"
            >
                Voir tous
            </a>

        </div>

    </div>


    <div class="divide-y divide-gray-100">

        @forelse($recentServices as $service)

            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">

                <div class="flex items-center gap-4">

                    {{-- LOGO --}}
                    @if($service->logo)

                        <img
                            src="{{ asset('storage/' . $service->logo) }}"
                            alt="{{ $service->nom_service }}"
                            class="w-11 h-11 rounded-xl object-cover"
                        >

                    @else

                        <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-600 font-bold">
                                {{ strtoupper(substr($service->nom_service ?? 'S', 0, 1)) }}
                            </span>
                        </div>

                    @endif


                    {{-- SERVICE INFO --}}
                    <div>

                        <h3 class="font-semibold text-gray-900">
                            {{ $service->nom_service }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            Service #{{ $service->id_service }}
                        </p>

                    </div>

                </div>


                {{-- STATUS --}}
                @if($service->actif)

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                        Actif
                    </span>

                @else

                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                        Inactif
                    </span>

                @endif

            </div>

        @empty

            <div class="p-8 text-center text-gray-500">
                Aucun service récent.
            </div>

        @endforelse

    </div>

</div>
```

</x-layouts.admin>
