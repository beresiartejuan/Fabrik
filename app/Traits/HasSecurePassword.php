<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

trait HasSecurePassword
{

    static string $password_field = "password";

    public function encrypt_password(): void
    {
        $this[self::$password_field] = Hash::make($this[self::$password_field]);
    }

    public function check_password($password): bool
    {
        return Hash::check($password, $this[self::$password_field]);
    }
}
