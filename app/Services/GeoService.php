<?php

namespace App\Services;

class GeoService
{
    public static function calculateDistanceBetweenTwoPoints(
        float $lat_from,
        float $lng_from,
        float $lat_to,
        float $lng_to
    ): float
    {
        $rad = M_PI / 180;
        $theta = $lng_from - $lng_to;
        $dist = sin($lat_from * $rad)
            * sin($lat_to * $rad) + cos($lat_from * $rad)
            * cos($lat_to * $rad) * cos($theta * $rad);

        $distance = acos($dist) / $rad * 60 * 1.853;

        if(is_nan($distance)) {
            return 0;
        }

        return $distance;
    }
}
