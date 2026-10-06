<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = Municipio::all();

        return view('municipios.index', compact('municipios'));
    }

    public function create()
    {
        return view('municipios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
        ]);

        Municipio::create($request->only([
            'nombre',
            'departamento'
        ]));

        return redirect()
            ->route('municipios.index')
            ->with('success', 'Municipio registrado correctamente.');
    }

    public function show(Municipio $municipio)
    {
        return view('municipios.show', compact('municipio'));
    }

    public function edit(Municipio $municipio)
    {
        return view('municipios.edit', compact('municipio'));
    }

    public function update(Request $request, Municipio $municipio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
        ]);

        $municipio->update($request->only([
            'nombre',
            'departamento'
        ]));

        return redirect()
            ->route('municipios.index')
            ->with('success', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipio $municipio)
    {
        $municipio->delete();

        return redirect()
            ->route('municipios.index')
            ->with('success', 'Municipio eliminado correctamente.');
    }
}
