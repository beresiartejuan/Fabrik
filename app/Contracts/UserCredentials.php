<?php

namespace App\Contracts;

class UserCredentials
{
    private string|null $_nick;
    private string|null $_password;
    private string|null $_token = null;

    public function nick(string | null $nick = null): string | null
    {
        if (gettype($nick) === "string") {
            $this->_nick = $nick;
        }

        return $this->_nick;
    }

    public function password(string | null $password = null): string | null
    {
        if (gettype($password) === "string") {
            $this->_password = $password;
        }

        return $this->_password;
    }

    public function token(string | null $token = null): string | null
    {
        if (gettype($token) === "string") {
            $this->_token = $token;
        }

        return $this->_token;
    }

    public function isAuthenticable(): bool
    {
        return $this->_nick && $this->_password;
    }

    public static function from(array $credentials)
    {
        return new self(
            $credentials['nick'],
            $credentials['password'],
            $credentials['token']
        );
    }

    public function __construct(
        string | null $nick = null,
        string | null $password = null,
        string | null $token = null
    ) {
        $this->_nick = $nick;
        $this->_password = $password;
        $this->_token = $token;
    }
}
