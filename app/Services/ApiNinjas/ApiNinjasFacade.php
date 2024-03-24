<?php

namespace App\Services\ApiNinjas;

use Exception;
use Illuminate\Support\Facades\Facade;

class ApiNinjasFacade extends Facade
{
    /**
     * @param array<string,mixed> $callback
     *
     * @throws Exception
     */
    public static function fake(array $callback = []): ClientFake
    {
        static::swap($fake = new ClientFake($callback));

        return $fake;
    }

    protected static function getFacadeAccessor(): string
    {
        return 'api-ninjas';
    }
}
