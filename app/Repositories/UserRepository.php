<?php

namespace App\Repositories;

use App\Models\User;
use App\Roles;

class UserRepository
{
    public function create(array $fillable)
    {
        $user = new User($fillable);
        $user->encrypt_password();
        $user->saveOrFail();
        return $user;
    }

    public function update(User $user, array $new_data)
    {
        $user->update($new_data);
        return $user;
    }

    public function admins()
    {
        return User::role(Roles::ADMIN)->get();
    }
}
