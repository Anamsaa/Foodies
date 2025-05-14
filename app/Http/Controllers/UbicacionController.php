<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;

class UbicacionController extends Controller
{
    public function getProvinces($regionId) {
        return response()->json(Province::where('region_id', $regionId)->get());
    }

    public function getCities($provinceId) {
        return response()->json(City::where('province_id', $provinceId)->get());
    }

    public function cargarRegiones() {
        $regions = Region::all();
        return view('formularios.registro-usuario', compact('regions'));
    }
}
