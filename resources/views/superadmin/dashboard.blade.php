<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard - Noubti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Noubti SuperAdmin</h1>
                    <p class="mt-1 text-sm text-slate-500">Gestion des services et supervision globale.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-semibold text-indigo-700">SuperAdmin</span>
            </div>
        </header>

        <main class="flex-1 py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

                @if(session('success'))
                    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-900 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-1 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-900">Créer un nouveau service</h2>
                        <p class="mt-2 text-sm text-slate-500">Ajoutez rapidement un service et générez automatiquement son QR Code de scan.</p>

                        <form action="{{ route('superadmin.service.store') }}" method="POST" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label for="nom_service" class="block text-sm font-medium text-slate-700">Nom du service</label>
                                <input id="nom_service" name="nom_service" type="text" value="{{ old('nom_service') }}" required class="mt-1 block w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100" />
                                @error('nom_service')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                Ajouter
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">Services existants</h2>
                                <p class="mt-2 text-sm text-slate-500">Visualisez les services créés et imprimez leur QR Code de scan.</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">{{ $services->count() }} service(s)</span>
                        </div>

                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">Nom du service</th>
                                        <th class="px-4 py-3">QR Code</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse($services as $service)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-4">
                                                <div class="font-semibold text-slate-900">{{ $service->nom_service }}</div>
                                                <div class="mt-1 text-xs text-slate-500 break-words">{{ $service->id_service }}</div>
                                            </td>
                                            <td class="px-4 py-4">
                                            <div id="qr-{{ $service->id_service }}" class="flex justify-center">
                                                {!! QrCode::size(120)->generate(url('/scan/' . $service->id_service)) !!}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <button type="button" onclick="printQr('{{ $service->id_service }}')" class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                                Imprimer
                                            </button>
                                        </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-slate-500">
                                                Aucun service trouvé. Créez-en un à gauche pour commencer.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function printQr(id) {
            const qrContainer = document.getElementById(`qr-${id}`);
            if (!qrContainer) {
                alert('QR Code introuvable pour impression.');
                return;
            }

            const html = `<!DOCTYPE html><html><head><title>Imprimer QR Code</title><style>body{margin:0;display:flex;justify-content:center;align-items:center;height:100vh;font-family:Inter,system-ui,-apple-system,Helvetica,Arial,sans-serif;background:#f8fafc;}svg{width:320px;height:auto;}</style></head><body>${qrContainer.innerHTML}</body></html>`;
            const printWindow = window.open('', '_blank');
            if (!printWindow) {
                alert('Impossible d ouvrir une nouvelle fenêtre d impression.');
                return;
            }

            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>
</body>
</html>
