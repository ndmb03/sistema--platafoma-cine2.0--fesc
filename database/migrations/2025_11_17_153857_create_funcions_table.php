<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funciones', function (Blueprint $table) {
            $table->id();
            
            // Llaves foráneas a los otros módulos
            $table->foreignId('pelicula_id')->constrained('peliculas')->onDelete('cascade');
            $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');

            // Campos requeridos
            $table->timestamp('horario')->comment('Fecha y hora de inicio de la función.');
            $table->decimal('precio_base', 8, 2)->default(5.00)->comment('Precio base del boleto para esta función.');
            
            // Campo de estado
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Índice para evitar la duplicación de funciones en la misma sala a la misma hora
            $table->unique(['sala_id', 'horario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funciones');
    }
};