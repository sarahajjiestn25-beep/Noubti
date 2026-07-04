<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('id_service');
            $table->string('nom_service', 100);
            $table->string('description', 500)->nullable();

            // Qr_code = chemin relatif vers l'image générée (ex: 'qrcodes/service_1.png')
            $table->string('qr_code', 255)->nullable();

            $table->boolean('actif')->default(true);

            // logo = chemin de l'image du service (stocké comme string, pas en binaire)
            $table->string('logo', 255)->nullable();

            $table->string('adresse', 300)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
