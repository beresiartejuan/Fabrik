<?php

namespace App;

use Spatie\Permission\Models\Role;

class Roles
{
    const ADMIN = "admin";
    const MANAGER = "manager";
    const WORKER = "worker";
    const CLIENT = "client";

    public static function admin()
    {
        return Role::where("name", self::ADMIN)->firstOrFail();
    }

    public static function manager()
    {
        return Role::where("name", self::MANAGER)->firstOrFail();
    }

    public static function worker()
    {
        return Role::where("name", self::WORKER)->firstOrFail();
    }

    public static function client()
    {
        return Role::where("name", self::CLIENT)->firstOrFail();
    }
}
