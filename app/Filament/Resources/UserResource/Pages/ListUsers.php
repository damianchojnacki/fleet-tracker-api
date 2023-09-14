<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\CarResource;
use App\Filament\Resources\UserResource;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Notifications\InvitedToOrganization;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Drivers';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New driver'),
            Action::make('invite')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->label('Invite driver')
                ->action(function (array $data): void {
                    if(OrganizationInvitation::where('email', $data['email'])->exists()) {
                        Notification::make()
                            ->title('User already exists')
                            ->danger()
                            ->send();

                        return;
                    }

                    OrganizationInvitation::create([
                        'email' => $data['email'],
                        'organization_id' => Filament::getTenant()->id,
                    ])->sendNotification();

                    Notification::make()
                        ->title('Invitation sent successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
