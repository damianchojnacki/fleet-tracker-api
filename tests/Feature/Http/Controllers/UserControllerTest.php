<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowsAuthenticatedUser(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('user.show'))
            ->assertSuccessful();

        $this->assertEquals($user->id, $response->json('id'));
    }

    public function testReturnsErrorMessageWhenEmailIsNotVerified(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('user.show'))
            ->assertStatus(409);

        $this->assertEquals('You must verify your email address.', $response->json('message'));
    }
}
