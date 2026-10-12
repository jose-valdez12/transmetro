<?php
namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Recorrido;
use App\Models\Estacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Iluminate\validation\ValidationException;
use App\Models\Bus;

class AlertaController extends Controller
{
    // Mostrar todas las alertas
    public function index()
    {
        $alertas = Alerta::with(['recorrido', 'estacion'])
            ->orderByDesc('fecha_hora')
            ->paginate(10);

        return view('alertas.index', compact('alertas'));
    }

    // Mostrar formulario para crear una alerta
    public function create()
    {
        $recorridos = Recorrido::with(['bus', 'linea'])
            ->orderByDesc('id_recorrido')
            ->get();

        $estaciones = Estacion::orderBy('nombre')->get();

        return view('alertas.create', compact(
            'recorridos',
            'estaciones'
        ));
    }

    // Guardar una nueva alerta
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_recorrido' => 'nullable|exists:recorridos,id_recorrido',
            'id_estacion' => 'nullable|exists:estaciones,id_estacion',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'estado' => [
                'required',
                Rule::in(['Pendiente', 'Atendida'])
            ]
        ]);

        // Debe existir al menos un recorrido o estación
        if (empty($datos['id_recorrido']) &&
            empty($datos['id_estacion'])) {

            return back()
                ->withInput()
                ->withErrors([
                    'id_recorrido' =>
                    'Debe seleccionar al menos un recorrido o una estación.'
                ]);
        }

        Alerta::create($datos);

        return redirect()
            ->route('alertas.index')
            ->with('success', 'Alerta registrada correctamente.');
    }

    // Mostrar los detalles de una alerta
    public function show($id)
    {
        $alerta = Alerta::with(['recorrido', 'estacion'])
            ->findOrFail($id);

        return view('alertas.show', compact('alerta'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $alerta = Alerta::findOrFail($id);

        $recorridos = Recorrido::with(['bus', 'linea'])
            ->orderByDesc('id_recorrido')
            ->get();

        $estaciones = Estacion::orderBy('nombre')->get();

        return view('alertas.edit', compact(
            'alerta',
            'recorridos',
            'estaciones'
        ));
    }

    // Actualizar una alerta
    public function update(Request $request, $id)
    {
        $alerta = Alerta::findOrFail($id);

        $datos = $request->validate([
            'id_recorrido' => 'nullable|exists:recorridos,id_recorrido',
            'id_estacion' => 'nullable|exists:estaciones,id_estacion',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'estado' => [
                'required',
                Rule::in(['Pendiente', 'Atendida'])
            ]
        ]);

        // Validar que exista una referencia
        if (empty($datos['id_recorrido']) &&
            empty($datos['id_estacion'])) {

            return back()
                ->withInput()
                ->withErrors([
                    'id_recorrido' =>
                    'Debe seleccionar al menos un recorrido o una estación.'
                ]);
        }

        $alerta->update($datos);

        return redirect()
            ->route('alertas.index')
            ->with('success', 'Alerta actualizada correctamente.');
    }

    // Eliminar una alerta
    public function destroy($id)
    {
        $alerta = Alerta::findOrFail($id);

        $alerta->delete();

        return redirect()
            ->route('alertas.index')
            ->with('success', 'Alerta eliminada correctamente.');
    }

    public function asignarBus($id)
    {
        $alerta = Alerta::with('estacion')->findOrFail($id);

        // Solo se pueden gestionar alertas pendientes
        // que correspondan a alta demanda de pasajeros.
        if (
            $alerta->estado !== 'Pendiente' ||
            $alerta->tipo !== 'Alta demanda de pasajeros' ||
            !$alerta->id_estacion
        ) {
            return redirect()
                ->route('alertas.index')
                ->with(
                    'error',
                    'Esta alerta no permite asignar un bus adicional.'
                );
        }

        // Buscar las líneas que pasan por la estación
        $lineas = DB::table('lineas')
            ->join(
                'linea_estacion',
                'lineas.id_linea',
                '=',
                'linea_estacion.id_linea'
            )
            ->where(
                'linea_estacion.id_estacion',
                $alerta->id_estacion
            )
            ->select(
                'lineas.id_linea',
                'lineas.nombre'
            )
            ->orderBy('lineas.nombre')
            ->get();

        // Obtener buses disponibles
        $buses = Bus::where('estado', 'Disponible')
            ->orderBy('codigo')
            ->get();

        return view('alertas.asignar-bus', compact(
            'alerta',
            'lineas',
            'buses'
        ));
    }

    // Registrar la asignación del bus adicional
    public function guardarAsignacionBus(Request $request, $id)
    {
        $datos = $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_linea' => 'required|exists:lineas,id_linea'
        ]);

        DB::transaction(function () use ($datos, $id) {

            // Bloquear alerta durante la operación
            $alerta = Alerta::where('id_alerta', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $alerta->estado !== 'Pendiente' ||
                $alerta->tipo !== 'Alta demanda de pasajeros' ||
                !$alerta->id_estacion
            ) {
                throw ValidationException::withMessages([
                    'id_bus' => 'Esta alerta ya fue atendida o no corresponde a alta demanda.'
                ]);
            }

            // Comprobar que la línea pasa por la estación
            $pertenece = DB::table('linea_estacion')
                ->where('id_linea', $datos['id_linea'])
                ->where('id_estacion', $alerta->id_estacion)
                ->exists();

            if (!$pertenece) {
                throw ValidationException::withMessages([
                    'id_linea' => 'La línea seleccionada no pasa por la estación afectada.'
                ]);
            }

            // Bloquear el bus para evitar asignaciones simultáneas
            $bus = Bus::where('id_bus', $datos['id_bus'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($bus->estado !== 'Disponible') {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus seleccionado ya no está disponible.'
                ]);
            }

            // Verificar que no tenga otra asignación activa
            $asignacionActiva = DB::table('asignaciones_bus_linea')
                    ->where('id_bus', $bus->id_bus)
                    ->where('estado', 1)
                    ->whereNull('fecha_fin')
                    ->exists();

            if ($asignacionActiva) {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus ya tiene una asignación activa.'
                ]);
            }

            // Registrar asignación
                DB::table('asignaciones_bus_linea')->insert([
                        'id_bus' => $bus->id_bus,
                        'id_linea' => $datos['id_linea'],
                        'fecha_inicio' => now()->toDateString(),
                        'fecha_fin' => null,
                        'estado' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                         ]);

            // Actualizar estado del bus
            $bus->estado = 'Asignado';
            $bus->save();

            // Marcar alerta como atendida
            $alerta->estado = 'Atendida';
            $alerta->save();
        });

        return redirect()
            ->route('alertas.index')
            ->with(
                'success',
                'Bus adicional asignado correctamente y alerta marcada como atendida.'
            );
    }
}
