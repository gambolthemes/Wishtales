@extends('layouts.app')

@section('title', 'Shop Cards')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                @if(isset($category))
                    {{ $category->name }}
                @else
                    All Cards
                @endif
            </h1>
            <p class="text-gray-600 mt-1">Find the perfect card for every occasion</p>
        </div>
        
        <!-- Search -->
        <form action="{{ route('cards.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       placeholder="Search cards..." 
                       value="{{ request('search') }}"
                       class="pl-10 pr-4 py-2 bg-white rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-full hover:bg-primary-dark transition">
                Search
            </button>
        </form>
    </div>
    
    <!-- Category Pills -->
    <div class="mb-8 overflow-x-auto">
        <div class="flex space-x-3 pb-2">
            <a href="{{ route('cards.index') }}" 
               class="category-pill px-4 py-2 bg-white rounded-full text-sm font-medium whitespace-nowrap transition shadow-sm {{ !isset($category) && !request('category') ? 'active' : '' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('cards.category', $cat) }}" 
                   class="category-pill px-4 py-2 bg-white rounded-full text-sm font-medium whitespace-nowrap transition shadow-sm {{ (isset($category) && $category->id == $cat->id) || request('category') == $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Filter Tabs -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('cards.index', array_merge(request()->except('premium', 'free'), [])) }}" 
           class="text-sm font-medium {{ !request('premium') && !request('free') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700' }}">
            All
        </a>
        <a href="{{ route('cards.index', array_merge(request()->except('free'), ['premium' => 1])) }}" 
           class="text-sm font-medium {{ request('premium') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700' }}">
            <i class="fas fa-crown text-yellow-500 mr-1"></i> Premium
        </a>
        <a href="{{ route('cards.index', array_merge(request()->except('premium'), ['free' => 1])) }}" 
           class="text-sm font-medium {{ request('free') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700' }}">
            Free
        </a>
    </div>
    
    <!-- Cards Grid -->
    <div class="card-grid">
        @forelse($cards as $card)
            <a href="{{ route('cards.show', $card) }}" 
               class="group bg-white rounded-2xl overflow-hidden shadow-md card-hover transition duration-300">
                <div class="relative aspect-[3/4] overflow-hidden">
                    @if($card->is_premium)
                        <div class="absolute top-2 left-2 z-10">
                            <span class="premium-badge px-2 py-1 rounded-full text-xs font-bold text-white">
                                <i class="fas fa-crown mr-1"></i> Premium
                            </span>
                        </div>
                    @endif
                    <img src="{{ $card->image }}" 
                         alt="{{ $card->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $card->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $card->category->name }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No cards found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your search or filters</p>
                <a href="{{ route('cards.index') }}" class="text-primary hover:text-primary-dark font-medium">
                    View all cards
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        {{ $cards->links() }}
    </div>
</div>
@endsection
