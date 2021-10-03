<?php

namespace App\Http\Controllers;

use App\Models\sensorConfig;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Config API Controller.
 */
class configController extends Controller
{
    /**
     * Delete a single cache entry.
     *
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        Log::channel('customMonolog')->debug("Cache with key $key was Deleted.");
        return Cache::forget($key);
    }

    /**
     * Delete cache storage.
     *
     * @return bool
     */
    public function clear()
    {
        Log::channel('customMonolog')->debug("Cache Cleared.");
        return Cache::flush();
    }

    /**
     * Check if cache is set.
     *
     * @param string $key
     * @return bool
     */
    public function has($key): bool
    {
        return Cache::has($key);
    }

    /**
     * Returns a cache value.
     *
     * @param string $lookupKey
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getConfigByKey(string $lookupKey) {
        $cacheKey = "cache_$lookupKey";
        $value = Cache::store('file')->get($cacheKey);
        if ($value === null) {
            $valueDb = sensorConfig::where('key', '=', $lookupKey)->value("value");
            if (!$valueDb) {
                return response("$lookupKey is not found.", 404);
            } else {
                // Cache the config.
                Cache::put($cacheKey, $valueDb, 525600);
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
        $cacheKey = "cache_$lookupValue";
        $value = Cache::store('file')->get($cacheKey);
        if ($value === null) {
            $valueDb = sensorConfig::where('value', '=', $lookupValue)->value("key");
            if (!$valueDb) {
                return response("$lookupValue is not found.", 404);
            } else {
                // Cache the config.
                Cache::put($cacheKey, $valueDb, 525600);
                $value = $valueDb;
            }
        }
        return $value;
    }
}
