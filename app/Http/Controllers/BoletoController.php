<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BoletoController extends Controller
{
    /**
     * Muestra los asientos ocupados para una función específica.
     * Retorna la fila y el número del asiento.
     * @param int $funcionId
     */
    public function getOcupados($funcionId)
    {
        // Se busca la función para asegurar que exista
        $funcion = Funcion::findOrFail($funcionId);

        // Se obtienen los identificadores de asientos ocupados como objetos con fila y asiento_numero
        $asientosOcupados = Boleto::where('funcion_id', $funcionId)
                                  ->select('fila', 'asiento_numero')
                                  ->get()
                                  ->toArray();
        
        return response()->json([
            'asientos_ocupados' => $asientosOcupados, // Ejemplo: [{"fila": "A", "asiento_numero": 1}]
            'sala_capacidad' => $funcion->sala->capacidad, 
            'precio_base' => $funcion->precio_base,
        ]);
    }

    /**
     * Procesa la compra de boletos para una función (Venta).
     * Recibe la ID de la función, la ID del usuario y un array de asientos seleccionados
     * con la estructura: [{"fila": "A", "numero": 1}, ...]
     */
    public function store(Request $request)
    {
        // 1. Validación de datos de entrada
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id',
            // user_id es opcional si permites ventas anónimas, pero lo marcamos como requerido 
            // si el formulario lo envía (o se obtiene de la sesión de autenticación).
            'user_id' => 'nullable|exists:users,id', 
            'asientos_seleccionados' => 'required|array|min:1',
            'asientos_seleccionados.*.fila' => 'required|string|max:5',
            'asientos_seleccionados.*.numero' => 'required|integer|min:1',
        ]);

        $funcion = Funcion::find($request->funcion_id);
        $asientosSeleccionados = $request->asientos_seleccionados;
        // Asignamos la ID de usuario o null si no está autenticado/proporcionado
        $userId = $request->user_id ?? auth()->id(); 

        try {
            DB::beginTransaction();

            $boletosData = [];
            $asientosParaVerificar = [];
            $precioBase = $funcion->precio_base;

            // 1. Preparamos los datos para la inserción y la verificación
            foreach ($asientosSeleccionados as $asiento) {
                $fila = strtoupper($asiento['fila']);
                $numero = $asiento['numero'];
                
                $asientosParaVerificar[] = ['fila' => $fila, 'asiento_numero' => $numero];
                
                $boletosData[] = [
                    'funcion_id' => $funcion->id,
                    'user_id' => $userId,
                    'fila' => $fila,
                    'asiento_numero' => $numero,
                    'precio' => $precioBase, // Usamos el precio base de la función
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 2. Verificamos disponibilidad de asientos mediante una consulta compleja
            $query = Boleto::where('funcion_id', $funcion->id);
            
            // Construye una consulta OR para verificar si ALGUNO de los asientos seleccionados ya está ocupado
            $query->where(function ($q) use ($asientosParaVerificar) {
                foreach ($asientosParaVerificar as $asiento) {
                    $q->orWhere(fn($subQuery) => $subQuery->where('fila', $asiento['fila'])->where('asiento_numero', $asiento['asiento_numero']));
                }
            });
            
            $asientosOcupados = $query->get(['fila', 'asiento_numero']);
            
            if ($asientosOcupados->isNotEmpty()) {
                DB::rollBack();
                // Formateamos los asientos conflictivos para el mensaje de error
                $asientosConflictivos = $asientosOcupados->map(fn($a) => "{$a->fila}-{$a->asiento_numero}")->implode(', ');
                
                throw ValidationException::withMessages([
                    'asientos_seleccionados' => "Los siguientes asientos ya fueron vendidos: {$asientosConflictivos}. Por favor, selecciona otros."
                ]);
            }

            // 3. Creación masiva de boletos
            Boleto::insert($boletosData);

            DB::commit();

            // 4. Retornar respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => '¡Compra exitosa! Se han reservado ' . count($boletosData) . ' asientos.',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            // Retornar un error general si la transacción falla
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // El resto de los métodos CRUD (edit, destroy) para Boletos se omiten por ser transaccionales.
}