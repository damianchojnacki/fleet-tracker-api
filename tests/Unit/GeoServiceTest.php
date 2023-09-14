<?php

namespace Tests\Unit;

use App\Services\GeoService;
use PHPUnit\Framework\TestCase;

class GeoServiceTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCorrectlyCalculatesDistanceBetweenTwoPoints(): void
    {
        $distance = GeoService::calculateDistanceBetweenTwoPoints(52.2327, 21.0141, 53.1222, 17.9945);

        $this->assertEquals(226.3, round($distance, 1));

        $distance = GeoService::calculateDistanceBetweenTwoPoints(53.1222, 17.9945, 52.2327, 21.0141);

        $this->assertEquals(226.3, round($distance, 1));

        $distance = GeoService::calculateDistanceBetweenTwoPoints(53.1322, 23.1687, 52.2327, 21.0141);

        $this->assertEquals(176.3, round($distance, 1));
    }
}
