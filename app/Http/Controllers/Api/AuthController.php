<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\LoginAction;
use App\Contracts\UserCredentials;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = UserCredentials::from(
            $request->validated()
        );

        LoginAction::handler($credentials);

        return $this->responseWithToken($credentials->token());
    }
}
