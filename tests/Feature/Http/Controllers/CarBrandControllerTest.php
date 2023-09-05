<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarBrandController
 */
class CarBrandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListsCarBrands(): void
    {
        $response = $this->getJson(route('brands.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(CarBrand::count(), $response->json());
    }

    public function testShowsCarBrand(): void
    {
        $brand = CarBrand::first();

        $response = $this->getJson(route('brands.show', $brand))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($brand->id, $response->json('id'));
    }
}
