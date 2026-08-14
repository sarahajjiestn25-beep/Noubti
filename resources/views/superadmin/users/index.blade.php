@extends('layouts.app')

@section('title','Gestion des Utilisateurs')

@section('content')

<div class="min-h-screen bg-slate-100">

<div class="max-w-7xl mx-auto p-8">

{{-- HEADER --}}

<div class="bg-white rounded-[30px] shadow-lg p-8 mb-8">

    <div class="flex justify-between items-center">

        <div class="flex items-center gap-5">

            <div class="w-20 h-20 rounded-3xl bg-blue-50 flex items-center justify-center">

                <img
                    src="{{ $appConfig?->logo ? asset('storage/' . $appConfig->logo) : asset('images/logo.png') }}"
                    class="w-14">

            </div>

            <div>

                <h1 class="text-5xl font-extrabold text-slate-800">

                    Utilisateurs

                </h1>

                <p class="text-slate-500 mt-2">

                    Gestion des comptes de la plateforme {{ $appConfig?->nom_app ?? 'Noubti' }}

                </p>

            </div>

        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('superadmin.dashboard') }}"
                class="px-6 py-3 rounded-xl bg-slate-800 text-white hover:bg-slate-900 transition">

                ← Dashboard

            </a>

            <a
                href="{{ route('superadmin.users.create') }}"
                class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition shadow">

                + Nouvel utilisateur

            </a>

        </div>

    </div>

</div>

{{-- STATS --}}

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">

        <p class="text-slate-500 text-sm">

            Total Utilisateurs

        </p>

        <h2 class="text-4xl font-bold mt-2">

            {{ $users->total() }}

        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <p class="text-slate-500 text-sm">

            Super Admins

        </p>

        <h2 class="text-4xl font-bold text-red-600 mt-2">

            {{ $users->where('role.nom_role','superadmin')->count() }}

        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <p class="text-slate-500 text-sm">

            Admins

        </p>

        <h2 class="text-4xl font-bold text-blue-600 mt-2">

            {{ $users->where('role.nom_role','admin')->count() }}

        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <p class="text-slate-500 text-sm">

            Responsables

        </p>

        <h2 class="text-4xl font-bold text-green-600 mt-2">

            {{ $users->where('role.nom_role','responsable')->count() }}

        </h2>

    </div>

</div>

{{-- TABLE --}}

<div class="bg-white rounded-[30px] shadow-lg overflow-hidden">

    <div class="px-8 py-6 border-b">

        <h2 class="text-2xl font-bold text-slate-800">

            Liste des utilisateurs

        </h2>

        <p class="text-slate-500 mt-1">

            {{ $users->total() }} utilisateur(s)

        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-8 py-5 text-left">

                        Nom

                    </th>

                    <th class="px-8 py-5 text-left">

                        Email

                    </th>

                    <th class="px-8 py-5 text-center">

                        Rôle

                    </th>

                    <th class="px-8 py-5 text-center">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr class="border-t hover:bg-slate-50 transition">

                    <td class="px-8 py-5 font-semibold text-slate-800">

                        {{ $user->nom }}

                    </td>

                    <td class="px-8 py-5 text-slate-600">

                        {{ $user->email }}

                    </td>

                    <td class="px-8 py-5 text-center">

                        @php

                            $badge = match(optional($user->role)->nom_role){

                                'superadmin' => 'bg-red-100 text-red-700',

                                'admin' => 'bg-blue-100 text-blue-700',

                                'responsable' => 'bg-green-100 text-green-700',

                                default => 'bg-slate-100 text-slate-700'

                            };

                        @endphp

                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $badge }}">

                            {{ optional($user->role)->nom_role }}

                        </span>

                    </td>
                                        <td class="px-8 py-5">

                        <div class="flex items-center justify-center gap-3">

                            <a
                                href="{{ route('superadmin.users.edit', $user) }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition duration-200">

                                Modifier

                            </a>

                            <form
                                action="{{ route('superadmin.users.destroy', $user) }}"
                                method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur ?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition duration-200">

                                    Supprimer

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="4"
                        class="py-20 text-center text-slate-400">

                        Aucun utilisateur trouvé.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if($users->hasPages())

<div class="mt-8">

    <div class="bg-white rounded-2xl shadow p-4">

        {{ $users->links() }}

    </div>

</div>

@endif

</div>

</div>

@endsection