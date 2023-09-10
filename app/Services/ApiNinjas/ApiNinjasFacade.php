<?php

namespace App\Services\ApiNinjas;

use Illuminate\Support\Facades\Facade;

class ApiNinjasFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-ninjas';
    }

    /**
     * @param array<string,mixed> $callback
     */
    public static function fake(array $callback = []): ClientFake
    {
        static::swap($fake = new ClientFake($callback));

        return $fake;
    }
}
