<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property string value
 * @property string key
 * @property array attributes
 */
class SensorConfig extends Model
{
    use HasFactory;

    const CONFIG_TYPE_APP = 'app_config';
    const CONFIG_TYPE_SENSOR_NAMES = 'sensor_names';
    const CONFIG_TYPE_REPORTING = 'app_reports';
    const CONFIG_TYPE_UPPER_THRESHOLDS = 'sensor_upper_thresholds';
    const CONFIG_TYPE_LOWER_THRESHOLDS = 'sensor_lower_thresholds';

    protected $fillable = [
        'key',
        'value',
        'type',
        'id'
    ];

    protected $casts = [
        "attributes" => "array"
    ];

    /**
     * @param string $attributeField
     * @return mixed
     */
    public function getJsonAttribute(string $attributeField) {
        return $this->attributes[$attributeField];
    }

    public function setJsonxAttributes($field, $value) {
        $this->attributes[$field] = $value;
    }

    /**
     * Get configred sensor names.
     *
     * @return array
     */
    public static function getSensorNames(): array
    {
        return SensorConfig::query()->where('type', self::CONFIG_TYPE_SENSOR_NAMES)->pluck('value')->toArray();
    }

    /**
     * Get configured sensor_ids.
     * @return Collection
     */
    public static function getConfiguredSensorIds(): Collection
    {
        return self::query()->select(DB::raw("JSON_Extract(sensor_configs.attributes,'$.sensor_id') as sensor_id"))->distinct()->pluck('sensor_id');
    }
}
