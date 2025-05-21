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

        // Guardar las imágenes temporalmente, y sus paths en la sesión
        $soloDatos = collect($datos)->except(['imagen-perfil', 'imagen-portada'])->toArray();
        $soloDatos['dias_apertura'] = $datos['dias_apertura'] ?? [];

        // Posible movimiento a editar perfil, se descarta la posibilidad de subir imágenes en un formulario de 2 pasos
        // if ($request->hasFile('imagen-perfil')) {
        //     $path = $request->file('imagen-perfil')->store('temp/profiles', 'public');
        //     $soloDatos['imagen_perfil_path'] = $path;
        // }

        // if ($request->hasFile('imagen-portada')) {
        //     $path = $request->file('imagen-portada')->store('temp/covers', 'public');
        //     $soloDatos['imagen_portada_path'] = $path;
        // }

       // logger('Paso 1 datos:' , $soloDatos);
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

            ## Posible incorporación de fotos en la edición del perfil
            // if (!empty($datos_paso1['imagen_perfil_path'])) {
            //     $finalPath = str_replace('temp/', 'profiles/', $datos_paso1['imagen_perfil_path']);
            //     Storage::disk('public')->move($datos_paso1['imagen_perfil_path'], $finalPath);
            //     $foto_perfil_id = Photo::create(['url' => $finalPath])->id;
            // }

            // if (!empty($datos_paso1['imagen_portada_path'])) {
            //     $finalPath = str_replace('temp/', 'covers/', $datos_paso1['imagen_portada_path']);
            //     Storage::disk('public')->move($datos_paso1['imagen_portada_path'], $finalPath);
            //     $foto_portada_id = Photo::create(['url' => $finalPath])->id;
            // }

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
            ]);

            DB::commit();
            Session::forget('restaurant_step1');

            return redirect()->route('dashboard.restaurant')->with('success', 'Perfil creado correctamente');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear perfil'])->WithInput();
        }

    }
}
