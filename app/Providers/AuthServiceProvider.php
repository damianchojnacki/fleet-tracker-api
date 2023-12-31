<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Frontend;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return Frontend::url()->resetPassword($user, $token);
        });

        VerifyEmail::createUrlUsing(function (User $user) {
            return Frontend::url()->verifyEmail($user);
        });

        Gate::define('viewApiDocs', function (User $user) {
            return $user->isAdmin();
        });
    }
}
