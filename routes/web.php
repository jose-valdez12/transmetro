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


//Rutas de Recorridos
route::get('/recorridos', [RecorridoController::class, 'index'])->name('recorridos.index');
route::get('/recorridos/create', [RecorridoController::class, 'create'])->name('recorridos.create');
route::post('/recorridos', [RecorridoController::class, 'store'])->name('recorridos.store');
route::get('/recorridos/{recorrido}', [RecorridoController::class, 'show'])->name('recorridos.show');
route::get('/recorridos/{recorrido}/edit', [RecorridoController::class, 'edit'])->name('recorridos.edit');
route::put('/recorridos/{recorrido}', [RecorridoController::class, 'update'])->name('recorridos.update');
route::delete('/recorridos/{recorrido}', [RecorridoController::class, 'destroy'])->name('recorridos.destroy');


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
