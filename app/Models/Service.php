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
        'qr_code',
        'actif',
        'logo',
        'adresse',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Un service peut avoir plusieurs responsables (users avec id_service = ce service).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_service', 'id_service');
    }

    /**
     * Un service peut avoir plusieurs reservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_service', 'id_service');
    }
}
