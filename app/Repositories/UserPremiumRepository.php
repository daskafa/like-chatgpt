<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Models\UserPremium;
use Illuminate\Database\Eloquent\Builder;

class UserPremiumRepository
{
    public static function query(): Builder
    {
        return UserPremium::query();
    }

    public static function makePremium(Product $product, User $user, string $receiptToken): UserPremium
    {
        return self::query()->create([
            'device_uuid' => $user->device_uuid,
            'product_id' => $product->uuid,
            'remaining_chat_credit' => $product->chat_credit,
            'receipt_token' => $receiptToken,
            'is_active' => true,
        ]);
    }

    public static function isActive(User $user): bool
    {
        return self::query()
            ->where('device_uuid', $user->device_uuid)
            ->where('is_active', true)
            ->exists();
    }
}
