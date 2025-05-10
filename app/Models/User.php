<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'referer_id',
        'reference_code',
        'phone',
        'lang',
        'balance',
        'balance_privacy',
        'reserved_balance',
        'freeze_balance',
        'active_time',
        'active_time_privacy',
        'is_premium',
        'is_complete_profile',
        'age',
        'age_privacy',
        'profession',
        'profession_privacy',
        'address',
        'address_privacy',
        'city',
        'city_privacy',
        'state',
        'state_privacy',
        'country',
        'country_privacy',
        'zip_code',
        'zip_code_privacy',
        'gender_id',
        'gender_privacy',
        'mood_id',
        'mood_privacy',
        'religion_id',
        'religion_privacy',
        'status',
        'last_active_at',
        'total_referral'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'float',
            'balance_privacy' => 'boolean',
            'reserved_balance' => 'float',
            'freeze_balance' => 'float',
            'spent_time' => 'float',
            'spent_time_privacy' => 'boolean',
            'is_premium' => 'boolean',
            'is_complete_profile' => 'boolean',
            'age' => 'float',
            'age_privacy' => 'boolean',
            'profession_privacy' => 'boolean',
            'address_privacy' => 'boolean',
            'city_privacy' => 'boolean',
            'state_privacy' => 'boolean',
            'country_privacy' => 'boolean',
            'zip_code_privacy' => 'boolean',
            'gender_privacy' => 'boolean',
            'mood_privacy' => 'boolean',
            'religion_privacy' => 'boolean',
            'status' => 'integer',
            'referer_id' => 'integer',
            'reference_code' => 'string',
            'google_id' => 'string',
            'phone' => 'string',
            'lang' => 'string',
            'gender' => 'string',

        ];
    }
    public function mood(): BelongsTo
    {
        return $this->belongsTo(Mood::class, 'mood_id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function referer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referer_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referer_id');
    }

}
