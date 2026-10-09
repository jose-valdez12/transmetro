<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acceso;
use App\Models\Estacion;

class AccesoController extends Controller
{
    public function index()
    {
        $accesos = Acceso::with('estacion.municipio')->paginate(10);

        return view('accesos.index', compact('accesos'));
    }

    public function create()
    {
        $estaciones = Estacion::where('estado', true)->get();

        return view('accesos.create', compact('estaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_estacion' => 'required|exists:estaciones,id_estacion',
            'estado' => 'required|boolean',
        ]);

        Acceso::create([
            'nombre' => $request->nombre,
            'id_estacion' => $request->id_estacion,
            'estado' => $request->estado,
        ]);

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso registrado correctamente.');
    }

    public function show($id)
    {
        $acceso = Acceso::with('estacion.municipio')->findOrFail($id);

        return view('accesos.show', compact('acceso'));
    }

    public function edit($id)
    {
        $acceso = Acceso::findOrFail($id);

        $estaciones = Estacion::where('estado', true)->get();

        return view('accesos.edit', compact('acceso', 'estaciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_estacion' => 'required|exists:estaciones,id_estacion',
            'estado' => 'required|boolean',
        ]);

        $acceso = Acceso::findOrFail($id);

        $acceso->update([
            'nombre' => $request->nombre,
            'id_estacion' => $request->id_estacion,
            'estado' => $request->estado,
        ]);

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $acceso = Acceso::findOrFail($id);

        $acceso->delete();

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso eliminado correctamente.');
    }
}
