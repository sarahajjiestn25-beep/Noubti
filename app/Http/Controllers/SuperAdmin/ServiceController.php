<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ServiceController extends Controller
{
    /**
     * Liste des services
     */
    public function index()
    {
        $services = Service::orderBy('id_service', 'desc')
            ->paginate(10);

        return view('superadmin.services.index', compact('services'));
    }

    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        return view('superadmin.services.create');
    }

    /**
     * Créer un service + générer automatiquement le QR Code
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_service' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'adresse' => 'nullable|string|max:300',
            'actif' => 'nullable|boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        $service = Service::create($validated);

        // Générer le QR Code
        $this->generateQrCode($service);

        return redirect()
            ->route('superadmin.services.index')
            ->with('success', 'Service créé avec succès et QR Code généré.');
    }

    /**
     * Formulaire de modification
     */
    public function edit(Service $service)
    {
        return view('superadmin.services.edit', compact('service'));
    }

    /**
     * Modifier un service + régénérer automatiquement le QR Code
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nom_service' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'adresse' => 'nullable|string|max:300',
            'actif' => 'nullable|boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        $service->update($validated);

        // Régénérer le QR Code après modification
        $this->generateQrCode($service);

        return redirect()
            ->route('superadmin.services.index')
            ->with('success', 'Service modifié avec succès et QR Code mis à jour.');
    }

    /**
     * Générer / régénérer le QR Code d'un service
     */
    private function generateQrCode(Service $service)
    {
        $url = route('public.service.show', $service);

        $fileName = 'qrcodes/service_' . $service->id_service . '.svg';

        $qrCode = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($url);

        Storage::disk('public')->put($fileName, $qrCode);

        $service->update([
            'qr_code' => $fileName,
        ]);
    }

    /**
     * Télécharger le QR Code
     */
    public function downloadQr(Service $service)
    {
        if (!$service->qr_code) {
            abort(404, 'QR Code introuvable.');
        }

        if (!Storage::disk('public')->exists($service->qr_code)) {
            abort(404, 'Fichier QR Code introuvable.');
        }

        return Storage::disk('public')->download(
            $service->qr_code,
            'QR_' . $service->nom_service . '.svg'
        );
    }

    /**
     * Supprimer un service + son QR Code
     */
    public function destroy(Service $service)
    {
        if ($service->qr_code) {
            Storage::disk('public')->delete($service->qr_code);
        }

        $service->delete();

        return redirect()
            ->route('superadmin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}