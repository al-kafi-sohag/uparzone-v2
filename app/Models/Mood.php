<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Mood extends Model
{
    use HasSlug;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;


    protected $appends = ['status_name', 'status_badge'];
    protected $fillable = [
        'name',
        'slug',
        'order',
        'status',
        'emoji',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }

    public function getStatusNameAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'success' : 'danger';
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
