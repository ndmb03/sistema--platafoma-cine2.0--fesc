<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcion extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * Basado en los requerimientos: horario, película, sala, boletos (implícito).
     * Incluimos un precio base para la función.
     * @var array<int, string>
     */
    protected $fillable = [
        'pelicula_id',
        'sala_id',
        'horario', // Fecha y hora de la función
        'precio_base',
    ];

    /**
     * Indica que el campo 'horario' debe ser tratado como un objeto Carbon.
     * @var array
     */
    protected $casts = [
        'horario' => 'datetime',
    ];

    /**
     * Define la relación: Una Función pertenece a una Película.
     * @return BelongsTo
     */
    public function pelicula(): BelongsTo
    {
        return $this->belongsTo(Pelicula::class);
    }

    /**
     * Define la relación: Una Función se realiza en una Sala.
     * @return BelongsTo
     */
    public function sala(): BelongsTo
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * Define la relación: Una Función tiene muchos Boletos vendidos.
     * @return HasMany
     */
    public function boletos(): HasMany
    {
        return $this->hasMany(Boleto::class);
    }
}