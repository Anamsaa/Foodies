<?php

use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Models\Province;
use App\Models\City;

// Peticiones al servidor 
Route::get('/api/provinces/{regionId}', function ($regionId) {
    $provinces = Province::where('region_id', $regionId)->get();
    return response()->json($provinces);
});

// Rutas para cargar ciudades por provincia
Route::get('/api/cities/{provinceId}', function ($provinceId) {
    $cities = City::where('province_id', $provinceId)->get();
    return response()->json($cities);
});