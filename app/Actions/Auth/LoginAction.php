<?php

namespace App\Actions\Auth;

use App\Contracts\UserCredentials;
use App\Exceptions\InvalidCredentials;
use App\Models\User;

class LoginAction
{
    public static function handler(UserCredentials &$credentials): void
    {
        $user = User::nick($credentials->nick());

        if (!$user) {
            throw new InvalidCredentials();
        }

        if (!$user->check_password($credentials->password())) {
            throw new InvalidCredentials();
        }

        $credentials->token((string) auth()->login($user));
    }

    public function __invoke(UserCredentials $credentials)
    {
        return $this::handler($credentials);
    }
}