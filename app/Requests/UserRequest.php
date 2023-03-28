<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255',
            'avatar' => 'string',
            'phone_number' => 'required|string|max:255',
            'is_marketing' => 'required|integer|min:0|max:1',
        ];
    }
}
