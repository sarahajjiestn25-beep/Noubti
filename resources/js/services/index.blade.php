@extends('layouts.app')

@section('title','Gestion des services')

@section('content')

<div class="min-h-screen bg-slate-100">

<div class="max-w-7xl mx-auto p-8">

@if(session('success'))

<div class="mb-8 rounded-2xl bg-green-50 border border-green-200 text-green-700 px-6 py-4 shadow-sm">

{{ session('success') }}

</div>

@endif

<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 p-8 shadow-xl mb-10">

<div class="absolute -right-12 -top-12 w-56 h-56 rounded-full bg-white/10"></div>

<div class="absolute right-20 bottom-0 w-32 h-32 rounded-full bg-white/5"></div>

<div class="relative flex flex-col lg:flex-row justify-between items-center gap-8">

<div class="flex items-center gap-6">

<div class="bg-white rounded-3xl shadow-lg p-4">

<img
src="{{ asset('images/logo.png') }}"
class="w-20 h-20 object-contain">

</div>

<div class="text-white">

<h1 class="text-5xl font-black">

Gestion des Services

</h1>

<p class="text-blue-100 mt-2 text-lg">

Créer, modifier et organiser les services disponibles.

</p>

</div>

</div>

<a
href="{{ route('superadmin.services.create')}}"
class="bg-white text-blue-700 font-bold px-8 py-4 rounded-2xl shadow-lg hover:scale-105 transition">

+ Nouveau Service

</a>

</div>

</div>

<div class="bg-white rounded-3xl shadow-xl overflow-hidden">

<div class="flex flex-col lg:flex-row justify-between items-center gap-5 p-8 border-b bg-slate-50">

<div>

<h2 class="text-2xl font-bold text-slate-800">

Liste des Services

</h2>

<p class="text-slate-500 mt-1">

{{ $services->count() }} service(s) disponible(s)

</p>

</div>

<input

id="search"

type="text"

placeholder="Rechercher un service..."

class="w-full lg:w-96 rounded-2xl border border-slate-300 px-5 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

</div>

<div class="overflow-x-auto">

<table class="w-full">

<thead class="bg-slate-100">

<tr>

<th class="px-6 py-5 text-left font-bold text-slate-700">

Service

</th>

<th class="px-6 py-5 text-left font-bold text-slate-700">

Description

</th>

<th class="px-6 py-5 text-center font-bold text-slate-700">

QR Code

</th>

<th class="px-6 py-5 text-center font-bold text-slate-700">

Statut

</th>

<th class="px-6 py-5 text-center font-bold text-slate-700">

Actions

</th>

</tr>

</thead>

<tbody id="servicesTable">

@forelse($services as $service)

<tr class="border-t hover:bg-blue-50 transition duration-300 service-row">

<td class="px-6 py-5">

<div class="flex items-center gap-4">

<div class="w-16 h-16 rounded-2xl overflow-hidden bg-blue-100 flex items-center justify-center shadow">

@if($service->logo)

<img
src="{{ asset('storage/'.$service->logo) }}"
class="w-full h-full object-cover">

@else

<span class="text-2xl">

🏥

</span>

@endif

</div>

<div>

<div class="font-bold text-slate-800 text-lg service-name">

{{ $service->nom_service }}

</div>

<div class="text-slate-400">

#{{ $service->id_service }}

</div>

</div>

</div>

</td>

<td class="px-6 py-5 text-slate-600">

{{ $service->description ?: '-' }}

</td>

<td class="text-center px-6 py-5">

@if($service->qr_code)

<img
src="{{ asset('storage/'.$service->qr_code) }}"
class="w-20 h-20 rounded-xl border bg-white mx-auto p-1 shadow">

@else

<span class="text-slate-400">

—

</span>

@endif

</td>

<td class="text-center px-6 py-5">
    @if($service->actif)

<span class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold text-sm">

● Actif

</span>

@else

<span class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold text-sm">

● Inactif

</span>

@endif

</td>

<td class="px-6 py-5">

<div class="flex justify-center gap-3">

<a
href="{{ route('superadmin.services.edit',$service) }}"
class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow">

Modifier

</a>

<form
action="{{ route('superadmin.services.destroy',$service)}}"
method="POST"
onsubmit="return confirm('Supprimer ce service ?')">

@csrf
@method('DELETE')

<button
class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition shadow">

Supprimer

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="py-20 text-center">

<div class="text-7xl mb-5">

📂

</div>

<h2 class="text-2xl font-bold text-slate-700">

Aucun service disponible

</h2>

<p class="text-slate-500 mt-2">

Commencez par créer votre premier service.

</p>

<a
href="{{ route('superadmin.services.create') }}"
class="inline-flex mt-8 bg-blue-600 hover:bg-blue-700 text-white px-7 py-3 rounded-2xl font-bold transition">

Créer un service

</a>

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@if($services instanceof \Illuminate\Contracts\Pagination\Paginator ||
$services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

<div class="bg-slate-50 border-t p-6">

{{ $services->links() }}

</div>

@endif

</div>

</div>

</div>

<script>

const search=document.getElementById("search");

search.addEventListener("keyup",function(){

const value=this.value.toLowerCase();

document.querySelectorAll(".service-row").forEach(row=>{

const name=row.querySelector(".service-name").innerText.toLowerCase();

row.style.display=name.includes(value) ? "" : "none";

});

});

</script>

@endsection