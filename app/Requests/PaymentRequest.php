<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|string|in:credit_card,cash_on_delivery,bank_transfer',
        ];
    }
}
