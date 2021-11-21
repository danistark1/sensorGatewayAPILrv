<?php

use App\Http\Controllers\SensorconfigController;
use App\Http\Controllers\SensorController;
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

Route::post('/sensorgateway/lrv', [SensorController::class, 'saveSensorData']);
Route::get('/sensorgateway/lrv', [SensorController::class,'index']);
Route::get('/sensorgateway/lrv/{sensor_id}', [SensorController::class,'getSensorBySensorId']);

// Config Routes

Route::get('/sensorgateway/lrv/config/get/{lookupKey}', [SensorConfigController::class,'getConfigByKey']);
Route::get('/sensorgateway/lrv/config/flush/all', [SensorConfigController::class,'clear']);
Route::get('/sensorgateway/lrv/config/flush/key/{lookupKey}', [SensorConfigController::class,'delete']);
Route::post('/sensorgateway/lrv/config', [SensorConfigController::class,'saveConfig']);
