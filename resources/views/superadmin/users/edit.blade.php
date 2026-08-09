@extends('layouts.app')

@section('title','Modifier Utilisateur')

@section('content')

<div class="max-w-5xl mx-auto py-10">

    <div class="bg-white rounded-[30px] shadow-lg overflow-hidden">

        {{-- Header --}}

        <div class="px-10 py-8 border-b flex justify-between items-center">

            <div>

                <h1 class="text-4xl font-bold text-slate-800">
                    Modifier un utilisateur
                </h1>

                <p class="text-slate-500 mt-2">
                    Mettre à jour les informations du compte.
                </p>

            </div>

            <a href="{{ route('superadmin.users.index') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 hover:bg-slate-100 transition">

                ← Retour

            </a>

        </div>

        {{-- Errors --}}

        @if($errors->any())

            <div class="mx-10 mt-8 bg-red-50 border border-red-200 rounded-2xl p-5">

                <h3 class="text-red-600 font-semibold mb-3">

                    Veuillez corriger les erreurs :

                </h3>

                <ul class="list-disc ml-5 text-red-600">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Form --}}

        <form
            action="{{ route('superadmin.users.update',$user) }}"
            method="POST"
            class="p-10">

            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-8">

                <div>

                    <label class="block mb-2 font-semibold text-slate-700">
                        Nom complet
                    </label>

                    <input
                        type="text"
                        name="nom"
                        value="{{ old('nom',$user->nom) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-slate-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email',$user->email) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-slate-700">
                        Nouveau mot de passe
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <p class="text-sm text-slate-500 mt-2">

                        Laisser vide pour conserver le mot de passe actuel.

                    </p>

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-slate-700">
                        Téléphone
                    </label>

                    <input
                        type="text"
                        name="telephone"
                        value="{{ old('telephone',$user->telephone) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-slate-700">
                        Rôle
                    </label>

                    <select
                        name="id_role"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        @foreach($roles as $role)

                            <option
                                value="{{ $role->id_role }}"
                                {{ $user->id_role == $role->id_role ? 'selected' : '' }}>

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
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <option value="">
                            Aucun service
                        </option>

                        @foreach($services as $service)

                            <option
                                value="{{ $service->id_service }}"
                                {{ $user->id_service == $service->id_service ? 'selected' : '' }}>

                                {{ $service->nom_service }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="border-t mt-10 pt-8 flex justify-end gap-4">

                <a href="{{ route('superadmin.users.index') }}"
                   class="px-6 py-3 rounded-xl border border-slate-300 hover:bg-slate-100 transition">

                    Annuler

                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg transition">

                    Enregistrer les modifications

                </button>

            </div>

        </form>

    </div>

</div>

@endsection