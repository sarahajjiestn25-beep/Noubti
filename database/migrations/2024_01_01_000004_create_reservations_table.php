<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_service');
            $table->string('nom_client', 100);
            $table->string('telephone', 30)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->unsignedInteger('numero_ticket');

            // statut values normalized to lowercase keys
            $table->enum('statut', ['en attente', 'en cours', 'termine', 'annule'])->default('en attente');
            $table->enum('booking_source', ['online', 'local'])->default('online');

            $table->unsignedSmallInteger('temps_restant')->default(0);

            // FK -> services
            $table->foreign('id_service')
                ->references('id_service')
                ->on('services')
                ->onDelete('cascade');

            // optional user id (do not create users for scanned clients)
            $table->unsignedBigInteger('id_user')->nullable();

            $table->timestamps();

            $table->index(['id_service', 'created_at', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
