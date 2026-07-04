<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id('id_configuration');

            $table->string('nom_app', 100)->default('QueueFlow');

            // logo = chemin de l'image (string), pas en binaire
            $table->string('logo', 255)->nullable();

            $table->string('couleur_primaire', 20)->default('#1A73E8');
            $table->string('couleur_secondaire', 20)->default('#34A853');

            $table->string('email_contact', 255)->nullable();
            $table->string('telephone_contact', 20)->nullable();
            $table->string('adresse_contact', 255)->nullable();

            // time = Date & Heure dans le MLD (ex: heure d'ouverture, ou horodatage de dernière modif)
            $table->dateTime('time')->nullable();

            // languages = string simple, ex: "fr,ar,en"
            $table->string('languages', 100)->default('fr');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
