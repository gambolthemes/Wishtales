@extends('layouts.app')

@section('title', 'My Gifts')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Gifts</h1>
            <p class="text-gray-600 mt-1">Track all your sent and scheduled greeting cards</p>
        </div>
        <a href="{{ route('cards.index') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
            <i class="fas fa-plus mr-2"></i> Send New Card
        </a>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Sent</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $gifts->where('status', 'sent')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-paper-plane text-green-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Opened</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $gifts->where('status', 'opened')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope-open text-blue-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Scheduled</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $gifts->where('status', 'scheduled')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Drafts</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $gifts->where('status', 'draft')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file text-gray-500"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gifts List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @forelse($gifts as $gift)
            <div class="flex items-center p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <!-- Card Thumbnail -->
                <div class="w-16 h-20 rounded-lg overflow-hidden mr-4 flex-shrink-0">
                    <img src="{{ $gift->card->image }}" alt="{{ $gift->card->title }}" class="w-full h-full object-cover">
                </div>
                
                <!-- Gift Info -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $gift->card->title }}</h3>
                    <p class="text-sm text-gray-500">
                        To: {{ $gift->recipient_name }} ({{ $gift->recipient_email }})
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        @if($gift->sent_at)
                            Sent {{ $gift->sent_at->diffForHumans() }}
                        @elseif($gift->scheduled_at)
                            Scheduled for {{ $gift->scheduled_at->format('M d, Y h:i A') }}
                        @else
                            Created {{ $gift->created_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
                
                <!-- Status Badge -->
                <div class="mr-4">
                    @switch($gift->status)
                        @case('draft')
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">Draft</span>
                            @break
                        @case('scheduled')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Scheduled</span>
                            @break
                        @case('sent')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Sent</span>
                            @break
                        @case('opened')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Opened</span>
                            @break
                        @case('failed')
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Failed</span>
                            @break
                    @endswitch
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('gifts.show', $gift) }}" class="p-2 text-gray-400 hover:text-primary transition" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($gift->status == 'draft')
                        <form action="{{ route('gifts.send', $gift) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-gray-400 hover:text-green-500 transition" title="Send Now">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('gifts.destroy', $gift) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this gift?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <i class="fas fa-gift text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No gifts yet</h3>
                <p class="text-gray-500 mb-6">Start spreading joy by sending your first greeting card!</p>
                <a href="{{ route('cards.index') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Browse Cards
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $gifts->links() }}
    </div>
</div>
@endsection
