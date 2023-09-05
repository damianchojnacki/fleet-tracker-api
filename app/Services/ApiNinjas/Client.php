<?php

namespace App\Services\ApiNinjas;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Client
{
    public PendingRequest $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->validateConfig();

        $this->request = Http::withHeader('X-API-KEY', config('services.api_ninjas.api_key'))
            ->acceptJson()
            ->baseUrl('https://api.api-ninjas.com/v1/');
    }

    public function validateConfig(): void
    {
        if (! config('services.api_ninjas.api_key')) {
            throw new \Exception('Please set your API_NINJAS_API_KEY in the .env file.');
        }
    }

    public function cars(): Cars
    {
        return new Cars($this);
    }
}
