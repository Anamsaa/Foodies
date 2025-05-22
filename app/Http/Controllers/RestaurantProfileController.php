<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Profile;
use App\Models\Restaurant;
use App\Models\Photo;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Storage;

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

        // Guardar las imágenes temporalmente, y sus paths en la sesión
        $soloDatos = collect($datos)->except(['imagen-perfil', 'imagen-portada'])->toArray();
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
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'direccion_confirmacion' => 'required|string|same:direccion',
            'comunidad-autonoma' => 'required|numeric',
            'provincia' => 'required|numeric',
            'ciudad' => 'required|numeric',
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
            return back()->withErrors(['error' => 'Error al crear perfil'])->WithInput();
        }

    }

    public function actualizarFotos(Request $request) {
        $perfil = auth('restaurant')->user()->profile; 
        $response = []; 

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
        $restaurant = auth('restaurant')->user();
        $perfil = $restaurant->profile;

        if (!$perfil || !$perfil->restaurant) {
            return redirect()->route('dashboard.user')
                ->withErrors('Tu perfil no está completo.');
        }

        return $this->renderPerfil($perfil);
    }

    public function verPerfilAjeno(Profile $perfil){
        if (!$perfil || !$perfil->restaurant) {
            return redirect()->route('dashboard.user')
                ->withErrors('Este establecimiento aún no ha completado su perfil.');
        }

        return $this->renderPerfil($perfil);
    }

    private function renderPerfil(Profile $perfil){
        $restaurant = $perfil->restaurant;
        $horarios = $restaurant->schedules;
        $diasApertura = $restaurant-> dias_apertura;
        $ubicacion = $perfil->city?->nombre_formateado ?? 'Desconocido';
        $direccion = $restaurant->address; 
        $numeroTelefonico = $restaurant->phone;
        $description = $restaurant->description;
    

        return view('restaurantes.perfil', compact(
            'perfil',
            'description',
            'edad',
            'tipoFoodie',
            'numeroReviews',
            'ubicacion'
        ));
    }


}
