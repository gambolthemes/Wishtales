@extends('layouts.app')

@section('title', 'Preview Gift')

@push('styles')
<style>
    .preview-bg {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }
    
    .envelope {
        background: linear-gradient(135deg, #d4a574 0%, #c4956a 100%);
        clip-path: polygon(0 30%, 50% 0, 100% 30%, 100% 100%, 0 100%);
    }
    
    .envelope.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffb347 100%);
    }
    
    .envelope.pink {
        background: linear-gradient(135deg, #ffb6c1 0%, #ff69b4 100%);
    }
    
    .envelope.blue {
        background: linear-gradient(135deg, #87ceeb 0%, #4169e1 100%);
    }
    
    .envelope.red {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
    }
    
    .sparkle {
        animation: sparkle 2s ease-in-out infinite;
    }
    
    @keyframes sparkle {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.2); }
    }
</style>
@endpush

@section('content')
<div class="preview-bg min-h-screen p-6 lg:p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('gifts.create', $gift->card) }}" class="text-white hover:text-primary transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Edit
        </a>
        <h1 class="text-white font-semibold text-xl">Preview</h1>
        <div></div>
    </div>
    
    <!-- Preview Container -->
    <div class="max-w-2xl mx-auto">
        <!-- Card Preview -->
        <div class="relative mb-8">
            <!-- Sparkles -->
            <div class="absolute -top-4 -left-4 text-yellow-300 text-2xl sparkle">✨</div>
            <div class="absolute -top-2 right-8 text-yellow-200 text-xl sparkle" style="animation-delay: 0.3s">✨</div>
            <div class="absolute bottom-20 -right-6 text-yellow-300 text-2xl sparkle" style="animation-delay: 0.6s">✨</div>
            <div class="absolute bottom-40 -left-8 text-yellow-200 text-lg sparkle" style="animation-delay: 0.9s">✨</div>
            
            <!-- Card -->
            <div class="aspect-[3/4] max-w-sm mx-auto rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ $gift->card->image }}" alt="{{ $gift->card->title }}" class="w-full h-full object-cover">
            </div>
            
            <!-- Envelope -->
            <div class="envelope {{ $gift->envelope_style }} absolute -bottom-8 left-1/2 -translate-x-1/2 w-80 h-24 rounded-b-lg shadow-xl"></div>
        </div>
        
        <!-- Message Preview -->
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 mt-16 text-white">
            <h3 class="font-semibold mb-4 text-center text-lg">Your Message</h3>
            
            <div class="bg-white bg-opacity-10 rounded-xl p-4 mb-4">
                <p class="text-center italic">{{ $gift->message ?: 'No message added' }}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">To:</p>
                    <p class="font-medium">{{ $gift->recipient_name }}</p>
                    <p class="text-gray-300 text-xs">{{ $gift->recipient_email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-400">From:</p>
                    <p class="font-medium">{{ $gift->sender_name }}</p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('gifts.create', $gift->card) }}" 
               class="bg-white bg-opacity-20 text-white px-8 py-4 rounded-xl font-semibold hover:bg-opacity-30 transition text-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            
            <form action="{{ route('gifts.send', $gift) }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full bg-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                    <i class="fas fa-paper-plane mr-2"></i>
                    @if($gift->scheduled_at)
                        Schedule Send
                    @else
                        Send Now
                    @endif
                </button>
            </form>
        </div>
        
        @if($gift->scheduled_at)
            <p class="text-center text-gray-400 mt-4 text-sm">
                <i class="fas fa-clock mr-1"></i>
                Scheduled for {{ $gift->scheduled_at->format('F j, Y \a\t g:i A') }}
            </p>
        @endif
    </div>
</div>
@endsection
