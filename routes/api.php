<?php

use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/provinces/{regionId}', [UbicacionController::class, 'getProvinces']);
    Route::get('/cities/{provinceId}', [UbicacionController::class, 'getCities']);
});