<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::group(['prefix' => 'api'], function () {
//    Route::post('/sensorgateway/lrv', ['middleware' => 'stype',\App\Http\Controllers\sensorController::class,'store']);


// Sensor Routes

Route::post('/sensorgateway/lrv', [\App\Http\Controllers\sensorController::class,'store']);
Route::get('/sensorgateway/lrv', [\App\Http\Controllers\sensorController::class,'index']);
Route::get('/sensorgateway/lrv/{id}', [\App\Http\Controllers\sensorController::class,'show']);

// Config Routes

Route::get('/sensorgateway/lrv/config/get/{lookupKey}', [\App\Http\Controllers\configController::class,'getConfigByKey']);
Route::get('/sensorgateway/lrv/config/flush/all', [\App\Http\Controllers\configController::class,'flushCache']);
Route::get('/sensorgateway/lrv/config/flush/key/{lookupKey}', [\App\Http\Controllers\configController::class,'deleteCacheKey']);
