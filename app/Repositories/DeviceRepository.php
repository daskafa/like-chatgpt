<?php

namespace App\Repositories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;

class DeviceRepository
{
    public static function query(): Builder
    {
        return Device::query();
    }

    public static function create(array $data): Device
    {
        return self::query()->create($data);
    }

    public static function updateDeviceName(string $deviceUuid, string $deviceName): void
    {
        self::query()->where('uuid', $deviceUuid)->update(['name' => $deviceName]);
    }
}
