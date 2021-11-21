<?php

namespace App\Services;

use App\Models\SensorData;
use App\Models\SensorType;
use Illuminate\Support\Facades\Log;

class SensorDataService
{
    /**
     * Create/Update Sensor data.
     *
     * @param $sensorDataArray
     * @return mixed
     * @throws \Throwable
     */
    public function createOrUpdateSensorData($sensorDataArray) {
        $sensorData = resolve(SensorData::class);
        $sensorData->name = $sensorDataArray['name'];
        $sensorData->value = $sensorDataArray['value'];
        $sensorData->location = $sensorDataArray['location'];
        $sensorData->sensor_id = $sensorDataArray['sensor_id'];
        /** @var  SensorData $sensorData */
        $success = $sensorData->saveOrFail($sensorDataArray);
        if ($success) {
            $sensorData->sensorType()
                ->updateOrCreate(
                    [
                        'sensor_data_id' => $sensorData->id,
                        'type'=>  $sensorDataArray['sensor_type']
                    ]);
        }
        return $success;
    }

    public function getSensorBySensorId($sensorId): array
    {
        return SensorData::query()->where('sensor_id', $sensorId)->get()->all();
    }
}
