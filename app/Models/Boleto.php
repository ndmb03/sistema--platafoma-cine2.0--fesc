<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// ... resto del código
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'funcion_id',
        'user_id', 
        'fila', 
        'asiento_numero',
        'precio'
    ]; 

    // Relaciones para el controlador
    public function funcion()
    {
        return $this->belongsTo(Funcion::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}