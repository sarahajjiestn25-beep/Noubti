<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // IMPORTANT : Laravel utilise 'id' par defaut pour l'authentification.
    // On garde id_user comme cle primaire reelle en base de donnees.
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nom',
        'email',
        'password',
        'telephone',
        'actif',
        'id_role',
        'id_service',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Chaque user appartient a un role (relation "posseder").
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    /**
     * Un user (responsable) peut etre lie a un service (relation "appartient").
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service');
    }

    /**
     * Un user (client) peut faire plusieurs reservations (relation "faire").
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_user', 'id_user');
    }

    /**
     * Methodes utilitaires pour verifier le role facilement dans les controllers/vues.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role->nom_role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role->nom_role === 'admin';
    }

    public function isResponsable(): bool
    {
        return $this->role->nom_role === 'responsable';
    }

}