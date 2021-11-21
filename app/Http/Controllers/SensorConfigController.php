<?php

namespace App\Http\Controllers;

use App\Models\SensorConfig;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\SensorConfigService;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Config API Controller.
 */
class SensorConfigController extends Controller
{
    const SENSOR_CONFIG_FETCH_ERROR = 'Something went wrong while fetching a config ';
    const SENSOR_CONFIG_SAVE_ERROR  = 'Something went wrong while saving a sensor config ';

    /**
     * Delete a single cache entry.
     *
     * @param string $key
     * @return bool
     */
    public function delete($key): bool
    {
        // TODO move to services class
        Log::channel('customMonolog')->debug("Cache with key $key was Deleted.");
        return Cache::forget($key);
    }

    /**
     * Delete cache storage.
     *
     * @return bool
     */
    public function clear(): bool
    {
        // TODO move to services class
        Log::channel('customMonolog')->debug("Cache Cleared.");
        return Cache::flush();
    }

    /**
     * Check if cache is set.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        // TODO move to services class.
        return Cache::has($key);
    }

    /**
     * Save a config.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveConfig(Request $request): JsonResponse {
        /** @var SensorConfigService $configService */
        $configService = resolve(SensorConfigService::class);
        try {
            $configService->createOrUpdateConfig($request->all());
            return response()->json($request->all(), 201);
        } catch (\Throwable $throwable) {
            Log::channel('customMonolog')->debug($throwable->getMessage(), [$request->all()]);
            return response()->json(['message' => self::SENSOR_CONFIG_SAVE_ERROR . $throwable->getMessage()], 500);
        }
    }

    /**
     * Returns a cache value.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getConfigByKey(Request $request): JsonResponse {
        /** @var  SensorConfigService $sensorConfigService */
        $sensorConfigService = resolve(SensorConfigService::class);
        try {
            $configValue = $sensorConfigService->getConfigKey($request->get('key'));
            return response()->json(['value' => $configValue], 201);
        } catch (\Throwable $throwable) {
            Log::channel('customMonolog')->debug($throwable->getMessage(), [$request->all()]);
            return response()->json(['message' => self::SENSOR_CONFIG_FETCH_ERROR . $throwable->getMessage()], 500);
        }
    }

    /**
     * Returns a cache value.
     *
     * @param string $lookupValue
     * @return array|mixed
     * @throws InvalidArgumentException
     */
    public function getConfigByValue(string $lookupValue) {
        // TODO move to services class.
        $cacheKey = "cache_$lookupValue";
        $value = Cache::store('file')->get($cacheKey);
        if ($value === null) {
            $valueDb = SensorConfig::where('value', '=', $lookupValue)->value("key");
            if (!$valueDb) {
                return [];
            } else {
                // Cache the config.
                Cache::put($cacheKey, $valueDb, 525600);
                $value = $valueDb;
            }
        }
        return $value;
    }
}
