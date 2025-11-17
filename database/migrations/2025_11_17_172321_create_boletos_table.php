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
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            
            // Llaves foráneas
            $table->foreignId('funcion_id')->constrained('funciones')->onDelete('cascade');
            // user_id es nullable para permitir ventas anónimas o fallar si el user no existe.
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->comment('Comprador del boleto.'); 

            // Campos de Asiento (separados por fila y número)
            $table->string('fila', 5)->comment('Identificador de la fila (ej. A, B).');
            $table->unsignedSmallInteger('asiento_numero')->comment('Número del asiento dentro de la fila.');
            
            // Campo de Precio
            $table->decimal('precio', 8, 2)->comment('Precio final pagado por el boleto.');
            
            $table->timestamps();

            // Clave única compuesta: Un asiento solo puede ser vendido una vez por función
            $table->unique(['funcion_id', 'fila', 'asiento_numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};