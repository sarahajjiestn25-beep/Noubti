@extends('layouts.app')

@section('title','Nouveau Service')

@section('content')

<div class="min-h-screen bg-slate-100 py-10">

<div class="max-w-3xl mx-auto">

<div class="bg-white rounded-3xl shadow-xl overflow-hidden">

<div class="bg-gradient-to-r from-blue-700 to-blue-500 px-8 py-8 text-white">

<h1 class="text-4xl font-black">

Créer un nouveau service

</h1>

<p class="mt-2 text-blue-100">

Ajoutez un nouveau service disponible pour les réservations.

</p>

</div>

<div class="p-8">

@if($errors->any())

<div class="mb-8 rounded-2xl bg-red-50 border border-red-200 p-5">

<ul class="list-disc pl-6 text-red-600">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="{{ route('admin.services.store') }}" method="POST">

@csrf

<div class="space-y-7">

<div>

<label class="block font-semibold text-slate-700 mb-2">

Nom du service

</label>

<input
type="text"
name="nom_service"
value="{{ old('nom_service') }}"
required
class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">

</div>

<div>

<label class="block font-semibold text-slate-700 mb-2">

Description

</label>

<textarea
name="description"
rows="4"
class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>

</div>

<div>

<label class="block font-semibold text-slate-700 mb-2">

Adresse

</label>

<input
type="text"
name="adresse"
value="{{ old('adresse') }}"
class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">

</div>

<div class="flex items-center gap-3">

<input
type="checkbox"
name="actif"
value="1"
checked
class="rounded border-slate-300 text-blue-600">

<label class="font-semibold">

Service actif

</label>

</div>

<div class="flex justify-between pt-6">

<a
href="{{ route('admin.services.index') }}"
class="px-6 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold transition">

Retour

</a>

<button
class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold transition">

Créer le service

</button>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

@endsection