<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'chat_id' => ['string', 'nullable'],
            'message' => ['required', 'string'],
        ];
    }
}
