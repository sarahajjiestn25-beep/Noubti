<x-layouts.admin title="Ajouter un service">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-900">
            Ajouter un service
        </h1>

        <p class="text-gray-500 mt-1">
            Créez un nouveau service dans {{ $appConfig?->nom_app ?? 'Noubti' }}.
        </p>

    </div>


    <div class="max-w-3xl bg-white rounded-2xl border border-gray-200 shadow-sm p-8">

        <form method="POST" action="{{ route('admin.services.store') }}">

            @csrf


            {{-- NOM --}}

            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nom du service
                </label>

                <input
                    type="text"
                    name="nom_service"
                    value="{{ old('nom_service') }}"
                    placeholder="Ex: Administration"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                >

                @error('nom_service')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- DESCRIPTION --}}

            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    placeholder="Description du service..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ADRESSE --}}

            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Adresse
                </label>

                <input
                    type="text"
                    name="adresse"
                    value="{{ old('adresse') }}"
                    placeholder="Ex: Nador, Maroc"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >

                @error('adresse')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ACTIF --}}

            <div class="mb-8">

                <label class="flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="actif"
                        value="1"
                        checked
                        class="w-5 h-5 text-indigo-600 rounded"
                    >

                    <span class="text-sm font-semibold text-gray-700">
                        Service actif
                    </span>

                </label>

            </div>


            {{-- BUTTONS --}}

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('admin.services.index') }}"
                    class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50"
                >
                    Annuler
                </a>


                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                >
                    Créer le service
                </button>

            </div>

        </form>

    </div>

</x-layouts.admin>