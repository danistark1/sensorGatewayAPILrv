<?php

namespace App\Extensions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\CacheInterface;

class SimpleCacheWrapper implements CacheInterface
{
    /**
     * Get Cache.
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * Set a cache value.
     *
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        Cache::put($key, $value, $this->ttl2minutes($ttl));

        return true;
    }

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
     * Get multiple cache.
     *
     * @param iterable $keys
     * @param null $default
     * @return iterable
     */
    public function getMultiple($keys, $default = null)
    {
        return Cache::many($keys);
    }

    /**
     * Set multiple cache.
     *
     * @param iterable $values
     * @param null $ttl
     * @return bool
     */
    public function setMultiple($values, $ttl = null)
    {
        Cache::putMany($values, $this->ttl2minutes($ttl));

        return true;
    }

    /**
     * Delete multiple cache.
     *
     * @param iterable $keys
     * @return bool|void
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * Check if cache is set.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return Cache::has($key);
    }

    protected function ttl2minutes($ttl)
    {
        if (is_null($ttl)) {
            return null;
        }
        if ($ttl instanceof \DateInterval) {
            return $ttl->days * 86400 + $ttl->h * 3600 + $ttl->i * 60;
        }

        return $ttl / 60;
    }
}
