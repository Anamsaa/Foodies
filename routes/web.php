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
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CulinaryEventController;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Route;

// DEFINICIÓN DE RUTAS DE LA RED SOCIAL

// RUTA AL DASHBOARD (Página principal de introducción)
Route::get('/', fn()=>view('landing'))->name('landing');
# --------------------------------------------------------------------------------------------------------------------------------------------------------

## Perfil de usuario (Redirigir al perfil de otros usuarios siendo persona)
Route::get('user/perfil/{profile}', [PeopleProfileController::class, 'verPerfilAjeno'])->name('perfil.user.ajeno');

## Perfil para que usuarios tipo persona vean perfiles de restaurantes 
Route::get('user/restaurant/perfil/{perfil}', [RestaurantProfileController::class, 'verPerfilAjenoDesdePersona'])->name('restaurant.perfil.user'); // personas.perfil-restaurante.blade.php

## Perfil de restaurante (Redirigir al perfil de otros usuarios siendo restaurante) 
Route::get('restaurant/perfil/{perfil}', [RestaurantProfileController::class, 'verPerfilAjeno'])->name('perfil.ajeno.restaurante');

## Perfil para que usuarios de tipo restaurante vean perfiles de personas
Route::get('restaurant/user/perfil/{profile}', [PeopleProfileController::class, 'verPerfilAjenoDesdeRestaurante'])->name('user.perfil.restaurante'); //restaurantes.perfil-persona.blade.php

// ** NOTA **
// Al contar con diferentes tipos de interfaz se optó por manejar rutas independientes a perfiles ajenos con roles diferentes, esto debido a que la barra de navegación lateral de ambos es diferente. 

# --------------------------------------------------------------------------------------------------------------------------------------------------------

// ------------------------INTERACCIONES ENTRE USUARIOS---------------------------- //
// Likes 
Route::post('/post/{post}/like', [PostController::class, 'like'])->name('post.like');
Route::delete('/post/{post}/like', [PostController::class, 'unlike'])->name('post.unlike');

// Comentarios
## Vista comentarios Usuarios 'Persona'
Route::get('/user/comments/{post}', [CommentController::class, 'showCommentsForUser'])->name('comments.user');

## Vista comentarios Usuarios 'Restaurante'
Route::get('/restaurant/comments/{post}', [CommentController::class, 'showCommentsForRestaurant'])->name('comments.restaurant');

## Acciones de comentarios
Route::post('/post/{post}/comment', [CommentController::class, 'createComment'])->name('post.comment');
Route::delete('/comment/{comment}', [CommentController::class, 'deleteComment'])->name('comment.delete');


// ------------------------SEGUIR A OTROS USUARIOS---------------------------- //
Route::post('/follow/{profile}', [FollowController::class, 'follow'])->name('follow');
Route::delete('/unfollow/{profile}', [FollowController::class, 'unfollow'])->name('unfollow');

// Participantes de eventos
//Route::get('/user/eventos/{evento}/participantes', [CulinaryEventController::class, 'saberParticipantes']);

