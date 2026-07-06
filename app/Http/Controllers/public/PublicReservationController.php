<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PublicReservationController extends Controller
{
    public function index()
    {
        $services = Service::where('actif', 1)->get();

        return view('public.reservation.form', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|max:100',
            'telephone_client' => 'required|max:20',
            'id_service' => 'required|exists:services,id_service',
        ]);

        $count = Reservation::where('id_service', $request->id_service)
            ->whereDate('date_reservation', today())
            ->count();

        $reservation = Reservation::create([

            'numero' => str_pad($count + 1,2,'0',STR_PAD_LEFT),

            'date_reservation' => today(),

            'heure_reservation' => now()->format('H:i:s'),

            'statut' => 'En attente',

            'temps_restant' => 0,

            'nom_client' => $request->nom_client,

            'telephone_client' => $request->telephone_client,

            'id_service' => $request->id_service,

            'id_user' => null,
        ]);

        return redirect()->route('public.ticket',$reservation);
    }

    public function ticket(Reservation $reservation)
    {
        $service = $reservation->service;

        $waitingBefore = Reservation::where('id_service',$reservation->id_service)
            ->where('statut','En attente')
            ->where('id_reservation','<',$reservation->id_reservation)
            ->count();

        $estimatedTime = $waitingBefore * 5;

        return view(
            'public.reservation.ticket',
            compact(
                'reservation',
                'service',
                'waitingBefore',
                'estimatedTime'
            )
        );
    }
public function status(Reservation $reservation)
{
    $reservation->refresh();

    $waitingBefore = Reservation::where('id_service', $reservation->id_service)
        ->where('statut', 'En attente')
        ->where('id_reservation', '<', $reservation->id_reservation)
        ->count();

    $estimatedTime = 0;

    if ($reservation->statut == 'En attente') {
        $estimatedTime = $waitingBefore * 5;
    }

    return response()->json([

        'numero' => $reservation->numero,

        'statut' => $reservation->statut,

        'waitingBefore' => $waitingBefore,

        'estimatedTime' => $estimatedTime,

        'isCurrent' => $reservation->statut == 'En cours',

        'isFinished' => $reservation->statut == 'Terminé',

        'isCancelled' => $reservation->statut == 'Annulé',

    ]);
}
}