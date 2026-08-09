<x-layouts.admin title="Services">

    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Services
            </h1>

            <p class="text-gray-500 mt-1">
                Gérez les services disponibles dans Noubti.
            </p>
        </div>

        <a href="{{ route('admin.services.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition">
            + Ajouter un service
        </a>

    </div>


    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif


    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                Liste des services
            </h2>
        </div>


        @if($services->count())

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                Service
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                Description
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                Adresse
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                Statut
                            </th>

                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($services as $service)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">

                                            <span class="font-bold text-indigo-600">
                                                {{ strtoupper(substr($service->nom_service, 0, 1)) }}
                                            </span>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-900">
                                                {{ $service->nom_service }}
                                            </p>

                                            <p class="text-xs text-gray-500">
                                                #{{ $service->id_service }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $service->description ?: 'Aucune description' }}
                                </td>


                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $service->adresse ?: 'Non renseignée' }}
                                </td>


                                <td class="px-6 py-5">

                                    @if($service->actif)

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                            Actif
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                            Inactif
                                        </span>

                                    @endif

                                </td>


                                <td class="px-6 py-5">

                                    <div class="flex justify-end items-center gap-2">

                                        <a href="{{ route('admin.services.edit', $service->id_service) }}"
                                           class="px-3 py-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-sm font-semibold">
                                            Modifier
                                        </a>


                                        <form action="{{ route('admin.services.destroy', $service->id_service) }}"
                                              method="POST"
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce service ?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-sm font-semibold">
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="p-6 border-t border-gray-200">
                {{ $services->links() }}
            </div>

        @else

            <div class="p-12 text-center">

                <div class="text-5xl mb-4">
                    📋
                </div>

                <h3 class="text-lg font-bold text-gray-900">
                    Aucun service
                </h3>

                <p class="text-gray-500 mt-2">
                    Commencez par ajouter votre premier service.
                </p>

                <a href="{{ route('admin.services.create') }}"
                   class="inline-block mt-5 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold">
                    + Ajouter un service
                </a>

            </div>

        @endif

    </div>

</x-layouts.admin>