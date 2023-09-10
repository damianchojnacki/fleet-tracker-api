<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DocsController
 */
class DocsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDocsAreVisibleInLocalEnv(): void
    {
        $this->app->detectEnvironment(static function () {
            return 'local';
        });

        $this->get(route('docs'))
            ->assertSuccessful()
            ->assertSeeText('Documentation');

        $this->get(route('docs', ['path' => 'css/base.css']))
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'text/css; charset=UTF-8');
    }

    public function testDocsAreNotVisibleByGuestInProductionEnv(): void
    {
        $this->app->detectEnvironment(static function () {
            return 'production';
        });

        $this->get(route('docs'))
            ->assertForbidden();
    }

    public function testDocsReturnNotFoundIfInvalidPath(): void
    {
        $this->app->detectEnvironment(static function () {
            return 'local';
        });

        $this->get(route('docs', ['path', 'invalid']))
            ->assertNotFound();
    }
}
