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

        return view('public.reservation', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|max:100',
            'telephone_client' => 'required|max:20',
            'id_service' => 'required'
        ]);

        $countToday = Reservation::where('id_service', $request->id_service)
            ->whereDate('date_reservation', today())
            ->count();

        $numero = 'A' . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        $reservation = Reservation::create([

            'numero' => $numero,

            'date_reservation' => now()->toDateString(),

            'heure_reservation' => now()->format('H:i:s'),

            'statut' => 'En attente',

            'temps_restant' => 0,

            'nom_client' => $request->nom_client,

            'telephone_client' => $request->telephone_client,

            'id_service' => $request->id_service,

            'id_user' => null
        ]);

        return redirect()->route('public.ticket', $reservation->id_reservation);
    }

    public function ticket(Reservation $reservation)
    {
        $service = $reservation->service;

        $waitingBefore = Reservation::where('id_service', $reservation->id_service)
            ->where('statut', 'En attente')
            ->where('id_reservation', '<', $reservation->id_reservation)
            ->count();

        $estimatedTime = $waitingBefore * 5;

        return view(
            'public.ticket',
            compact(
                'reservation',
                'service',
                'waitingBefore',
                'estimatedTime'
            )
        );
    }
}