<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public static function query(): Builder
    {
        return Product::query();
    }

    public static function getByUuid(string $uuid): Product
    {
        return self::query()->where('uuid', $uuid)->firstOrFail();
    }
}
