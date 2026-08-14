@extends('layouts.app')

@section('title', 'Configuration')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

    <div class="max-w-5xl mx-auto">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200
                        text-green-700 rounded-2xl px-6 py-4 shadow-sm">

                <span class="text-xl">✓</span>

                <span class="font-semibold">
                    {{ session('success') }}
                </span>

            </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-8">

            <a href="{{ route('superadmin.dashboard') }}"
               class="inline-flex items-center gap-2
                      text-slate-500 hover:text-blue-600
                      font-semibold text-sm transition mb-5">

                <span class="text-lg">←</span>

                Retour au tableau de bord

            </a>

            <div>
                <h1 class="text-4xl font-black text-slate-800">
                    Configuration {{ $configuration->nom_app }}
                </h1>

                <p class="text-slate-500 mt-2">
                    Gérez les paramètres généraux de votre plateforme Noubti.
                </p>
            </div>

        </div>


        {{-- CONFIGURATION CARD --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-8 py-6 border-b bg-slate-50">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-2xl bg-blue-100
                                flex items-center justify-center text-2xl">
                        ⚙️
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Paramètres de la plateforme
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Modifiez les informations générales de Noubti.
                        </p>
                    </div>

                </div>

            </div>


            {{-- FORM --}}
            <form action="{{ route('superadmin.configuration.update') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-8">

                @csrf
                @method('PUT')


                {{-- APPLICATION --}}
                <div class="mb-10">

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">
                            Informations de la plateforme
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Informations principales affichées sur la plateforme.
                        </p>
                    </div>


                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- NOM --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nom de l'application
                            </label>

                            <input
                                type="text"
                                name="nom_app"
                                value="{{ old('nom_app', $configuration->nom_app) }}"
                                required
                                class="w-full border border-slate-300 rounded-xl
                                       px-4 py-3
                                       focus:ring-2 focus:ring-blue-500
                                       focus:border-blue-500
                                       focus:outline-none">

                            @error('nom_app')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- LANGUE --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Langue
                            </label>

                            <select
                                name="languages"
                                class="w-full border border-slate-300 rounded-xl
                                       px-4 py-3 bg-white
                                       focus:ring-2 focus:ring-blue-500
                                       focus:border-blue-500
                                       focus:outline-none">

                                <option value="fr"
                                    {{ old('languages', $configuration->languages) == 'fr' ? 'selected' : '' }}>
                                    Français
                                </option>

                                <option value="ar"
                                    {{ old('languages', $configuration->languages) == 'ar' ? 'selected' : '' }}>
                                    العربية
                                </option>

                                <option value="en"
                                    {{ old('languages', $configuration->languages) == 'en' ? 'selected' : '' }}>
                                    English
                                </option>

                            </select>

                            @error('languages')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div>


                {{-- LOGO --}}
                <div class="mb-10 pt-8 border-t">

                    <div class="mb-6">

                        <h3 class="text-lg font-bold text-slate-800">
                            Logo
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Logo utilisé sur la plateforme.
                        </p>

                    </div>


                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

                        <div class="w-28 h-28 rounded-2xl border border-slate-200
                                    bg-slate-50 flex items-center justify-center overflow-hidden">

                            @if($configuration->logo)

                                <img
                                    src="{{ asset('storage/'.$configuration->logo) }}"
                                    alt="Logo"
                                    class="w-full h-full object-contain p-3">

                            @else

                                <img
                                    src="{{ asset('images/logo.png') }}"
                                    alt="Logo Noubti"
                                    class="w-20 h-20 object-contain">

                            @endif

                        </div>


                        <div>

                            <input
                                type="file"
                                name="logo"
                                accept="image/png,image/jpeg,image/webp"
                                class="block w-full text-sm text-slate-500
                                       file:mr-4 file:py-2.5 file:px-4
                                       file:rounded-xl file:border-0
                                       file:bg-blue-50 file:text-blue-700
                                       file:font-semibold
                                       hover:file:bg-blue-100">

                            <p class="text-xs text-slate-400 mt-2">
                                PNG, JPG ou WEBP — 2 MB maximum.
                            </p>

                            @error('logo')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- COLORS --}}
                <div class="mb-10 pt-8 border-t">

                    <div class="mb-6">

                        <h3 class="text-lg font-bold text-slate-800">
                            Apparence
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Personnalisez les couleurs principales de la plateforme.
                        </p>

                    </div>


                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- PRIMARY --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Couleur primaire
                            </label>

                            <div class="flex items-center gap-3">

                                <input
                                    type="color"
                                    name="couleur_primaire"
                                    value="{{ old('couleur_primaire', $configuration->couleur_primaire) }}"
                                    class="w-14 h-12 rounded-xl border border-slate-300
                                           cursor-pointer">

                                <input
                                    type="text"
                                    value="{{ old('couleur_primaire', $configuration->couleur_primaire) }}"
                                    readonly
                                    class="flex-1 border border-slate-300 rounded-xl
                                           px-4 py-3 bg-slate-50 text-slate-600">

                            </div>

                            @error('couleur_primaire')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SECONDARY --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Couleur secondaire
                            </label>

                            <div class="flex items-center gap-3">

                                <input
                                    type="color"
                                    name="couleur_secondaire"
                                    value="{{ old('couleur_secondaire', $configuration->couleur_secondaire) }}"
                                    class="w-14 h-12 rounded-xl border border-slate-300
                                           cursor-pointer">

                                <input
                                    type="text"
                                    value="{{ old('couleur_secondaire', $configuration->couleur_secondaire) }}"
                                    readonly
                                    class="flex-1 border border-slate-300 rounded-xl
                                           px-4 py-3 bg-slate-50 text-slate-600">

                            </div>

                            @error('couleur_secondaire')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- CONTACT --}}
                <div class="mb-10 pt-8 border-t">

                    <div class="mb-6">

                        <h3 class="text-lg font-bold text-slate-800">
                            Coordonnées
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Informations de contact de l'établissement.
                        </p>

                    </div>


                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- EMAIL --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email de contact
                            </label>

                            <input
                                type="email"
                                name="email_contact"
                                value="{{ old('email_contact', $configuration->email_contact) }}"
                                class="w-full border border-slate-300 rounded-xl
                                       px-4 py-3
                                       focus:ring-2 focus:ring-blue-500
                                       focus:outline-none">

                            @error('email_contact')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- TELEPHONE --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Téléphone
                            </label>

                            <input
                                type="text"
                                name="telephone_contact"
                                value="{{ old('telephone_contact', $configuration->telephone_contact) }}"
                                class="w-full border border-slate-300 rounded-xl
                                       px-4 py-3
                                       focus:ring-2 focus:ring-blue-500
                                       focus:outline-none">

                            @error('telephone_contact')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- ADRESSE --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Adresse
                            </label>

                            <input
                                type="text"
                                name="adresse_contact"
                                value="{{ old('adresse_contact', $configuration->adresse_contact) }}"
                                class="w-full border border-slate-300 rounded-xl
                                       px-4 py-3
                                       focus:ring-2 focus:ring-blue-500
                                       focus:outline-none">

                            @error('adresse_contact')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ACTIONS --}}
                <div class="pt-6 border-t flex flex-col sm:flex-row
                            justify-end gap-3">

                    <a
                        href="{{ route('superadmin.dashboard') }}"
                        class="inline-flex items-center justify-center
                               px-6 py-3 rounded-xl
                               border border-slate-300
                               text-slate-600 font-semibold
                               hover:bg-slate-50 transition">

                        Annuler

                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center
                               px-6 py-3 rounded-xl
                               bg-blue-600 hover:bg-blue-700
                               text-white font-bold
                               shadow-lg shadow-blue-600/20
                               transition">

                        Enregistrer les modifications

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection