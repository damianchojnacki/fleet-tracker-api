<?php

namespace Tests\Feature\Providers;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Providers\RouteServiceProvider
 */
class RouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testApiIsThrottledByIp(): void
    {
        config()->set('app.api_rate_limit_by_minute', 5);
        config()->set('app.frontend_url', 'http://127.0.0.1:3000');

        foreach (range(1, 5) as $i) {
            $this->getJson(route('brands.index'), [
                'X-Forwarded-For' => '192.168.0.1',
            ])->assertSuccessful();
        }

        $this->getJson(route('brands.index'), [
            'X-Forwarded-For' => '192.168.0.1',
        ])->assertTooManyRequests();

        $this->getJson(route('brands.index'), [
            'X-Forwarded-For' => '192.168.0.2',
        ])->assertSuccessful();
    }
}
