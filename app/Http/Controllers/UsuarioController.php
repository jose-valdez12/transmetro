<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    // ==========================================
    // ROLES PERMITIDOS
    // ==========================================
    private function roles()
    {
        return [
            'Administrador',
            'Encargado de lineas',
            'Operador de estacion',
            'Piloto',
            'Guardia'
        ];
    }

    // ==========================================
    // MOSTRAR TODOS LOS USUARIOS
    // ==========================================
    public function index()
    {
        $usuarios = Usuario::orderByDesc('id_usuario')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE REGISTRO
    // ==========================================
    public function create()
    {
        $roles = $this->roles();

        return view('usuarios.create', compact('roles'));
    }

    // ==========================================
    // GUARDAR NUEVO USUARIO
    // ==========================================
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100'
            ],
            'correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'correo')
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(3)
            ],
            'rol' => [
                'required',
                Rule::in($this->roles())
            ],
            'estado' => [
                'required',
                'boolean'
            ]
        ], [
            'nombre.required' =>
                'El nombre del usuario es obligatorio.',

            'correo.required' =>
                'El correo electrónico es obligatorio.',

            'correo.email' =>
                'Ingrese un correo electrónico válido.',

            'correo.unique' =>
                'Ya existe un usuario registrado con este correo.',

            'password.required' =>
                'La contraseña es obligatoria.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',

            'rol.required' =>
                'Debe seleccionar un rol.',

            'rol.in' =>
                'El rol seleccionado no es válido.',

            'estado.required' =>
                'Debe seleccionar el estado del usuario.'
        ]);

        Usuario::create([
            'nombre' => $datos['nombre'],
            'correo' => $datos['correo'],
            'password' => Hash::make($datos['password']),
            'rol' => $datos['rol'],
            'estado' => $datos['estado']
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario registrado correctamente.'
            );
    }

    // ==========================================
    // MOSTRAR DETALLES DEL USUARIO
    // ==========================================
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);

        return view('usuarios.show', compact('usuario'));
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE EDICIÓN
    // ==========================================
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);

        $roles = $this->roles();

        return view(
            'usuarios.edit',
            compact('usuario', 'roles')
        );
    }

    // ==========================================
    // ACTUALIZAR USUARIO
    // ==========================================
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100'
            ],
            'correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'correo')
                    ->ignore($usuario->id_usuario, 'id_usuario')
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(3)
            ],
            'rol' => [
                'required',
                Rule::in($this->roles())
            ],
            'estado' => [
                'required',
                'boolean'
            ]
        ], [
            'nombre.required' =>
                'El nombre del usuario es obligatorio.',

            'correo.required' =>
                'El correo electrónico es obligatorio.',

            'correo.email' =>
                'Ingrese un correo electrónico válido.',

            'correo.unique' =>
                'El correo ya pertenece a otro usuario.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',

            'rol.in' =>
                'El rol seleccionado no es válido.'
        ]);

        // Evitar desactivar o quitar el rol
        // Administrador al último administrador activo.
        $pierdeAccesoAdministrador =
            $usuario->rol === 'Administrador'
            && $usuario->estado
            && (
                $datos['rol'] !== 'Administrador'
                || (int) $datos['estado'] === 0
            );

        if ($pierdeAccesoAdministrador) {
            $otrosAdministradores = Usuario::where(
                'rol',
                'Administrador'
            )
            ->where('estado', 1)
            ->where('id_usuario', '!=', $usuario->id_usuario)
            ->exists();

            if (!$otrosAdministradores) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'rol' =>
                            'No se puede desactivar o cambiar el rol del último administrador activo.'
                    ]);
            }
        }

        // Actualizar información general
        $usuario->nombre = $datos['nombre'];
        $usuario->correo = $datos['correo'];
        $usuario->rol = $datos['rol'];
        $usuario->estado = $datos['estado'];

        // Actualizar contraseña solamente
        // cuando se ingrese una nueva.
        if (!empty($datos['password'])) {
            $usuario->password = Hash::make(
                $datos['password']
            );
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }

    // ==========================================
    // ELIMINAR USUARIO
    // ==========================================
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Impedir eliminar la propia cuenta
        // cuando la autenticación utiliza Usuario.
        if (
            auth()->check()
            && auth()->user() instanceof Usuario
            && auth()->user()->getAuthIdentifier() == $usuario->id_usuario
        ) {
            return redirect()
                ->route('usuarios.index')
                ->with(
                    'error',
                    'No puede eliminar su propia cuenta.'
                );
        }

        // Evitar eliminar el último administrador activo
        if (
            $usuario->rol === 'Administrador'
            && $usuario->estado
        ) {
            $otrosAdministradores = Usuario::where(
                'rol',
                'Administrador'
            )
            ->where('estado', 1)
            ->where('id_usuario', '!=', $usuario->id_usuario)
            ->exists();

            if (!$otrosAdministradores) {
                return redirect()
                    ->route('usuarios.index')
                    ->with(
                        'error',
                        'No se puede eliminar el último administrador activo.'
                    );
            }
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario eliminado correctamente.'
            );
    }
}
