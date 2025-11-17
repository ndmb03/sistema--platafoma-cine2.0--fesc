<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\CarteleraController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Cartelera)
|--------------------------------------------------------------------------
*/

// Ruta principal para ver la cartelera
Route::get('/', [CarteleraController::class, 'index'])->name('cartelera.index');

// Rutas para seleccionar una película y ver sus horarios
Route::get('/peliculas/{pelicula}', [CarteleraController::class, 'showFunctions'])->name('cartelera.show_functions');

// Ruta para la vista de selección de asientos para una función
Route::get('/funciones/{funcion}/asientos', [CarteleraController::class, 'selectSeats'])->name('cartelera.select_seats');

// API para la gestión de Boletos (Consumo por JavaScript)
Route::post('/boletos/comprar', [BoletoController::class, 'store'])->name('boletos.store');
Route::get('/boletos/ocupados/{funcionId}', [BoletoController::class, 'getOcupados'])->name('boletos.ocupados');


/*
|--------------------------------------------------------------------------
| Rutas de Administración (CRUD - Protegidas por middleware 'auth' idealmente)
|--------------------------------------------------------------------------
*/

// Usaremos un grupo de rutas para la sección de administración, asumiendo un prefijo.

Route::prefix('admin')->name('admin.')->group(function () {
    // CRUD Películas
    Route::resource('peliculas', PeliculaController::class);

    // CRUD Salas
    Route::resource('salas', SalaController::class);

    // CRUD Funciones
    Route::resource('funciones', FuncionController::class);
    
    // CRUD Boletos (Si se necesitaran vistas de reportes)
    // Route::resource('boletos', BoletoController::class)->only(['index', 'show']);
});


// Ruta de ejemplo para el login (asumimos que ya existe)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');