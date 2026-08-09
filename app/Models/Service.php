<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'id_service';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nom_service',
        'description',
        'adresse',
        'actif',
        'qr_code',
        'logo',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Les utilisateurs/responsables liés à ce service
     */
    public function users()
    {
        return $this->hasMany(
            User::class,
            'id_service',
            'id_service'
        );
    }

    /**
     * Les réservations liées à ce service
     */
    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'id_service',
            'id_service'
        );
    }
}