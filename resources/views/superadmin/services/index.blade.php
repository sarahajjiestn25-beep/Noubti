@extends('layouts.app')

@section('title','Gestion des services')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

    <div class="max-w-7xl mx-auto">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 rounded-2xl px-6 py-4 shadow">
                {{ session('success') }}
            </div>
        @endif
{{-- HEADER --}}

<div class="bg-white rounded-3xl shadow-xl px-8 py-7 mb-8">
    
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

    {{-- LEFT : ICON + TITLE --}}
    <div class="flex items-center gap-5">

        {{-- SERVICE ICON --}}
        <div class="w-20 h-20 rounded-2xl bg-blue-50 flex items-center justify-center shrink-0 shadow-sm">
            <span class="text-4xl">🏢</span>
        </div>

        <div>
            <h1 class="text-4xl font-black text-slate-800">
                Gestion des services
            </h1>

            <p class="text-slate-500 mt-2 text-lg">
                Gérez les services disponibles dans votre établissement.
            </p>
        </div>

    </div>

    {{-- RIGHT : ACTIONS --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

        {{-- DASHBOARD --}}
        <a
            href="{{ route('superadmin.dashboard') }}"
            class="inline-flex items-center justify-center gap-2
                   bg-slate-800 hover:bg-slate-900
                   text-white px-6 py-3.5
                   rounded-xl font-bold
                   shadow-md hover:shadow-lg
                   transition duration-200">

            <span class="text-lg">←</span>
            Dashboard
        </a>

        {{-- NEW SERVICE --}}
        <a
            href="{{ route('superadmin.services.create') }}"
            class="inline-flex items-center justify-center gap-2
                   bg-blue-600 hover:bg-blue-700
                   text-white px-6 py-3.5
                   rounded-xl font-bold
                   shadow-md hover:shadow-lg
                   transition duration-200">

            <span class="text-lg">+</span>
            Nouveau service
        </a>

    </div>

</div>


</div>

 

        {{-- SERVICES TABLE --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            {{-- TABLE HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b">

                <h2 class="text-2xl font-bold text-slate-800">
                    Liste des services
                </h2>

                <input
                    id="search"
                    type="text"
                    placeholder="Rechercher un service..."
                    class="border border-slate-300 rounded-xl px-5 py-3 w-full md:w-80 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[1100px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="text-left px-6 py-4 font-bold text-slate-700">
                                Service
                            </th>

                            <th class="text-left px-6 py-4 font-bold text-slate-700">
                                Description
                            </th>

                            <th class="text-left px-6 py-4 font-bold text-slate-700">
                                Adresse
                            </th>

                            <th class="text-center px-6 py-4 font-bold text-slate-700">
                                QR Code
                            </th>

                            <th class="text-center px-6 py-4 font-bold text-slate-700">
                                Statut
                            </th>

                            <th class="text-center px-6 py-4 font-bold text-slate-700">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody id="servicesTable">

                        @forelse($services as $service)

                            <tr class="border-t hover:bg-slate-50 transition service-row">

                                {{-- SERVICE --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden shrink-0">

                                            @if($service->logo)

                                                <img
                                                    src="{{ asset('storage/'.$service->logo) }}"
                                                    class="w-full h-full object-cover">

                                            @else

                                                <span class="text-blue-700 text-xl">
                                                    🏢
                                                </span>

                                            @endif

                                        </div>

                                        <div>

                                            <div class="font-bold text-slate-800 text-lg service-name">
                                                {{ $service->nom_service }}
                                            </div>

                                            <div class="text-slate-400 text-sm">
                                                #{{ $service->id_service }}
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- DESCRIPTION --}}
                                <td class="px-6 py-5 text-slate-600">

                                    <div class="max-w-xs">
                                        {{ $service->description ?: '-' }}
                                    </div>

                                </td>

                                {{-- ADRESSE --}}
                                <td class="px-6 py-5 text-slate-600">

                                    @if($service->adresse)

                                        <div class="flex items-start gap-2 max-w-xs">

                                            <span class="text-blue-600 mt-0.5">
                                                📍
                                            </span>

                                            <span>
                                                {{ $service->adresse }}
                                            </span>

                                        </div>

                                    @else

                                        <span class="text-slate-400">
                                            -
                                        </span>

                                    @endif

                                </td>

                              {{-- QR CODE --}}
<td class="px-6 py-5 text-center">

    @if($service->qr_code)

        <div class="flex flex-col items-center gap-2">

            <img
                src="{{ asset('storage/'.$service->qr_code) }}"
                alt="QR Code {{ $service->nom_service }}"
                class="w-20 h-20 border border-slate-200 rounded-lg bg-white p-1">

            <a
                href="{{ route('superadmin.services.downloadQr', $service) }}"
                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg
                       text-slate-500 hover:text-blue-600 hover:bg-blue-50
                       text-xs font-medium transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-3.5 h-3.5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"/>

                </svg>

                Télécharger

            </a>

        </div>

    @else

        <span class="inline-flex px-3 py-2 rounded-lg bg-slate-100 text-slate-400 text-sm">
            Aucun
        </span>

    @endif

</td>

                                 

                                {{-- STATUS --}}
                                <td class="px-6 py-5 text-center">

                                    @if($service->actif)

                                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                            ● Actif
                                        </span>

                                    @else

                                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold text-sm">
                                            ● Inactif
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td class="px-6 py-5">

                                    <div class="flex justify-center gap-3">

                                        <a
                                            href="{{ route('superadmin.services.edit',$service) }}"
                                            class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                                            Modifier

                                        </a>

                                        <form
                                            action="{{ route('superadmin.services.destroy',$service) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer ce service ?')">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition">

                                                Supprimer

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="py-16 text-center">

                                    <div class="text-6xl mb-4">
                                        📂
                                    </div>

                                    <h3 class="text-xl font-bold text-slate-700">
                                        Aucun service
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Commencez par créer votre premier service.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if(
                $services instanceof \Illuminate\Contracts\Pagination\Paginator ||
                $services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
            )

                <div class="p-6 border-t bg-slate-50">
                    {{ $services->links() }}
                </div>

            @endif

        </div>

    </div>

</div>

{{-- SEARCH --}}
<script>

const search = document.getElementById("search");

if (search) {

    search.addEventListener("keyup", function () {

        let value = this.value.toLowerCase();

        document.querySelectorAll(".service-row").forEach(row => {

            let name = row.querySelector(".service-name").innerText.toLowerCase();

            row.style.display = name.includes(value) ? "" : "none";

        });

    });

}

</script>

@endsection 