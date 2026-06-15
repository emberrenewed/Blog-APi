<?php

namespace App\Actions\Auth;

use App\Models\User;

class LogoutAction
{
    public function handle(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
