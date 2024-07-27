<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public static function query(): Builder
    {
        return User::query();
    }

    public static function checkUserIsRegistered(string $deviceUuid): bool
    {
        return self::query()->where('device_uuid', $deviceUuid)->exists();
    }

    public static function create(array $data): User
    {
        return self::query()->create($data);
    }

    public static function getUserByDeviceUuid(string $deviceUuid): User
    {
        return self::query()->where('device_uuid', $deviceUuid)->firstOrFail();
    }
}
