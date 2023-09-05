<?php

namespace App\Services\ApiNinjas;

use App\Services\ApiNinjas\Structs\CarStruct;
use Illuminate\Support\Collection;

interface CarApi
{
    /**
     * @return Collection<int, CarStruct>
     */
    public function get(string $brand, int $year): Collection;
}
