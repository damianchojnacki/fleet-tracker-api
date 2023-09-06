<?php

namespace App\Services;

use ApiNinjas;
use App\Services\ApiNinjas\CarApi;
use App\Services\ApiNinjas\Structs\CarStruct;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CarRepository
{
    protected CarApi $api;

    public function __construct()
    {
        $this->api = ApiNinjas::cars();
    }

    /**
     * @return Collection<int,CarStruct>
     */
    public function all(string $brand, int $year): Collection
    {
        return $this->api->get($brand, $year);
    }

    /**
     * @return Collection<int,string>
     */
    public function models(string $brand, int $year): Collection
    {
        return $this->all($brand, $year)
            ->pluck('model')
            ->unique()
            ->values();
    }

    /**
     * @return Collection<int,string>
     */
    public function fuelTypes(string $brand, int $year): Collection
    {
        return $this->all($brand, $year)
            ->pluck('fuel_type')
            ->unique()
            ->values();
    }

    /**
     * @return Collection<int,string>
     */
    public function drives(string $brand, int $year): Collection
    {
        return $this->all($brand, $year)
            ->pluck('drive')
            ->unique()
            ->values();
    }

    /**
     * @return Collection<int,string>
     */
    public function transmissions(string $brand, int $year): Collection
    {
        return $this->all($brand, $year)
            ->pluck('transmission')
            ->unique()
            ->values();
    }

    public static function mpgToKml(float $mpg): float
    {
        return round(235.214583 / $mpg, 2);
    }
}
