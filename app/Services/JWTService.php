<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    static string $field = "data";
    static string $method = "HS256";
    static string $env_key = "JWT_SECRET";
    static string $test_key = "testkey";

    public static function write(array $data)
    {
        return JWT::encode([
            self::$field => $data
        ], env(self::$env_key, self::$test_key), self::$method);
    }

    public static function read(string $jwt)
    {
        $jwt = JWT::decode(
            $jwt,
            new Key(
                env(
                    self::$env_key,
                    self::$test_key
                ),
                self::$method
            )
        );
        $field = self::$field;

        if (!isset($jwt->$field)) return null;

        return (array) $jwt->$field;
    }
}
