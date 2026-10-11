<?php

namespace App\Http\Controllers;

use App\Models\VisitaEstacion;
use App\Models\Recorrido;
use App\Models\Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class VisitaEstacionController extends Controller
{
    // Listar visitas registradas
    public function index()
    {
        $visitas = VisitaEstacion::with([
            'recorrido.bus',
            'recorrido.linea',
            'estacion'
        ])
        ->orderByDesc('id_visita')
        ->paginate(10);

        return view('visitas.index', compact('visitas'));
    }

    // Formulario para registrar una visita
    public function create()
    {
        $recorridos = Recorrido::with(['bus', 'linea'])
            ->where('estado', 'En curso')
            ->orderByDesc('id_recorrido')
            ->get();

        $estaciones = Estacion::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        return view('visitas.create',
            compact('recorridos', 'estaciones'));
    }

    // Guardar una visita
   public function store(Request $request)
{
    $datos = $request->validate([
        'id_recorrido' => 'required|exists:recorridos,id_recorrido',
        'id_estacion' => 'required|exists:estaciones,id_estacion',
        'fecha_hora_llegada' => 'required|date',
        'fecha_hora_salida' => 'nullable|date|after_or_equal:fecha_hora_llegada',
        'cantidad_pasajeros' => 'required|integer|min:0'
    ]);

    // Buscar recorrido y bus
    $recorrido = Recorrido::with('bus')
        ->findOrFail($datos['id_recorrido']);

    // Solo permitir recorridos en curso
    if ($recorrido->estado !== 'En curso') {
        return back()
            ->withInput()
            ->withErrors([
                'id_recorrido' =>
                'Solo se pueden registrar visitas en recorridos en curso.'
            ]);
    }

    // Comprobar que la estación pertenece a la línea
    $pertenece = DB::table('linea_estacion')
        ->where('id_linea', $recorrido->id_linea)
        ->where('id_estacion', $datos['id_estacion'])
        ->exists();

    if (!$pertenece) {
        return back()
            ->withInput()
            ->withErrors([
                'id_estacion' =>
                'La estación seleccionada no pertenece a la línea del recorrido.'
            ]);
    }

    // Verificar capacidad del bus
    $capacidad = $recorrido->bus->capacidad_maxima;

    if ($capacidad <= 0) {
        return back()
            ->withInput()
            ->withErrors([
                'id_recorrido' =>
                'El bus debe tener una capacidad máxima mayor que cero.'
            ]);
    }

    if ($datos['cantidad_pasajeros'] > $capacidad) {
        return back()
            ->withInput()
            ->withErrors([
                'cantidad_pasajeros' =>
                'La cantidad de pasajeros supera la capacidad máxima del bus.'
            ]);
    }

    // Calcular porcentaje de ocupación
    $ocupacion = ($datos['cantidad_pasajeros'] / $capacidad) * 100;

    // Regla del 25%: esperar al menos 5 minutos
    if ($ocupacion < 25 && !empty($datos['fecha_hora_salida'])) {

        $llegada = Carbon::parse($datos['fecha_hora_llegada']);
        $salida = Carbon::parse($datos['fecha_hora_salida']);

        $salidaMinima = $llegada->copy()->addMinutes(5);

        if ($salida->lt($salidaMinima)) {
            return back()
                ->withInput()
                ->withErrors([
                    'fecha_hora_salida' =>
                    'El bus tiene una ocupación inferior al 25%. '
                    . 'Debe esperar al menos 5 minutos en la estación. '
                    . 'La hora mínima de salida es '
                    . $salidaMinima->format('d/m/Y H:i') . '.'
                ]);
        }
    }

    // Guardar visita sin modificar la hora de salida
    VisitaEstacion::create($datos);

    return redirect()
        ->route('visitas.index')
        ->with('success', 'Visita registrada correctamente.');
}

    // Mostrar detalles de una visita
    public function show($id)
    {
        $visita = VisitaEstacion::with([
            'recorrido.bus',
            'recorrido.linea',
            'estacion'
        ])->findOrFail($id);

        return view('visitas.show', compact('visita'));
    }

    // Formulario para editar una visita
    public function edit($id)
    {
        $visita = VisitaEstacion::findOrFail($id);

        $recorridos = Recorrido::with(['bus', 'linea'])
            ->where('estado', 'En curso')
            ->orWhere('id_recorrido', $visita->id_recorrido)
            ->orderByDesc('id_recorrido')
            ->get();

        $estaciones = Estacion::orderBy('nombre')->get();

        return view('visitas.edit',
            compact('visita', 'recorridos', 'estaciones'));
    }

    // Actualizar una visita
   public function update(Request $request, $id)
{
    $visita = VisitaEstacion::findOrFail($id);

    $datos = $request->validate([
        'id_recorrido' => 'required|exists:recorridos,id_recorrido',
        'id_estacion' => 'required|exists:estaciones,id_estacion',
        'fecha_hora_llegada' => 'required|date',
        'fecha_hora_salida' => 'nullable|date|after_or_equal:fecha_hora_llegada',
        'cantidad_pasajeros' => 'required|integer|min:0'
    ]);

    $recorrido = Recorrido::with('bus')
        ->findOrFail($datos['id_recorrido']);

    // Comprobar que la estación pertenece a la línea
    $pertenece = DB::table('linea_estacion')
        ->where('id_linea', $recorrido->id_linea)
        ->where('id_estacion', $datos['id_estacion'])
        ->exists();

    if (!$pertenece) {
        return back()
            ->withInput()
            ->withErrors([
                'id_estacion' =>
                'La estación seleccionada no pertenece a la línea del recorrido.'
            ]);
    }

    // Verificar capacidad del bus
    $capacidad = $recorrido->bus->capacidad_maxima;

    if ($capacidad <= 0) {
        return back()
            ->withInput()
            ->withErrors([
                'id_recorrido' =>
                'El bus debe tener una capacidad máxima mayor que cero.'
            ]);
    }

    if ($datos['cantidad_pasajeros'] > $capacidad) {
        return back()
            ->withInput()
            ->withErrors([
                'cantidad_pasajeros' =>
                'La cantidad de pasajeros supera la capacidad máxima del bus.'
            ]);
    }

    // Calcular ocupación
    $ocupacion = ($datos['cantidad_pasajeros'] / $capacidad) * 100;

    // Validar espera mínima de 5 minutos
    if ($ocupacion < 25 && !empty($datos['fecha_hora_salida'])) {

        $llegada = Carbon::parse($datos['fecha_hora_llegada']);
        $salida = Carbon::parse($datos['fecha_hora_salida']);

        $salidaMinima = $llegada->copy()->addMinutes(5);

        if ($salida->lt($salidaMinima)) {
            return back()
                ->withInput()
                ->withErrors([
                    'fecha_hora_salida' =>
                    'El bus tiene una ocupación inferior al 25%. '
                    . 'Debe esperar al menos 5 minutos en la estación. '
                    . 'La hora mínima de salida es '
                    . $salidaMinima->format('d/m/Y H:i') . '.'
                ]);
        }
    }

    // Actualizar visita
    $visita->update($datos);

    return redirect()
        ->route('visitas.index')
        ->with('success', 'Visita actualizada correctamente.');
}

    // Eliminar una visita
    public function destroy($id)
    {
        $visita = VisitaEstacion::findOrFail($id);

        $visita->delete();

        return redirect()
            ->route('visitas.index')
            ->with('success', 'Visita eliminada correctamente.');
    }
}
