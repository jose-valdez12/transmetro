<?php

namespace App\Http\Controllers;

use App\Models\AsignacionBusLinea;
use App\Models\Bus;
use App\Models\Linea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsignacionBusLineaController extends Controller
{
    // Listar asignaciones
    public function index()
    {
        $asignaciones = AsignacionBusLinea::with(['bus', 'linea'])
            ->orderByDesc('id_asignacion')
            ->paginate(10);

        return view('asignacion-bus.index',
            compact('asignaciones'));
    }

    // Formulario de registro
    public function create()
    {
        $buses = Bus::where('estado', 'Disponible')
            ->orderBy('codigo')
            ->get();

        $lineas = Linea::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        return view('asignacion-bus.create',
            compact('buses', 'lineas'));
    }

    // Guardar asignación
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_linea' => 'required|exists:lineas,id_linea',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|boolean'
        ]);

        DB::transaction(function () use ($datos) {
            $bus = Bus::where('id_bus', $datos['id_bus'])
                ->lockForUpdate()
                ->firstOrFail();

            $linea = Linea::findOrFail($datos['id_linea']);

            if ($bus->estado !== 'Disponible') {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus debe estar disponible para asignarlo.'
                ]);
            }

            if (!$linea->estado) {
                throw ValidationException::withMessages([
                    'id_linea' => 'La línea seleccionada está inactiva.'
                ]);
            }

            $existe = AsignacionBusLinea::where('id_bus', $bus->id_bus)
                ->where('estado', 1)
                ->exists();

            if ($existe) {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus ya tiene una asignación activa.'
                ]);
            }

            $asignacion = AsignacionBusLinea::create($datos);

            if ($asignacion->estado) {
                $bus->update(['estado' => 'Asignado']);
            }
        });

        return redirect()
            ->route('asignacion-bus.index')
            ->with('success', 'Asignación registrada correctamente.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $asignacion = AsignacionBusLinea::with(['bus', 'linea'])
            ->findOrFail($id);

        return view('asignacion-bus.show',
            compact('asignacion'));
    }

    // Formulario de edición
    public function edit($id)
    {
        $asignacion = AsignacionBusLinea::findOrFail($id);

        $buses = Bus::whereIn('estado', ['Disponible', 'Asignado'])
            ->orderBy('codigo')
            ->get();

        $lineas = Linea::orderBy('nombre')->get();

        return view('asignacion-bus.edit',
            compact('asignacion', 'buses', 'lineas'));
    }

    // Actualizar asignación
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_linea' => 'required|exists:lineas,id_linea',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|boolean'
        ]);

        DB::transaction(function () use ($id, $datos) {
            $asignacion = AsignacionBusLinea::findOrFail($id);
            $busAnteriorId = $asignacion->id_bus;

            $ids = array_unique([
                (int) $busAnteriorId,
                (int) $datos['id_bus']
            ]);
            sort($ids);

            $buses = Bus::whereIn('id_bus', $ids)
                ->orderBy('id_bus')
                ->lockForUpdate()
                ->get()
                ->keyBy('id_bus');

            $busNuevo = $buses->get($datos['id_bus']);
            $linea = Linea::findOrFail($datos['id_linea']);

            if ($datos['estado'] && !$linea->estado) {
                throw ValidationException::withMessages([
                    'id_linea' => 'No puedes activar una asignación en una línea inactiva.'
                ]);
            }

            $existe = AsignacionBusLinea::where('id_bus', $datos['id_bus'])
                ->where('estado', 1)
                ->where('id_asignacion', '!=', $id)
                ->exists();

            if ($datos['estado'] && $existe) {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus ya tiene otra asignación activa.'
                ]);
            }

            if ($datos['estado'] &&
                $busNuevo->estado !== 'Disponible' &&
                !($asignacion->estado &&
                  $busAnteriorId == $datos['id_bus'] &&
                  $busNuevo->estado === 'Asignado')) {

                throw ValidationException::withMessages([
                    'id_bus' => 'El bus seleccionado no está disponible.'
                ]);
            }

            $asignacion->update($datos);

            foreach ($buses as $bus) {
                $tieneAsignacion = AsignacionBusLinea::where(
                    'id_bus', $bus->id_bus
                )->where('estado', 1)->exists();

                if ($tieneAsignacion) {
                    $bus->update(['estado' => 'Asignado']);
                } elseif ($bus->estado === 'Asignado') {
                    $bus->update(['estado' => 'Disponible']);
                }
            }
        });

        return redirect()
            ->route('asignacion-bus.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    // Eliminar asignación
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $asignacion = AsignacionBusLinea::findOrFail($id);

            $bus = Bus::where('id_bus', $asignacion->id_bus)
                ->lockForUpdate()
                ->firstOrFail();

            $asignacion->delete();

            $tieneAsignacion = AsignacionBusLinea::where(
                'id_bus', $bus->id_bus
            )->where('estado', 1)->exists();

            if (!$tieneAsignacion && $bus->estado === 'Asignado') {
                $bus->update(['estado' => 'Disponible']);
            }
        });

        return redirect()
            ->route('asignacion-bus.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }

     // Finalizar una asignación de bus
    public function finalizar($id)
    {
        DB::transaction(function () use ($id) {

            $asignacion = AsignacionBusLinea::findOrFail($id);

            // Bloquear el bus durante la operación
            $bus = Bus::where('id_bus', $asignacion->id_bus)
                ->lockForUpdate()
                ->firstOrFail();

            // Bloquear y volver a consultar la asignación
            $asignacion = AsignacionBusLinea::where(
                'id_asignacion',
                $id
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar que la asignación esté activa
            if (!$asignacion->estado) {
                throw ValidationException::withMessages([
                    'asignacion' =>
                        'Esta asignación ya fue finalizada.'
                ]);
            }

            // Registrar la finalización
            $asignacion->update([
                'fecha_fin' => now()->toDateString(),
                'estado' => 0
            ]);

            // Comprobar si el bus tiene otra asignación activa
            $tieneOtraAsignacion = AsignacionBusLinea::where(
                'id_bus',
                $bus->id_bus
            )
                ->where('estado', 1)
                ->exists();

            // Liberar el bus si ya no tiene asignaciones activas
            if (
                !$tieneOtraAsignacion &&
                $bus->estado === 'Asignado'
            ) {
                $bus->update([
                    'estado' => 'Disponible'
                ]);
            }
        });

        return redirect()
            ->route('asignacion-bus.index')
            ->with(
                'success',
                'Asignación finalizada correctamente. El bus ha quedado disponible si no tiene otras asignaciones activas.'
            );
    }
}
