<?php

namespace Tests\Unit;

use ApiNinjas;
use App\Models\User;
use App\Services\ApiNinjas\Structs\CarStruct;
use App\Services\CarRepository;
use App\Services\Frontend;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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
