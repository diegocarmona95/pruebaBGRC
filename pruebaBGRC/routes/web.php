<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Vehiculos
Route::post('/registrarVehiculo', [App\Http\Controllers\VehiculoController::class, 'registrarVehiculo']);
Route::get('/listarVehiculos', [App\Http\Controllers\VehiculoController::class, 'listarVehiculos']);
Route::post('/eliminarVehiculo', [App\Http\Controllers\VehiculoController::class, 'eliminarVehiculo']);

//Personas
Route::get('/listarPersonas', [App\Http\Controllers\PersonaController::class, 'listarPersonas']);
Route::get('/listarPersonasTabla', [App\Http\Controllers\PersonaController::class, 'listarPersonasTabla']);
Route::post('/registrarActualizarPersona', [App\Http\Controllers\PersonaController::class, 'registrarActualizarPersona']);
Route::post('/eliminarPersona', [App\Http\Controllers\PersonaController::class, 'eliminarPersona']);