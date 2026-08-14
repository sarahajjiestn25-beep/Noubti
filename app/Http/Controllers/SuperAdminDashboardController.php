<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\Reservation;
use App\Exports\ReservationsExport;
use Maatwebsite\Excel\Facades\Excel;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return view('superadmin.dashboard', [

            'servicesCount' => Service::count(),

            'usersCount' => User::count(),

            'adminsCount' => User::whereHas('role', function ($q) {
                $q->where('nom_role', 'admin');
            })->count(),

            'responsablesCount' => User::whereHas('role', function ($q) {
                $q->where('nom_role', 'responsable');
            })->count(),

            'todayReservations' => Reservation::whereDate(
                'created_at',
                today()
            )->count(),

            'waitingCount' => Reservation::where('statut', 'en attente')->count(),

            'processingCount' => Reservation::where('statut', 'en cours')->count(),

            'finishedCount' => Reservation::where('statut', 'termine')->count(),

            'cancelledCount' => Reservation::where('statut', 'annule')->count(),

            'latestReservations' => Reservation::latest('id')
                ->take(10)
                ->get(),

        ]);
    }
    public function exportExcel()
{
    return Excel::download(
        new ReservationsExport,
        'reservations.xlsx'
    );
}
}