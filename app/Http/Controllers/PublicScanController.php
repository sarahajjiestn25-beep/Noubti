<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PublicScanController extends Controller
{
    // 1. Afficher le formulaire d'inscription après le scan du QR Code
    public function showScanForm($uid)
    {
        $service = Service::where('id_service', $uid)->first();

        if (!$service) {
            abort(404, 'Service non trouvé ou QR Code invalide.');
        }

        return view('public.scan_form', compact('service'));
    }

    // 2. Enregistrer le client et lui attribuer un numéro de ticket
    public function storeClientTicket(Request $request, $uid)
    {
        $service = Service::where('id_service', $uid)->first();

        if (!$service) {
            abort(404, 'Service non trouvé.');
        }

        // Validation des données du formulaire
        $request->validate([
            'nom' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
        ]);

        // Calculer le numéro du ticket pour aujourd'hui
        $todayTicketsCount = Reservation::where('id_service', $service->id_service)
            ->whereDate('created_at', today())
            ->count();
        
        $ticketNumber = $todayTicketsCount + 1;

        // Créer la réservation (ne pas créer d'utilisateur)
        $reservation = Reservation::create([
            'id_service' => $service->id_service,
            'nom_client' => $request->nom,
            'telephone' => $request->telephone,
            'numero_ticket' => $ticketNumber,
            'statut' => 'en attente',
            'temps_restant' => 0,
            'id_user' => null,
        ]);

        // Rediriger vers la page d'affichage du ticket
        return redirect()->route('public.ticket.show', ['id' => $reservation->id]);
    }

    // 3. Afficher le ticket digital final au client
    public function showTicket($id)
    {
        $reservation = Reservation::with(['user', 'service'])->find($id);

        if (!$reservation) {
            abort(404, 'Ticket non trouvé.');
        }

        // Calculer combien de personnes attendent avant ce client
        $peopleAhead = Reservation::where('id_service', $reservation->id_service)
            ->where('id', '<', $reservation->id)
            ->where('statut', 'en attente')
            ->where('created_at', '<', $reservation->created_at)
            ->count();

        // Temps d'attente estimé (5 minutes par personne)
        $estimatedWaitTime = $peopleAhead * 5;

        return view('public.ticket_view', compact('reservation', 'peopleAhead', 'estimatedWaitTime'));
    }
}