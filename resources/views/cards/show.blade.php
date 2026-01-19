@extends('layouts.app')

@section('title', $card->title)

@section('content')
<div class="p-6 lg:p-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('cards.index') }}" class="text-gray-500 hover:text-primary">Shop</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('cards.category', $card->category) }}" class="text-gray-500 hover:text-primary">{{ $card->category->name }}</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-800">{{ $card->title }}</span>
    </nav>
    
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Card Preview -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="relative aspect-[3/4] rounded-xl overflow-hidden">
                @if($card->is_premium)
                    <div class="absolute top-4 left-4 z-10">
                        <span class="premium-badge px-3 py-1.5 rounded-full text-sm font-bold text-white">
                            <i class="fas fa-crown mr-1"></i> Premium
                        </span>
                    </div>
                @endif
                <img src="{{ $card->image }}" 
                     alt="{{ $card->title }}" 
                     class="w-full h-full object-cover">
            </div>
        </div>
        
        <!-- Card Details -->
        <div>
            <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-medium mb-4">
                {{ $card->category->name }}
            </span>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $card->title }}</h1>
            
            @if($card->description)
                <p class="text-gray-600 mb-6">{{ $card->description }}</p>
            @endif
            
            <div class="flex items-center gap-6 mb-8 text-sm text-gray-500">
                <span><i class="fas fa-eye mr-1"></i> {{ number_format($card->views) }} views</span>
                <span><i class="fas fa-paper-plane mr-1"></i> {{ number_format($card->uses) }} sent</span>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('cards.customize', $card) }}" 
                   class="block w-full bg-primary text-white text-center py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                    <i class="fas fa-magic mr-2"></i> Customize & Send
                </a>
                
                @auth
                    <a href="{{ route('gifts.create', $card) }}" 
                       class="block w-full bg-white border-2 border-primary text-primary text-center py-4 rounded-xl font-semibold hover:bg-primary hover:text-white transition">
                        <i class="fas fa-paper-plane mr-2"></i> Quick Send
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="block w-full bg-white border-2 border-gray-300 text-gray-600 text-center py-4 rounded-xl font-semibold hover:border-primary hover:text-primary transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login to Send
                    </a>
                @endauth
            </div>
            
            <!-- Features -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="font-semibold text-gray-800 mb-4">What's Included</h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-600">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        Personalized message
                    </li>
                    <li class="flex items-center text-gray-600">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        Beautiful envelope animation
                    </li>
                    <li class="flex items-center text-gray-600">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        Send instantly or schedule
                    </li>
                    <li class="flex items-center text-gray-600">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        Track when it's opened
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Related Cards -->
    @if($relatedCards->count() > 0)
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">You Might Also Like</h2>
            
            <div class="card-grid">
                @foreach($relatedCards as $relatedCard)
                    <a href="{{ route('cards.show', $relatedCard) }}" 
                       class="group bg-white rounded-2xl overflow-hidden shadow-md card-hover transition duration-300">
                        <div class="relative aspect-[3/4] overflow-hidden">
                            @if($relatedCard->is_premium)
                                <div class="absolute top-2 left-2 z-10">
                                    <span class="premium-badge px-2 py-1 rounded-full text-xs font-bold text-white">
                                        <i class="fas fa-crown mr-1"></i> Premium
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $relatedCard->image }}" 
                                 alt="{{ $relatedCard->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $relatedCard->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $relatedCard->category->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
