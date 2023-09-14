<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, string|null>
     */
    public function hosts(): array
    {
        return [
            $this->frontendDomain(),
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }

    public function frontendDomain(): ?string
    {
        return parse_url($this->app['config']->get('app.frontend_url'), PHP_URL_HOST) ?? null;
    }
}
