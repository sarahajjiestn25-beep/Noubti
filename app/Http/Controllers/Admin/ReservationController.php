<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('service')
            ->latest('id_reservation')
            ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }
}
