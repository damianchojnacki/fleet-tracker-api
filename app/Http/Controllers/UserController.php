<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Http\Resources\UserResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show authenticated user.
     */
    public function show(Request $request): UserResource
    {
        /** @var User $user */
        $user = $request->user();

        if(!$user->hasVerifiedEmail()){
            abort(409, 'You must verify your email address.');
        }

        return new UserResource($user);
    }
}
