<?php

namespace App\Services\ApiNinjas;

use Illuminate\Support\Facades\Cache;

trait CacheRequests
{
    protected function cache(string $path, callable $callback)
    {
        return Cache::rememberForever($path, fn() => $callback($path));
    }
}
