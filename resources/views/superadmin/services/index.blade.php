<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-6">
                    <h3 class="text-lg font-bold">Liste des Services</h3>
                    <a href="{{ route('superadmin.services.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Ajouter un Service
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Nom du Service</th>
                            <th class="px-4 py-2 text-left">Adresse</th>
                            <th class="px-4 py-2 text-center">QR Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $service->nom_service }}</td>
                            <td class="px-4 py-2">{{ $service->Adresse ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="w-24 h-24 mx-auto p-1 bg-white flex items-center justify-center border">
                                    {!! QrCode::size(90)->margin(1)->generate(url('/scan/' . $service->id_service)) !!}
                                </div>
                                <span class="text-[10px] text-gray-400 block mt-1">Prêt pour scan</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                Aucun service trouvé. <a href="{{ route('superadmin.services.create') }}" class="text-blue-500 underline">Ajoutez-en un ici</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>. 