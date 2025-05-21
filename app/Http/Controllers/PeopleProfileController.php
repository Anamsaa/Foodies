<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Session;
use App\Models\Profile;
use App\Models\Person;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\DB;
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
}
