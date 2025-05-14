<?php

use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

Route::get('/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
Route::get('/cities/{provinceId}', [UbicacionController::class, 'getCities']);