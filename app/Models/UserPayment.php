<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UserPaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([UserPaymentObserver::class])]
class UserPayment extends Model
{
    public const STATUS_PENDING = 0;
    public const STATUS_COMPLETED = 1;
    public const STATUS_FAILED = 2;
    public const STATUS_CANCELLED = 3;

    public const PAYMENT_METHOD_SSLCOMMERZ = 0;
    public const PAYMENT_METHOD_MANUAL = 1;

    protected $fillable = [
        'user_id',
        'user_transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'payment_note',
        'details',
        'key',
    ];

    protected $appends = [
        'statusText',
        'statusBadge',
        'paymentMethodText',
        'paymentMethodBadge',
    ];

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-500',
            self::STATUS_COMPLETED => 'bg-green-500',
            self::STATUS_FAILED => 'bg-red-500',
            self::STATUS_CANCELLED => 'bg-red-500',
            default => 'bg-red-500',
        };
    }

    public function getPaymentMethodTextAttribute()
    {
        return match ($this->payment_method) {
            self::PAYMENT_METHOD_SSLCOMMERZ => 'SSLCommerz',
            self::PAYMENT_METHOD_MANUAL => 'Manual',
            default => 'Unknown',
        };
    }

    public function getPaymentMethodBadgeAttribute()
    {
        return match ($this->payment_method) {
            self::PAYMENT_METHOD_SSLCOMMERZ => 'bg-yellow-500',
            self::PAYMENT_METHOD_MANUAL => 'bg-green-500',
            default => 'bg-red-500',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
