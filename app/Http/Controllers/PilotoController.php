<?php
namespace App\Http\Controllers;

use App\Models\Piloto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PilotoController extends Controller
{
    // Mostrar todos los pilotos
    public function index()
    {
        $pilotos = Piloto::orderByDesc('id_piloto')
            ->paginate(10);

        return view('pilotos.index', compact('pilotos'));
    }

    // Mostrar formulario para registrar piloto
    public function create()
    {
        return view('pilotos.create');
    }

    // Guardar nuevo piloto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'required|boolean'
        ]);

        Piloto::create($datos);

        return redirect()
            ->route('pilotos.index')
            ->with('success', 'Piloto registrado correctamente.');
    }

    // Mostrar detalles del piloto
    public function show($id)
    {
        $piloto = Piloto::findOrFail($id);

        return view('pilotos.show', compact('piloto'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $piloto = Piloto::findOrFail($id);

        return view('pilotos.edit', compact('piloto'));
    }

    // Actualizar información del piloto
    public function update(Request $request, $id)
    {
        $piloto = Piloto::findOrFail($id);

        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'required|boolean'
        ]);

        // Evitar desactivar pilotos con asignaciones activas
        if (
            !$datos['estado'] &&
            $piloto->estado &&
            $piloto->asignaciones()->where('estado', 1)->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'estado' => 'No se puede desactivar un piloto que tiene asignaciones activas.'
                ]);
        }

        $piloto->update($datos);

        return redirect()
            ->route('pilotos.index')
            ->with('success', 'Piloto actualizado correctamente.');
    }

    // Eliminar piloto
    public function destroy($id)
    {
        $piloto = Piloto::findOrFail($id);

        // Evitar eliminar pilotos con formaciones registradas
        if ($piloto->formaciones()->exists()) {
            return redirect()
                ->route('pilotos.index')
                ->with(
                    'error',
                    'No se puede eliminar el piloto porque tiene formaciones registradas.'
                );
        }

        // Evitar eliminar pilotos con asignaciones registradas
        if ($piloto->asignaciones()->exists()) {
            return redirect()
                ->route('pilotos.index')
                ->with(
                    'error',
                    'No se puede eliminar el piloto porque tiene asignaciones registradas.'
                );
        }

        $piloto->delete();

        return redirect()
            ->route('pilotos.index')
            ->with('success', 'Piloto eliminado correctamente.');
    }
}
