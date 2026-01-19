<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Birthday',
                'slug' => 'birthday',
                'icon' => '🎂',
                'description' => 'Celebrate birthdays with beautiful cards',
                'sort_order' => 1,
            ],
            [
                'name' => 'Anniversary',
                'slug' => 'anniversary',
                'icon' => '💕',
                'description' => 'Mark special milestones with anniversary cards',
                'sort_order' => 2,
            ],
            [
                'name' => 'Easter',
                'slug' => 'easter',
                'icon' => '🐣',
                'description' => 'Easter greetings and spring celebrations',
                'sort_order' => 3,
            ],
            [
                'name' => 'Just Because',
                'slug' => 'just-because',
                'icon' => '🌸',
                'description' => 'No reason needed to show you care',
                'sort_order' => 4,
            ],
            [
                'name' => 'Women\'s Month',
                'slug' => 'womens-month',
                'icon' => '👩',
                'description' => 'Celebrate the women in your life',
                'sort_order' => 5,
            ],
            [
                'name' => 'Love',
                'slug' => 'love',
                'icon' => '❤️',
                'description' => 'Express your love with romantic cards',
                'sort_order' => 6,
            ],
            [
                'name' => 'Thank You',
                'slug' => 'thank-you',
                'icon' => '🙏',
                'description' => 'Show your gratitude with thank you cards',
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
