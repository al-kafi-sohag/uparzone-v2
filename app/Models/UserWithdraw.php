<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWithdraw extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    protected $fillable = [
        'user_id',
        'amount',
        'gateway',
        'account_number',
        'division',
        'user_transaction_id',
        'details',
        'status',
    ];

    protected $appends = [
        'statusText',
        'statusBadge',
    ];

    public function getStatusTextAttribute()
    {
        return $this->status == self::STATUS_PENDING ? 'Pending' : ($this->status == self::STATUS_APPROVED ? 'Approved' : 'Rejected');
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status == self::STATUS_PENDING ? 'bg-warning' : ($this->status == self::STATUS_APPROVED ? 'bg-success' : 'bg-danger');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
