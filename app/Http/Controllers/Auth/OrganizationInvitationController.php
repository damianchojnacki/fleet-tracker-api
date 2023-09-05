<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AcceptOrganizationInvitationRequest;
use App\Http\Requests\Auth\CancelOrganizationInvitationRequest;
use App\Models\OrganizationInvitation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrganizationInvitationController extends Controller
{
    public function accept(AcceptOrganizationInvitationRequest $request, OrganizationInvitation $invitation): JsonResponse
    {
        $request->user()->update([
            'organization_id' => $invitation->organization->id,
        ]);

        $invitation->delete();

        return $this->noContent();
    }

    public function cancel(CancelOrganizationInvitationRequest $request, OrganizationInvitation $invitation): JsonResponse
    {
        $invitation->delete();

        return $this->noContent();
    }
}