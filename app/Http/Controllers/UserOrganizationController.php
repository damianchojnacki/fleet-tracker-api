<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AcceptOrganizationInvitationRequest;
use App\Http\Requests\Auth\CancelOrganizationInvitationRequest;
use App\Http\Requests\CreateUserOrganizationRequest;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use Illuminate\Http\JsonResponse;

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
