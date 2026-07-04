@extends('layouts.public')

@section('title','Nouvelle réservation')

@section('content')

<div class="hero pb-40">

    <div class="max-w-6xl mx-auto text-center pt-16">

        <img
            src="{{ asset('images/logo.png') }}"
            class="w-24 h-24 mx-auto rounded-full bg-white p-3 shadow-xl"
            alt="logo">

        <h1 class="text-6xl font-bold text-white mt-5">
            Noubti
        </h1>

        <p class="text-blue-100 text-xl mt-3">
            Système intelligent de gestion des files d'attente
        </p>

    </div>

</div>

<div class="max-w-6xl mx-auto px-5 -mt-24">

<div class="glass p-10">

<h2 class="text-4xl font-bold text-slate-800 text-center">

Nouvelle réservation

</h2>

<p class="text-center text-slate-500 mt-3 mb-10">

Remplissez vos informations pour obtenir votre ticket numérique.

</p>

@if($errors->any())

<div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-8">

<ul class="list-disc pl-6 text-red-600">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<div class="grid md:grid-cols-3 gap-6 mb-10">

<div class="card p-6 text-center">

<div class="feature-icon bg-blue-600 text-white mx-auto mb-4">

📱

</div>

<h3 class="font-bold text-lg">

QR Code

</h3>

<p class="text-slate-500 text-sm mt-2">

Scannez le QR Code pour accéder directement à la réservation.

</p>

</div>

<div class="card p-6 text-center">

<div class="feature-icon bg-green-500 text-white mx-auto mb-4">

🎟️

</div>

<h3 class="font-bold text-lg">

Ticket instantané

</h3>

<p class="text-slate-500 text-sm mt-2">

Votre numéro est généré automatiquement.

</p>

</div>

<div class="card p-6 text-center">

<div class="feature-icon bg-orange-500 text-white mx-auto mb-4">

⏱️

</div>

<h3 class="font-bold text-lg">

Temps réel

</h3>

<p class="text-slate-500 text-sm mt-2">

Suivez votre position dans la file d'attente.

</p>

</div>

</div>

<form action="{{ route('public.reservation.store') }}" method="POST">

@csrf

<div class="grid md:grid-cols-2 gap-6">

<div>

<label class="font-semibold text-slate-700">

Nom complet

</label>

<input
type="text"
name="nom_client"
value="{{ old('nom_client') }}"
required
placeholder="Ex : Sara Hajji"
class="input mt-2">

</div>

<div>

<label class="font-semibold text-slate-700">

Téléphone

</label>

<input
type="text"
name="telephone_client"
value="{{ old('telephone_client') }}"
required
placeholder="06XXXXXXXX"
class="input mt-2">

</div>

</div>

<div class="mt-7">

<label class="font-semibold text-slate-700">

Choisir un service

</label>

<select
name="id_service"
required
class="input mt-2">

<option value="">

-- Sélectionnez un service --

</option>

@foreach($services as $service)

<option
value="{{ $service->id_service }}"
{{ old('id_service')==$service->id_service ? 'selected' : '' }}>

{{ $service->nom_service }}

</option>

@endforeach

</select>

</div>

<div class="mt-10">

<button
type="submit"
class="btn-primary text-lg">

🎟️ Obtenir mon ticket

</button>

</div>

</form>

</div>

<div class="text-center text-slate-500 mt-10 mb-10">

© {{ date('Y') }} Noubti — Tous droits réservés.

</div>

</div>

@endsection