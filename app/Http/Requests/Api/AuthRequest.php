<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'device_uuid' => ['required', 'string', 'uuid'],
            'device_name' => ['required', 'string'],
        ];
    }
}
