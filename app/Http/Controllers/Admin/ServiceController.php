<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Liste des services
     */
    public function index()
    {
        $services = Service::orderBy('id_service', 'desc')
            ->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Enregistrer un service
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

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Formulaire de modification
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Modifier un service
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

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service modifié avec succès.');
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}