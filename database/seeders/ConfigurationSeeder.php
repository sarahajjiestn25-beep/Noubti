<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        Configuration::firstOrCreate(
            ['id_configuration' => 1],
            [
                'nom_app' => 'QueueFlow',
                'logo' => null,
                'couleur_primaire' => '#1A73E8',
                'couleur_secondaire' => '#34A853',
                'email_contact' => 'contact@queueflow.com',
                'telephone_contact' => '0500000000',
                'adresse_contact' => 'Nador, Maroc',
                'time' => now(),
                'languages' => 'fr',
            ]
        );
    }
}