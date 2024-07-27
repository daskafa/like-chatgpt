<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'string', 'uuid'],
            'receipt_token' => ['required', 'string'],
        ];
    }
}
