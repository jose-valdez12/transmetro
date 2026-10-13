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

//Rutas de todas las vistas de la aplicacion.

Route::get('/', function () {
    return view('inicio');
});

//Rutas de los municipios
route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios.index');
route::get('/municipios/create', [MunicipioController::class, 'create'])->name('municipios.create');
route::post('/municipios', [MunicipioController::class, 'store'])->name('municipios.store');
route::get('/municipios/{municipios}', [MunicipioController::class, 'show'])->name('municipios.show');
route::get('/municipios/{municipios}/edit', [MunicipioController::class, 'edit'])->name('municipios.edit');
route::put('/municipios/{municipios}', [MunicipioController::class, 'update'])->name('municipios.update');
route::delete('/municipios/{municipios}', [MunicipioController::class, 'destroy'])->name('municipios.destroy');


//Rutas de las lineas
route::get('/lineas', [LineaController::class, 'index'])->name('lineas.index');
route::get('/lineas/create', [LineaController::class, 'create'])->name('lineas.create');
route::post('/lineas', [LineaController::class, 'store'])->name('lineas.store');
route::get('/lineas/{linea}', [LineaController::class, 'show'])->name('lineas.show');
route::get('/lineas/{linea}/edit', [LineaController::class, 'edit'])->name('lineas.edit');
route::put('/lineas/{linea}', [LineaController::class, 'update'])->name('lineas.update');
route::delete('/lineas/{linea}', [LineaController::class, 'destroy'])->name('lineas.destroy');


//Rutas de las estaciones
route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones.index');
route::get('/estaciones/create', [EstacionController::class, 'create'])->name('estaciones.create');
route::post('/estaciones', [EstacionController::class, 'store'])->name('estaciones.store');
route::get('/estaciones/{estacion}', [EstacionController::class, 'show'])->name('estaciones.show');
route::get('/estaciones/{estacion}/edit', [EstacionController::class, 'edit'])->name('estaciones.edit');
route::put('/estaciones/{estacion}', [EstacionController::class, 'update'])->name('estaciones.update');
route::delete('/estaciones/{estacion}', [EstacionController::class, 'destroy'])->name('estaciones.destroy');


//Rutas de Accesos
route::get('/accesos', [AccesoController::class, 'index'])->name('accesos.index');
route::get('/accesos/create', [AccesoController::class, 'create'])->name('accesos.create');
route::post('/accesos', [AccesoController::class, 'store'])->name('accesos.store');
route::get('/accesos/{acceso}/edit', [AccesoController::class, 'edit'])->name('accesos.edit');
route::put('/accesos/{acceso}', [AccesoController::class, 'update'])->name('accesos.update');
route::delete('/accesos/{acceso}', [AccesoController::class, 'destroy'])->name('accesos.destroy');
route::get('/accesos/{acceso}', [AccesoController::class, 'show'])->name('accesos.show');


//Rutas de Buses
route::get('/buses', [BusController::class, 'index'])->name('buses.index');
route::get('/buses/create', [BusController::class, 'create'])->name('buses.create');
route::post('/buses', [BusController::class, 'store'])->name('buses.store');
route::get('/buses/{bus}', [BusController::class, 'show'])->name('buses.show');
route::get('/buses/{bus}/edit', [BusController::class, 'edit'])->name('buses.edit');
route::put('/buses/{bus}', [BusController::class, 'update'])->name('buses.update');
route::delete('/buses/{bus}', [BusController::class, 'destroy'])->name('buses.destroy');


