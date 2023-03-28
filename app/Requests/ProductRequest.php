<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_uuid' => 'required|string|max:36',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|between:0, 9999999999.99',
            'description' => 'required|string|max: 65535',
        ];
    }
}
