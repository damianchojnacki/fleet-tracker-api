<?php

namespace App\Services\ApiNinjas;

use Illuminate\Support\Facades\Facade;

class ApiNinjasFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-ninjas';
    }

    public static function fake(array $callback = []): ClientFake
    {
        static::swap($fake = new ClientFake($callback));

        return $fake;
    }
}
