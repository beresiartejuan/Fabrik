<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return !auth()->check();
    }

    public function rules()
    {
        return [
            "nick" => "required|string|min:3",
            "password" => "required|string|min:5",
        ];
    }
}
