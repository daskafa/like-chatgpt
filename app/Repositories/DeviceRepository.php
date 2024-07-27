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
}
