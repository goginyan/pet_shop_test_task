<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'payment_id' => 'required|integer|exists:payments,id',
            'order_status_id' => 'required|integer|exists:order_statuses,id',
            'products' => 'required|array',
            'products.*.product' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'address.shipping' => 'string',
            'address.billing' => 'string',
            'amount' => 'required|numeric|between:0,9999999999.99',
            'delivery_fee' => 'required|numeric|between:0,999999.99',
        ];
    }
}
