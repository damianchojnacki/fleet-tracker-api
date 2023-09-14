<?php

namespace App\Filament\Resources\OrganizationInvitationResource\Pages;

use App\Filament\Resources\CarResource;
use App\Filament\Resources\OrganizationInvitationResource;
use App\Filament\Resources\UserResource;
use App\Models\OrganizationInvitation;
use App\Notifications\InvitedToOrganization;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListOrganizationInvitations extends ListRecords
{
    protected static string $resource = OrganizationInvitationResource::class;

    protected static ?string $title = 'Invitations';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
