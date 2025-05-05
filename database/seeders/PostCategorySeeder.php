<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostCategory;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostCategory::create([
            'name' => 'General',
            'slug' => 'general',
        ]);

        PostCategory::create([
            'name' => 'Travel',
            'slug' => 'travel',
        ]);

        PostCategory::create([
            'name' => 'Food',
            'slug' => 'food',
        ]);

        PostCategory::create([
            'name' => 'Health',
            'slug' => 'health',
        ]);

        PostCategory::create([
            'name' => 'Beauty',
            'slug' => 'beauty',
        ]);

        PostCategory::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
        ]);

        PostCategory::create([
            'name' => 'Sports',
            'slug' => 'sports',
        ]);

        PostCategory::create([
            'name' => 'Music',
            'slug' => 'music',
        ]);

        PostCategory::create([
            'name' => 'Movies',
            'slug' => 'movies',
        ]);

        PostCategory::create([
            'name' => 'Books',
            'slug' => 'books',
        ]);

        PostCategory::create([
            'name' => 'Games',
            'slug' => 'games',
        ]);

        PostCategory::create([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        PostCategory::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        PostCategory::create([
            'name' => 'Lifestyle',
            'slug' => 'lifestyle',
        ]);

        PostCategory::create([
            'name' => 'Education',
            'slug' => 'education',
        ]);

        PostCategory::create([
            'name' => 'Business',
            'slug' => 'business',
        ]);

        PostCategory::create([
            'name' => 'Others',
            'slug' => 'others',
        ]);
    }
}
