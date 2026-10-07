<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Municipio;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index()
    {
        $lineas = Linea::with('municipios')->get();

        return view('lineas.index', compact('lineas'));
    }

    public function create()
    {
        $municipios = Municipio::where('estado', true)->get();

        return view('lineas.create', compact('municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'distancia_total' => 'required|numeric|min:0',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
        ]);

        Linea::create([
            'nombre' => $request->nombre,
            'distancia_total' => $request->distancia_total,
            'id_municipio' => $request->id_municipio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('lineas.index')
            ->with('success', 'Línea registrada correctamente.');
    }

    public function show(Linea $linea)
    {
        $linea->load('municipios');

        return view('lineas.show', compact('linea'));
    }

    public function edit(Linea $linea)
    {
        $municipios = Municipio::where('estado', true)->get();

        return view('lineas.edit', compact('linea', 'municipios'));
    }

    public function update(Request $request, Linea $linea)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'distancia_total' => 'required|numeric|min:0',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'estado' => 'required|boolean',
        ]);

        $linea->update([
            'nombre' => $request->nombre,
            'distancia_total' => $request->distancia_total,
            'id_municipio' => $request->id_municipio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('lineas.index')
            ->with('success', 'Línea actualizada correctamente.');
    }

    public function destroy(Linea $linea)
    {
        $linea->delete();

        return redirect()->route('lineas.index')
            ->with('success', 'Línea eliminada correctamente.');
    }
}
