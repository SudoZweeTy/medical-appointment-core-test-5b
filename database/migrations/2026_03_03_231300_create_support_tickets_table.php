<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración para crear la tabla de tickets de soporte
return new class extends Migration
{
    /**
     * Ejecutar la migración: crear tabla support_tickets.
     */
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();

            // Relación con el usuario que creó el ticket
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Datos principales del ticket
            $table->string('title');
            $table->text('description');

            // Estado del ticket (abierto, en progreso, cerrado)
            $table->enum('status', ['abierto', 'en_progreso', 'cerrado'])
                  ->default('abierto');

            // Prioridad del ticket (baja, media, alta)
            $table->enum('priority', ['baja', 'media', 'alta'])
                  ->default('media');

            // Respuesta del administrador (puede ser nula inicialmente)
            $table->text('admin_response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revertir la migración: eliminar tabla support_tickets.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
