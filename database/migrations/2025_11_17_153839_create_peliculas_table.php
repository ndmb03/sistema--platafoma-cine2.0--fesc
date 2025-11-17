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
    Schema::create('peliculas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo', 100);
        $table->string('genero', 50);
        $table->integer('duracion')->comment('Duración en minutos');
        $table->string('clasificacion', 10)->default('G');
        $table->string('foto')->nullable(); // Ruta de la foto (opcional por ahora)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};
