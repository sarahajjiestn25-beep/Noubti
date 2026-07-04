<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Cle primaire personnalisee (par defaut Laravel cherche 'id')
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nom_role',
    ];

    /**
     * Un role peut avoir plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
