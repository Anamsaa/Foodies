<?php

use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

// Definción de rutas de la red social

// La raíz de mi dominio me retorna al dashboard
Route::view('/', 'foodies.principal')->name('principal');
Route::view('perfil', 'foodies.perfil')->name('perfil');
Route::view('eventos-culinarios', 'foodies.eventos')->name('eventos');
Route::view('seguidos', 'foodies.seguidos')->name('seguidos');
Route::view('red-de-sabores', 'foodies.red')->name('red');
Route::view('ajustes', 'foodies.ajustes')->name('ajustes');
Route::view('logout', 'foodies.logout')->name('logout');
Route::view('login-user', 'foodies.login-user')->name('login');
Route::view('registro', 'foodies.register-user')->name('register');
Route::view('login-restaurante', 'foodies.login-rest')->name('login-restaurante');
Route::view('registro-restaurante', 'foodies.register-rest')->name('register-restaurante');
Route::view('creacion-perfil-restaurante', 'formularios.registro-restaurantes')->name('creacion-restaurantes');
Route::view('creacion-perfil-restaurante-2', 'formularios.registro-restaurantes-2')->name('creacion-restaurantes-2');

Route::get('creacion-perfil', [UbicacionController::class, 'cargarRegiones'])->name('crear-perfil');

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);