//Rutas de Asignaciones de Buses a Lineas
route::get('/asignacion-bus', [AsignacionBusLineaController::class, 'index'])->name('asignacion-bus.index');
route::get('/asignacion-bus/create', [AsignacionBusLineaController::class, 'create'])->name('asignacion-bus.create');
route::post('/asignacion-bus', [AsignacionBusLineaController::class, 'store'])->name('asignacion-bus.store');
route::get('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'show'])->name('asignacion-bus.show');
route::get('/asignacion-bus/{asignacion}/edit', [AsignacionBusLineaController::class, 'edit'])->name('asignacion-bus.edit');
route::put('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'update'])->name('asignacion-bus.update');
route::delete('/asignacion-bus/{asignacion}', [AsignacionBusLineaController::class, 'destroy'])->name('asignacion-bus.destroy');
Route::patch('/asignacion-bus/{id}/finalizar',[AsignacionBusLineaController::class, 'finalizar'])->name('asignacion-bus.finalizar');
Route::resource('asignacion-bus', AsignacionBusLineaController::class);


//Rutas de Recorridos
route::get('/recorridos', [RecorridoController::class, 'index'])->name('recorridos.index');
route::get('/recorridos/create', [RecorridoController::class, 'create'])->name('recorridos.create');
route::post('/recorridos', [RecorridoController::class, 'store'])->name('recorridos.store');
route::get('/recorridos/{recorrido}', [RecorridoController::class, 'show'])->name('recorridos.show');
route::get('/recorridos/{recorrido}/edit', [RecorridoController::class, 'edit'])->name('recorridos.edit');
route::put('/recorridos/{recorrido}', [RecorridoController::class, 'update'])->name('recorridos.update');
route::delete('/recorridos/{recorrido}', [RecorridoController::class, 'destroy'])->name('recorridos.destroy');
Route::patch('/recorridos/{id}/iniciar',[RecorridoController::class, 'iniciar'])->name('recorridos.iniciar');
Route::patch( '/recorridos/{id}/finalizar', [RecorridoController::class, 'finalizar'])->name('recorridos.finalizar');


//Rutas de Visita a Estaciones
route::get('/visitas', [VisitaEstacionController::class, 'index'])->name('visitas.index');
route::get('/visitas/create', [VisitaEstacionController::class, 'create'])->name('visitas.create');
route::post('/visitas', [VisitaEstacionController::class, 'store'])->name('visitas.store');
route::get('/visitas/{visita}', [VisitaEstacionController::class, 'show'])->name('visitas.show');
route::get('/visitas/{visita}/edit', [VisitaEstacionController::class, 'edit'])->name('visitas.edit');
route::put('/visitas/{visita}', [VisitaEstacionController::class, 'update'])->name('visitas.update');
route::delete('/visitas/{visita}', [VisitaEstacionController::class, 'destroy'])->name('visitas.destroy');


//Rutas de Alertas
route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
route::get('/alertas/create', [AlertaController::class, 'create'])->name('alertas.create');
route::post('/alertas', [AlertaController::class, 'store'])->name('alertas.store');
route::get('/alertas/{alerta}', [AlertaController::class, 'show'])->name('alertas.show');
route::get('/alertas/{alerta}/edit', [AlertaController::class, 'edit'])->name('alertas.edit');
route::put('/alertas/{alerta}', [AlertaController::class, 'update'])->name('alertas.update');
route::delete('/alertas/{alerta}', [AlertaController::class, 'destroy'])->name('alertas.destroy');
route::get('/alertas/{id}/asignar-bus', [AlertaController::class, 'asignarBus'])->name('alertas.asignar-bus');
route::post('/alertas/{id}/asignar-bus',[AlertaController::class, 'guardarAsignacionBus']) ->name('alertas.guardar-asignacion');



//Rutas de Piloto
Route::resource('pilotos', PilotoController::class);
Route::get('/pilotos', [PilotoController::class, 'index']) ->name('pilotos.index');
Route::get('/pilotos/create', [PilotoController::class, 'create']) ->name('pilotos.create');
Route::post('/pilotos', [PilotoController::class, 'store'])->name('pilotos.store');
Route::get('/pilotos/{id}', [PilotoController::class, 'show']) ->name('pilotos.show');
Route::get('/pilotos/{id}/edit', [PilotoController::class, 'edit'])->name('pilotos.edit');
Route::put('/pilotos/{id}', [PilotoController::class, 'update'])->name('pilotos.update');
Route::delete('/pilotos/{id}', [PilotoController::class, 'destroy'])->name('pilotos.destroy');




 // RUTAS DE FORMACIÓN DE PILOTOS
route::get('/formacion-pilotos', [FormacionPilotoController::class, 'index']) ->name('formacion-pilotos.index');
route::get('/formacion-pilotos/create', [FormacionPilotoController::class, 'create']) ->name('formacion-pilotos.create');
route::post('/formacion-pilotos', [FormacionPilotoController::class, 'store']) ->name('formacion-pilotos.store');
route::get('/formacion-pilotos/{id}',[FormacionPilotoController::class, 'show']) ->name('formacion-pilotos.show');
route::get('/formacion-pilotos/{id}/edit',  [FormacionPilotoController::class, 'edit'])->name('formacion-pilotos.edit');
route::put('/formacion-pilotos/{id}',  [FormacionPilotoController::class, 'update']) ->name('formacion-pilotos.update');
route::delete('/formacion-pilotos/{id}', [FormacionPilotoController::class, 'destroy'])  ->name('formacion-pilotos.destroy');



// GESTIÓN DE ASIGNACIÓN DE PILOTOS
route::get('/asignaciones-pilotos',[AsignacionPilotoController::class, 'index']) ->name('asignaciones-pilotos.index');
route::get('/asignaciones-pilotos/create', [AsignacionPilotoController::class, 'create']) ->name('asignaciones-pilotos.create');
route::post('/asignaciones-pilotos', [AsignacionPilotoController::class, 'store']) ->name('asignaciones-pilotos.store');
route::get('/asignaciones-pilotos/{id}',  [AsignacionPilotoController::class, 'show']) ->name('asignaciones-pilotos.show');
route::get('/asignaciones-pilotos/{id}/edit', [AsignacionPilotoController::class, 'edit']) ->name('asignaciones-pilotos.edit');
route::put('/asignaciones-pilotos/{id}', [AsignacionPilotoController::class, 'update'])  ->name('asignaciones-pilotos.update');
route::patch('/asignaciones-pilotos/{id}/finalizar', [AsignacionPilotoController::class, 'finalizar']) ->name('asignaciones-pilotos.finalizar');
route::delete('/asignaciones-pilotos/{id}', [AsignacionPilotoController::class, 'destroy']) ->name('asignaciones-pilotos.destroy');


//Rutas de Guardia
// Listado de guardias
Route::get('/guardias',
    [GuardiaController::class, 'index'])
    ->name('guardias.index');

// Formulario de registro
Route::get('/guardias/create',
    [GuardiaController::class, 'create'])
    ->name('guardias.create');

// Guardar guardia
Route::post('/guardias',
    [GuardiaController::class, 'store'])
    ->name('guardias.store');

// Mostrar detalles
Route::get('/guardias/{id}',
    [GuardiaController::class, 'show'])
    ->name('guardias.show');

// Formulario de edición
Route::get('/guardias/{id}/edit',
    [GuardiaController::class, 'edit'])
    ->name('guardias.edit');

// Actualizar guardia
Route::put('/guardias/{id}',
    [GuardiaController::class, 'update'])
    ->name('guardias.update');

// Eliminar guardia
Route::delete('/guardias/{id}',
    [GuardiaController::class, 'destroy'])
    ->name('guardias.destroy');
