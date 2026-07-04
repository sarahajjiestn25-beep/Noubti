<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Affiche le dashboard du SuperAdmin avec les services.
     */
    public function index(Request $request): View
    {
        $services = Service::all();
        return view('superadmin.dashboard', compact('services'));
    }

    /**
     * Stocke un nouveau service et génère un QR Code.
     */
    public function storeService(Request $request): RedirectResponse
    {
        $request->validate([
            'nom_service' => ['required', 'string', 'max:255'],
        ]);

        Service::create([
            'nom_service' => $request->nom_service,
            'actif' => true,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Service créé avec succès.');
    }
}
