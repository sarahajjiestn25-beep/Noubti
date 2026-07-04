<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    /**
     * Afficher formulaire réservation
     */
    public function show(Service $service)
    {
        if (!$service->actif) {
            abort(404, 'Service non disponible');
        }

        $activeTicketId = session()->get('active_ticket_service_' . $service->id_service);

        if ($activeTicketId) {
            $ticket = Reservation::find($activeTicketId);

            if ($ticket && in_array($ticket->statut, ['En attente', 'En cours'])) {
                return redirect()->route('public.ticket.show', $ticket->id_reservation);
            }
        }

        return view('public.scan_form', compact('service'));
    }

    /**
     * Créer ticket
     */
    public function store(Request $request, Service $service)
    {
        if (!$service->actif) {
            abort(404, 'Service non disponible');
        }

        $request->validate([
            'telephone' => 'required|string|max:30'
        ]);

        // Nombre tickets aujourd'hui
        $todayCount = Reservation::where('id_service', $service->id_service)
            ->whereDate('date_reservation', today())
            ->count();

        $ticketNumber = $todayCount + 1;

        $reservation = Reservation::create([
            'numero' => $ticketNumber,
            'date_reservation' => now()->toDateString(),
            'heure_reservation' => now()->format('H:i:s'),
            'statut' => 'En attente',
            'temps_restant' => 0,
            'id_service' => $service->id_service,

            // مهم: خليها 1 مؤقتا إذا DB ماكاتقبلش NULL
            'id_user' => 1
        ]);

        session()->put(
            'active_ticket_service_' . $service->id_service,
            $reservation->id_reservation
        );

        return redirect()->route(
            'public.ticket.show',
            $reservation->id_reservation
        );
    }

    /**
     * Afficher ticket
     */
    public function ticket(Reservation $reservation)
    {
        $service = $reservation->service;

        $waitingBefore = Reservation::where('id_service', $reservation->id_service)
            ->where('statut', 'En attente')
            ->where('id_reservation', '<', $reservation->id_reservation)
            ->whereDate('date_reservation', $reservation->date_reservation)
            ->count();

        $estimatedTime = $waitingBefore * 5;

        return view('public.ticket_view', compact(
            'reservation',
            'service',
            'waitingBefore',
            'estimatedTime'
        ));
    }

    /**
     * AJAX status
     */
    public function checkStatus(Reservation $reservation)
    {
        $waitingBefore = Reservation::where('id_service', $reservation->id_service)
            ->where('statut', 'En attente')
            ->where('id_reservation', '<', $reservation->id_reservation)
            ->whereDate('date_reservation', $reservation->date_reservation)
            ->count();

        $estimatedTime = $waitingBefore * 5;

        return response()->json([
            'id' => $reservation->id_reservation,
            'statut' => $reservation->statut,
            'numero' => $reservation->numero,
            'waitingBefore' => $waitingBefore,
            'estimatedTime' => $estimatedTime,
        ]);
    }
    
}