<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\AsignacionBusLineaController;
use App\Http\Controllers\RecorridoController;
use App\Http\Controllers\VisitaEstacionController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\PilotoController;
use App\Http\Controllers\FormacionPilotoController;
use App\Http\Controllers\AsignacionPilotoController;
use App\Http\Controllers\GuardiaController;
use App\Http\Controllers\AsignacionGuardiaController;
use App\Http\Controllers\ParqueoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;

// AUTENTICACIÓN: estas rutas deben estar disponibles sin sesión.
Route::get('/login', [AuthController::class, 'mostrarLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.procesar');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Política de permisos:
// - Todo usuario autenticado puede consultar los módulos (index y show).
// - Solo Administrador puede crear, editar, eliminar o ejecutar acciones que cambian datos.
// - Gestión de Usuarios sigue siendo exclusiva del Administrador.
// Nota: para usuarios no administradores, ocultar también botones de modificación en las vistas.

// MÓDULOS: solamente accesibles con una sesión iniciada.
Route::middleware('auth')->group(function () {
    // Inicio y dashboard
    Route::get('/', function () { return view('inicio'); });
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // Municipios
    Route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios.index');
    Route::get('/municipios/create', [MunicipioController::class, 'create'])->middleware('rol:Administrador')->name('municipios.create');
    Route::post('/municipios', [MunicipioController::class, 'store'])->middleware('rol:Administrador')->name('municipios.store');
    Route::get('/municipios/{municipios}', [MunicipioController::class, 'show'])->name('municipios.show');
    Route::get('/municipios/{municipios}/edit', [MunicipioController::class, 'edit'])->middleware('rol:Administrador')->name('municipios.edit');
    Route::put('/municipios/{municipios}', [MunicipioController::class, 'update'])->middleware('rol:Administrador')->name('municipios.update');
    Route::delete('/municipios/{municipios}', [MunicipioController::class, 'destroy'])->middleware('rol:Administrador')->name('municipios.destroy');

    // Líneas
    Route::get('/lineas', [LineaController::class, 'index'])->name('lineas.index');
    Route::get('/lineas/create', [LineaController::class, 'create'])->middleware('rol:Administrador')->name('lineas.create');
    Route::post('/lineas', [LineaController::class, 'store'])->middleware('rol:Administrador')->name('lineas.store');
    Route::get('/lineas/{linea}', [LineaController::class, 'show'])->name('lineas.show');
    Route::get('/lineas/{linea}/edit', [LineaController::class, 'edit'])->middleware('rol:Administrador')->name('lineas.edit');
    Route::put('/lineas/{linea}', [LineaController::class, 'update'])->middleware('rol:Administrador')->name('lineas.update');
    Route::delete('/lineas/{linea}', [LineaController::class, 'destroy'])->middleware('rol:Administrador')->name('lineas.destroy');

    // Estaciones
    Route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones.index');
    Route::get('/estaciones/create', [EstacionController::class, 'create'])->middleware('rol:Administrador')->name('estaciones.create');
    Route::post('/estaciones', [EstacionController::class, 'store'])->middleware('rol:Administrador')->name('estaciones.store');
    Route::get('/estaciones/{estacion}', [EstacionController::class, 'show'])->name('estaciones.show');
    Route::get('/estaciones/{estacion}/edit', [EstacionController::class, 'edit'])->middleware('rol:Administrador')->name('estaciones.edit');
    Route::put('/estaciones/{estacion}', [EstacionController::class, 'update'])->middleware('rol:Administrador')->name('estaciones.update');
    Route::delete('/estaciones/{estacion}', [EstacionController::class, 'destroy'])->middleware('rol:Administrador')->name('estaciones.destroy');

    // Accesos
    Route::get('/accesos', [AccesoController::class, 'index'])->name('accesos.index');
    Route::get('/accesos/create', [AccesoController::class, 'create'])->middleware('rol:Administrador')->name('accesos.create');
    Route::post('/accesos', [AccesoController::class, 'store'])->middleware('rol:Administrador')->name('accesos.store');
    Route::get('/accesos/{acceso}/edit', [AccesoController::class, 'edit'])->middleware('rol:Administrador')->name('accesos.edit');
    Route::put('/accesos/{acceso}', [AccesoController::class, 'update'])->middleware('rol:Administrador')->name('accesos.update');
    Route::delete('/accesos/{acceso}', [AccesoController::class, 'destroy'])->middleware('rol:Administrador')->name('accesos.destroy');
    Route::get('/accesos/{acceso}', [AccesoController::class, 'show'])->name('accesos.show');

    // Buses
    Route::get('/buses', [BusController::class, 'index'])->name('buses.index');
    Route::get('/buses/create', [BusController::class, 'create'])->middleware('rol:Administrador')->name('buses.create');
    Route::post('/buses', [BusController::class, 'store'])->middleware('rol:Administrador')->name('buses.store');
    Route::get('/buses/{bus}', [BusController::class, 'show'])->name('buses.show');
    Route::get('/buses/{bus}/edit', [BusController::class, 'edit'])->middleware('rol:Administrador')->name('buses.edit');
    Route::put('/buses/{bus}', [BusController::class, 'update'])->middleware('rol:Administrador')->name('buses.update');
    Route::delete('/buses/{bus}', [BusController::class, 'destroy'])->middleware('rol:Administrador')->name('buses.destroy');

    // Asignación de buses a líneas
    Route::get('/asignacion-bus', [AsignacionBusLineaController::class, 'index'])->name('asignacion-bus.index');
    Route::get('/asignacion-bus/create', [AsignacionBusLineaController::class, 'create'])->middleware('rol:Administrador')->name('asignacion-bus.create');
    Route::post('/asignacion-bus', [AsignacionBusLineaController::class, 'store'])->middleware('rol:Administrador')->name('asignacion-bus.store');
    Route::get('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'show'])->name('asignacion-bus.show');
    Route::get('/asignacion-bus/{asignacion}/edit', [AsignacionBusLineaController::class, 'edit'])->middleware('rol:Administrador')->name('asignacion-bus.edit');
    Route::put('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'update'])->middleware('rol:Administrador')->name('asignacion-bus.update');
    Route::delete('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'destroy'])->middleware('rol:Administrador')->name('asignacion-bus.destroy');
    Route::patch('/asignacion-bus/{id}/finalizar', [AsignacionBusLineaController::class, 'finalizar'])->middleware('rol:Administrador')->name('asignacion-bus.finalizar');

    // Recorridos
    Route::get('/recorridos', [RecorridoController::class, 'index'])->name('recorridos.index');
    Route::get('/recorridos/create', [RecorridoController::class, 'create'])->middleware('rol:Administrador')->name('recorridos.create');
    Route::post('/recorridos', [RecorridoController::class, 'store'])->middleware('rol:Administrador')->name('recorridos.store');
    Route::get('/recorridos/{recorrido}', [RecorridoController::class, 'show'])->name('recorridos.show');
    Route::get('/recorridos/{recorrido}/edit', [RecorridoController::class, 'edit'])->middleware('rol:Administrador')->name('recorridos.edit');
    Route::put('/recorridos/{recorrido}', [RecorridoController::class, 'update'])->middleware('rol:Administrador')->name('recorridos.update');
    Route::delete('/recorridos/{recorrido}', [RecorridoController::class, 'destroy'])->middleware('rol:Administrador')->name('recorridos.destroy');
    Route::patch('/recorridos/{id}/iniciar', [RecorridoController::class, 'iniciar'])->middleware('rol:Administrador')->name('recorridos.iniciar');
    Route::patch('/recorridos/{id}/finalizar', [RecorridoController::class, 'finalizar'])->middleware('rol:Administrador')->name('recorridos.finalizar');

    // Visitas a estaciones
    Route::get('/visitas', [VisitaEstacionController::class, 'index'])->name('visitas.index');
    Route::get('/visitas/create', [VisitaEstacionController::class, 'create'])->middleware('rol:Administrador')->name('visitas.create');
    Route::post('/visitas', [VisitaEstacionController::class, 'store'])->middleware('rol:Administrador')->name('visitas.store');
    Route::get('/visitas/{visita}', [VisitaEstacionController::class, 'show'])->name('visitas.show');
    Route::get('/visitas/{visita}/edit', [VisitaEstacionController::class, 'edit'])->middleware('rol:Administrador')->name('visitas.edit');
    Route::put('/visitas/{visita}', [VisitaEstacionController::class, 'update'])->middleware('rol:Administrador')->name('visitas.update');
    Route::delete('/visitas/{visita}', [VisitaEstacionController::class, 'destroy'])->middleware('rol:Administrador')->name('visitas.destroy');

    // Alertas y asignación de bus por alta demanda
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
    Route::get('/alertas/create', [AlertaController::class, 'create'])->middleware('rol:Administrador')->name('alertas.create');
    Route::post('/alertas', [AlertaController::class, 'store'])->middleware('rol:Administrador')->name('alertas.store');
    Route::get('/alertas/{alerta}', [AlertaController::class, 'show'])->name('alertas.show');
    Route::get('/alertas/{alerta}/edit', [AlertaController::class, 'edit'])->middleware('rol:Administrador')->name('alertas.edit');
    Route::put('/alertas/{alerta}', [AlertaController::class, 'update'])->middleware('rol:Administrador')->name('alertas.update');
    Route::delete('/alertas/{alerta}', [AlertaController::class, 'destroy'])->middleware('rol:Administrador')->name('alertas.destroy');
    Route::get('/alertas/{id}/asignar-bus', [AlertaController::class, 'asignarBus'])->middleware('rol:Administrador')->name('alertas.asignar-bus');
    Route::post('/alertas/{id}/asignar-bus', [AlertaController::class, 'guardarAsignacionBus'])->middleware('rol:Administrador')->name('alertas.guardar-asignacion');

    // Pilotos (sin Route::resource duplicado)
    Route::get('/pilotos', [PilotoController::class, 'index'])->name('pilotos.index');
    Route::get('/pilotos/create', [PilotoController::class, 'create'])->middleware('rol:Administrador')->name('pilotos.create');
    Route::post('/pilotos', [PilotoController::class, 'store'])->middleware('rol:Administrador')->name('pilotos.store');
    Route::get('/pilotos/{id}', [PilotoController::class, 'show'])->name('pilotos.show');
    Route::get('/pilotos/{id}/edit', [PilotoController::class, 'edit'])->middleware('rol:Administrador')->name('pilotos.edit');
    Route::put('/pilotos/{id}', [PilotoController::class, 'update'])->middleware('rol:Administrador')->name('pilotos.update');
    Route::delete('/pilotos/{id}', [PilotoController::class, 'destroy'])->middleware('rol:Administrador')->name('pilotos.destroy');

    // Formación de pilotos
    Route::get('/formacion-pilotos', [FormacionPilotoController::class, 'index'])->name('formacion-pilotos.index');
    Route::get('/formacion-pilotos/create', [FormacionPilotoController::class, 'create'])->middleware('rol:Administrador')->name('formacion-pilotos.create');
    Route::post('/formacion-pilotos', [FormacionPilotoController::class, 'store'])->middleware('rol:Administrador')->name('formacion-pilotos.store');
    Route::get('/formacion-pilotos/{id}', [FormacionPilotoController::class, 'show'])->name('formacion-pilotos.show');
    Route::get('/formacion-pilotos/{id}/edit', [FormacionPilotoController::class, 'edit'])->middleware('rol:Administrador')->name('formacion-pilotos.edit');
    Route::put('/formacion-pilotos/{id}', [FormacionPilotoController::class, 'update'])->middleware('rol:Administrador')->name('formacion-pilotos.update');
    Route::delete('/formacion-pilotos/{id}', [FormacionPilotoController::class, 'destroy'])->middleware('rol:Administrador')->name('formacion-pilotos.destroy');

    // Asignación de pilotos
    Route::get('/asignaciones-pilotos', [AsignacionPilotoController::class, 'index'])->name('asignaciones-pilotos.index');
    Route::get('/asignaciones-pilotos/create', [AsignacionPilotoController::class, 'create'])->middleware('rol:Administrador')->name('asignaciones-pilotos.create');
    Route::post('/asignaciones-pilotos', [AsignacionPilotoController::class, 'store'])->middleware('rol:Administrador')->name('asignaciones-pilotos.store');
    Route::get('/asignaciones-pilotos/{id}', [AsignacionPilotoController::class, 'show'])->name('asignaciones-pilotos.show');
    Route::get('/asignaciones-pilotos/{id}/edit', [AsignacionPilotoController::class, 'edit'])->middleware('rol:Administrador')->name('asignaciones-pilotos.edit');
    Route::put('/asignaciones-pilotos/{id}', [AsignacionPilotoController::class, 'update'])->middleware('rol:Administrador')->name('asignaciones-pilotos.update');
    Route::patch('/asignaciones-pilotos/{id}/finalizar', [AsignacionPilotoController::class, 'finalizar'])->middleware('rol:Administrador')->name('asignaciones-pilotos.finalizar');
    Route::delete('/asignaciones-pilotos/{id}', [AsignacionPilotoController::class, 'destroy'])->middleware('rol:Administrador')->name('asignaciones-pilotos.destroy');

    // Guardias
    Route::get('/guardias', [GuardiaController::class, 'index'])->name('guardias.index');
    Route::get('/guardias/create', [GuardiaController::class, 'create'])->middleware('rol:Administrador')->name('guardias.create');
    Route::post('/guardias', [GuardiaController::class, 'store'])->middleware('rol:Administrador')->name('guardias.store');
    Route::get('/guardias/{id}', [GuardiaController::class, 'show'])->name('guardias.show');
    Route::get('/guardias/{id}/edit', [GuardiaController::class, 'edit'])->middleware('rol:Administrador')->name('guardias.edit');
    Route::put('/guardias/{id}', [GuardiaController::class, 'update'])->middleware('rol:Administrador')->name('guardias.update');
    Route::delete('/guardias/{id}', [GuardiaController::class, 'destroy'])->middleware('rol:Administrador')->name('guardias.destroy');

    // Asignación de guardias: conservar nombre singular
    Route::get('/asignacion-guardia', [AsignacionGuardiaController::class, 'index'])->name('asignacion-guardia.index');
    Route::get('/asignacion-guardia/create', [AsignacionGuardiaController::class, 'create'])->middleware('rol:Administrador')->name('asignacion-guardia.create');
    Route::post('/asignacion-guardia', [AsignacionGuardiaController::class, 'store'])->middleware('rol:Administrador')->name('asignacion-guardia.store');
    Route::get('/asignacion-guardia/{id}', [AsignacionGuardiaController::class, 'show'])->name('asignacion-guardia.show');
    Route::get('/asignacion-guardia/{id}/edit', [AsignacionGuardiaController::class, 'edit'])->middleware('rol:Administrador')->name('asignacion-guardia.edit');
    Route::put('/asignacion-guardia/{id}', [AsignacionGuardiaController::class, 'update'])->middleware('rol:Administrador')->name('asignacion-guardia.update');
    Route::patch('/asignacion-guardia/{id}/finalizar', [AsignacionGuardiaController::class, 'finalizar'])->middleware('rol:Administrador')->name('asignacion-guardia.finalizar');
    Route::delete('/asignacion-guardia/{id}', [AsignacionGuardiaController::class, 'destroy'])->middleware('rol:Administrador')->name('asignacion-guardia.destroy');

    // Parqueos
    Route::get('/parqueos', [ParqueoController::class, 'index'])->name('parqueos.index');
    Route::get('/parqueos/create', [ParqueoController::class, 'create'])->middleware('rol:Administrador')->name('parqueos.create');
    Route::post('/parqueos', [ParqueoController::class, 'store'])->middleware('rol:Administrador')->name('parqueos.store');
    Route::get('/parqueos/{id}', [ParqueoController::class, 'show'])->name('parqueos.show');
    Route::get('/parqueos/{id}/edit', [ParqueoController::class, 'edit'])->middleware('rol:Administrador')->name('parqueos.edit');
    Route::put('/parqueos/{id}', [ParqueoController::class, 'update'])->middleware('rol:Administrador')->name('parqueos.update');
    Route::delete('/parqueos/{id}', [ParqueoController::class, 'destroy'])->middleware('rol:Administrador')->name('parqueos.destroy');

    Route::middleware('rol:Administrador')->group(function () {
        // Usuarios: acceso exclusivo para Administrador.
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});
