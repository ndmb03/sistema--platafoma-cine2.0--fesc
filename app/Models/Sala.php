<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sala extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * Basado en los requerimientos: capacidad, tipo, número.
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'capacidad',
        'tipo', // Ejemplo: '2D', '3D', 'VIP'
    ];

    /**
     * Define la relación: Una Sala puede albergar muchas Funciones programadas.
     * @return HasMany
     */
    public function funciones(): HasMany
    {
        return $this->hasMany(Funcion::class);
    }
}