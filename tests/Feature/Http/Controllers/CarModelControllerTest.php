<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarModel;
use App\Models\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarModelController
 */
class CarModelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldListCarModels(): void
    {
        CarModel::factory()->count(3)->create();

        $response = $this->getJson(route('models.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $model = CarModel::factory()->create();

        $response = $this->getJson(route('models.show', $model))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($model->id, $response->json('id'));
    }
}
