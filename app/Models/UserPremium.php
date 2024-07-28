<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPremium extends Model
{
    use HasFactory;

    protected $table = 'user_premiums';

    protected $fillable = [
        'device_uuid',
        'product_id',
        'remaining_chat_credit',
        'receipt_token',
        'is_active',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_uuid', 'uuid');
    }
}
