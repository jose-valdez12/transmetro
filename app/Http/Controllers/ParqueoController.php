<?php
namespace App\Http\Controllers;

use App\Models\Parqueo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParqueoController extends Controller
{
    // ==========================================
    // MOSTRAR TODOS LOS PARQUEOS
    // ==========================================
    public function index()
    {
        $parqueos = Parqueo::orderByDesc('id_parqueo')
            ->paginate(10);

        return view('parqueos.index', compact('parqueos'));
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE REGISTRO
    // ==========================================
    public function create()
    {
        return view('parqueos.create');
    }

    // ==========================================
    // GUARDAR NUEVO PARQUEO
    // ==========================================
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                'unique:parqueos,codigo'
            ],
            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Ocupado',
                    'Mantenimiento'
                ])
            ]
        ], [
            'codigo.required' =>
                'El código del parqueo es obligatorio.',

            'codigo.unique' =>
                'Ya existe un parqueo registrado con este código.',

            'codigo.max' =>
                'El código no puede superar los 50 caracteres.',

            'estado.required' =>
                'Debe seleccionar el estado del parqueo.',

            'estado.in' =>
                'El estado seleccionado no es válido.'
        ]);

        Parqueo::create($datos);

        return redirect()
            ->route('parqueos.index')
            ->with(
                'success',
                'Parqueo registrado correctamente.'
            );
    }

    // ==========================================
    // MOSTRAR DETALLES DEL PARQUEO
    // ==========================================
    public function show($id)
    {
        $parqueo = Parqueo::findOrFail($id);

        return view('parqueos.show', compact('parqueo'));
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE EDICIÓN
    // ==========================================
    public function edit($id)
    {
        $parqueo = Parqueo::findOrFail($id);

        return view('parqueos.edit', compact('parqueo'));
    }

    // ==========================================
    // ACTUALIZAR PARQUEO
    // ==========================================
    public function update(Request $request, $id)
    {
        $parqueo = Parqueo::findOrFail($id);

        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('parqueos', 'codigo')
                    ->ignore($parqueo->id_parqueo, 'id_parqueo')
            ],
            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Ocupado',
                    'Mantenimiento'
                ])
            ]
        ], [
            'codigo.required' =>
                'El código del parqueo es obligatorio.',

            'codigo.unique' =>
                'El código ingresado ya pertenece a otro parqueo.',

            'codigo.max' =>
                'El código no puede superar los 50 caracteres.',

            'estado.required' =>
                'Debe seleccionar el estado del parqueo.',

            'estado.in' =>
                'El estado seleccionado no es válido.'
        ]);

        $parqueo->update($datos);

        return redirect()
            ->route('parqueos.index')
            ->with(
                'success',
                'Parqueo actualizado correctamente.'
            );
    }

    // ==========================================
    // ELIMINAR PARQUEO
    // ==========================================
    public function destroy($id)
    {
        $parqueo = Parqueo::findOrFail($id);

        $parqueo->delete();

        return redirect()
            ->route('parqueos.index')
            ->with(
                'success',
                'Parqueo eliminado correctamente.'
            );
    }
}
