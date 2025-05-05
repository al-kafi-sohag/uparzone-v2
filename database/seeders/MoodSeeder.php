<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mood;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mood::create([
            'name' => 'Happy',
            'slug' => 'happy',
            'emoji' => '😊',
        ]);

        Mood::create([
            'name' => 'Sad',
            'slug' => 'sad',
            'emoji' => '😢',
        ]);

        Mood::create([
            'name' => 'Angry',
            'slug' => 'angry',
            'emoji' => '😠',
        ]);

        Mood::create([
            'name' => 'Fear',
            'slug' => 'fear',
            'emoji' => '😨',
        ]);

        Mood::create([
            'name' => 'Surprise',
            'slug' => 'surprise',
            'emoji' => '😮',
        ]);

        Mood::create([
            'name' => 'Disgust',
            'slug' => 'disgust',
            'emoji' => '🤢',
        ]);

        Mood::create([
            'name' => 'Neutral',
            'slug' => 'neutral',
            'emoji' => '😐',
        ]);
    }
}
