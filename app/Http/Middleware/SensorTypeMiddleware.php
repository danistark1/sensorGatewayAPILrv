<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\sensorType;

class SensorTypeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Perform action
        $sensorTypeID = $request->get('sensor_type_id');
        $sensorType = sensorType::find($sensorTypeID);
        if (!$sensorType) {
            return response("from middleware",433);
        }

        return $next($request);
    }
}
