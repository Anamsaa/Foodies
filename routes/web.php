<?php

use App\Http\Controllers\RegisterPeopleController;
use App\Http\Controllers\RegisterRestaurantController;
use App\Http\Controllers\LoginRestaurantController;
use App\Http\Controllers\LogoutRestaurantController;
use App\Http\Controllers\LoginPeopleController;
use App\Http\Controllers\LogoutPeopleController;
use App\Http\Controllers\RestaurantProfileController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

// DEFINICIÓN DE RUTAS DE LA RED SOCIAL

// RUTA AL DASHBOARD (Página principal de introducción)
Route::get('/', fn()=>view('landing'))->name('landing');
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

    // Pruebas de funcionamiento de creación de perfiles (rutas temporales):
    Route::get('crear-perfil', fn() => view('personas.creation-user'))->name('crear.perfil.user');
    Route::get('creacion-perfil-user', [UbicacionController::class, 'cargarRegiones'])->name('crear-perfil');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware(['auth:user', 'prevent-back-history'])->group(function() {
        Route::get('dashboard', fn() => view('personas.principal'))->name('dashboard.user');
        Route::get('perfil', fn() => view('personas.perfil'))->name('perfil.user');
        Route::get('red-de-sabores', fn() => view('personas.perfil'))->name('red.user');
        Route::get('seguidos', fn() => view('personas.perfil'))->name('seguidos.user');
        Route::get('eventos-culinarios', fn() => view('personas.perfil'))->name('eventos.user');
        Route::get('ajustes', fn() => view('personas.ajustes'))->name('ajustes.user');
        //Route::get('crear-perfil', fn() => view('personas.creation-user'))->name('crear.perfil.user');
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

    // Pruebas de formularios (No son definitivas)
    //Route::get('crear-perfil', fn() => view('restaurantes.creation-rest'))->name('crear.perfil.restaurante');
    //Route::view('crear-perfil-restaurante-2', 'restaurantes.creation-rest-2')->name('crear-perfil.restaurante-2');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware(['auth:restaurant', 'prevent-back-history'])->group(function() {
        Route::get('dashboard', fn() => view('restaurantes.principal'))->name('dashboard.restaurant');
        Route::get('perfil', fn() => view('restaurantes.perfil'))->name('perfil.restaurante');
        Route::get('ajustes', fn() => view('restaurantes.ajustes'))->name('ajustes.restaurante');

        // Creación del perfil de restaurnate en 2 pasos 
        ### 1 paso 
        Route::get('crear-perfil-restaurante', [RestaurantProfileController::class, 'showStep1'])->name('crear-perfil.restaurante');
        Route::post('crear-perfil-restaurante', [RestaurantProfileController::class, 'saveStep1'])->name('crear-perfil.restaurante.guardar');

        ### 2 paso 
        Route::get('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'showStep2'])->name('crear-perfil.restaurante-2');
        Route::post('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'saveStep2']);

        Route::post('logout', [LogoutRestaurantController::class, 'logout'])->name('logout.restaurant');
    });
});

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);


