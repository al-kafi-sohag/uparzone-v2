<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UserTransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([UserTransactionObserver::class])]
class UserTransaction extends Model
{

    public const STATUS_PENDING = 0;
    public const STATUS_COMPLETED = 1;

    public const TYPE_CREDIT = 0;
    public const TYPE_DEBIT = 1;

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'amount',
        'note',
        'status',
        'type',
        'key',
    ];

    protected $appends = [
        'statusText',
        'statusBadge',
        'typeText',
    ];

    public function getStatusTextAttribute()
    {
        return $this->status == self::STATUS_PENDING ? 'Pending' : 'Completed';
    }

    public function getTypeTextAttribute()
    {
        return $this->type == self::TYPE_CREDIT ? 'Credit' : 'Debit';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status == self::STATUS_PENDING ? 'text-yellow-800 bg-yellow-100' : 'text-green-800 bg-green-100';
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
