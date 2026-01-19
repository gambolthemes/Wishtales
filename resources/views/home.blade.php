@extends('layouts.app')

@section('title', 'Home - Send Beautiful Digital Cards')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(180deg, #FFF5F5 0%, #FFE4E9 50%, #FFD6E0 100%);
    }
    
    .hero-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FF6B9D' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .card-float {
        animation: cardFloat 4s ease-in-out infinite;
    }
    
    .card-float-delayed {
        animation: cardFloat 4s ease-in-out infinite;
        animation-delay: -1.3s;
    }
    
    .card-float-delayed-2 {
        animation: cardFloat 4s ease-in-out infinite;
        animation-delay: -2.6s;
    }
    
    @keyframes cardFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(2deg); }
    }
    
    .text-gradient-pink {
        background: linear-gradient(135deg, #FF6B9D 0%, #FF8E53 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .feature-card {
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: scale(1.05);
    }
    
    .category-card:hover .category-icon {
        transform: scale(1.2) rotate(10deg);
    }
    
    .category-icon {
        transition: all 0.3s ease;
    }
    
    .stat-counter {
        background: linear-gradient(135deg, #FF6B9D 0%, #c850c0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .testimonial-card {
        transition: all 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
    }
    
    .cta-gradient {
        background: linear-gradient(135deg, #FF6B9D 0%, #FF8E53 100%);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-gradient hero-pattern py-16 lg:py-24 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <div class="inline-flex items-center bg-white/80 backdrop-blur-sm rounded-full px-4 py-2 mb-6 shadow-sm">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium text-gray-600">Over 2,000+ cards sent this month</span>
                </div>
                
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                    <span class="text-gray-800">Send Beautiful</span><br>
                    <span class="text-gradient-pink">Digital Cards</span><br>
                    <span class="text-gray-800">Instantly</span> <span class="text-3xl lg:text-5xl">✨</span>
                </h1>
                
                <p class="text-gray-600 text-lg mb-8 max-w-lg">
                    Create personalized greeting cards for any occasion. Add your message, customize the design, and send joy to your loved ones in seconds.
                </p>
                
                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="{{ route('cards.index') }}" 
                       class="bg-white text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-gray-50 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 border border-gray-100">
                        <i class="fas fa-pencil-alt mr-2 text-primary"></i> Create Card Now
                    </a>
                    <a href="#how-it-works" 
                       class="bg-transparent text-gray-600 px-8 py-4 rounded-full font-semibold hover:bg-white/50 transition flex items-center">
                        <i class="fas fa-play-circle mr-2 text-primary"></i> How It Works
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="flex items-center gap-8">
                    <div>
                        <div class="text-3xl font-bold text-gradient-pink">10K+</div>
                        <div class="text-gray-500 text-sm">Happy Users</div>
                    </div>
                    <div class="w-px h-12 bg-gray-300"></div>
                    <div>
                        <div class="text-3xl font-bold text-gradient-pink">50K+</div>
                        <div class="text-gray-500 text-sm">Cards Sent</div>
                    </div>
                    <div class="w-px h-12 bg-gray-300"></div>
                    <div>
                        <div class="text-3xl font-bold text-gradient-pink">100+</div>
                        <div class="text-gray-500 text-sm">Templates</div>
                    </div>
                </div>
            </div>
            
            <!-- Right - Floating Cards -->
            <div class="relative h-96 lg:h-[500px] hidden lg:block">
                <!-- Glow Effects -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-pink-300/30 to-purple-300/30 rounded-full blur-3xl"></div>
                
                <!-- Card 1 - Birthday (Left) -->
                <div class="absolute top-12 left-32 w-44 card-float" style="transform-origin: center;">
                    <div class="relative rounded-2xl overflow-hidden shadow-[0_15px_40px_rgba(0,0,0,0.15)] border-3 border-white bg-white">
                        <div class="aspect-[3/4]">
                            <img src="https://images.unsplash.com/photo-1558636508-e0db3814bd1d?w=300&h=400&fit=crop" alt="Birthday Card" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3">
                            <span class="inline-block bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                🎂 Birthday
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2 - Love (Center - Main) -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-44 z-20 card-float-delayed">
                    <div class="relative rounded-2xl overflow-hidden shadow-[0_25px_50px_rgba(255,107,157,0.3)] border-3 border-white bg-white">
                        <div class="aspect-[3/4] bg-gradient-to-br from-pink-400 via-rose-400 to-pink-500 relative">
                            <!-- Gift Box Design -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="relative">
                                    <!-- Gift Box -->
                                    <div class="w-20 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg shadow-lg relative overflow-hidden">
                                        <!-- Ribbon Horizontal -->
                                        <div class="absolute top-1/2 left-0 right-0 h-3 bg-yellow-400 -translate-y-1/2"></div>
                                        <!-- Ribbon Vertical -->
                                        <div class="absolute top-0 bottom-0 left-1/2 w-3 bg-yellow-400 -translate-x-1/2"></div>
                                        <!-- Shine -->
                                        <div class="absolute top-1.5 left-1.5 w-3 h-3 bg-white/30 rounded-full"></div>
                                    </div>
                                    <!-- Bow -->
                                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 flex items-center">
                                        <div class="w-4 h-4 bg-yellow-400 rounded-full -mr-0.5"></div>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <div class="w-4 h-4 bg-yellow-400 rounded-full -ml-0.5"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Confetti -->
                            <div class="absolute top-3 left-3 w-1.5 h-1.5 bg-white/60 rounded-full"></div>
                            <div class="absolute top-6 right-4 w-2 h-2 bg-yellow-300/60 rounded-full"></div>
                            <div class="absolute bottom-10 left-4 w-1.5 h-1.5 bg-white/40 rounded-full"></div>
                            <div class="absolute bottom-16 right-3 w-1.5 h-1.5 bg-purple-300/60 rounded-full"></div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-pink-600/90 to-transparent">
                            <span class="inline-block bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                💝 Love
                            </span>
                        </div>
                    </div>
                    <!-- Floating Badge -->
                    <div class="absolute -top-2 -right-2 bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                        Popular ⭐
                    </div>
                </div>
                
                <!-- Card 3 - Celebration (Right) -->
                <div class="absolute top-8 right-8 w-44 card-float-delayed-2">
                    <div class="relative rounded-2xl overflow-hidden shadow-[0_15px_40px_rgba(0,0,0,0.15)] border-3 border-white bg-white">
                        <div class="aspect-[3/4]">
                            <img src="https://images.unsplash.com/photo-1513151233558-d860c5398176?w=300&h=400&fit=crop" alt="Celebration Card" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3">
                            <span class="inline-block bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                🎉 Celebration
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-6 left-1/3 w-6 h-6 border-2 border-pink-300/50 rounded-full animate-pulse"></div>
                <div class="absolute bottom-16 left-16 w-4 h-4 bg-gradient-to-br from-yellow-300 to-orange-300 rounded-full opacity-60 animate-bounce" style="animation-duration: 2s;"></div>
                <div class="absolute top-1/4 right-4 w-3 h-3 bg-gradient-to-br from-cyan-300 to-blue-300 rounded-full opacity-60"></div>
                <div class="absolute bottom-1/3 right-20 w-2 h-2 bg-gradient-to-br from-purple-300 to-pink-300 rounded-full opacity-60"></div>
                
                <!-- Sparkles -->
                <svg class="absolute top-16 right-24 w-5 h-5 text-yellow-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0L14.59 8.41L23 11L14.59 13.59L12 22L9.41 13.59L1 11L9.41 8.41L12 0Z"/>
                </svg>
                <svg class="absolute bottom-28 left-24 w-4 h-4 text-pink-400 animate-pulse" style="animation-delay: 0.5s;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0L14.59 8.41L23 11L14.59 13.59L12 22L9.41 13.59L1 11L9.41 8.41L12 0Z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Trusted By Section -->
<section class="py-12 px-6 bg-white border-b">
    <div class="max-w-7xl mx-auto">
        <p class="text-center text-gray-400 text-sm font-medium mb-8 uppercase tracking-wider">Trusted by teams at</p>
        <div class="flex flex-wrap justify-center items-center gap-12 opacity-50">
            <div class="flex items-center gap-2 text-gray-400">
                <i class="fab fa-google text-3xl"></i>
                <span class="font-semibold text-lg">Google</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
                <i class="fab fa-microsoft text-3xl"></i>
                <span class="font-semibold text-lg">Microsoft</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
                <i class="fab fa-slack text-3xl"></i>
                <span class="font-semibold text-lg">Slack</span>
            </div>
            <div class="flex items-center gap-2 text-gray-400">
                <i class="fab fa-spotify text-3xl"></i>
                <span class="font-semibold text-lg">Spotify</span>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 px-6 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
                CATEGORIES
            </span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Cards for Every Occasion</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">From birthdays to thank you notes, find the perfect card to express your feelings</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('cards.category', $category) }}" 
                   class="category-card bg-white rounded-2xl p-6 shadow-md hover:shadow-xl text-center group cursor-pointer">
                    <div class="category-icon w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center text-3xl
                        @switch($category->slug)
                            @case('birthday')
                                bg-pink-100
                                @break
                            @case('anniversary')
                                bg-red-100
                                @break
                            @case('thank-you')
                                bg-yellow-100
                                @break
                            @case('love')
                                bg-rose-100
                                @break
                            @case('easter')
                                bg-green-100
                                @break
                            @default
                                bg-purple-100
                        @endswitch
                    ">
                        @switch($category->slug)
                            @case('birthday')
                                🎂
                                @break
                            @case('anniversary')
                                💕
                                @break
                            @case('easter')
                                🐣
                                @break
                            @case('just-because')
                                🌸
                                @break
                            @case('womens-month')
                                👩
                                @break
                            @case('love')
                                ❤️
                                @break
                            @case('thank-you')
                                🙏
                                @break
                            @default
                                🎉
                        @endswitch
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-400">{{ $category->cards_count ?? rand(5, 20) }} cards</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Cards Section -->
<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <div>
                <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    POPULAR
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800">Featured Cards</h2>
            </div>
            <a href="{{ route('cards.index') }}" class="mt-4 md:mt-0 text-primary hover:text-primary-dark font-semibold inline-flex items-center group">
                View All Cards 
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($featuredCards->take(8) as $card)
                <a href="{{ route('cards.show', $card) }}" 
                   class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        @if($card->is_premium)
                            <div class="absolute top-3 left-3 z-10">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 px-3 py-1 rounded-full text-xs font-bold text-white shadow-lg">
                                    <i class="fas fa-crown mr-1"></i> PRO
                                </span>
                            </div>
                        @endif
                        <img src="{{ $card->image }}" 
                             alt="{{ $card->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition">
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-semibold">
                                    <i class="fas fa-eye mr-1"></i> Preview
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 truncate mb-1">{{ $card->title }}</h3>
                        <p class="text-sm text-gray-400 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-primary mr-2"></span>
                            {{ $card->category->name }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-inbox text-gray-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No featured cards yet</p>
                    <p class="text-gray-400 text-sm">Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-20 px-6 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
                HOW IT WORKS
            </span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Send Cards in 3 Easy Steps</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Creating and sending beautiful digital cards has never been easier</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="feature-card bg-white rounded-3xl p-8 text-center shadow-lg relative">
                <div class="step-line relative">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-br from-primary to-pink-400 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        1
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Choose a Card</h3>
                <p class="text-gray-500">Browse our extensive collection of beautifully designed cards for any occasion.</p>
            </div>
            
            <!-- Step 2 -->
            <div class="feature-card bg-white rounded-3xl p-8 text-center shadow-lg relative">
                <div class="step-line relative">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-br from-primary to-pink-400 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        2
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Customize It</h3>
                <p class="text-gray-500">Add your personal message, choose envelope styles, and make it uniquely yours.</p>
            </div>
            
            <!-- Step 3 -->
            <div class="feature-card bg-white rounded-3xl p-8 text-center shadow-lg">
                <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-br from-primary to-pink-400 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    3
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Send with Love</h3>
                <p class="text-gray-500">Deliver instantly via email or schedule for the perfect moment.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
                TESTIMONIALS
            </span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Loved by Thousands</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">See what our happy users have to say about their experience</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="testimonial-card bg-gradient-to-br from-pink-50 to-white rounded-3xl p-8 shadow-lg">
                <div class="flex items-center gap-1 text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"The cards are absolutely gorgeous! I sent one to my mom for her birthday and she was over the moon. So easy to use!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-purple-400 flex items-center justify-center text-white font-bold">S</div>
                    <div>
                        <p class="font-bold text-gray-800">Sarah Johnson</p>
                        <p class="text-sm text-gray-400">Marketing Manager</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="testimonial-card bg-gradient-to-br from-blue-50 to-white rounded-3xl p-8 shadow-lg">
                <div class="flex items-center gap-1 text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"We use WishTales for all our team celebrations. The scheduling feature is a game-changer. Highly recommend!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center text-white font-bold">M</div>
                    <div>
                        <p class="font-bold text-gray-800">Michael Chen</p>
                        <p class="text-sm text-gray-400">Team Lead</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="testimonial-card bg-gradient-to-br from-purple-50 to-white rounded-3xl p-8 shadow-lg">
                <div class="flex items-center gap-1 text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"Finally, a modern way to send cards! The envelope animations are such a nice touch. My friends love receiving them."</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">E</div>
                    <div>
                        <p class="font-bold text-gray-800">Emily Davis</p>
                        <p class="text-sm text-gray-400">Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="cta-gradient rounded-3xl p-12 text-center text-white relative overflow-hidden">
            <!-- Background decorations -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Ready to Spread Some Joy?</h2>
                <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                    Join thousands of happy users sending beautiful digital cards to their loved ones. Start creating today!
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('cards.index') }}" 
                       class="bg-white text-primary px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-rocket mr-2"></i> Get Started Free
                    </a>
                    @guest
                        <a href="{{ route('register') }}" 
                           class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition">
                            Create Account
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-16 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <i class="fas fa-gift text-white"></i>
                    </div>
                    <span class="text-2xl font-bold">WishTales</span>
                </div>
                <p class="text-gray-400 mb-6 max-w-sm">
                    Create and send beautiful digital greeting cards for any occasion. Spread joy with personalized messages.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
            <!-- Links -->
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('cards.index') }}" class="hover:text-white transition">Browse Cards</a></li>
                    <li><a href="#how-it-works" class="hover:text-white transition">How It Works</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h4 class="font-bold mb-4">Support</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ route('help-center') }}" class="hover:text-white transition">Help Center</a></li>
                    <li><a href="{{ route('privacy-policy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms-of-service') }}" class="hover:text-white transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} WishTales. All rights reserved. Made with <i class="fas fa-heart text-primary"></i></p>
        </div>
    </div>
</footer>
@endsection
