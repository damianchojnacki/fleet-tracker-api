<?php

namespace App\Services\ApiNinjas;

use Illuminate\Support\ServiceProvider;

class ApiNinjasServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('api-ninjas', function () {
            return new Client();
        });

        $this->app->alias('api-ninjas', Client::class);
    }
}
