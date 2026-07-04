<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $primaryKey = 'id_reservation';

    public $incrementing = true;

    protected $keyType = 'int';
    protected $fillable = [
    'numero',
    'date_reservation',
    'heure_reservation',
    'statut',
    'temps_restant',
    'nom_client',
    'telephone_client',
    'id_service',
    'id_user'
];

    protected $casts = [
        'temps_restant' => 'integer',
        'date_reservation' => 'date'
    ];

    public function service()
    {
        return $this->belongsTo(
            Service::class,
            'id_service',
            'id_service'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function getFormattedTicketAttribute()
    {
        $prefix = strtoupper(
            substr($this->service->nom_service ?? 'T', 0, 1)
        );

        return $prefix . str_pad(
            $this->numero,
            3,
            '0',
            STR_PAD_LEFT
        );
    }
}