<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{


    public function run()
    {
        NewsCategory::insert([
            [
                'id' => '1',
                'title' => 'Breaking News',
                'slug' => 'breaking-news',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'title' => 'Political News',
                'slug' => 'political-news',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'title' => 'Sports News',
                'slug' => 'sport-news',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
