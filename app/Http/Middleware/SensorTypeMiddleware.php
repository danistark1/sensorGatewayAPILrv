<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SensorType;

class SensorTypeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Perform action
        $sensorTypeID = $request->get('sensor_type_id');
        $sensorType = SensorType::find($sensorTypeID);
        if (!$sensorType) {
            return response("from middleware",433);
        }

        return $next($request);
    }
}