// RUTAS DE USUARIO PERSONA
### Se realizan con un prefijo diferenciador para evitar incidentes con las rutas
Route::prefix('user')->group(function () {

    // Rutas públicas 
    ## Registro de restaurantes
    Route::get('register', fn() => view('auth.register-user'))->name('register.user');
    Route::post('register', [RegisterPeopleController::class, 'store'])->name('register.user.guardar');

    ## Login de restaurantes 
    Route::get('login', fn() => view('auth.login-user'))->name('login.user');
    Route::post('login', [LoginPeopleController::class, 'login'])->name('login.user.guardar');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware(['auth:user', 'prevent-back-history'])->group(function() {

        ## Dashboard usuarios
        Route::get('dashboard', [PeopleProfileController::class, 'mostrarDashboard'])->name('dashboard.user');

        ## Creación de perfil para usarios 
        Route::get('crear-perfil-restaurante', [PeopleProfileController::class, 'showForm'])->name('crear-perfil.user');
        Route::post('crear-perfil-restaurante', [PeopleProfileController::class, 'guardarDatos'])->name('crear-perfil.guardar');

        ## Redirigir al perfil del usuario propietario
        Route::get('perfil', [PeopleProfileController::class, 'verMiPerfil'])->name('perfil.user');
     
        // Subir y actualizar fotos de perfil y portada 
        Route::post('profile/update-photos', [PeopleProfileController::class, 'actualizarFotos'])->name('profile.photos.update');

        // ----------------------------------- PUBLICACIONES --------------------------------------- //
        // POSTS
        ## Redactar Post Regular 
        Route::get('redactar-post', fn() => view('publicaciones.form-posts'))->name('redactar.post');

        ## Registrar Post Regular 
        Route::post('redactar-post', [PostController::class, 'store'])->name('post.store');

        ## Modificar Post
        Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');  

        ## Eliminar Post
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

        // EVENTOS CULINARIOS
        ## Ver formulario de creación de eventos
        Route::get('crear-evento', [CulinaryEventController::class, 'create'])->name('evento.create');

        ## Enviar datos del formulario y crear evento
        Route::post('crear-evento', [CulinaryEventController::class, 'store'])->name('evento.store');
        
        ## Modificar Eventos Culinarios
        Route::get('/eventos/{event}/edit', [CulinaryEventController::class, 'edit'])->name('evento.edit');
        Route::put('/eventos/{event}', [CulinaryEventController::class, 'update'])->name('evento.update');

        ## Eliminar evento
        Route::delete('/eventos/{event}', [CulinaryEventController::class, 'destroy'])->name('evento.destroy');

        // ------------------------------- PARTICIPACIÓN EN LOS EVENTOS-----------------------------------
        ## Unirse a la participación 
        Route::post('/eventos/{event}/unirse', [CulinaryEventController::class, 'join'])->name('evento.join');
        ## Cancelar participación 
        Route::delete('/eventos/{event}/cancelar', [CulinaryEventController::class, 'leave'])->name('evento.leave');

        // -------------------------------------------------------------------------------------------------------------- //
        
        ## Encontrar nuevos usuarios para seguir
        Route::get('red-de-sabores', [FollowController::class, 'sugerenciasParaSeguir'])->name('red.user');

        ## Lista de usuarios seguidos
        Route::get('seguidos', [FollowController::class, 'verSeguidos'])->name('seguidos.user');

        ## Eventos culinarios
        Route::get('eventos', [CulinaryEventController::class, 'indexUser'])->name('eventos.index');

        ## Ajustes / Edición de datos de creación de perfil y Eliminación de cuenta
        ## Ver el formulario y pasarle los datos para el value 
        Route::get('ajustes', [PeopleProfileController::class, 'mostrarFormularioAjustes'])->name('ajustes.user');
        ## Enviar los datos
        Route::post('ajustes', [PeopleProfileController::class, 'actualizarDatos'])->name('ajustes.update');

        ## Configurar por defecto la foto de portada y de perfil
        Route::post('ajustes/foto/eliminar', [PeopleProfileController::class, 'eliminarFotos'])->name('perfil.eliminar.foto');

        ## Eliminar la cuenta 
        Route::delete('eliminar-cuenta', [PeopleProfileController::class, 'eliminarCuenta'])->name('user.delete');
        
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
    Route::post('register', [RegisterRestaurantController::class, 'store'])->name('register.restaurant.guardar');

    ## Login de restaurantes 
    Route::get('login', fn() => view('auth.login-rest'))->name('login.restaurant');
    Route::post('login', [LoginRestaurantController::class, 'login'])->name('login.restaurant.guardar');

    // Rutas privadas (Requieren de autentificación de parte de los usuarios)
    Route::middleware(['auth:restaurant', 'prevent-back-history'])->group(function() {

        ## Dashboard restaurantes
        Route::get('dashboard', [RestaurantProfileController::class, 'mostrarDashboard'])->name('dashboard.restaurant');
        
        // Creación del perfil de restaurnate en 2 pasos 
        ### 1 paso 
        Route::get('crear-perfil-restaurante', [RestaurantProfileController::class, 'showStep1'])->name('crear-perfil.restaurante');
        Route::post('crear-perfil-restaurante', [RestaurantProfileController::class, 'saveStep1'])->name('crear-perfil.restaurante.guardar');

        ### 2 paso 
        Route::get('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'showStep2'])->name('crear-perfil.restaurante-2');
        Route::post('crear-perfil-restaurante-2', [RestaurantProfileController::class, 'saveStep2']);

        ## Redirigir al perfil del usuario propietario
        Route::get('perfil', [RestaurantProfileController::class, 'verMiPerfil'])->name('perfil.restaurante');

        ## Subir y actualizar fotos de perfil y portada
        Route::post('profile/update-photos', [RestaurantProfileController::class, 'actualizarFotos'])->name('profile.photos.update');

        //--------------------------------------- PUBLICACIONES---------------------------------------//
         // POSTS
        ## Redactar Post Regular 
        Route::get('redactar-post', fn() => view('publicaciones.form-posts-restaurant'))->name('redactar.post.restaurant');
        ## Registrar Post Regular 
        Route::post('redactar-post', [PostController::class, 'store'])->name('post.store.restaurant');
        ## Modificar Post
        Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit.restaurant');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update.restaurant');  
        ## Eliminar Post
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy.restaurant');

        
        ## Ajustes / Edición de datos de creación de perfil y Eliminación de cuenta
        ## Ver el formulario y pasarle los datos para el value 
        Route::get('ajustes', [RestaurantProfileController::class, 'mostrarFormularioAjustes'])->name('ajustes.restaurante');
        ## Enviar los datos
        Route::post('ajustes', [RestaurantProfileController::class, 'actualizarDatos'])->name('ajustes.update.rest');
        ## Configurar por defecto la foto de portada y de perfil
        Route::post('ajustes/foto/eliminar', [RestaurantProfileController::class, 'eliminarFotos'])->name('rest.eliminar.foto');
        ## Eliminar la cuenta 
        Route::delete('eliminar-cuenta', [RestaurantProfileController::class, 'eliminarCuenta'])->name('rest.delete');

        ## Logout
        Route::post('logout', [LogoutRestaurantController::class, 'logout'])->name('logout.restaurant');
    });
});

// Definicion de rutas para establecer conexión con archivos JSON
Route::get('/api/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/api/cities/{provinceId}', [UbicacionController::class, 'getCities']);

// Redordatorio de horarios de restaurante
Route::get('/api/restaurantes/{id}/horarios', function ($id) {
    $perfil = \App\Models\Profile::with('restaurant')->find($id);

    if (!$perfil || !$perfil->restaurant) {
        return response()->json(['error' => 'Restaurante no encontrado'], 404);
    }

    return response()->json([
        'horarios' => $perfil->restaurant->horarios ?? 'No hay horarios definidos',
    ]);
});

// Verfiicar la existencia de un evento
Route::get('/api/verificar-evento', [CulinaryEventController::class, 'verificarEvento']); 




