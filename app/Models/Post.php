<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;


    protected $fillable = [
        'title',
        'content',
        'user_id',
        'post_category_id',
        'religion_id',
        'mood_id',
        'gender_id',
        'is_adult',
        'status',
        'views',
        'reactions',
        'comments',
        'shares',
    ];

    protected $appends = [
        'status_name',
        'status_badge',
        'media_url',
        'media_type',
        'media_thumb_url'
    ];
    protected $casts = [
        'is_adult' => 'boolean',
    ];

    public function getStatusNameAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status == self::STATUS_ACTIVE ? 'success' : 'danger';
    }

    public function getMediaTypeAttribute()
    {
        return optional($this->getFirstMedia('post_media'))->mime_type;
    }

    public function getMediaUrlAttribute()
    {
        return optional($this->getFirstMedia('post_media'))->getFullUrl();
    }

    public function getMediaThumbUrlAttribute()
    {
        return optional($this->getFirstMedia('post_media'))->getFullUrl('thumb');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_media')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                if (str_contains($media->mime_type, 'image')) {
                    $this->addMediaConversion('original')
                        ->format('webp')
                        ->quality(80)
                        ->optimize()
                        ->performOnCollections('post_media');

                    // Create a thumbnail in WebP format
                    $this->addMediaConversion('thumb')
                        ->format('webp')
                        ->quality(10)
                        ->blur(1)
                        ->pixelate(5)
                        ->optimize();
                }
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function postReactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator('-')
            ->usingLanguage('en');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
