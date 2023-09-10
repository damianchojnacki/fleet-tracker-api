<?php

namespace Tests\Feature\Services;

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
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = json_decode(file_get_contents(base_path('tests/fixtures/cars.json')), true);

        ApiNinjas::fake([
            'cars*' => $this->data,
        ]);
    }

    public function testGetsCars(): void
    {
        $cars = (new CarRepository())->all('toyota', 1993);

        $cars->each(function ($car) {
            $this->assertInstanceOf(CarStruct::class, $car);
        });
    }

    public function testGetsModels(): void
    {
        $types = (new CarRepository())->models('toyota', 1993);

        $this->assertCount(2, $types);
        $this->assertEquals('camry', $types->get(0));
        $this->assertEquals('supra', $types->get(1));
    }

    public function testGetFuelTypes(): void
    {
        $types = (new CarRepository())->fuelTypes('toyota', 1993);

        $this->assertCount(2, $types);
        $this->assertEquals('hybrid', $types->get(0));
        $this->assertEquals('gas', $types->get(1));
    }

    public function testGetDrives(): void
    {
        $types = (new CarRepository())->drives('toyota', 1993);

        $this->assertCount(2, $types);
        $this->assertEquals('fwd', $types->get(0));
        $this->assertEquals('rwd', $types->get(1));
    }

    public function testGetTransmissions(): void
    {
        $types = (new CarRepository())->transmissions('toyota', 1993);

        $this->assertCount(2, $types);
        $this->assertEquals('a', $types->get(0));
        $this->assertEquals('m', $types->get(1));
    }
}
