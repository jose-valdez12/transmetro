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
        'estado' => 'required|boolean',
    ]);

    Municipio::create($request->only([
        'nombre',
        'departamento',
        'estado'
    ]));

    return redirect()->route('municipios.index')
        ->with('success', 'Municipio registrado correctamente.');
}

    public function show(Municipio $municipios)
    {
        return view('municipios.show', compact('municipios'));
    }

    public function edit(Municipio $municipios)
    {
        return view('municipios.edit', compact('municipios'));
    }

    public function update(Request $request, Municipio $municipios)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'estado' => 'required|boolean',
            'departamento' => 'required|string|max:100'
        ]);

        $municipios->update($request->only([
            'nombre',
            'estado',
            'departamento'
        ]));

        return redirect()
            ->route('municipios.index')
            ->with('success', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipio $municipios)
    {
        $municipios->delete();

        return redirect()
            ->route('municipios.index')
            ->with('success', 'Municipio eliminado correctamente.');
    }
}
