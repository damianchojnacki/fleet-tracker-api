<?php

namespace App\Services\ApiNinjas;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ClientFake extends Client
{
    public PendingRequest $request;

    /**
     * @param  array<string,mixed>  $callback
     *
     * @throws Exception
     */
    public function __construct(array $callback = [])
    {
        parent::__construct();

        $callback = collect($callback)->mapWithKeys(function ($item, $key) {
            return [static::$url.$key => $item];
        })->toArray();

        Http::fake($callback);

        $this->request = Http::withHeader('X-API-KEY', config('services.api_ninjas.api_key'))
            ->acceptJson()
            ->baseUrl(static::$url);
    }

    public function cars(): Cars
    {
        return new Cars($this);
    }
}
