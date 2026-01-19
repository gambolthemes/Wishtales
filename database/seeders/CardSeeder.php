<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        $birthdayCards = [
            [
                'title' => 'Happy Birthday Cake',
                'description' => 'A colorful birthday cake card with candles',
                'image' => 'https://images.unsplash.com/photo-1558636508-e0db3814bd1d?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#FFF5E6',
            ],
            [
                'title' => 'Birthday Balloons',
                'description' => 'Festive balloons for birthday celebrations',
                'image' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#E6F4FF',
            ],
            [
                'title' => 'Confetti Celebration',
                'description' => 'Colorful confetti birthday card',
                'image' => 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => true,
                'background_color' => '#FFE6F0',
            ],
            [
                'title' => 'Birthday Wishes',
                'description' => 'Elegant birthday wishes card',
                'image' => 'https://images.unsplash.com/photo-1464349153735-7db50ed83c84?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => false,
                'background_color' => '#F0E6FF',
            ],
        ];

        $anniversaryCards = [
            [
                'title' => 'Happy Anniversary',
                'description' => 'Celebrate your love with this elegant card',
                'image' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => true,
                'background_color' => '#FFECEC',
            ],
            [
                'title' => 'Love Potion',
                'description' => 'A magical anniversary greeting',
                'image' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => false,
                'background_color' => '#FFE4EC',
            ],
            [
                'title' => 'Dream Couple',
                'description' => 'For the perfect couple',
                'image' => 'https://images.unsplash.com/photo-1529634597503-139d3726fed5?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#4AC4E0',
            ],
            [
                'title' => 'Forever Together',
                'description' => 'Celebrate your eternal love',
                'image' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => false,
                'background_color' => '#FFF0F5',
            ],
        ];

        $loveCards = [
            [
                'title' => 'I Love You',
                'description' => 'Simple and heartfelt love card',
                'image' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#FFE4E9',
            ],
            [
                'title' => 'Hearts & Roses',
                'description' => 'Classic romantic card',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => false,
                'background_color' => '#FFD6E0',
            ],
        ];

        $thankYouCards = [
            [
                'title' => 'Thank You Flowers',
                'description' => 'Beautiful floral thank you card',
                'image' => 'https://images.unsplash.com/photo-1487530811176-3780de880c2d?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#E8F5E9',
            ],
            [
                'title' => 'Grateful Heart',
                'description' => 'Express your gratitude',
                'image' => 'https://images.unsplash.com/photo-1606103920295-9a091573f160?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => false,
                'background_color' => '#FFF8E1',
            ],
        ];

        $justBecauseCards = [
            [
                'title' => 'Thinking of You',
                'description' => 'Let someone know you care',
                'image' => 'https://images.unsplash.com/photo-1518882605630-8eb738e92a82?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#F3E5F5',
            ],
            [
                'title' => 'Sunshine Wishes',
                'description' => 'Brighten someone\'s day',
                'image' => 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => false,
                'background_color' => '#FFFDE7',
            ],
        ];

        $easterCards = [
            [
                'title' => 'Easter Bunny',
                'description' => 'Cute Easter bunny greeting',
                'image' => 'https://images.unsplash.com/photo-1521967906867-14ec9d64bee8?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => false,
                'background_color' => '#E8F5E9',
            ],
            [
                'title' => 'Spring Flowers',
                'description' => 'Celebrate spring and Easter',
                'image' => 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => true,
                'background_color' => '#FFF9C4',
            ],
        ];

        $womensMonthCards = [
            [
                'title' => 'Women\'s Day',
                'description' => 'Celebrate International Women\'s Day',
                'image' => 'https://images.unsplash.com/photo-1489924309280-8e53bbf2be47?w=400&h=600&fit=crop',
                'is_premium' => false,
                'is_featured' => true,
                'background_color' => '#FCE4EC',
            ],
            [
                'title' => 'Strong Women',
                'description' => 'Honor the strong women in your life',
                'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=400&h=600&fit=crop',
                'is_premium' => true,
                'is_featured' => false,
                'background_color' => '#F3E5F5',
            ],
        ];

        $cardsByCategory = [
            'birthday' => $birthdayCards,
            'anniversary' => $anniversaryCards,
            'love' => $loveCards,
            'thank-you' => $thankYouCards,
            'just-because' => $justBecauseCards,
            'easter' => $easterCards,
            'womens-month' => $womensMonthCards,
        ];

        foreach ($cardsByCategory as $categorySlug => $cards) {
            $category = Category::where('slug', $categorySlug)->first();
            
            if ($category) {
                foreach ($cards as $cardData) {
                    Card::create([
                        ...$cardData,
                        'slug' => Str::slug($cardData['title']) . '-' . uniqid(),
                        'category_id' => $category->id,
                        'views' => rand(100, 5000),
                        'uses' => rand(10, 500),
                    ]);
                }
            }
        }
    }
}
