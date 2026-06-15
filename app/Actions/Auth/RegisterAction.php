<?php

namespace App\Actions\Auth;

use App\Models\User;

class RegisterAction
{
    public function handle(array $data): array
    {
        $user = new User();

        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->password = $data['password'];

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
