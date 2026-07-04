<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nom', 100);
            $table->string('email', 200)->unique();
            $table->string('password', 200);
            $table->string('telephone', 20)->nullable();
            $table->boolean('actif')->default(true);

            // FK -> roles (relation "posseder" 1,1 => NOT NULL, chaque user a obligatoirement un role)
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')
                  ->references('id_role')
                  ->on('roles')
                  ->onDelete('restrict');

            // FK -> services (relation "appartient" 0,1 => nullable, seul le responsable est lié a un service)
            $table->unsignedBigInteger('id_service')->nullable();
            $table->foreign('id_service')
                  ->references('id_service')
                  ->on('services')
                  ->onDelete('set null');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
