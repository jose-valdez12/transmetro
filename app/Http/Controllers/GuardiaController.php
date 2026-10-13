<?php

namespace App\Http\Controllers;

use App\Models\Guardia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuardiaController extends Controller
{
    // Mostrar listado de guardias
    public function index()
    {
        $guardias = Guardia::orderByDesc('id_guardia')
            ->paginate(10);

        return view('guardias.index', compact('guardias'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        return view('guardias.create');
    }

    // Guardar nuevo guardia
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'estado' => 'required|boolean'
        ]);

        Guardia::create($datos);

        return redirect()
            ->route('guardias.index')
            ->with('success', 'Guardia registrado correctamente.');
    }

    // Mostrar detalles del guardia
    public function show($id)
    {
        $guardia = Guardia::findOrFail($id);

        return view('guardias.show', compact('guardia'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $guardia = Guardia::findOrFail($id);

        return view('guardias.edit', compact('guardia'));
    }

    // Actualizar información del guardia
    public function update(Request $request, $id)
    {
        $guardia = Guardia::findOrFail($id);

        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'estado' => 'required|boolean'
        ]);

        // Impedir desactivar guardias con asignaciones activas
        if ((int) $datos['estado'] === 0) {

            $tieneAsignacionActiva = $guardia->asignaciones()
                ->where('estado', 1)
                ->exists();

            if ($tieneAsignacionActiva) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'estado' => 'No se puede desactivar el guardia porque tiene una asignación activa.'
                    ]);
            }
        }

        $guardia->update($datos);

        return redirect()
            ->route('guardias.index')
            ->with('success', 'Guardia actualizado correctamente.');
    }

    // Eliminar guardia
    public function destroy($id)
    {
        $guardia = Guardia::findOrFail($id);

        // Evitar eliminar guardias con asignaciones registradas
        if ($guardia->asignaciones()->exists()) {
            return redirect()
                ->route('guardias.index')
                ->with(
                    'error',
                    'No se puede eliminar el guardia porque tiene asignaciones registradas.'
                );
        }

        $guardia->delete();

        return redirect()
            ->route('guardias.index')
            ->with('success', 'Guardia eliminado correctamente.');
    }
}
