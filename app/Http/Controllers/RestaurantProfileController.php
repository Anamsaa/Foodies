<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Profile;
use App\Models\Restaurant;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Region;
use App\Models\Follow;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
## Librería que me permite trabajar con fechas
use Carbon\Carbon;

class RestaurantProfileController extends Controller
{
    // Primer paso de envio de datos 
    public function showStep1() {
         logger( 'Inicia envío de datos');
        // Confirmar que un perfil ya registrado, no vuelva a realizar el proceso
        $user = auth('restaurant')->user();

        if ($user->profile) {
            return redirect()->route('dashboard.restaurant');
        }

        return view('restaurantes.creation-rest'); 
    }

    public function saveStep1(Request $request) {

        // Validación automática de datos 
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'horarios' => 'nullable|string',
            'invitacion' => 'nullable|string',
            'link-restaurante' => 'nullable|string',
            'tipo' => 'required|string',
            'imagen-perfil' => 'nullable|image',
            'imagen-portada' => 'nullable|image',
            'dias_apertura' => 'nullable|array',
            'dias_apertura.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
        ]);

        $soloDatos = $datos;
        $soloDatos['dias_apertura'] = $datos['dias_apertura'] ?? [];
        Session::put('restaurant_step1', $soloDatos);

        return redirect()->route('crear-perfil.restaurante-2');
    }

    // Segundo paso de envio de datos 
    public function showStep2() {

        // Doble verificación en ambos pasos
        $user = auth('restaurant')->user();
        if ($user->profile) {
            return redirect()->route('dashboard.restaurant');
        }

        // Control de verificación sobre los datos del primer paso de creación del formulario
        if (!Session::has('restaurant_step1')) {
            return redirect()->route('crear-perfil.restaurante');
        }

        $regions = Region::all(); 
        return view('restaurantes.creation-rest-2', compact('regions'));
    }

    public function saveStep2(Request $request) {

        if ($request->_action === 'back') {
            Session::put('restaurant_step2', $request->except('_token', '_action'));
            return redirect()->route('crear-perfil.restaurante');
        }

        $datos = $request->validate([
            'telefono' => 'required|string|max:20|regex:/^[\+0-9\s\-\(\)]+$/u',
            'direccion' => 'required|string|max:255',
            'direccion_confirmacion' => 'required|string|same:direccion',
            'comunidad-autonoma' => 'required|numeric',
            'provincia' => 'required|numeric',
            'ciudad' => 'required|numeric',
        ], [
            'direccion.confirmed' => 'Las direcciones no coinciden, verifique de nuevo',
            'telefono.regex' => 'Número de teléfono inválido. Número máx. de digitos: 20',
            'comunidad-autonoma.required' => 'Selecciona una comunidad autónoma.',
            'provincia.required' => 'Selecciona una provincia.',
            'ciudad.required' => 'Selecciona una ciudad.',
        ]); 

        $datos_paso1 = Session::get('restaurant_step1');

        DB::beginTransaction(); 
        try {

            // Guardar las imágenes 
            $foto_perfil_id = null;
            $foto_portada_id = null; 
        
            // Creación del perfil 
            $perfil = Profile::create([
                'account_id' => auth('restaurant')->user()->id,
                'region_id' => $datos['comunidad-autonoma'],
                'province_id' => $datos['provincia'],
                'city_id' => $datos['ciudad'],
                'profile_photo_id' => $foto_perfil_id, 
                'cover_photo_id' => $foto_portada_id,
                'user_type' => 'Restaurant',
            ]);

            // Crear restaurante
            Restaurant::create([
                'profile_id' => $perfil->id,
                'name' => $datos_paso1['nombre'],
                'description' => $datos_paso1['invitacion'],
                'address' => $datos['direccion'],
                'website' => $datos_paso1['link-restaurante'],
                'phone' => $datos['telefono'],
                'dias_apertura' => $datos_paso1['dias_apertura'] ?? [],
                'horarios'=> $datos_paso1['horarios'],
                'tipo' =>  $datos_paso1['tipo'],
            ]);

            DB::commit();
            Session::forget('restaurant_step1');

            return redirect()->route('dashboard.restaurant')->with('success', 'Perfil creado correctamente');

        } catch (Exception $e) {
            DB::rollBack();

            // Ver el error específico en los logs 
            Log::error('Error al crear perfil de restaurante', [
                'message' => $e->getMessage(), 
                'trace'=> $e->getTraceAsString(),
            ]); 

            //return back()->withErrors(['error' => 'Error al crear perfil' .$e->getMessage()])->WithInput();
        }

    }

    public function actualizarFotos(Request $request) {

        try {
            $profile = auth('restaurant')->user()->profile;

            if (!$profile) {
                return response()->json(['error' => 'Perfil no encontrado'], 404);
            }

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profiles', 'public');
                $photo = Photo::create(['url' => $path]);

                $profile->profile_photo_id = $photo->id;
                $profile->save();
            }

            if ($request->hasFile('cover_photo')) {
                $path = $request->file('cover_photo')->store('cover_photos', 'public');
                $photo = Photo::create(['url' => $path]);

                $profile->cover_photo_id = $photo->id;
                $profile->save();
            }

            $profile->load('profilePhoto', 'coverPhoto');

            return response()->json([
                'profile_photo_url' => optional($profile->profilePhoto)->url,
                'cover_photo_url' => optional($profile->coverPhoto)->url,
            ]);
        } catch (Exception $e) {
            Log::error('Error al actualizar fotos: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verMiPerfil(){
        $restaurant = auth('restaurant')->user();
        $perfil = $restaurant->profile;

        if (!$perfil || !$perfil->restaurant) {
            return redirect()->route('dashboard.restaurant')
                ->withErrors('Tu perfil no está completo.');
        }

        return $this->renderPerfil($perfil);
    }

    public function verPerfilAjeno(Profile $perfil){

        $perfil->load('restaurant'); 
         //dd($perfil, $perfil->restaurant); 
         
        if (!$perfil || !$perfil->restaurant) {
            return redirect()->route('dashboard.restaurant')
                ->withErrors('Este establecimiento aún no ha completado su perfil.');
        }

        return $this->renderPerfil($perfil);
    }

    public function verPerfilAjenoDesdePersona(Profile $perfil){
       $perfil->load('restaurant', 'profilePhoto', 'coverPhoto');

        if (!$perfil || !$perfil->restaurant) {
        return redirect()->route('dashboard.user')
            ->withErrors('Este establecimiento aún no ha completado su perfil.');
        }

        $restaurant = $perfil->restaurant;
        $tipoRestaurante = $restaurant->tipo;
        $horarios = $restaurant->horarios;
        $diasApertura = $restaurant->dias_apertura;
        $ubicacion = $perfil->city?->nombre_formateado ?? 'Desconocido';
        $direccion = $restaurant->address;
        $numeroTelefonico = $restaurant->phone;
        $website = Str::start($restaurant->website, 'https://');
        $descripcion = $restaurant->description;

        $posts = Post::with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.profilePhoto',
            'profile.restaurant'
        ])
        ->where('profile_id', $perfil->id)
        ->where('visibility', 'Public')
        ->orderBy('created_at', 'desc')
        ->get();
    
        return view('personas.perfil-restaurante', compact(
        'perfil',
        'descripcion',
        'tipoRestaurante',
        'horarios',
        'diasApertura',
        'ubicacion',
        'direccion',
        'website',
        'numeroTelefonico',
        'posts'
        ));
    }

    private function renderPerfil(Profile $perfil){
        $perfil->load('restaurant', 'profilePhoto', 'coverPhoto');
        $restaurant = $perfil->restaurant;
        $tipoRestaurante = $restaurant->tipo;
        $horarios = $restaurant->horarios;
        $diasApertura = $restaurant-> dias_apertura;
        $ubicacion = $perfil->city?->nombre_formateado ?? 'Desconocido';
        $direccion = $restaurant->address; 
        $numeroTelefonico = $restaurant->phone;
        $website = Str::start($restaurant->website, 'https://');
        $descripcion = $restaurant->description;

        $posts = Post::with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.profilePhoto',
            'profile.restaurant'
        ])
        ->where('profile_id', $perfil->id)
        ->where('visibility', 'Public')
        ->orderBy('created_at', 'desc')
        ->get();
    
        return view('restaurantes.perfil', compact(
            'perfil',
            'descripcion',
            'tipoRestaurante',
            'horarios',
            'diasApertura',
            'ubicacion',
            'direccion',
            'website',
            'numeroTelefonico',
            'posts'
        ));
    }

    public function mostrarDashboard() {
        $perfil = auth('restaurant')->user()->profile;
        $perfil->load('profilePhoto');

        $restaurantId = $perfil->restaurant->id;

        // Cargar los post creados por el usuario y los post realizados de Eventos culinarios que se realizarán en el establecimiento
        $postsNormales = Post::with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.profilePhoto',
            'profile.restaurant'
        ])
        ->where('profile_id', $perfil->id)
        ->where('visibility', 'Public')
        ->orderBy('created_at', 'desc')
        ->get();

        $postsEventos = Post::with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.profilePhoto',
            'profile.restaurant'
        ])
        ->whereHas('culinaryEvent', function ($query) use ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        })
        ->where('post_type', 'Culinary Event')
        ->where('visibility', 'Public')
        ->orderBy('created_at', 'desc')
        ->get();

        $posts = $postsNormales->concat($postsEventos)->sortByDesc('created_at');

        $misNovedades = Follow::with(['follower.person', 'follower.profilePhoto'])
            ->where('followed_id', $perfil->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($follow) {
                return [
                    'nombre' => $follow->follower->person->first_name . ' ' . $follow->follower->person->last_name,
                    'foto' => optional($follow->follower->profilePhoto)->url ?? asset('images/default_image_profile.png'),
                    'tiempo' => Carbon::parse($follow->created_at)->diffForHumans(),
                    'profile' => $follow->follower,
                ];
            });

        return view('restaurantes.principal', compact(
            'perfil',
            'posts',
            'misNovedades',
        ));
    }

     public function mostrarFormularioAjustes() {
        // Cuenta del usuario
        $user = auth('restaurant')->user(); 
        // Datos del perfil del usuario
        $perfil = $user->profile; 
        // En caso de no tener un perfil creado o que el perfil no sea de una persona retorna al dahsboard
        if (!$perfil || !$perfil->restaurant) {
            return redirect()->route('dashboard.user');
        }

        // Asegurarse de que los datos de perfil estén cargados antes de pasarlos
        $perfil->load('restaurant');
        // Cargar las regioness
        $regions = $regions = Region::all();
        return view('restaurantes.ajustes', compact('perfil', 'regions', 'user'));
    }

    public function actualizarDatos(Request $request){
        $user = auth('restaurant')->user();
        $profile = $user->profile;
        $restaurant = $profile->restaurant;
        $userId = $user->id;
    
        $rules = [
            'nombre' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
            'horarios' => 'nullable|string|max:255',
            'invitacion' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'direccion_confirmacion' => 'nullable|string|same:direccion',
            'comunidad-autonoma' => 'nullable|numeric',
            'dias_apertura' => 'nullable|array',
            'dias_apertura.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'link-restaurante' => 'nullable|string|max:255',
        ];

        // ** EMAIL **
        // Validación si se llena el campo email
        if ($request->filled('email') && $request->email !== $user->email) {
            $rules['email'] = [
                'required', 
                'email', 
                'confirmed', 
                'regex:/^[a-zA-Z][a-zA-Z0-9.\-_]+@[a-zA-Z0-9.\-_]+\.[a-zA-Z]{2,6}$/', 
                'unique:accounts,email,' . $userId,
            ]; 
        } elseif ($request->filled('email') && $request->email === $user->email) {
            // Si el correo actual se repite envía esto
            return back()->withErrors(['email' => 'Ya estás usando este correo electrónico. Intenta con otro.'])->withInput();
        }

        // ** CONTRASEÑA ** 
        // Validación si se llena el campo contraseña
        // Si la contraseña actual es la misma 
        if ($request->filled('password')) {
            if (Hash::check($request->password, $user->password_hash)) {
                return back()->withErrors(['password' => 'La nueva contraseña debe ser diferente a la actual'])->withInput();
            }

            $rules['password'] = [
                'required',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&-_]).{8,}$/',
            ];
        }

        // ** TELÉFONO **
        if ($request->filled('telefono')) {
            $rules['telefono'] = [
                'nullable',
                'string',
                'max:20', 
                'regex:/^[\+0-9\s\-\(\)]+$/u'
            ];
        }

        // ** VALIDACIÓN PROVINCIA **
        if ($request->filled('provincia')) {
            $rules['provincia'] = [
                'nullable',
                'numeric',
                'required_with:comunidad-autonoma'
            ];
        }

        // ** VALIDACIÓN CIUDAD **
        if ($request->filled('ciudad')) {
            $rules['ciudad'] = [
                'nullable',
                'numeric',
                'required_with:provincia'
            ];
        }

        // Mensajes personalizados según el campo que se esté validando 
        $messages = [
            'direccion.confirmed' => 'Las direcciones no coinciden, verifique de nuevo',
            'email.regex' => 'Nuevo correo inválido. Intenta con otro',
            'email.confirmed' => 'Los correos no coinciden',
            'email.unique' => 'Este correo ya está en uso.',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial (@$!%*#?&-_)',
            'telefono.regex' => 'Número de teléfono inválido. Número máx. de digitos: 20',
            'provincia.required_with' => 'Selecciona una comunidad autónoma antes de la provincia.',
            'ciudad.required_with' => 'Selecciona una provincia antes de la ciudad.',
        ]; 

        // Lanzar errores de validación
        $validated = $request->validate($rules, $messages);
        $account = \App\Models\Account::findOrFail($userId);


        // **CUENTA**
        $requiereLogout = false; 
        // Actualizar datos de la cuenta
        // email
        if ($request->filled('email') && $request->email !== $user->email) {
            $account->email = $request->email;
            $requiereLogout = true;
        }
        
        //contraseña
        if ($request->filled('password')) {
            $account->password_hash = Hash::make($request->password);
            $requiereLogout = true;
        }
        
        $account->save();

        if ($requiereLogout) {
            auth('restaurant')->logout(); 
            return redirect()->route('login.restaurant')->with('success', 'Datos actualizados, vuelve a iniciar sesión');
        }

        // **DATOS DE PERFIL**
        // Actualización de persona
        if ($restaurant) {
            $campos = [
                'nombre' => 'name',
                'horarios' => 'horarios',
                'link-restaurante' => 'website',
                'invitacion' => 'description',
                'telefono' => 'phone',
                'direccion' => 'address',
                'dias_apertura' => 'dias_apertura',
                'tipo' => 'tipo',
            ];

            foreach ($campos as $input => $campoModelo) {
                if ($request->filled($input)) {
                    $restaurant->{$campoModelo} = $request->input($input);
                }
            }

            $restaurant->save();
        }

        // Actualización de ubicación en el perfil
        if ($request->filled('comunidad-autonoma')) {
            $profile->region_id = $request->input('comunidad-autonoma');
        }
        if ($request->filled('provincia')) {
            $profile->province_id = $request->input('provincia');
        }
        if ($request->filled('ciudad')) {
            $profile->city_id = $request->input('ciudad');
        }

        $profile->save();

        return redirect()->back()->with('success', 'Datos actualizados correctamente');

    }

    public function eliminarFotos(Request $request) {

        $request->validate([
            'tipo' => 'required|in:perfil,portada',
        ]); 

        $perfil = auth('restaurant')->user()->profile; 

        if ($request->tipo === 'perfil') {
            $perfil->profile_photo_id = null; 
        } elseif ($request->tipo === 'portada') {
            $perfil->cover_photo_id = null; 
        }

        $tipo = $request->tipo;

        $perfil->save();

        return back()->with('sucess', 'Ahora tu foto de' . ucfirst($tipo) . 'se ha cambiado a una predeterminada.');

    }

    public function eliminarCuenta(){
        $user = auth('restaurant')->user();

        DB::beginTransaction();
            try {
                $profile = $user->profile;

                if ($profile) {
                    foreach ($profile->posts as $post) {
                        if ($post->photo) {
                            Storage::disk('public')->delete($post->photo->url);
                            $post->photo->delete();
                        }
                        $post->delete();
                    }

                    $profile->comments()->delete();
                    $profile->likes()->delete();

                    $profile->followers()->delete();
                    $profile->followings()->delete();

                    $profile->sentNotifications()->delete();
                    $profile->receivedNotifications()->delete();

                    // Eliminar fotos de perfil y portada
                    if ($profile->profilePhoto) {
                        Storage::disk('public')->delete($profile->profilePhoto->url);
                        $profile->profilePhoto->delete();
                    }

                    if ($profile->coverPhoto) {
                        Storage::disk('public')->delete($profile->coverPhoto->url);
                        $profile->coverPhoto->delete();
                    }

                    // Eliminar entidad Person
                    if ($profile->person) {
                        $profile->person->delete();
                    }
                     // Eliminar perfil
                    $profile->delete();
                }

                auth('restaurant')->logout();

                $user->delete();
                            
                DB::commit();

                return redirect()->route('login.restaurant')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
            } catch (Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Ocurrió un error al eliminar tu cuenta.'])->withInput();
            }       
    } 
}
