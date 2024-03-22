<?php

namespace App\Services\ApiNinjas\Structs;

class CarStruct
{
    public function __construct(
        public int $city_mpg,
        public string $class,
        public int $combination_mpg,
        public string $drive,
        public string $fuel_type,
        public int $highway_mpg,
        public string $make,
        public string $model,
        public string $transmission,
        public int $year,
        public ?float $displacement = null,
        public ?int $cylinders = null,
    ) {
    }
}
