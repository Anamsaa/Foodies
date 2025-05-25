<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Person;
use App\Models\Region;
use App\Models\Photo;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;
## Librería que me permite trabajar con fechas
use Carbon\Carbon;
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

        // Validar los datos antes de ser enviados
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fnacimiento' => 'required|date',
            'comunidad-autonoma' => 'required|numeric',
            'provincia' => 'required|numeric',
            'ciudad' => 'required|numeric',
            'descripcion-usuario' => 'required|string|max:255',
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

            //Log::error('Error al crear perfil: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo crear el perfil'.  $e->getMessage()])->withInput();
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

    private function renderPerfil(Profile $perfil){

        $perfil->load('profilePhoto', 'coverPhoto', 'person');
        $person = $perfil->person;
        $description = $person->description;
        $birthDate = $person->birth_date;
        $edad = Carbon::parse($birthDate)->age;
        $numeroReviews = $perfil->posts()->where('post_type', 'review')->count();
        // Últimos posts
        //dd($perfil->posts()->latest()->get());
        $posts = $perfil->posts()
            ->latest()
            ->with([
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
        if ($numeroReviews <= 10) {
            $tipoFoodie = 'Foodie nuevo';
        } elseif ($numeroReviews <= 20) {
            $tipoFoodie = 'Foodie entusiasta';
        } elseif ($numeroReviews <= 49) {
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
            'numeroReviews',
            'ubicacion',
            'posts'
        ));
    }
    public function mostrarDashboard() {
        $perfil = auth('user')->user()->profile;
        $perfil->load('profilePhoto'); 
        return view('personas.principal', compact('perfil'));
    }
}
