<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Municipio;
use Illuminate\Http\Request;

class EstacionController extends Controller
{
    public function index()
    {
        $estaciones = Estacion::with('municipio')->paginate(10);

        return view('estaciones.index', compact('estaciones'));
    }

    public function create()
    {
        $municipios = Municipio::where('estado', true)->get();

        return view('estaciones.create', compact('municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
        ]);

        Estacion::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'id_municipio' => $request->id_municipio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('estaciones.index')
            ->with('success', 'Estación registrada correctamente.');
    }

   public function show($id)
{
    $estacion = Estacion::with('municipio')->findOrFail($id);

    return view('estaciones.show', compact('estacion'));
}

    public function edit($id)
    {
        $estacion = Estacion::findOrFail($id);

        $municipios = Municipio::where('estado', true)->get();

        return view('estaciones.edit', compact('estacion', 'municipios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
        ]);

        $estacion = Estacion::findOrFail($id);

        $estacion->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'id_municipio' => $request->id_municipio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('estaciones.index')
            ->with('success', 'Estación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $estacion = Estacion::findOrFail($id);

        $estacion->delete();

        return redirect()->route('estaciones.index')
            ->with('success', 'Estación eliminada correctamente.');
    }
}
