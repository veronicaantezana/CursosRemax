<?php

namespace App\Services;

use App\DTOs\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserSyncService
{
    public function syncUser(UserData $userData): User
    {
        Log::info('Sincronizando usuario', $userData->toArray());

        try {
            $user = User::updateOrCreate(
                ['external_id' => $userData->user_id],
                [
                    'username' => $userData->username,
                    'name_to_show' => $userData->name_to_show,
                    'first_name' => $userData->first_name,
                    'last_name' => $userData->last_name,
                    'role_id' => $userData->role_id,
                    'role' => $userData->role,
                ]
            );

            Log::info('Usuario sincronizado exitosamente', [
                'user_id' => $user->id,
                'external_id' => $user->external_id
            ]);

            return $user;

        } catch (\Exception $e) {
            Log::error('Error sincronizando usuario', [
                'error' => $e->getMessage(),
                'user_data' => $userData->toArray()
            ]);

            throw $e;
        }
    }
}