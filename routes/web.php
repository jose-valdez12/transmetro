<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LineaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



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
