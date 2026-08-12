@extends('layouts.app')

@section('title','Modifier le service')

@section('content')

<div class="min-h-screen bg-slate-100">

<div class="max-w-4xl mx-auto p-8">

<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 p-8 shadow-xl mb-10">

<div class="absolute -right-12 -top-12 w-56 h-56 rounded-full bg-white/10"></div>
<div class="absolute right-20 bottom-0 w-32 h-32 rounded-full bg-white/5"></div>

<div class="relative flex justify-between items-center flex-wrap gap-6">

<div class="flex items-center gap-5">

<div class="bg-white rounded-3xl shadow-lg p-4">

<img
src="{{ asset('images/logo.png') }}"
class="w-16 h-16 object-contain">

</div>

<div class="text-white">

<h1 class="text-4xl font-black">

Modifier le Service

</h1>

<p class="text-blue-100 mt-2">

Mettre à jour les informations du service.

</p>

</div>

</div>

<a
href="{{ route('superadmin.services.index') }}"
class="bg-white text-blue-700 font-bold px-7 py-3 rounded-2xl shadow hover:scale-105 transition">

← Retour

</a>

</div>

</div>

@if($errors->any())

<div class="mb-8 rounded-2xl border border-red-200 bg-red-50 p-6">

<h3 class="font-bold text-red-700 mb-3">

Veuillez corriger les erreurs :

</h3>

<ul class="list-disc pl-5 text-red-600">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<div class="bg-white rounded-3xl shadow-xl p-10">

<form
method="POST"
action="{{ route('superadmin.services.update',$service) }}">

@csrf
@method('PUT')

<div class="grid md:grid-cols-2 gap-8">

<div>

<label class="block mb-2 font-semibold text-slate-700">

Nom du service

</label>

<input
type="text"
name="nom_service"
value="{{ old('nom_service',$service->nom_service) }}"
class="w-full rounded-2xl border-slate-300 px-5 py-3 focus:ring-2 focus:ring-blue-500">

</div>

<div>

<label class="block mb-2 font-semibold text-slate-700">

Adresse

</label>

<input
type="text"
name="adresse"
value="{{ old('adresse',$service->adresse) }}"
class="w-full rounded-2xl border-slate-300 px-5 py-3 focus:ring-2 focus:ring-blue-500">

</div>

</div>

<div class="mt-8">

<label class="block mb-2 font-semibold text-slate-700">

Description

</label>

<textarea
name="description"
rows="5"
class="w-full rounded-2xl border-slate-300 px-5 py-3 focus:ring-2 focus:ring-blue-500">{{ old('description',$service->description) }}</textarea>

</div>

<div class="mt-8">

<label class="inline-flex items-center gap-3">

<input
type="checkbox"
name="actif"
value="1"
{{ old('actif',$service->actif) ? 'checked' : '' }}
class="w-5 h-5 rounded text-blue-600">

<span class="font-semibold text-slate-700">

Service actif

</span>

</label>

</div>

<div class="border-t mt-10 pt-8 flex justify-end gap-4">

<a
href="{{ route('superadmin.services.index') }}"
class="px-7 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 font-semibold transition">

Annuler

</a>

<button
type="submit"
class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg transition">

Enregistrer

</button>

</div>

</form>

</div>

</div>

</div>

@endsection