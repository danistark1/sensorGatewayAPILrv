<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static findOrFail(mixed $typeID)
 */
class SensorType extends Model
{
    const SENSOR_TYPE_PH                   = 'ph';
    const SENSOR_TYPE_MOTION               = 'motion';
    const SENSOR_TYPE_MOISTURE             = 'moisture';
    const SENSOR_TYPE_CHLORINE             = 'chlorine';
    const SENSOR_TYPE_HUMIDITY             = 'humidity';
    const SENSOR_TYPE_TEMPERATURE          = 'temperature';
    const SENSOR_TYPE_TEMPERATURE_HUMIDITY = 'temperature-humidity';

    const SENSOR_TYPES = [
        self::SENSOR_TYPE_PH,
        self::SENSOR_TYPE_MOTION,
        self::SENSOR_TYPE_MOISTURE,
        self::SENSOR_TYPE_CHLORINE,
        self::SENSOR_TYPE_HUMIDITY,
        self::SENSOR_TYPE_TEMPERATURE,
        self::SENSOR_TYPE_TEMPERATURE_HUMIDITY
    ];

    use HasFactory;

    protected $fillable = [
        'sensor_data_id',
        'type'
    ];
}
