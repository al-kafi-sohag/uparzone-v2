<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTimeTracking extends Model
{
    public const TRACKING_INTERVAL = 90;
    protected $fillable = [
        'user_id',
        'last_active_at',
        'active_time',
        'reward_amount',
    ];
}
