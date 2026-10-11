<?php
namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Recorrido;
use App\Models\Estacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
}
