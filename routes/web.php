<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Definción de rutas de la red social

// La raíz de mi dominio me retorna al dashboard
Route::view('/', 'foodies.principal')->name('principal');
Route::view('perfil', 'foodies.perfil')->name('perfil');
Route::view('eventos-culinarios', 'foodies.eventos')->name('eventos');
Route::view('seguidos', 'foodies.seguidos')->name('seguidos');
Route::view('red-de-sabores', 'foodies.red')->name('red');
Route::view('ajustes', 'foodies.ajustes')->name('ajustes');
Route::view('log-out', 'foodies.logout')->name('logout');
Route::view('registro', 'formularios.registro-usuario')->name('usuarios');

