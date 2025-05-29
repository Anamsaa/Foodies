<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Person;
use App\Models\Region;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Follow;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
## Librería que me permite trabajar con fechas
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class PeopleProfileController extends Controller
{
    public function showForm() {
        // Comprobamos si el usuario tiene un perfil creado
        $user = auth('user')->user(); 

        if($user->profile) {
            return redirect()->route('dashboard.user');
        }

        // Pasarle todas las comunidades autónomas a los campos del Select
        $regions = Region::all(); 
        return view('personas.creation-user', compact('regions'));
    }

    public function guardarDatos(Request $request) {


        $fechaMinima = now()->subYears(16)->format('Y-m-d');

        // Validar los datos antes de ser enviados
        $datos = $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'apellidos' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'fnacimiento' => 'required|date|before_or_equal:' . $fechaMinima,
            'comunidad-autonoma' => 'required|numeric',
            'provincia' => 'required|numeric',
            'ciudad' => 'required|numeric',
            'descripcion-usuario' => 'required|string|max:255',
            ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'fnacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fnacimiento.before_or_equal' => 'Debes tener al menos 16 años para registrarte.',
            'comunidad-autonoma.required' => 'Selecciona una comunidad autónoma.',
            'provincia.required' => 'Selecciona una provincia.',
            'ciudad.required' => 'Selecciona una ciudad.',
            'descripcion-usuario.required' => 'La descripción es obligatoria.',
        ]); 

        DB::beginTransaction();

        try {
            $perfil = Profile::create([
                'account_id' => auth('user')->user()->id,
                'region_id' => $datos['comunidad-autonoma'],
                'province_id' => $datos['provincia'],
                'city_id' => $datos['ciudad'],
                'user_type' => 'Person',
            ]); 

            Person::create([
                'profile_id' => $perfil->id,
                'first_name' => $datos['nombre'],
                'last_name' => $datos['apellidos'],
                'birth_date' => $datos['fnacimiento'],
                'description' => $datos['descripcion-usuario'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('dashboard.user')->with('success', 'Perfil creado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function actualizarFotos(Request $request) {
        $perfil = auth('user')->user()->profile; 
        $response = []; 

        // Validar que el perfil existe 
        if (!$perfil) {
            return response()->json(['error' => 'Perfil no encontrado'], 404); 
        }

        // Subir la foto de perfil y crear un registro en la tabla "Photos"
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $photo = Photo::create(['url' => $path]); 

            $perfil->profile_photo_id = $photo->id; 
            $perfil->save(); 

            $response['profile_photo_url'] = $photo->url;
        }

        // Subir la foto de portada
        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('covers', 'public');
            $photo = Photo::create(['url' => $path]); 

            $perfil->cover_photo_id = $photo->id; 
            $perfil->save(); 

            $response['cover_photo_url'] = $photo->url;
        }
        return response()->json($response);
    }

    public function verMiPerfil(){
        $user = auth('user')->user();
        $perfil = $user->profile;

        if (!$perfil || !$perfil->person) {
            return redirect()->route('dashboard.user')
                ->withErrors('Tu perfil no está completo.');
        }

        return $this->renderPerfil($perfil);
    }

    public function verPerfilAjeno(Profile $profile){
        if (!$profile || !$profile->person) {
            return redirect()->route('dashboard.user')
                ->withErrors('Este usuario aún no ha completado su perfil.');
        }

        return $this->renderPerfil($profile);
    }

    public function verPerfilAjenoDesdeRestaurante(Profile $profile){

        $profile->load('profilePhoto', 'coverPhoto', 'person');

        if (!$profile || !$profile->person) {
            return redirect()->route('dashboard.restaurant')
            ->withErrors('Este usuario aún no ha completado su perfil.');
        }

        $person = $profile->person;
        $description = $person->description;
        $birthDate = $person->birth_date;
        $edad = Carbon::parse($birthDate)->age;
        $numeroPosts = $profile->posts()->count();

        $posts = $profile->posts()
            ->latest()
            ->with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.person',
            'profile.restaurant',
            'profile.profilePhoto'
        ])
        ->get();

        // Categorías de Foodies
        if ($numeroPosts <= 10) {
            $tipoFoodie = 'Foodie nuevo';
        } 
        elseif ($numeroPosts <= 20) {
            $tipoFoodie = 'Foodie entusiasta';
        } 
        elseif ($numeroPosts <= 49) {
            $tipoFoodie = 'King foodie';
        } 
        else {
            $tipoFoodie = 'Foodie Master';
        }

        $ubicacion = $profile->city?->nombre_formateado ?? 'Desconocido';


        return view('restaurantes.perfil-persona', compact(
            'profile',
            'description',
            'edad',
            'tipoFoodie',
            'numeroPosts',
            'ubicacion',
            'posts'
        ));
    }

    // Paso de datos al perfil de usuario
    private function renderPerfil(Profile $perfil){

        $perfil->load('profilePhoto', 'coverPhoto', 'person');
        $person = $perfil->person;
        $description = $person->description;
        $birthDate = $person->birth_date;
        $edad = Carbon::parse($birthDate)->age;
        $numeroPosts = $perfil->posts()->count();
        // Últimos posts
        //dd($perfil->posts()->latest()->get());
        $posts = $perfil->posts()
            ->latest()
            ->with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.person',
            'profile.restaurant',
            'profile.profilePhoto'
            ])
            ->get();
        //$posts = $perfil->posts()->latest()->get();

        // Categorías de Foodies 
        if ($numeroPosts <= 10) {
            $tipoFoodie = 'Foodie nuevo';
        } elseif ($numeroPosts <= 20) {
            $tipoFoodie = 'Foodie entusiasta';
        } elseif ($numeroPosts <= 49) {
            $tipoFoodie = 'King foodie';
        } else {
            $tipoFoodie = 'Foodie Master';
        }

        $ubicacion = $perfil->city?->nombre_formateado ?? 'Desconocido';

        return view('personas.perfil', compact(
            'perfil',
            'description',
            'edad',
            'tipoFoodie',
            'numeroPosts',
            'ubicacion',
            'posts'
        ));
    }

    // Paso de datos al dashboard de usuarios "Persona"
    public function mostrarDashboard() {
        $perfil = auth('user')->user()->profile;
        $perfil->load('profilePhoto'); 
        $perfilesSeguidos = Follow::where('follower_id', $perfil->id)
        ->where('status', 'Following')
        ->pluck('followed_id')
        ->toArray();

        // Mostrar en el Dashboard solo publicaciones de perfiles que sigue el usuario "Persona"
        $perfilesPermitidos = array_merge([$perfil->id], $perfilesSeguidos);

        $posts = Post::with([
            'culinaryEvent',
            'photo',
            'likes',
            'comments',
            'profile.profilePhoto',
            'profile.person',
            'profile.restaurant'
        ])
        ->where('visibility', 'Public')
        ->whereIn('profile_id', $perfilesPermitidos)
        ->orderBy('created_at', 'desc')
        ->get();

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

        $sugerencias = Profile::with(['person', 'profilePhoto'])
            ->where('id', '!=', $perfil->id)
            ->where('province_id', $perfil->province_id)
            ->where('user_type', 'Person')
            ->whereDoesntHave('followers', function ($q) use ($perfil) {
                $q->where('follower_id', $perfil->id);
            })
            ->take(3)
            ->get();

        $numeroPosts = $perfil->posts()->where('post_type', 'review')->count();

        if ($numeroPosts <= 10) {
            $tipoFoodie = 'Foodie nuevo';
        } 
        elseif ($numeroPosts <= 20) {
            $tipoFoodie = 'Foodie entusiasta';
        } 
        elseif ($numeroPosts <= 49) {
            $tipoFoodie = 'King foodie';
        } 
        else {
            $tipoFoodie = 'Foodie Master';
        }

        return view('personas.principal', compact(
            'perfil', 
            'posts', 
            'misNovedades', 
            'sugerencias', 
            'numeroPosts',
            'tipoFoodie',
        ));
    }

    public function mostrarFormularioAjustes() {
        // Cuenta del usuario
        $user = auth('user')->user(); 
        // Datos del perfil del usuario
        $perfil = $user->profile; 
        // En caso de no tener un perfil creado o que el perfil no sea de una persona retorna al dahsboard
        if (!$perfil || !$perfil->person) {
            return redirect()->route('dashboard.user');
        }

        // Asegurarse de que los datos de perfil estén cargados antes de pasarlos
        $perfil->load('person');
        // Cargar las regiones
        $regions = $regions = Region::all();
        return view('personas.ajustes', compact('perfil', 'regions', 'user'));
    }

    //Actualización de datos del perfil a través de ajustes
    public function actualizarDatos(Request $request){
        $user = auth('user')->user();
        $profile = $user->profile;
        $person = $profile->person;
        $userId = $user->id;
        $fechaMinima = now()->subYears(16)->format('Y-m-d');

        $rules = [
            'first_name' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
            'descripcion-usuario' => 'nullable|string|max:255',
            'comunidad-autonoma' => 'nullable|numeric',
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

        // ** FECHA DE NACIMIENTO ** 
        // Validación de fecha de nacimiento 
        if ($request->filled('fnacimiento')) {
            $rules['fnacimiento'] = [
                'nullable',
                'date', 
                'before_or_equal:' . $fechaMinima
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
            'email.regex' => 'Nuevo correo inválido. Intenta con otro',
            'email.confirmed' => 'Los correos no coinciden',
            'email.unique' => 'Este correo ya está en uso.',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial (@$!%*#?&-_)',
            'first_name.regex' => 'El nombre debe contener sólo letras',
            'last_name.regex' => 'El apellido debe contener sólo letras',
            'fnacimiento.before_or_equal' => 'Debes tener al menos 16 años para registrarte',
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
            auth('user')->logout(); 
            return redirect()->route('login.user')->with('success', 'Datos actualizados, vuelve a iniciar sesión');
        }

        // **DATOS DE PERFIL**
        // Actualización de persona
        if ($person) {
            if ($request->filled('first_name')) {
                $person->first_name = $request->input('first_name');
            }
            if ($request->filled('last_name')) {
                $person->last_name = $request->input('last_name');
            }
            if ($request->filled('fnacimiento')) {
                $person->birth_date = $request->input('fnacimiento');
            }

            if ($request->filled('descripcion-usuario')) {
                $person->description = $request->input('descripcion-usuario');
            }

            $person->save();
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

        $perfil = auth('user')->user()->profile; 

        if ($request->tipo === 'perfil') {
            $perfil->profile_photo_id = null; 
        } elseif ($request->tipo === 'portada') {
            $perfil->cover_photo_id = null; 
        }

        $tipo = $request->tipo;

        $perfil->save();

        return back()->with('sucess', 'Ahora tu foto de' . ucfirst($tipo) . 'se ha cambiado a una predeterminada.');

    }

    public function eliminarCuenta(Request $request){
        $user = auth('user')->user();

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

                auth('user')->logout();

                $user->delete();
                            
                DB::commit();

                return redirect()->route('landing')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
            } catch (Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Ocurrió un error al eliminar tu cuenta.'])->withInput();
            }       
    }
}
