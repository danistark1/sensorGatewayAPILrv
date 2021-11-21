<?php

namespace App\Services;

use App\Models\SensorConfig;
use Illuminate\Support\Facades\Cache;

class SensorConfigService
{

    public function getConfigKey(string $lookupKey) {
        $cacheKey = "cache_$lookupKey";
        $value = Cache::store('file')->get($cacheKey);
        if ($value === null) {
            $valueDb = SensorConfig::where('key', '=', $lookupKey)->value("value");
            if (!$valueDb) {
                return [];
            } else {
                // Cache the config.
                Cache::put($cacheKey, $valueDb, 525600); // TODO config this.
                $value = $valueDb;
            }
        }
        return $value;
    }
    /**
     * Create/Update Config.
     *
     * @param $configArray
     */
    public function createOrUpdateConfig($configArray) {
        /** @var SensorConfig $sensorConfig */
        $sensorConfig = resolve(SensorConfig::class);
        if (isset($configArray['id'])) {
            $sensorConfig = $sensorConfig->find($configArray['id']);
        }
        $sensorConfig->key = $configArray['key'];
        $sensorConfig->value = $configArray['value'];
        $sensorConfig->type = $configArray['type'];
        $sensorConfig->attributes = $configArray['attributes'];
        $sensorConfig->save();
    }
}
