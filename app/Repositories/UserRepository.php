<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $fillable)
    {
        $user = new User($fillable);
        $user->encrypt_password();
        $user->saveOrFail();
        return $user;
    }
}
