<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Profile;
use App\Models\Restaurant;
use App\Models\Photo;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            // Ver el error específico en los logs 
            Log::error('Error al crear perfil de restaurante', [
                'message' => $e->getMessage(), 
                'trace'=> $e->getTraceAsString(),
            ]); 

            return back()->withErrors(['error' => 'Error al crear perfil' .$e->getMessage()])->WithInput();
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


        return view('personas.perfil-restaurante', compact(
        'perfil',
        'descripcion',
        'tipoRestaurante',
        'horarios',
        'diasApertura',
        'ubicacion',
        'direccion',
        'website',
        'numeroTelefonico'
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
    

        return view('restaurantes.perfil', compact(
            'perfil',
            'descripcion',
            'tipoRestaurante',
            'horarios',
            'diasApertura',
            'ubicacion',
            'direccion',
            'website',
            'numeroTelefonico'
        ));
    }
}
