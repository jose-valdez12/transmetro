<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ==========================================
    // MOSTRAR FORMULARIO DE INICIO DE SESIÓN
    // ==========================================
    public function mostrarLogin()
    {
        // Si el usuario ya inició sesión,
        // enviarlo a la página principal.
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    // ==========================================
    // VALIDAR CREDENCIALES E INICIAR SESIÓN
    // ==========================================
    public function login(Request $request)
    {
        $datos = $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ], [
            'correo.required' => 'Ingrese su correo electrónico.',
            'correo.email' => 'Ingrese un correo válido.',
            'password.required' => 'Ingrese su contraseña.'
        ]);

        // Verificar correo, contraseña y estado.
        $credenciales = [
            'correo' => $datos['correo'],
            'password' => $datos['password'],
            'estado' => 1
        ];

        if (Auth::attempt($credenciales)) {

            // Regenerar la sesión por seguridad.
            $request->session()->regenerate();

            // Redirigir al inicio de Transmetro.
            return redirect()->intended('/');
        }

        // Credenciales incorrectas.
        return back()
            ->withErrors([
                'correo' => 'Correo, contraseña incorrecta o usuario inactivo.'
            ])
            ->onlyInput('correo');
    }

    // ==========================================
    // CERRAR SESIÓN
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with(
                'success',
                'Sesión cerrada correctamente.'
            );
    }
}
