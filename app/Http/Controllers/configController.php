<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\sensorConfig;
use Illuminate\Support\Facades\Log;

class configController extends Controller
{
    /**
     * Get all available config Keys.
     * This will be used for a drop-down ui to update configs.
     *
     */
    public function getAllKeys(): Response {
    }

    /**
     * Returns a cache value.
     *
     * @param string $lookupKey
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getConfigByKey(string $lookupKey) {
        $value = Cache::store('file')->has("cache_$lookupKey");
        if (!$value) {
            $valueDb = sensorConfig::where('key', '=', $lookupKey)->value("value");
            if (!$valueDb) {
                return response("$lookupKey is not found.", 404);
            } else {
                // Cache the config.
                Cache::put("cache_$lookupKey", $valueDb, 525600);
                $value = $valueDb;
            }
        }
        return $value;
    }

    /**
     * Returns a cache value.
     *
     * @param string $lookupValue
     */
    public function getConfigByValue(string $lookupValue) {
        $value = Cache::store('file')->has("cache_$lookupValue");
        if (!$value) {
            $valueDb = sensorConfig::where('value', '=', $lookupValue)->value("key");
            if (!$valueDb) {
                return response("$lookupValue is not found.", 404);
            } else {
                // Cache the config.
                Cache::put("cache_$lookupValue", $valueDb, 525600);
                $value = $valueDb;
            }
        }
        return $value;
    }

    /**
     *
     * @param string $lookupKey
     */
    public function deleteCacheKey(string $lookupKey) {
        Cache::forget("cache_$lookupKey");
    }

    /**
     *
     */
    public function flushCache() {
        Cache::flush();
        Log::channel('customMonolog')->debug("Cache Cleared.");

    }
}
