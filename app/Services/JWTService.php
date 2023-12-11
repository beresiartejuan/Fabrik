<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    static string $field = "data";
    static string $method = "HS256";

    public static function write(array $data)
    {
        return JWT::encode([
            self::$field => $data
        ], env("JWT_SECRET", "testkey"), self::$method);
    }

    public static function read(string $jwt)
    {
        $jwt = JWT::decode($jwt, new Key(env("JWT_SECRET", "testkey"), self::$method));
        $field = self::$field;

        if (!isset($jwt->$field)) return null;

        return (array) $jwt->$field;
    }
}
