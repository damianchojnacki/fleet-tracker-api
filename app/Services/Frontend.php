<?php

namespace App\Services;

class Frontend
{
    public static function url(): FrontendUrlGenerator
    {
        return new FrontendUrlGenerator(config('app.frontend_url'));
    }
}
