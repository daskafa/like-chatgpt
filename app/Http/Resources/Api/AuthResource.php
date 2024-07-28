<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'device_name' => $this->device->name,
            'premium_information' => [
                'remaining_active_chat_credit' => $this->whenLoaded('premiums', function () {
                    return $this->premiums->where('is_active', true)->first()?->remaining_chat_credit;
                }),
            ],
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
