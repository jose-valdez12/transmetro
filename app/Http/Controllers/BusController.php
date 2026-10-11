<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BusController extends Controller
{
    // Mostrar listado de buses
    public function index()
    {
        $buses = Bus::orderBy('id_bus', 'desc')->paginate(10);

        return view('buses.index', compact('buses'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        return view('buses.create');
    }

    // Guardar nuevo bus
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'required|string|max:50|unique:buses,codigo',
            'capacidad_maxima' => 'required|integer|min:1',
            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Asignado',
                    'Mantenimiento',
                    'Fuera de servicio'
                ])
            ]
        ]);

        Bus::create($datos);

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus registrado correctamente.');
    }

    // Mostrar detalles de un bus
    public function show($id)
    {
        $bus = Bus::findOrFail($id);

        return view('buses.show', compact('bus'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $bus = Bus::findOrFail($id);

        return view('buses.edit', compact('bus'));
    }

    // Actualizar bus
    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('buses', 'codigo')
                    ->ignore($bus->id_bus, 'id_bus')
            ],
            'capacidad_maxima' => 'required|integer|min:1',
            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Asignado',
                    'Mantenimiento',
                    'Fuera de servicio'
                ])
            ]
        ]);

        $bus->update($datos);

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus actualizado correctamente.');
    }

    // Eliminar bus
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);

        $bus->delete();

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus eliminado correctamente.');
    }
}
