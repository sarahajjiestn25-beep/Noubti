<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ResponsableController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Do not redirect authenticated users to home — show dashboard for testing.
        $service = $user->service;

        if ($service) {
            $waitingCount = Reservation::where('id_service', $service->id_service)
                ->where('statut', 'en attente')
                ->count();

            $processingCount = Reservation::where('id_service', $service->id_service)
                ->where('statut', 'en cours')
                ->count();

            $finishedCount = Reservation::where('id_service', $service->id_service)
                ->where('statut', 'termine')
                ->count();

            $queue = Reservation::where('id_service', $service->id_service)
                ->whereIn('statut', ['en attente', 'en cours'])
              ->orderBy('id_reservation')
                ->get();
        } else {
            // If no service assigned, show empty stats so Responsable can still access the UI
            $waitingCount = $processingCount = $finishedCount = 0;
            $queue = collect();
        }

        return view('dashboard', compact('service', 'waitingCount', 'processingCount', 'finishedCount', 'queue'));
    }

    public function nextTicket(Request $request)
    {
        $user = Auth::user();

        if (! $user || ! $user->isResponsable()) {
            return redirect()->route('home');
        }

        $service = $user->service;

        if (! $service) {
            return redirect()->back()->with('error', 'Service non attribué.');
        }

        $ticket = Reservation::where('id_service', $service->id_service)
            ->where('statut', 'en attente')
            ->orderBy('id_reservation')
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('error', 'Aucun ticket en attente.');
        }

        $ticket->update(['statut' => 'en cours']);

        return Redirect::back()->with('success', 'Ticket #' . $ticket->numero_ticket . ' mis en cours.');
    }

    public function finishTicket(Request $request)
    {
        $user = Auth::user();

        if (! $user || ! $user->isResponsable()) {
            return redirect()->route('home');
        }

        $service = $user->service;

        if (! $service) {
            return redirect()->back()->with('error', 'Service non attribué.');
        }

        $ticket = Reservation::where('id_service', $service->id_service)
            ->where('statut', 'en cours')
            ->orderBy('id_reservation')
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('error', 'Aucun ticket en cours.');
        }

        $ticket->update(['statut' => 'termine']);

        return Redirect::back()->with('success', 'Ticket #' . $ticket->numero_ticket . ' terminé.');
    }

    public function cancelTicket(Request $request)
    {
        $user = Auth::user();

        if (! $user || ! $user->isResponsable()) {
            return redirect()->route('home');
        }

        $service = $user->service;

        if (! $service) {
            return redirect()->back()->with('error', 'Service non attribué.');
        }

        $ticket = Reservation::where('id_service', $service->id_service)
            ->where('statut', 'en cours')
            ->orderBy('id_reservation')
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('error', 'Aucun ticket en cours à annuler.');
        }

        $ticket->update(['statut' => 'annule']);

        return Redirect::back()->with('success', 'Ticket #' . $ticket->numero_ticket . ' annulé.');
    }
}
