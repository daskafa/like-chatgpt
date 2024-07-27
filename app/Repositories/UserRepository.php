<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    private const AUTH_TOKEN_NAME = 'auth_token';

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

    public static function getByDeviceUuid(string $deviceUuid): User
    {
        return self::query()->where('device_uuid', $deviceUuid)->firstOrFail();
    }

    public static function createPlainTextToken(User $user): string
    {
        return $user->createToken(self::AUTH_TOKEN_NAME)->plainTextToken;
    }
}
