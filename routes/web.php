<?php

use App\Http\Controllers\RegisterPeopleController;
use App\Http\Controllers\RegisterRestaurantController;
use App\Http\Controllers\LoginRestaurantController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

// DEFINICIÓN DE RUTAS DE LA RED SOCIAL

// RUTAS DE USUARIO PERSONA
Route::view('dashboard', 'personas.principal')->name('principal');
Route::view('perfil', 'personas.perfil')->name('perfil');
Route::view('eventos-culinarios', 'personas.eventos')->name('eventos');
Route::view('seguidos', 'personas.seguidos')->name('seguidos');
Route::view('red-de-sabores', 'personas.red')->name('red');
Route::view('ajustes', 'personas.ajustes')->name('ajustes');
Route::view('logout', 'personas.logout')->name('logout');
Route::view('login-user', 'auth.login-user')->name('login-user');
//Route::view('registro-user', 'auth.register-user')->name('register');
Route::get('creacion-perfil-user', [UbicacionController::class, 'cargarRegiones'])->name('crear-perfil');

// Formulario registro Usuario 
Route::get('register-user', function() {
    return view('auth.register-user');
})->name('register.user.form');

// Datos de registro persona
Route::post('register-user', [RegisterPeopleController::class, 'store'])->name('register.user');

# --------------------------------------------------------------------------------------------------------------------------------------------------------
// RUTAS DE USUARIO RESTAURANTE
Route::view('dashboard-restaurantes', 'restaurantes.principal')->name('dashboard.restaurant');
Route::view('perfil-restaurantes', 'restaurantes.perfil')->name('perfil-rest');
Route::view('ajustes-restaurantes', 'restaurantes.ajustes')->name('ajustes');
Route::view('logout-restaurantes', 'restaurantes.logout')->name('logout');
//Route::view('registro-restaurante', 'auth.register-rest')->name('register-restaurante');
Route::view('creacioan-perfil-restaurante', 'restaurantes.creation-rest')->name('creacion-restaurantes');
Route::view('creacion-perfil-restaurante-2', 'restaurantes.creation-rest-2')->name('creacion-restaurantes-2');

// Formulario Registro-estaurante 
Route::get('register-restaurant', function() {
    return view('auth.register-rest');
})->name('register.restaurant');

// Procesar Registro-restaurante
Route::post('register-restaurant', [RegisterRestaurantController::class, 'store'])->name('register.restaurant');

// Formulario Login-restaurante 
Route::get('login-restaurante', function() {
    return view('auth.login-rest');
})->name('login.restaurant');

// Procesar Login-restaurante
Route::post('login-restaurante', [LoginRestaurantController::class, 'login'])->name('login.restaurant');

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);


