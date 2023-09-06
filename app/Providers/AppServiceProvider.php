<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro('signature', function (string $route, array $attributes = [], Carbon $expiration = null) {
            $url = $this->signedRoute($route, $attributes, $expiration);

            parse_str(parse_url($url, PHP_URL_QUERY), $query);

            return $query['signature'];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        JsonResource::withoutWrapping();
    }
}
