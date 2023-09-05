<?php

namespace App\Services\ApiNinjas;

use App\Services\ApiNinjas\Structs\CarStruct;
use App\Services\CacheRequests;
use Illuminate\Support\Collection;

class Cars implements CarApi
{
    use CacheRequests;

    public function __construct(protected Client $client) {}

    /**
     * @return Collection<int,CarStruct>
     */
    public function get(string $brand, int $year): Collection
    {
        return $this->cache("cars?make=$brand&year=$year&limit=50", function (string $path) {
            return $this->client
                ->request
                ->get($path)
                ->collect()
                ->map(fn(array $model) => new CarStruct(...$model));
        });
    }
}
