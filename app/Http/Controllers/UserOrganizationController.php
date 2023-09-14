<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserOrganizationRequest;
use App\Models\Organization;

class UserOrganizationController extends Controller
{
    /**
     * Create user organization.
     */
    public function store(CreateUserOrganizationRequest $request): Organization
    {
        $user = $request->user();

        $organization = new Organization($request->validated());
        $organization->owner()->associate($user);
        $organization->save();

        $user->update([
            'organization_id' => $organization->id,
        ]);

        return $organization;
    }
}
