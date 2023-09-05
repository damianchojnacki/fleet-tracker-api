<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

trait CacheRequests
{
    protected function cache(string $path, callable $callback): mixed
    {
        return Cache::rememberForever($path, fn() => $callback($path));
    }
}
