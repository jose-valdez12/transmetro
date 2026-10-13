<?php
namespace App\Http\Controllers;

use App\Models\AsignacionPiloto;
use App\Models\Piloto;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsignacionPilotoController extends Controller
{
    // Mostrar todas las asignaciones
    public function index()
    {
        $asignaciones = AsignacionPiloto::with(['piloto', 'bus'])
            ->orderByDesc('id_asignacion_piloto')
            ->paginate(10);

        return view('asignaciones-pilotos.index', compact('asignaciones'));
    }

    // Formulario para registrar asignación
    public function create()
    {
        $pilotos = Piloto::where('estado', 1)
            ->orderBy('nombres')
            ->get();

        $buses = Bus::whereIn('estado', ['Disponible', 'Asignado'])
            ->orderBy('codigo')
            ->get();

        return view('asignaciones-pilotos.create', compact(
            'pilotos',
            'buses'
        ));
    }

    // Guardar nueva asignación
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_piloto' => 'required|integer|exists:pilotos,id_piloto',
            'id_bus' => 'required|integer|exists:buses,id_bus',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio'
        ]);

        DB::transaction(function () use ($datos) {

            // Bloquear registros durante la operación
            $piloto = Piloto::where('id_piloto', $datos['id_piloto'])
                ->lockForUpdate()
                ->firstOrFail();

            $bus = Bus::where('id_bus', $datos['id_bus'])
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar piloto activo
            if (!$piloto->estado) {
                throw ValidationException::withMessages([
                    'id_piloto' => 'El piloto seleccionado está inactivo.'
                ]);
            }

            // Verificar estado del bus
            if (!in_array($bus->estado, ['Disponible', 'Asignado'])) {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus no está disponible para asignar un piloto.'
                ]);
            }

            // Evitar dos asignaciones activas del piloto
            $pilotoAsignado = AsignacionPiloto::where(
                'id_piloto',
                $datos['id_piloto']
            )->where('estado', 1)->exists();

            if ($pilotoAsignado) {
                throw ValidationException::withMessages([
                    'id_piloto' => 'Este piloto ya tiene una asignación activa.'
                ]);
            }

            // Evitar dos pilotos activos en el mismo bus
            $busAsignado = AsignacionPiloto::where(
                'id_bus',
                $datos['id_bus']
            )->where('estado', 1)->exists();

            if ($busAsignado) {
                throw ValidationException::withMessages([
                    'id_bus' => 'Este bus ya tiene un piloto asignado.'
                ]);
            }

            // Registrar asignación
            AsignacionPiloto::create([
                'id_piloto' => $datos['id_piloto'],
                'id_bus' => $datos['id_bus'],
                'fecha_inicio' => $datos['fecha_inicio'],
                'fecha_fin' => null,
                'estado' => 1
            ]);
        });

        return redirect()
            ->route('asignaciones-pilotos.index')
            ->with('success', 'Piloto asignado correctamente al bus.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $asignacion = AsignacionPiloto::with(['piloto', 'bus'])
            ->findOrFail($id);

        return view('asignaciones-pilotos.show', compact('asignacion'));
    }

    // Formulario de edición
    public function edit($id)
    {
        $asignacion = AsignacionPiloto::findOrFail($id);

        $pilotos = Piloto::where('estado', 1)
            ->orWhere('id_piloto', $asignacion->id_piloto)
            ->orderBy('nombres')
            ->get();

        $buses = Bus::whereIn('estado', ['Disponible', 'Asignado'])
            ->orWhere('id_bus', $asignacion->id_bus)
            ->orderBy('codigo')
            ->get();

        return view('asignaciones-pilotos.edit', compact(
            'asignacion',
            'pilotos',
            'buses'
        ));
    }

    // Actualizar asignación
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'id_piloto' => 'required|integer|exists:pilotos,id_piloto',
            'id_bus' => 'required|integer|exists:buses,id_bus',
            'fecha_inicio' => 'required|date'
        ]);

        DB::transaction(function () use ($id, $datos) {

            $asignacion = AsignacionPiloto::where(
                'id_asignacion_piloto',
                $id
            )->lockForUpdate()->firstOrFail();

            if (!$asignacion->estado) {
                throw ValidationException::withMessages([
                    'asignacion' => 'No se puede editar una asignación finalizada.'
                ]);
            }

            $piloto = Piloto::where('id_piloto', $datos['id_piloto'])
                ->lockForUpdate()
                ->firstOrFail();

            $bus = Bus::where('id_bus', $datos['id_bus'])
                ->lockForUpdate()
                ->firstOrFail();

            if (!$piloto->estado) {
                throw ValidationException::withMessages([
                    'id_piloto' => 'El piloto seleccionado está inactivo.'
                ]);
            }

            if (!in_array($bus->estado, ['Disponible', 'Asignado'])) {
                throw ValidationException::withMessages([
                    'id_bus' => 'El bus no está disponible.'
                ]);
            }

            // Buscar otra asignación activa del piloto
            $pilotoOcupado = AsignacionPiloto::where(
                'id_piloto',
                $datos['id_piloto']
            )
            ->where('estado', 1)
            ->where('id_asignacion_piloto', '!=', $id)
            ->exists();

            if ($pilotoOcupado) {
                throw ValidationException::withMessages([
                    'id_piloto' => 'Este piloto ya tiene otra asignación activa.'
                ]);
            }

            // Buscar otra asignación activa del bus
            $busOcupado = AsignacionPiloto::where(
                'id_bus',
                $datos['id_bus']
            )
            ->where('estado', 1)
            ->where('id_asignacion_piloto', '!=', $id)
            ->exists();

            if ($busOcupado) {
                throw ValidationException::withMessages([
                    'id_bus' => 'Este bus ya tiene otro piloto asignado.'
                ]);
            }

            $asignacion->update($datos);
        });

        return redirect()
            ->route('asignaciones-pilotos.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    // Finalizar asignación sin eliminar historial
    public function finalizar($id)
    {
        DB::transaction(function () use ($id) {

            $asignacion = AsignacionPiloto::where(
                'id_asignacion_piloto',
                $id
            )->lockForUpdate()->firstOrFail();

            if (!$asignacion->estado) {
                throw ValidationException::withMessages([
                    'asignacion' => 'Esta asignación ya está finalizada.'
                ]);
            }

            // No finalizar si el bus tiene un recorrido en curso
            $recorridoEnCurso = \App\Models\Recorrido::where(
                'id_bus',
                $asignacion->id_bus
            )
            ->where('estado', 'En curso')
            ->exists();

            if ($recorridoEnCurso) {
                throw ValidationException::withMessages([
                    'asignacion' => 'No se puede finalizar la asignación porque el bus tiene un recorrido en curso.'
                ]);
            }

            $asignacion->update([
                'fecha_fin' => now()->toDateString(),
                'estado' => 0
            ]);
        });

        return redirect()
            ->route('asignaciones-pilotos.index')
            ->with('success', 'Asignación del piloto finalizada correctamente.');
    }

    // Eliminar únicamente asignaciones finalizadas
    public function destroy($id)
    {
        $asignacion = AsignacionPiloto::findOrFail($id);

        if ($asignacion->estado) {
            return redirect()
                ->route('asignaciones-pilotos.index')
                ->with(
                    'error',
                    'Primero debe finalizar la asignación antes de eliminarla.'
                );
        }

        $asignacion->delete();

        return redirect()
            ->route('asignaciones-pilotos.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}
