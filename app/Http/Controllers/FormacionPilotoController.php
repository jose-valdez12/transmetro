<?php

namespace App\http\Controllers;

use App\Models\FormacionPiloto;
use App\Models\Piloto;
use Illuminate\Http\Request;

class FormacionPilotoController extends Controller
{
    // Mostrar todas las formaciones
    public function index()
    {
        $formaciones = FormacionPiloto::with('piloto')
            ->orderByDesc('id_formacion')
            ->paginate(10);

        return view('formacion-pilotos.index', compact('formaciones'));
    }

    // Mostrar formulario para registrar formación
    public function create()
    {
        $pilotos = Piloto::where('estado', 1)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('formacion-pilotos.create', compact('pilotos'));
    }

    // Guardar nueva formación
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_piloto' => 'required|integer|exists:pilotos,id_piloto',
            'institucion' => 'required|string|max:150',
            'titulo' => 'required|string|max:150',
            'fecha' => 'nullable|date'
        ]);

        // Verificar que el piloto esté activo
        $piloto = Piloto::findOrFail($datos['id_piloto']);

        if (!$piloto->estado) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_piloto' => 'El piloto seleccionado está inactivo.'
                ]);
        }

        FormacionPiloto::create($datos);

        return redirect()
            ->route('formacion-pilotos.index')
            ->with('success', 'Formación registrada correctamente.');
    }

    // Mostrar detalles de una formación
    public function show($id)
    {
        $formacion = FormacionPiloto::with('piloto')
            ->findOrFail($id);

        return view('formacion-pilotos.show', compact('formacion'));
    }

    // Mostrar formulario para editar formación
    public function edit($id)
    {
        $formacion = FormacionPiloto::findOrFail($id);

        // Incluir pilotos activos y el piloto actual
        $pilotos = Piloto::where('estado', 1)
            ->orWhere('id_piloto', $formacion->id_piloto)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('formacion-pilotos.edit', compact(
            'formacion',
            'pilotos'
        ));
    }

    // Actualizar formación
    public function update(Request $request, $id)
    {
        $formacion = FormacionPiloto::findOrFail($id);

        $datos = $request->validate([
            'id_piloto' => 'required|integer|exists:pilotos,id_piloto',
            'institucion' => 'required|string|max:150',
            'titulo' => 'required|string|max:150',
            'fecha' => 'nullable|date'
        ]);

        // Si cambia el piloto, debe estar activo
        if ($formacion->id_piloto != $datos['id_piloto']) {
            $piloto = Piloto::findOrFail($datos['id_piloto']);

            if (!$piloto->estado) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'id_piloto' => 'No se puede asignar la formación a un piloto inactivo.'
                    ]);
            }
        }

        $formacion->update($datos);

        return redirect()
            ->route('formacion-pilotos.index')
            ->with('success', 'Formación actualizada correctamente.');
    }

    // Eliminar formación
    public function destroy($id)
    {
        $formacion = FormacionPiloto::findOrFail($id);

        $formacion->delete();

        return redirect()
            ->route('formacion-pilotos.index')
            ->with('success', 'Formación eliminada correctamente.');
    }
}
