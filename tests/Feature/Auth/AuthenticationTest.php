<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogIn(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSuccessful();

        $this->assertNotNull($response->json('token'));
    }

    public function testUserCanNotLogInUsingWrongPassword(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertInvalid('email');
    }

    public function testLoginIsThrottled(): void
    {
        $user = User::factory()->create();

        foreach(range(0, 5) as $i){
            $response = $this->postJson(route('login'), [
                'email' => $user->email,
                'password' => Str::random(),
            ]);
        }

        $this->assertStringContainsString('Too many login attempts.', $response->json('message'));
    }

    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('logout'))
            ->assertSuccessful();
    }
}
