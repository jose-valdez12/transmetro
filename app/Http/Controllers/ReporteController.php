<?php
namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Recorrido;
use App\Models\Piloto;
use App\Models\Guardia;
use App\Models\Estacion;
use App\Models\Alerta;
use App\Models\Municipio;
use App\Models\Linea;
use App\Models\Parqueo;
use Illuminate\Http\Request;


class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }


public function buses(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');

    $consulta = Bus::query();

    // Buscar por código del bus
    if ($busqueda !== '') {
        $consulta->where('codigo', 'like', '%' . $busqueda . '%');
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Obtener resultados
    $buses = $consulta->orderBy('id_bus', 'desc')->get();

    // Estados disponibles para el filtro
    $estados = Bus::query()
        ->whereNotNull('estado')
        ->distinct()
        ->orderBy('estado')
        ->pluck('estado');

    return view('reportes.buses', compact(
        'buses',
        'busqueda',
        'estado',
        'estados'
    ));
}

public function recorridos(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');
    $fechaInicio = $request->input('fecha_inicio', '');
    $fechaFin = $request->input('fecha_fin', '');

    $consulta = Recorrido::with(['bus', 'linea']);

    // Buscar por código del bus
    if ($busqueda !== '') {
        $consulta->whereHas('bus', function ($query) use ($busqueda) {
            $query->where('codigo', 'like', '%' . $busqueda . '%');
        });
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Filtrar por fecha inicial
    if ($fechaInicio !== '') {
        $consulta->whereDate('fecha', '>=', $fechaInicio);
    }

    // Filtrar por fecha final
    if ($fechaFin !== '') {
        $consulta->whereDate('fecha', '<=', $fechaFin);
    }

    // Obtener recorridos
    $recorridos = $consulta
        ->orderBy('fecha', 'desc')
        ->orderBy('id_recorrido', 'desc')
        ->get();

    // Obtener estados disponibles
    $estados = Recorrido::query()
        ->whereNotNull('estado')
        ->distinct()
        ->orderBy('estado')
        ->pluck('estado');

    return view('reportes.recorridos', compact(
        'recorridos',
        'busqueda',
        'estado',
        'fechaInicio',
        'fechaFin',
        'estados'
    ));
}


public function pilotos(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');

    $consulta = Piloto::query();

    // Buscar por nombres, apellidos o teléfono
    if ($busqueda !== '') {
        $consulta->where(function ($query) use ($busqueda) {
            $query->where('nombres', 'like', '%' . $busqueda . '%')
                  ->orWhere('apellidos', 'like', '%' . $busqueda . '%')
                  ->orWhere('telefono', 'like', '%' . $busqueda . '%');
        });
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Obtener pilotos ordenados por nombre
    $pilotos = $consulta
        ->orderBy('nombres', 'asc')
        ->orderBy('apellidos', 'asc')
        ->get();

    return view('reportes.pilotos', compact(
        'pilotos',
        'busqueda',
        'estado'
    ));
}

public function guardias(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');

    $consulta = Guardia::query();

    // Buscar por nombres, apellidos o teléfono
    if ($busqueda !== '') {
        $consulta->where(function ($query) use ($busqueda) {
            $query->where('nombres', 'like', '%' . $busqueda . '%')
                  ->orWhere('apellidos', 'like', '%' . $busqueda . '%')
                  ->orWhere('telefono', 'like', '%' . $busqueda . '%');
        });
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Obtener guardias ordenados alfabéticamente
    $guardias = $consulta
        ->orderBy('nombres', 'asc')
        ->orderBy('apellidos', 'asc')
        ->get();

    return view('reportes.guardias', compact(
        'guardias',
        'busqueda',
        'estado'
    ));
}

public function estaciones(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');
    $municipio = $request->input('municipio', '');

    $consulta = Estacion::with('municipio');

    // Buscar por nombre o dirección
    if ($busqueda !== '') {
        $consulta->where(function ($query) use ($busqueda) {
            $query->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('direccion', 'like', '%' . $busqueda . '%');
        });
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Filtrar por municipio
    if ($municipio !== '') {
        $consulta->where('id_municipio', $municipio);
    }

    // Obtener estaciones
    $estaciones = $consulta
        ->orderBy('nombre', 'asc')
        ->get();

    // Obtener municipios para el filtro
    $municipios = \App\Models\Municipio::orderBy('id_municipio')
        ->get();

    return view('reportes.estaciones', compact(
        'estaciones',
        'municipios',
        'busqueda',
        'estado',
        'municipio'
    ));
}

public function alertas(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $tipo = $request->input('tipo', '');
    $estado = $request->input('estado', '');
    $fechaInicio = $request->input('fecha_inicio', '');
    $fechaFin = $request->input('fecha_fin', '');

    $consulta = Alerta::with(['estacion', 'recorrido']);

    // Buscar por descripción o nombre de estación
    if ($busqueda !== '') {
        $consulta->where(function ($query) use ($busqueda) {
            $query->where('descripcion', 'like', '%' . $busqueda . '%')
                  ->orWhereHas('estacion', function ($subconsulta) use ($busqueda) {
                      $subconsulta->where('nombre', 'like', '%' . $busqueda . '%');
                  });
        });
    }

    // Filtrar por tipo
    if ($tipo !== '') {
        $consulta->where('tipo', $tipo);
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Filtrar desde una fecha
    if ($fechaInicio !== '') {
        $consulta->whereDate('fecha_hora', '>=', $fechaInicio);
    }

    // Filtrar hasta una fecha
    if ($fechaFin !== '') {
        $consulta->whereDate('fecha_hora', '<=', $fechaFin);
    }

    // Obtener alertas
    $alertas = $consulta
        ->orderBy('fecha_hora', 'desc')
        ->orderBy('id_alerta', 'desc')
        ->get();

    // Tipos registrados en la base de datos
    $tipos = Alerta::query()
        ->whereNotNull('tipo')
        ->distinct()
        ->orderBy('tipo')
        ->pluck('tipo');

    // Estados registrados en la base de datos
    $estados = Alerta::query()
        ->whereNotNull('estado')
        ->distinct()
        ->orderBy('estado')
        ->pluck('estado');

    return view('reportes.alertas', compact(
        'alertas',
        'busqueda',
        'tipo',
        'estado',
        'fechaInicio',
        'fechaFin',
        'tipos',
        'estados'
    ));
}

public function municipios(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');

    $consulta = Municipio::query();

    // Buscar por nombre o departamento
    if ($busqueda !== '') {
        $consulta->where(function ($query) use ($busqueda) {
            $query->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('departamento', 'like', '%' . $busqueda . '%');
        });
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Obtener municipios ordenados alfabéticamente
    $municipios = $consulta
        ->orderBy('nombre', 'asc')
        ->get();

    return view('reportes.municipios', compact(
        'municipios',
        'busqueda',
        'estado'
    ));
}

public function lineas(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');
    $municipio = $request->input('municipio', '');

    // Consultar líneas con sus municipios
    // y contar las estaciones asociadas
    $consulta = Linea::with('municipio')
        ->withCount('estaciones');

    // Buscar por nombre de línea
    if ($busqueda !== '') {
        $consulta->where('nombre', 'like', '%' . $busqueda . '%');
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Filtrar por municipio
    if ($municipio !== '') {
        $consulta->where('id_municipio', $municipio);
    }

    // Obtener líneas ordenadas alfabéticamente
    $lineas = $consulta
        ->orderBy('nombre', 'asc')
        ->get();

    // Municipios disponibles para el filtro
    $municipios = Municipio::orderBy('nombre', 'asc')
        ->get();

    return view('reportes.lineas', compact(
        'lineas',
        'municipios',
        'busqueda',
        'estado',
        'municipio'
    ));
}

public function parqueos(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));
    $estado = $request->input('estado', '');

    $consulta = Parqueo::query();

    // Buscar parqueos por código
    if ($busqueda !== '') {
        $consulta->where(
            'codigo',
            'like',
            '%' . $busqueda . '%'
        );
    }

    // Filtrar por estado
    if ($estado !== '') {
        $consulta->where('estado', $estado);
    }

    // Obtener parqueos ordenados por código
    $parqueos = $consulta
        ->orderBy('codigo', 'asc')
        ->get();

    // Obtener los estados registrados en MySQL
    $estados = Parqueo::query()
        ->whereNotNull('estado')
        ->distinct()
        ->orderBy('estado')
        ->pluck('estado');

    return view('reportes.parqueos', compact(
        'parqueos',
        'busqueda',
        'estado',
        'estados'
    ));
}
}
