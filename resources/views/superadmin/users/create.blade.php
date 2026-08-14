@extends('layouts.app')

@section('title','Ajouter un utilisateur')

@section('content')

<div class="min-h-screen bg-slate-100">

<div class="max-w-5xl mx-auto p-8">

{{-- HEADER --}}

<div class="relative overflow-hidden rounded-[30px] bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 shadow-xl mb-8">

<div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-white/10"></div>

<div class="absolute right-24 bottom-0 w-28 h-28 rounded-full bg-white/5"></div>

<div class="relative flex justify-between items-center p-10">

<div class="flex items-center gap-5">

<div class="w-20 h-20 rounded-3xl bg-white flex items-center justify-center shadow">

<img
src="{{ $appConfig?->logo ? asset('storage/' . $appConfig->logo) : asset('images/logo.png') }}"
class="w-14">

</div>

<div class="text-white">

<h1 class="text-4xl font-black">

Nouvel utilisateur

</h1>

<p class="mt-2 text-blue-100">

Créer un nouveau compte pour la plateforme {{ $appConfig?->nom_app ?? 'Noubti' }}

</p>

</div>

</div>

<a
href="{{ route('superadmin.users.index') }}"
class="bg-white/20 backdrop-blur px-6 py-3 rounded-xl text-white hover:bg-white/30 transition">

← Retour

</a>

</div>

</div>

{{-- FORM --}}

<div class="bg-white rounded-[30px] shadow-lg overflow-hidden">

<form
action="{{ route('superadmin.users.store') }}"
method="POST">

@csrf

<div class="p-10">

<h2 class="text-xl font-bold text-slate-800 mb-6">

Informations personnelles

</h2>

<div class="grid md:grid-cols-2 gap-6">

<div>

<label class="block mb-2 font-semibold text-slate-700">

Nom complet

</label>

<input
type="text"
name="nom"
value="{{ old('nom') }}"
required

class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">

@error('nom')

<p class="text-red-500 text-sm mt-2">

{{ $message }}

</p>

@enderror

</div>

<div>

<label class="block mb-2 font-semibold text-slate-700">

Adresse Email

</label>

<input
type="email"
name="email"
value="{{ old('email') }}"
required

class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">

@error('email')

<p class="text-red-500 text-sm mt-2">

{{ $message }}

</p>

@enderror

</div>

</div>

<div class="mt-10">

<h2 class="text-xl font-bold text-slate-800 mb-6">

Sécurité

</h2>

<div class="grid md:grid-cols-2 gap-6">

<div>

<label class="block mb-2 font-semibold text-slate-700">

Mot de passe

</label>

<input
type="password"
name="password"
required

class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">

@error('password')

<p class="text-red-500 text-sm mt-2">

{{ $message }}

</p>

@enderror

</div>

<div>

<label class="block mb-2 font-semibold text-slate-700">

Confirmation

</label>

<input
type="password"
name="password_confirmation"
required

class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

            </div>

            <div class="mt-10">

                <h2 class="text-xl font-bold text-slate-800 mb-6">

                    Affectation

                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="block mb-2 font-semibold text-slate-700">

                            Rôle

                        </label>

                        <select
                            name="id_role"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">

                            @foreach($roles as $role)

                                <option value="{{ $role->id_role }}">

                                    {{ ucfirst($role->nom_role) }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2 font-semibold text-slate-700">

                            Service

                        </label>

                        <select
                            name="id_service"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none">

                            <option value="">

                                Aucun service

                            </option>

                            @foreach($services as $service)

                                <option value="{{ $service->id_service }}">

                                    {{ $service->nom_service }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </div>

        <div class="border-t bg-slate-50 px-10 py-6 flex justify-end gap-4">

            <a
                href="{{ route('superadmin.users.index') }}"
                class="px-6 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 transition">

                Annuler

            </a>

            <button
                type="submit"
                class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg transition">

                Enregistrer

            </button>

        </div>

    </form>

</div>

</div>

</div>

@endsection