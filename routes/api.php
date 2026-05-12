<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CltLayupController;
use App\Http\Controllers\Api\CltLayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::apiResource('suppliers', SupplierController::class);

Route::prefix('suppliers/{supplier}')->group(function () {
    Route::get('layups', [CltLayupController::class, 'index']);
    Route::post('layups', [CltLayupController::class, 'store']);
    Route::put('layups/{id}', [CltLayupController::class, 'update']);
    Route::delete('layups/{id}', [CltLayupController::class, 'destroy']);

        Route::prefix('layups/{layup}')->group(function () {
                Route::get('layers', [CltLayerController::class, 'index']);
                Route::post('layers', [CltLayerController::class, 'store']);
                Route::put('layers/{id}', [CltLayerController::class, 'update']);
                Route::delete('layers/{id}', [CltLayerController::class, 'destroy']);
            });
});
