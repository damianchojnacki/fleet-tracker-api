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

    public function shouldListCarBrands(): void
    {
        CarBrand::factory()->count(3)->create();

        $response = $this->getJson(route('brands.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }

    public function shouldShowCarBrand(): void
    {
        $brand = CarBrand::factory()->create();

        $response = $this->getJson(route('brands.show', $brand))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($brand->id, $response->json('id'));
    }
}
