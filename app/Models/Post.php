<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'religion_id',
        'mood_id',
        'gender_id',
        'is_adult_content',
        'status'
    ];

    protected $casts = [
        'is_adult_content' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_media')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300);
                    
                $this->addMediaConversion('medium')
                    ->width(600)
                    ->height(600);
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
}
