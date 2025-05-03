<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'spent_time',
        'spent_time_privacy',
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
        'status'
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
            'status' => 'integer'
        ];
    }
}
