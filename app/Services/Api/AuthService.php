<?php

namespace App\Services\Api;

use App\Repositories\DeviceRepository;
use App\Repositories\UserRepository;

class AuthService
{
    public function registerUser(string $deviceUuid, string $deviceName): void
    {
        DeviceRepository::create([
            'uuid' => $deviceUuid,
            'name' => $deviceName,
        ]);

        UserRepository::create([
            'device_uuid' => $deviceUuid,
        ]);
    }
}
