<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;

class PerfilController extends Controller
{
    public function mostrarDatosUbicacion() {
        $regions = Region::all();
        $provinces = Province::all();
        $cities = City::all();

        return view('formularios.registro-usuario', compact('regions', 'provinces', 'cities'));
    }
}
