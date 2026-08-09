<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalReservations = Reservation::count();

        $todayReservations = Reservation::whereDate(
            'created_at',
            today()
        )->count();

        $servicesCount = Service::count();

        $usersCount = User::count();

        $waiting = Reservation::where('statut','En attente')->count();

        $processing = Reservation::where('statut','En cours')->count();

        $finished = Reservation::where('statut','Terminé')->count();

        $cancelled = Reservation::where('statut','Annulé')->count();

        return view('superadmin.statistics', compact(
            'totalReservations',
            'todayReservations',
            'servicesCount',
            'usersCount',
            'waiting',
            'processing',
            'finished',
            'cancelled'
        ));
    }
}