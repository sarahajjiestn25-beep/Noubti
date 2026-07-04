<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ServiceController extends Controller
{
    /**
     * Affiche la liste de tous les services.
     */
    public function index()
    {
        // select() explicite pour eviter de charger des colonnes inutiles (optimisation)
        $services = Service::select('id_service', 'nom_service', 'description', 'qr_code', 'actif', 'logo')
            ->latest('id_service')
            ->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Affiche le formulaire de creation.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Enregistre un nouveau service + genere son QR Code local.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_service' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'adresse'     => 'nullable|string|max:300',
            'actif'       => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        // On cree le service d'abord pour recuperer son id_service auto-incremente
        $service = Service::create($validated);

        // Generation du QR Code local (aucune API externe, 100% gratuit)
        // Le QR Code encode l'URL publique de reservation du service
        $publicUrl = route('public.service.show', $service->id_service);

        $qrCodePath = 'qrcodes/service_' . $service->id_service . '.svg';

        QrCode::format('svg')
            ->size(300)
            ->color(0, 51, 102) // Couleur primaire Noubti (#003366) en RGB
            ->generate($publicUrl, public_path('storage/' . $qrCodePath));

        $service->update(['qr_code' => $qrCodePath]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service cree avec succes. QR Code genere.');
    }

    /**
     * Affiche le formulaire d'edition.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Met a jour un service existant.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nom_service' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'adresse'     => 'nullable|string|max:300',
            'actif'       => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service mis a jour avec succes.');
    }

    /**
     * Supprime un service (et son QR Code associe).
     */
    public function destroy(Service $service)
    {
        // Supprime le fichier QR code physique s'il existe
        $qrPath = public_path('storage/' . $service->qr_code);
        if ($service->qr_code && file_exists($qrPath)) {
            unlink($qrPath);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service supprime avec succes.');
    }
}
