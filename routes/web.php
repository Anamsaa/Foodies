<?php

use App\Http\Controllers\RegisterPeopleController;
use App\Http\Controllers\RegisterRestaurantController;
use App\Http\Controllers\LoginRestaurantController;
use App\Http\Controllers\LogoutRestaurantController;
use App\Http\Controllers\LoginPeopleController;
use App\Http\Controllers\LogoutPeopleController;
use App\Http\Controllers\RestaurantProfileController;
use App\Http\Controllers\PeopleProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UbicacionController;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Route;

// DEFINICIÓN DE RUTAS DE LA RED SOCIAL

// RUTA AL DASHBOARD (Página principal de introducción)
Route::get('/', fn()=>view('landing'))->name('landing');
# --------------------------------------------------------------------------------------------------------------------------------------------------------

// ACTUAL EDICIÓN DE PLANTILLAS: 
Route::view('perfil-prueba',('layouts.layout-perfil'))->name('layout-perfil.user');

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

        ## Dashboard usuarios
        Route::get('dashboard', [PeopleProfileController::class, 'mostrarDashboard'])->name('dashboard.user');

        ## Creación de perfil para usarios 
        Route::get('crear-perfil-restaurante', [PeopleProfileController::class, 'showForm'])->name('crear-perfil.user');
        Route::post('crear-perfil-restaurante', [PeopleProfileController::class, 'guardarDatos'])->name('crear-perfil.guardar');

        ## Redirigir al perfil del usuario propietario
        Route::get('perfil', [PeopleProfileController::class, 'verMiPerfil'])->name('perfil.user');
        ## Redirigir al perfil de otros usuarios
        Route::get('perfil/{profile}', [PeopleProfileController::class, 'verPerfilAjeno'])->name('perfil.user.ajeno');

        // Subir y actualizar fotos de perfil y portada 
        Route::post('profile/update-photos', [PeopleProfileController::class, 'actualizarFotos'])->name('profile.photos.update');

        //------------------------ PUBLICACIONES---------------------------------------//
        // POSTS
        ## Redactar Post Regular 
        Route::get('redactar-post', fn() => view('compartidas.form-posts'))->name('redactar.post');
        ## Registrar Post Regular 
        Route::post('redactar-post', [PostController::class, 'store'])->name('post.store');
        ## Modificar Post
        Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');  
        ## Eliminar Post
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

        // RESEÑAS 
        ## Redactar reseñas
        Route::get('crear-reseña', fn () => view('personas.formulario-reseña'))->name('redactar.review');

        // EVENTOS CULINARIOS
        ## Redactar Eventos Culinarios
        Route::get('crear-evento', fn () => view('personas.formulario-evento'))->name('redactar.evento');

        Route::get('red-de-sabores', fn() => view('personas.red'))->name('red.user');
        Route::get('seguidos', fn() => view('personas.seguidos'))->name('seguidos.user');
        Route::get('eventos-culinarios', fn() => view('personas.eventos'))->name('eventos.user');
        Route::get('ajustes', fn() => view('personas.ajustes'))->name('ajustes.user');
        
        ## Logout
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

        ## Dashboard restaurantes
        Route::get('dashboard', fn() => view('restaurantes.principal'))->name('dashboard.restaurant');
        
        // Creación del perfil de restaurnate en 2 pasos 
        ### 1 paso 
        Route::get('crear-perfil-restaurante', [RestaurantProfileController::class, 'showStep1'])->name('crear-perfil.restaurante');
        Route::post('crear-perfil-restaurante', [RestaurantProfileController::class, 'saveStep1'])->name('crear-perfil.restaurante.guardar');

        ### 2 paso 
        Route::get('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'showStep2'])->name('crear-perfil.restaurante-2');
        Route::post('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'saveStep2']);

        ## Redirigir al perfil del usuario propietario
        Route::get('perfil', [RestaurantProfileController::class, 'verMiPerfil'])->name('perfil.restaurante');
        ## Redirigir al perfil de otros usuarios
        Route::get('perfil/{profile}', [RestaurantProfileController::class, 'verPerfilAjeno'])->name('perfil.ajeno');

        ## Subir y actualizar fotos de perfil y portada
        Route::post('profile/update-photos', [RestaurantProfileController::class, 'actualizarFotos'])->name('profile.photos.update');

        //------------------------ PUBLICACIONES---------------------------------------//
         // POSTS
        ## Redactar Post Regular 
        Route::get('redactar-post', fn() => view('compartidas.form-posts'))->name('redactar.post.restaurant');
        ## Registrar Post Regular 
        Route::post('redactar-post', [PostController::class, 'store'])->name('post.store.restaurant');
        ## Modificar Post
        Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit.restaurant');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update.restaurant');  
        ## Eliminar Post
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy.restaurant');
        
        Route::get('ajustes', fn() => view('restaurantes.ajustes'))->name('ajustes.restaurante');

        ## Logout
        Route::post('logout', [LogoutRestaurantController::class, 'logout'])->name('logout.restaurant');
    });
});

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);




