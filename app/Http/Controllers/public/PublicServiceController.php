<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    /**
     * Afficher un service pour le public.
     */
    public function show(Service $service)
    {
        if (!$service->actif) {
            abort(404);
        }

        return view('public.service', compact('service'));
    }

    /**
     * Créer une réservation pour un service.
     */
    public function store(Request $request, Service $service)
    {
        if (!$service->actif) {
            abort(404);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'telephone' => 'required|string|max:30',
        ]);

        $reservation = Reservation::create([
            'id_service' => $service->id_service,
            'nom' => $validated['nom'],
            'telephone' => $validated['telephone'],
        ]);

        return redirect()
            ->route('public.ticket.show', $reservation)
            ->with('success', 'Votre réservation a été créée avec succès.');
    }

    /**
     * Afficher le ticket.
     */
    public function ticket(Reservation $reservation)
    {
        $reservation->load('service');

        return view('public.ticket', compact('reservation'));
    }

    /**
     * Vérifier le statut du ticket.
     */
    public function checkStatus(Reservation $reservation)
    {
        return response()->json([
            'id_reservation' => $reservation->id_reservation,
            'statut' => $reservation->statut,
            'numero_ticket' => $reservation->numero_ticket,
        ]);
    }
}
