<?php

namespace App\Http\Controllers;

use App\Events\SensorReports;

use App\Jobs\SendEmailNotificationJob;
use App\Models\SensorConfig;
use App\Models\SensorType;
use App\Models\SensorData;
use App\Services\SensorDataService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SensorController extends Controller
{
    const SENSOR_DATA_SAVE_ERROR = 'Something went wrong while saving the sensor data ';
    const SENSOR_DATA_BY_SENSOR_ID_ERROR = 'Something went wrong while fetching sensor data by sensor_id ';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return SensorData::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSensorData(Request $request): JsonResponse
    {
        // Get configured sensor names.
        $configuredSensorNames = SensorConfig::getSensorNames(); // TODO this should be cached.
        $sensorIds = SensorConfig::getConfiguredSensorIds();

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::in($configuredSensorNames)],
            'value' => 'required|array',
            'location' => 'required|string',
            'sensor_id' => ['required', Rule::in($sensorIds)],
            'sensor_type' => ['required', Rule::in(SensorType::SENSOR_TYPES)]
        ]);

        if ($validator->fails()) {
            return response()->json(['validation failed. ' . $validator->errors()], 402);
        }
        /** @var SensorDataService $sensorDataService */
        $sensorDataService = resolve(SensorDataService::class);
        $sensorData = $request->all();
        try {
            $sensorDataService->createOrUpdateSensorData($sensorData);
            return response()->json($sensorData, 201);
        } catch(\Throwable $throwable) {
            Log::channel('customMonolog')->debug($throwable->getMessage(), [$sensorData]);
            return response()->json(['message' => self::SENSOR_DATA_SAVE_ERROR . $throwable->getMessage()], 500);
        }
        // Trigger email event.
        //event(new SensorReports($sensorData));
    }

    /**
     * Get sensor data by sensor_id
     *
     * @param Request $request
     * @param int $sensorId
     * @return JsonResponse
     */
    public function getSensorBySensorId(Request $request, int $sensorId): JsonResponse
    {
        $sensorDataService = resolve(SensorDataService::class);
        try {
            $sensorData = $sensorDataService->getSensorBySensorId($sensorId);
            return response()->json($sensorData, 200);
        } catch (\Throwable $throwable) {
            Log::channel('customMonolog')->debug($throwable->getMessage(), ['sensor_id' => $sensorId]);
            return response()->json(['message' => self::SENSOR_DATA_BY_SENSOR_ID_ERROR . $throwable->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteSensorData($id): Response
    {
        //
    }
}
