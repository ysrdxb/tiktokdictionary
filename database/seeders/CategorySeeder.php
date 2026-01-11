<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'TikTok Trends', 'icon' => 'trending', 'color' => '#fe2c55', 'sort_order' => 1],
            ['name' => 'Slang', 'icon' => 'chat', 'color' => '#25f4ee', 'sort_order' => 2],
            ['name' => 'Gaming', 'icon' => 'game', 'color' => '#9333ea', 'sort_order' => 3],
            ['name' => 'Memes', 'icon' => 'emoji', 'color' => '#f59e0b', 'sort_order' => 4],
            ['name' => 'Music', 'icon' => 'music', 'color' => '#10b981', 'sort_order' => 5],
            ['name' => 'Fashion', 'icon' => 'shirt', 'color' => '#ec4899', 'sort_order' => 6],
            ['name' => 'Internet Culture', 'icon' => 'globe', 'color' => '#3b82f6', 'sort_order' => 7],
            ['name' => 'Gen-Z', 'icon' => 'zap', 'color' => '#8b5cf6', 'sort_order' => 8],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                $category
            );
        }
    }
}
