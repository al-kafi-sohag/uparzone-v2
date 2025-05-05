<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Religion::create([
            'name' => 'Islam',
            'slug' => 'islam',
        ]);

        Religion::create([
            'name' => 'Christian',
            'slug' => 'christian',
        ]);

        Religion::create([
            'name' => 'Hindu',
            'slug' => 'hindu',
        ]);

        Religion::create([
            'name' => 'Buddhist',
            'slug' => 'buddhist',
        ]);

        Religion::create([
            'name' => 'Other',
            'slug' => 'other',
        ]);
    }
}
