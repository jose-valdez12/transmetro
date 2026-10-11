<?php
namespace App\Models;

use App\Models\Estacion;
use App\Models\Municipio;
use App\Models\Alerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EstacionController extends Controller
{
    // Listado de estaciones
    public function index()
    {
        $estaciones = Estacion::with('municipio')
            ->orderByDesc('id_estacion')
            ->paginate(10);

        return view('estaciones.index', compact('estaciones'));
    }

    // Formulario de registro
    public function create()
    {
        $municipios = Municipio::orderBy('nombre')->get();

        return view('estaciones.create', compact('municipios'));
    }

    // Guardar estación
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
            'capacidad_maxima' => 'required|integer|min:1',
            'pasajeros_actuales' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($datos) {

            $estacion = Estacion::create($datos);

            $this->verificarAlertaCapacidad($estacion);
        });

        return redirect()
            ->route('estaciones.index')
            ->with('success', 'Estación registrada correctamente.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $estacion = Estacion::with('municipio')
            ->findOrFail($id);

        return view('estaciones.show', compact('estacion'));
    }

    // Formulario de edición
    public function edit($id)
    {
        $estacion = Estacion::findOrFail($id);

        $municipios = Municipio::orderBy('nombre')->get();

        return view('estaciones.edit', compact(
            'estacion',
            'municipios'
        ));
    }

    // Actualizar estación
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
            'capacidad_maxima' => 'required|integer|min:1',
            'pasajeros_actuales' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($datos, $id) {

            // Bloquear la estación durante la actualización
            $estacion = Estacion::where('id_estacion', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $estacion->update($datos);

            $this->verificarAlertaCapacidad($estacion);
        });

        return redirect()
            ->route('estaciones.index')
            ->with('success', 'Estación actualizada correctamente.');
    }

    // Eliminar estación
    public function destroy($id)
    {
        $estacion = Estacion::findOrFail($id);

        // Evitar eliminar estaciones que tienen relaciones
        $tieneLineas = DB::table('linea_estacion')
            ->where('id_estacion', $id)
            ->exists();

        $tieneVisitas = DB::table('visitas_estacion')
            ->where('id_estacion', $id)
            ->exists();

        $tieneAlertas = Alerta::where('id_estacion', $id)
            ->exists();

        $tieneAccesos = DB::table('accesos')
            ->where('id_estacion', $id)
            ->exists();

        if (
            $tieneLineas ||
            $tieneVisitas ||
            $tieneAlertas ||
            $tieneAccesos
        ) {
            return redirect()
                ->route('estaciones.index')
                ->with(
                    'error',
                    'No se puede eliminar la estación porque tiene registros relacionados.'
                );
        }

        $estacion->delete();

        return redirect()
            ->route('estaciones.index')
            ->with('success', 'Estación eliminada correctamente.');
    }

    // Regla automática: alerta al alcanzar el 150% de capacidad
    private function verificarAlertaCapacidad(Estacion $estacion)
    {
        // No generar alertas con capacidad inválida
        if ($estacion->capacidad_maxima <= 0) {
            return;
        }

        // Calcular el porcentaje de ocupación
        $porcentaje = $estacion->porcentajeOcupacion();

        // Comprobar si se alcanzó el límite
        if ($estacion->requiereAlerta()) {

            // Verificar si ya existe una alerta pendiente
            $alertaExistente = Alerta::where(
                    'id_estacion',
                    $estacion->id_estacion
                )
                ->where('tipo', 'Alta demanda de pasajeros')
                ->where('estado', 'Pendiente')
                ->exists();

            // Crear alerta solamente si no hay otra pendiente
            if (!$alertaExistente) {

                Alerta::create([
                    'id_recorrido' => null,
                    'id_estacion' => $estacion->id_estacion,
                    'tipo' => 'Alta demanda de pasajeros',
                    'descripcion' =>
                        'La estación ' . $estacion->nombre .
                        ' ha alcanzado el ' .
                        number_format($porcentaje, 2) .
                        '% de su capacidad máxima. ' .
                        'Capacidad: ' . $estacion->capacidad_maxima .
                        ' pasajeros. ' .
                        'Pasajeros actuales: ' .
                        $estacion->pasajeros_actuales .
                        '. Se requiere enviar otro bus.',
                    'fecha_hora' => now(),
                    'estado' => 'Pendiente'
                ]);
            }
        }
    }
}
