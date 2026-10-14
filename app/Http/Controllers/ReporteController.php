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

    public function recorridos()
{
    $recorridos = Recorrido::all();

    return view('reportes.recorridos', compact('recorridos'));
}
public function pilotos()
{
    $pilotos = Piloto::all();

    return view('reportes.pilotos', compact('pilotos'));
}
public function guardias()
{
    $guardias = Guardia::all();

    return view('reportes.guardias', compact('guardias'));
}
public function estaciones()
{
    $estaciones = Estacion::all();

    return view('reportes.estaciones', compact('estaciones'));
}
public function alertas()
{
    $alertas = Alerta::all();

    return view('reportes.alertas', compact('alertas'));
}
public function municipios()
{
    $municipios = Municipio::all();

    return view('reportes.municipios', compact('municipios'));
}
public function lineas()
{
    $lineas = Linea::all();

    return view('reportes.lineas', compact('lineas'));
}
public function parqueos()
{
    $parqueos = Parqueo::all();

    return view('reportes.parqueos', compact('parqueos'));
}
}
