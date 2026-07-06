@extends('layouts.app')

@section('title','Modifier le service')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-8 py-6">

            <h1 class="text-3xl font-bold text-white">
                Modifier le service
            </h1>

            <p class="text-blue-100 mt-2">
                Modifiez les informations du service.
            </p>

        </div>

        <div class="p-8">

            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <ul class="list-disc pl-5 text-red-600">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST"
                  action="{{ route('admin.services.update',$service) }}">

                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div>

                        <label class="block mb-2 font-semibold">
                            Nom du service
                        </label>

                        <input
                            type="text"
                            name="nom_service"
                            value="{{ old('nom_service',$service->nom_service) }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div>

                        <label class="block mb-2 font-semibold">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description',$service->description) }}</textarea>

                    </div>

                    <div>

                        <label class="block mb-2 font-semibold">
                            Adresse
                        </label>

                        <input
                            type="text"
                            name="adresse"
                            value="{{ old('adresse',$service->adresse) }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="flex items-center">

                        <input
                            id="actif"
                            type="checkbox"
                            name="actif"
                            value="1"
                            {{ old('actif',$service->actif) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600">

                        <label for="actif" class="ml-3 font-semibold">

                            Service actif

                        </label>

                    </div>

                </div>

                <div class="mt-10 flex justify-between">

                    <a href="{{ route('admin.services.index') }}"
                       class="px-6 py-3 rounded-xl bg-slate-200 hover:bg-slate-300">

                        Retour

                    </a>

                    <button
                        class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold">

                        Enregistrer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection