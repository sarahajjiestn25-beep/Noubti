@extends('layouts.app')

@section('title','Gestion des services')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

    <div class="max-w-7xl mx-auto">

        @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 rounded-2xl px-6 py-4 shadow">

            {{ session('success') }}

        </div>

        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">

            <div>

                <h1 class="text-4xl font-black text-slate-800">

                    Gestion des services

                </h1>

                <p class="text-slate-500 mt-2">

                    Gérez les services disponibles dans votre établissement.

                </p>

            </div>

            <a href="{{ route('admin.services.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-bold shadow-lg transition">

                + Nouveau service

            </a>

        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

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

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="text-left px-6 py-4 font-bold">
                                Service
                            </th>

                            <th class="text-left px-6 py-4 font-bold">
                                Description
                            </th>

                            <th class="text-center px-6 py-4 font-bold">
                                QR Code
                            </th>

                            <th class="text-center px-6 py-4 font-bold">
                                Statut
                            </th>

                            <th class="text-center px-6 py-4 font-bold">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody id="servicesTable">

                        @forelse($services as $service)

                        <tr class="border-t hover:bg-slate-50 transition service-row">

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">

                                        @if($service->logo)

                                            <img src="{{ asset('storage/'.$service->logo) }}"
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

                            <td class="px-6 py-5">

                                {{ $service->description ?: '-' }}

                            </td>

                            <td class="px-6 py-5 text-center">

                                @if($service->qr_code)

                                    <img
                                        src="{{ asset('storage/'.$service->qr_code) }}"
                                        class="w-20 h-20 mx-auto border rounded-lg bg-white p-1">

                                @else

                                    <span class="text-slate-400">

                                        Aucun

                                    </span>

                                @endif

                            </td>
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

                            <td class="px-6 py-5">

                                <div class="flex justify-center gap-3">

                                    <a href="{{ route('admin.services.edit',$service) }}"
                                       class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                                        Modifier

                                    </a>

                                    <form action="{{ route('admin.services.destroy',$service) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer ce service ?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition">

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="py-16 text-center">

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

            @if($services instanceof \Illuminate\Contracts\Pagination\Paginator ||
                $services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

            <div class="p-6 border-t bg-slate-50">

                {{ $services->links() }}

            </div>

            @endif

        </div>

    </div>

</div>

<script>

const search=document.getElementById("search");

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

document.querySelectorAll(".service-row").forEach(row=>{

let name=row.querySelector(".service-name").innerText.toLowerCase();

row.style.display=name.includes(value) ? "" : "none";

});

});

</script>

@endsection