<?php

namespace App\Http\Controllers;

use App\Models\Recorrido;
use App\Models\Bus;
use App\Models\Linea;
use App\Models\AsignacionBusLinea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RecorridoController extends Controller
{
    // Mostrar todos los recorridos
    public function index()
    {
        $recorridos = Recorrido::with(['bus', 'linea'])
            ->orderByDesc('id_recorrido')
            ->paginate(10);

        return view('recorridos.index', compact('recorridos'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        // Buses con asignaciones activas
        $idsBuses = AsignacionBusLinea::where('estado', 1)
            ->pluck('id_bus');

        $buses = Bus::whereIn('id_bus', $idsBuses)
            ->where('estado', 'Asignado')
            ->orderBy('codigo')
            ->get();

        $lineas = Linea::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        return view('recorridos.create', compact('buses', 'lineas'));
    }

    // Guardar recorrido
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_linea' => 'required|exists:lineas,id_linea',
            'fecha' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'estado' => [
                'required',
                Rule::in([
                    'Programado',
                    'En curso',
                    'Finalizado',
                    'Cancelado'
                ])
            ]
        ]);

        // Comprobar asignación activa del bus a la línea
        $asignacion = AsignacionBusLinea::where('id_bus', $datos['id_bus'])
            ->where('id_linea', $datos['id_linea'])
            ->where('estado', 1)
            ->whereDate('fecha_inicio', '<=', $datos['fecha'])
            ->where(function ($consulta) use ($datos) {
                $consulta->whereNull('fecha_fin')
                    ->orWhereDate('fecha_fin', '>=', $datos['fecha']);
            })
            ->exists();

        if (!$asignacion) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_linea' => 'El bus no tiene una asignación activa a esta línea para la fecha seleccionada.'
                ]);
        }

        // Evitar recorridos activos simultáneos del mismo bus
        if ($datos['estado'] === 'En curso') {
            $enCurso = Recorrido::where('id_bus', $datos['id_bus'])
                ->where('estado', 'En curso')
                ->exists();

            if ($enCurso) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'estado' => 'Este bus ya tiene un recorrido en curso.'
                    ]);
            }
        }

        Recorrido::create($datos);

        return redirect()
            ->route('recorridos.index')
            ->with('success', 'Recorrido registrado correctamente.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $recorrido = Recorrido::with(['bus', 'linea'])
            ->findOrFail($id);

        return view('recorridos.show', compact('recorrido'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $recorrido = Recorrido::findOrFail($id);

        $idsBuses = AsignacionBusLinea::where('estado', 1)
            ->pluck('id_bus');

        $buses = Bus::whereIn('id_bus', $idsBuses)
            ->orWhere('id_bus', $recorrido->id_bus)
            ->orderBy('codigo')
            ->get();

        $lineas = Linea::orderBy('nombre')->get();

        return view('recorridos.edit',
            compact('recorrido', 'buses', 'lineas'));
    }

    // Actualizar recorrido
    public function update(Request $request, $id)
    {
        $recorrido = Recorrido::findOrFail($id);

        $datos = $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_linea' => 'required|exists:lineas,id_linea',
            'fecha' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
            'estado' => [
                'required',
                Rule::in([
                    'Programado',
                    'En curso',
                    'Finalizado',
                    'Cancelado'
                ])
            ]
        ]);

        $asignacion = AsignacionBusLinea::where('id_bus', $datos['id_bus'])
            ->where('id_linea', $datos['id_linea'])
            ->where('estado', 1)
            ->whereDate('fecha_inicio', '<=', $datos['fecha'])
            ->where(function ($consulta) use ($datos) {
                $consulta->whereNull('fecha_fin')
                    ->orWhereDate('fecha_fin', '>=', $datos['fecha']);
            })
            ->exists();

        if (!$asignacion) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_linea' => 'No existe una asignación activa para ese bus, línea y fecha.'
                ]);
        }

        if ($datos['estado'] === 'En curso') {
            $enCurso = Recorrido::where('id_bus', $datos['id_bus'])
                ->where('estado', 'En curso')
                ->where('id_recorrido', '!=', $id)
                ->exists();

            if ($enCurso) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'estado' => 'El bus ya tiene otro recorrido en curso.'
                    ]);
            }
        }

        $recorrido->update($datos);

        return redirect()
            ->route('recorridos.index')
            ->with('success', 'Recorrido actualizado correctamente.');
    }

    // Eliminar recorrido
    public function destroy($id)
    {
        $recorrido = Recorrido::findOrFail($id);

        // No eliminar recorridos con visitas registradas
        if ($recorrido->visitas()->exists()) {
            return redirect()
                ->route('recorridos.index')
                ->with('error', 'No se puede eliminar un recorrido que tiene visitas a estaciones registradas.');
        }

        // No eliminar recorridos con alertas asociadas
        if ($recorrido->alertas()->exists()) {
            return redirect()
                ->route('recorridos.index')
                ->with('error', 'No se puede eliminar un recorrido que tiene alertas registradas.');
        }

        $recorrido->delete();

        return redirect()
            ->route('recorridos.index')
            ->with('success', 'Recorrido eliminado correctamente.');
    }

     // Iniciar un recorrido programado
    public function iniciar($id)
    {
        DB::transaction(function () use ($id) {

            $recorrido = Recorrido::findOrFail($id);

            // Bloquear el bus para evitar operaciones simultáneas
            $bus = Bus::where('id_bus', $recorrido->id_bus)
                ->lockForUpdate()
                ->firstOrFail();

            $recorrido = Recorrido::where('id_recorrido', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($recorrido->estado !== 'Programado') {
                throw ValidationException::withMessages([
                    'recorrido' => 'Solo se pueden iniciar recorridos programados.'
                ]);
            }

            // Comprobar que el bus esté asignado a la línea
            $asignacion = AsignacionBusLinea::where('id_bus', $bus->id_bus)
                ->where('id_linea', $recorrido->id_linea)
                ->where('estado', 1)
                ->whereDate('fecha_inicio', '<=', now()->toDateString())
                ->where(function ($consulta) {
                    $consulta->whereNull('fecha_fin')
                        ->orWhereDate('fecha_fin', '>=', now()->toDateString());
                })
                ->exists();

            if (!$asignacion || $bus->estado !== 'Asignado') {
                throw ValidationException::withMessages([
                    'recorrido' => 'El bus no tiene una asignación activa a esta línea.'
                ]);
            }

            // Evitar dos recorridos simultáneos
            $otroRecorrido = Recorrido::where('id_bus', $bus->id_bus)
                ->where('estado', 'En curso')
                ->exists();

            if ($otroRecorrido) {
                throw ValidationException::withMessages([
                    'recorrido' => 'Este bus ya tiene un recorrido en curso.'
                ]);
            }

            $recorrido->update([
                'estado' => 'En curso',
                'fecha' => now()->toDateString(),
                'hora_inicio' => now()->format('H:i:s'),
                'hora_fin' => null
            ]);
        });

        return redirect()
            ->route('recorridos.index')
            ->with('success', 'Recorrido iniciado correctamente.');
    }

    // Finalizar un recorrido en curso
    public function finalizar($id)
    {
        DB::transaction(function () use ($id) {

            $recorrido = Recorrido::where('id_recorrido', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($recorrido->estado !== 'En curso') {
                throw ValidationException::withMessages([
                    'recorrido' => 'Solo se pueden finalizar recorridos en curso.'
                ]);
            }

            $recorrido->update([
                'estado' => 'Finalizado',
                'hora_fin' => now()->format('H:i:s')
            ]);
        });

        return redirect()
            ->route('recorridos.index')
            ->with('success', 'Recorrido finalizado correctamente.');
    }
}
