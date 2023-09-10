<?php

namespace Tests\Feature\Services;

use ApiNinjas;
use App\Services\ApiNinjas\Structs\CarStruct;
use Exception;
use Tests\TestCase;

/**
 * @see \App\Services\ApiNinjas\Client
 */
class ApiNinjasTest extends TestCase
{
    public function testValidatesConfig(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Please set your API_NINJAS_API_KEY in the .env file.');

        app('api-ninjas');
    }

    public function testGetsCars(): void
    {
        $data = json_decode(file_get_contents(base_path('tests/fixtures/cars.json')), true);

        ApiNinjas::fake([
            'cars*' => $data,
        ]);

        $cars = ApiNinjas::cars()->get('toyota', 1993);

        $cars->each(function ($car) {
            $this->assertInstanceOf(CarStruct::class, $car);
        });
    }
}
