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
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if(!$user->hasVerifiedEmail()){
            return $this->setStatusCode(409)->json([
                'message' => 'You must verify your email address.'
            ]);
        }

        return $this->ok(
            new UserResource($user)
        );
    }
}
