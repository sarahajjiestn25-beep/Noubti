<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ResponsableDashboardController extends Controller
{
    /**
     * Dashboard Responsable
     */
    public function index()
    {
        $user = Auth::user();
        $service = $user->service;

        $waitingCount = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En attente')
            ->count();

        $processingCount = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->count();

        $finishedCount = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'Terminé')
            ->count();

        $cancelledCount = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'Annulé')
            ->count();

        $currentTicket = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        $queue = Reservation::where('id_service', $user->id_service)
            ->orderBy('id_reservation')
            ->get();
            
        return view('responsable.dashboard', compact(
            'service',
            'waitingCount',
            'processingCount',
            'finishedCount',
            'cancelledCount',
            'queue',
            'currentTicket'
             ));
    }

    /**
     * Appeler le prochain ticket
     */
    public function nextTicket()
    {
        $user = Auth::user();

        $currentTicket = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if ($currentTicket) {
            return back()->with('error', 'Un ticket est déjà en cours.');
        }

        $nextTicket = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En attente')
            ->orderBy('id_reservation')
            ->first();

        if (!$nextTicket) {
            return back()->with('error', 'Aucun ticket en attente.');
        }

        $nextTicket->update([
            'statut' => 'En cours'
        ]);

        return back()->with('success', 'Ticket appelé avec succès.');
    }

    /**
     * Terminer le ticket actuel
     */
    public function finishTicket()
    {
        $user = Auth::user();

        $currentTicket = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if (!$currentTicket) {
            return back()->with('error', 'Aucun ticket en cours.');
        }

        $currentTicket->update([
            'statut' => 'Terminé'
        ]);

        return back()->with('success', 'Ticket terminé avec succès.');
    }

    /**
     * Annuler le ticket actuel
     */
    public function cancelTicket()
    {
        $user = Auth::user();

        $currentTicket = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if (!$currentTicket) {
            return back()->with('error', 'Aucun ticket en cours.');
        }

        $currentTicket->update([
            'statut' => 'Annulé'
        ]);

        return back()->with('success', 'Ticket annulé.');
    }
}