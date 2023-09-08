<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AcceptOrganizationInvitationRequest;
use App\Http\Requests\Auth\CancelOrganizationInvitationRequest;
use App\Models\OrganizationInvitation;
use Illuminate\Http\JsonResponse;

class OrganizationInvitationController extends Controller
{
    /**
     * Accept organization invitation.
     */
    public function accept(AcceptOrganizationInvitationRequest $request, OrganizationInvitation $invitation): JsonResponse
    {
        $request->user()->update([
            'organization_id' => $invitation->organization->id,
        ]);

        $invitation->delete();

        return $this->noContent();
    }

    /**
     * Cancel organization invitation.
     */
    public function cancel(CancelOrganizationInvitationRequest $request, OrganizationInvitation $invitation): JsonResponse
    {
        $invitation->delete();

        return $this->noContent();
    }
}
