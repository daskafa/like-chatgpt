<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPremium extends Model
{
    protected $table = 'user_premiums';

    protected $fillable = [
        'device_uuid',
        'product_id',
        'remaining_chat_credit',
        'receipt_token',
        'is_active',
    ];
}
