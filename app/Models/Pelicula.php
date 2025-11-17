<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelicula extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * Basado en los requerimientos: título, género, duración, clasificación, foto.
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'genero',
        'duracion', // En minutos
        'clasificacion',
        'foto_url', // Campo para almacenar la ruta o URL de la foto
    ];

    /**
     * Define la relación: Una Película puede tener muchas Funciones programadas.
     * @return HasMany
     */
    public function funciones(): HasMany
    {
        return $this->hasMany(Funcion::class);
    }
}