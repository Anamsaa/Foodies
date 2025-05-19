<?php

use App\Http\Controllers\RegisterPeopleController;
use App\Http\Controllers\RegisterRestaurantController;
use App\Http\Controllers\LoginRestaurantController;
use App\Http\Controllers\LogoutRestaurantController;
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
### Se realizan con un prefijo diferenciador para evitar incidentes con las rutas
Route::prefix('restaurant')->group(function () {

    // Rutas públicas 
    ## Registro de restaurantes
    Route::get('register', fn() => view('auth.register-rest'))->name('register.restaurant');
    Route::post('register', [RegisterRestaurantController::class, 'store'])->name('register.restaurant');

    ## Login de restaurantes 
    Route::get('login', fn() => view('auth.login-rest'))->name('login.restaurant');
    Route::post('login', [LoginRestaurantController::class, 'login'])->name('login.restaurant');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware('auth:restaurant')->group(function() {
        Route::get('dashboard', fn() => view('restaurantes.principal'))->name('dashboard.restaurant');
        Route::get('perfil', fn() => view('restaurantes.perfil'))->name('perfil.restaurante');
        Route::get('ajustes', fn() => view('restaurantes.ajustes'))->name('ajustes.restaurante');
        Route::get('crear-perfil', fn() => view('restaurantes.creation-rest'))->name('crear.perfil.restaurante');
        Route::get('crear-perfil-2', fn() => view('restaurantes.creation-rest-2'))->name('crear.perfil.restaurante.2');
        Route::post('logout', [LogoutRestaurantController::class, 'logout'])->name('logout.restaurant');
    });
});



//--------------------- RUTAS PÚBLICAS ------------------------
// Route::view('perfil-restaurantes', 'restaurantes.perfil')->name('perfil-rest');
// Route::view('ajustes-restaurantes', 'restaurantes.ajustes')->name('ajustes');
// Route::view('logout-restaurantes', 'restaurantes.logout')->name('logout');
// //Route::view('registro-restaurante', 'auth.register-rest')->name('register-restaurante');
// Route::view('creacioan-perfil-restaurante', 'restaurantes.creation-rest')->name('creacion-restaurantes');
// Route::view('creacion-perfil-restaurante-2', 'restaurantes.creation-rest-2')->name('creacion-restaurantes-2');


// //--------------------- RUTAS PRIVADAS ------------------------
// // Formulario Registro-restaurante 
// Route::get('register-restaurant', function() {
//     return view('auth.register-rest');
// })->name('register.restaurant');

// // Procesar Registro-restaurante
// Route::post('register-restaurant', [RegisterRestaurantController::class, 'store'])->name('register.restaurant');

// // Formulario Login-restaurante 
// Route::get('login-restaurante', function() {
//     return view('auth.login-rest');
// })->name('login.restaurant');

// // Procesar Login-restaurante
// Route::post('login-restaurante', [LoginRestaurantController::class, 'login'])->name('login.restaurant');

// // Entrada del Dashboard-restaurante
// Route::get('dashboard-restaurantes', function() {
//     return view('restaurantes.principal');
// })->middleware('auth:restaurant')->name('dashboard.restaurant');


// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);


