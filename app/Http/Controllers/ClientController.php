<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Afficher la page du scan (Formulaire ou Ticket actif)
    public function show($id_service)
    {
        $service = Service::where('id_service', $id_service)->firstOrFail();
        
        // Vérifier si le client a déjà un ticket actif pour ce service f la session
        $activeTicketId = session()->get('active_ticket_service_' . $id_service);
        
        if ($activeTicketId) {
            $ticket = Reservation::where('id_reservation', $activeTicketId)->first();
            
            if ($ticket && in_array($ticket->statut, ['en attente', 'en cours'])) {
                // Calcule du nombre de personnes avant lui
                $waitingBefore = Reservation::where('id_service', $id_service)
                    ->where('statut', 'en attente')
                    ->where('id_reservation', '<', $ticket->id_reservation)
                    ->count();
                    
                $estimatedTime = $waitingBefore * 5; // 5 min par personne
                
                // Extraction de la chaîne Nom/Tel depuis temps_restant
                $clientInfo = explode(' - ', $ticket->temps_restant ?? 'Client - ');
                $nom_client = $clientInfo[0] ?? 'Client Anonyme';
                
                return view('client.scan', [
                    'service' => $service,
                    'ticket' => $ticket,
                    'nom_client' => $nom_client,
                    'waitingBefore' => $waitingBefore,
                    'estimatedTime' => $estimatedTime
                ]);
            }
        }

        // Si aucun ticket actif, on affiche le formulaire
        return view('client.scan', compact('service'));
    }

    // Enregistrer le ticket direct f la table reservations
    public function storeTicket(Request $request)
    {
        $request->validate([
            'id_service' => 'required|integer',
            'nom_client' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
        ]);

        $id_service = $request->id_service;

        // Calculer le numéro de ticket (max du jour + 1) f l-champ 'numero'
        $maxToday = Reservation::where('id_service', $id_service)
            ->whereDate('created_at', today())
            ->max('numero');
            
        $nextNumero = $maxToday ? $maxToday + 1 : 1;

        // Stocker Nom et Téléphone f 'temps_restant' pour éviter de modifier la structure SQL
        $infosStockage = $request->nom_client . ' - ' . $request->telephone;

        // Insertion directe 3la 7sab la structure dyalk
        $ticket = Reservation::create([
            'id_service' => $id_service,
            'numero' => $nextNumero,
            'temps_restant' => $infosStockage,
            'statut' => 'en attente',
            'date_reservation' => today()->toDateString(),
            'heure_reservation' => now()->toTimeString(),
        ]);

        // Sauvegarder dans la session du navigateur du client
        session()->put('active_ticket_service_' . $id_service, $ticket->id_reservation);

        return redirect()->route('client.scan', ['id_service' => $id_service]);
    }
}