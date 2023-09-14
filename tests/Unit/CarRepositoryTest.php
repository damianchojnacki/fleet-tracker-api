<?php

namespace Tests\Unit;

use App\Services\CarRepository;
use Tests\TestCase;

/**
 * @see \App\Services\CarRepository
 */
class CarRepositoryTest extends TestCase
{
    public function testConvertsMpgToKmh(): void
    {
        $l100 = CarRepository::mpgTol100(30);

        $this->assertEquals(7.84, $l100);

        $l100 = CarRepository::mpgTol100(50);

        $this->assertEquals(4.7, $l100);
    }
}
