<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configuration = Configuration::first();

        return view('superadmin.configuration.index', compact('configuration'));
    }

    public function update(Request $request)
    {
        $configuration = Configuration::first();

        if (!$configuration) {
            $configuration = new Configuration();
        }

        $validated = $request->validate([
            'nom_app' => 'required|string|max:255',

            'langue' => 'nullable|string|max:10',

            'couleur_primaire' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'couleur_secondaire' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {

            $path = $request->file('logo')->store(
                'configuration',
                'public'
            );

            $validated['logo'] = $path;
        }

        $configuration->fill($validated);
        $configuration->save();

        return redirect()
            ->route('superadmin.configuration.index')
            ->with('success', 'Configuration mise à jour avec succès.');
    }
}