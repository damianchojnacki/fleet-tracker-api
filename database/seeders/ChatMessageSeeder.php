<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::whereHas('organization')
            ->with('organization')
            ->get()
            ->each(function (User $user) {
                $user->chatMessages()->saveMany(
                    ChatMessage::factory()
                        ->count(rand(3, 10))
                        ->make([
                            'user_id' => $user->id,
                            'author_id' => $user->organization->owner_id,
                        ]),
                );
            });
    }
}
