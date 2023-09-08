<?php

namespace App\Models;

use App\Notifications\InvitedToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class OrganizationInvitation extends Model
{
    use HasFactory;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function sendNotification(): void
    {
        Notification::route('mail', $this->email)
            ->notify(new InvitedToOrganization($this));
    }
}
