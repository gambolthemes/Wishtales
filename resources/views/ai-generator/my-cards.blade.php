@extends('layouts.app')

@section('title', 'My AI Generated Cards')

@push('styles')
<style>
    .page-bg {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        min-height: calc(100vh - 64px);
    }
    
    .card-item {
        transition: all 0.3s ease;
    }
    
    .card-item:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<div class="page-bg py-8 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">
                    <i class="fas fa-folder-open text-yellow-400 mr-3"></i>
                    My AI Generated Cards
                </h1>
                <p class="text-gray-400">All your saved AI-generated card designs</p>
            </div>
            <a href="{{ route('ai.generator') }}" class="bg-gradient-to-r from-pink-500 to-orange-400 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Generate New
            </a>
        </div>
        
        @if($cards->count() > 0)
        <!-- Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($cards as $card)
            <div class="card-item relative group rounded-2xl overflow-hidden shadow-xl bg-white/5">
                <div class="aspect-[3/4]">
                    <img src="{{ $card->image_url }}" alt="Generated Card" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition">
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-white text-sm mb-2 line-clamp-2">{{ $card->prompt }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex gap-2">
                                <span class="bg-white/20 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $card->style }}</span>
                                @if($card->recipe)
                                <span class="bg-pink-500/30 text-pink-300 text-[10px] px-2 py-0.5 rounded-full">#{{ $card->recipe }}</span>
                                @endif
                            </div>
                            <form action="{{ route('ai.destroy', $card) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center text-red-400 hover:bg-red-500/40 transition" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Date Badge -->
                <div class="absolute top-3 left-3">
                    <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-full">
                        {{ $card->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $cards->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 bg-white/5 rounded-full flex items-center justify-center">
                <i class="fas fa-wand-magic-sparkles text-gray-500 text-4xl"></i>
            </div>
            <h3 class="text-white text-xl font-semibold mb-2">No saved cards yet</h3>
            <p class="text-gray-400 mb-6">Generate some amazing AI cards and save them here!</p>
            <a href="{{ route('ai.generator') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-orange-400 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                <i class="fas fa-sparkles"></i> Start Generating
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
