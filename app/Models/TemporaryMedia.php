<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class TemporaryMedia extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'temporary_medias';
    protected $fillable = [
        'user_id',
        'folder',
        'temp_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->temp_id = Str::uuid();
            $model->folder = 'temp_' . time();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('temp_media')
            ->singleFile();
    }
}
