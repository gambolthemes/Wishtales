@extends('layouts.app')

@section('title', 'Get Inspired')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Get Inspired</h1>
        <p class="text-gray-600 mt-1">Discover beautiful card designs for every occasion</p>
    </div>
    
    <!-- Category Pills -->
    <div class="mb-8 overflow-x-auto">
        <div class="flex space-x-3 pb-2">
            <a href="{{ route('cards.index') }}" 
               class="category-pill active px-4 py-2 bg-white rounded-full text-sm font-medium whitespace-nowrap transition shadow-sm">
                All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('cards.category', $category) }}" 
                   class="category-pill px-4 py-2 bg-white rounded-full text-sm font-medium whitespace-nowrap transition shadow-sm">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Masonry Grid -->
    <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
        @foreach($cards as $card)
            <a href="{{ route('cards.show', $card) }}" 
               class="group block bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition break-inside-avoid mb-4">
                <div class="relative overflow-hidden">
                    @if($card->is_premium)
                        <div class="absolute top-2 left-2 z-10">
                            <span class="premium-badge px-2 py-1 rounded-full text-xs font-bold text-white">
                                <i class="fas fa-crown mr-1"></i> Premium
                            </span>
                        </div>
                    @endif
                    <img src="{{ $card->image }}" 
                         alt="{{ $card->title }}" 
                         class="w-full h-auto group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $card->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $card->category->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        {{ $cards->links() }}
    </div>
</div>
@endsection
