<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $primaryKey = 'id_configuration';

    protected $fillable = [
        'nom_app',
        'logo',
        'couleur_primaire',
        'couleur_secondaire',
        'email_contact',
        'telephone_contact',
        'adresse_contact',
        'time',
        'languages',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
