<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Reservation::with(['user','service'])
            ->get()
            ->map(function ($reservation) {

                return [

                    'Ticket'    => $reservation->numero_ticket,

                    'Client'    => optional($reservation->user)->nom,

                    'Téléphone' => optional($reservation->user)->telephone,

                    'Service'   => optional($reservation->service)->nom_service,

                    'Statut'    => $reservation->statut,

                    'Date'      => $reservation->date_reservation,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Ticket',
            'Client',
            'Téléphone',
            'Service',
            'Statut',
            'Date',
        ];
    }
}