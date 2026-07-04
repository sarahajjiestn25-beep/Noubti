<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ResponsableDashboardController extends Controller
{
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

        $queue = Reservation::where('id_service', $user->id_service)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('responsable.dashboard', compact(
            'service',
            'waitingCount',
            'processingCount',
            'finishedCount',
            'cancelledCount',
            'queue'
        ));
    }


    // appeler prochain ticket
    public function nextTicket()
    {
        $user = Auth::user();

        // vérifier si déjà un ticket en cours
        $current = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if ($current) {
            return back()->with('error', 'Un ticket est déjà en cours');
        }

        // prendre premier ticket en attente
        $next = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En attente')
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$next) {
            return back()->with('error', 'Aucun ticket en attente');
        }

        $next->update([
            'statut' => 'En cours'
        ]);

        return back()->with('success', 'Client suivant appelé');
    }


    // terminer ticket actuel
    public function finishTicket()
    {
        $user = Auth::user();

        $current = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if (!$current) {
            return back()->with('error', 'Aucun ticket en cours');
        }

        $current->update([
            'statut' => 'Terminé'
        ]);

        return back()->with('success', 'Ticket terminé');
    }


    // annuler ticket
    public function cancelTicket()
    {
        $user = Auth::user();

        $current = Reservation::where('id_service', $user->id_service)
            ->where('statut', 'En cours')
            ->first();

        if (!$current) {
            return back()->with('error', 'Aucun ticket en cours');
        }

        $current->update([
            'statut' => 'Annulé'
        ]);

        return back()->with('success', 'Ticket annulé');
    }
}