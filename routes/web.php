<?php

use App\Http\Controllers\RegisterPeopleController;
use App\Http\Controllers\RegisterRestaurantController;
use App\Http\Controllers\LoginRestaurantController;
use App\Http\Controllers\LogoutRestaurantController;
use App\Http\Controllers\LoginPeopleController;
use App\Http\Controllers\LogoutPeopleController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

// DEFINICIÓN DE RUTAS DE LA RED SOCIAL

Route::get('creacion-perfil-user', [UbicacionController::class, 'cargarRegiones'])->name('crear-perfil');

# --------------------------------------------------------------------------------------------------------------------------------------------------------

// RUTAS DE USUARIO PERSONA
### Se realizan con un prefijo diferenciador para evitar incidentes con las rutas
Route::prefix('user')->group(function () {

    // Rutas públicas 
    ## Registro de restaurantes
    Route::get('register', fn() => view('auth.register-user'))->name('register.user');
    Route::post('register', [RegisterPeopleController::class, 'store'])->name('register.user');

    ## Login de restaurantes 
    Route::get('login', fn() => view('auth.login-user'))->name('login.user');
    Route::post('login', [LoginPeopleController::class, 'login'])->name('login.user');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware(['auth:user', 'prevent-back-history'])->group(function() {
        Route::get('dashboard', fn() => view('personas.principal'))->name('dashboard.user');
        Route::get('perfil', fn() => view('personas.perfil'))->name('perfil.user');
        Route::get('red-de-sabores', fn() => view('personas.perfil'))->name('red.user');
        Route::get('seguidos', fn() => view('personas.perfil'))->name('seguidos.user');
        Route::get('eventos-culinarios', fn() => view('personas.perfil'))->name('eventos.user');
        Route::get('ajustes', fn() => view('personas.ajustes'))->name('ajustes.user');
        Route::get('crear-perfil', fn() => view('personas.creation-rest'))->name('crear.perfil.user');
        Route::get('crear-perfil-2', fn() => view('personas.creation-rest-2'))->name('crear.perfil.user.2');
        Route::post('logout', [LogoutPeopleController::class, 'logout'])->name('logout.user');
    });
});

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
    Route::middleware(['auth:restaurant', 'prevent-back-history'])->group(function() {
        Route::get('dashboard', fn() => view('restaurantes.principal'))->name('dashboard.restaurant');
        Route::get('perfil', fn() => view('restaurantes.perfil'))->name('perfil.restaurante');
        Route::get('ajustes', fn() => view('restaurantes.ajustes'))->name('ajustes.restaurante');
        Route::get('crear-perfil', fn() => view('restaurantes.creation-rest'))->name('crear.perfil.restaurante');
        Route::get('crear-perfil-2', fn() => view('restaurantes.creation-rest-2'))->name('crear.perfil.restaurante.2');
        Route::post('logout', [LogoutRestaurantController::class, 'logout'])->name('logout.restaurant');
    });
});

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);


