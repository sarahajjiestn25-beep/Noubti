<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('platform_name')->default('Noubti');

            $table->string('platform_description')
                ->nullable();

            $table->string('logo')
                ->nullable();

            $table->integer('ticket_duration')
                ->default(5);

            $table->boolean('reservations_enabled')
                ->default(true);

            $table->text('closed_message')
                ->nullable();

            $table->boolean('platform_enabled')
                ->default(true);

            $table->text('welcome_message')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};