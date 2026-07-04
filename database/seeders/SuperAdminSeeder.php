<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $roleSuperAdmin = Role::where('nom_role', 'superadmin')->first();

        User::firstOrCreate(
            ['email' => 'superadmin@queueflow.com'],
            [
                'nom' => 'Super Admin',
                'password' => Hash::make('Password123!'),
                'telephone' => '0600000000',
                'actif' => true,
                'id_role' => $roleSuperAdmin->id_role,
                'id_service' => null,
            ]
        );
    }
}