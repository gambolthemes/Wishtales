@extends('layouts.app')

@section('title', 'Gift Details')

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('gifts.index') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to My Gifts
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Gift Details</h1>
    </div>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Card Preview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-4">
                <div class="aspect-[3/4] rounded-xl overflow-hidden mb-4">
                    <img src="{{ $gift->card->image }}" alt="{{ $gift->card->title }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-gray-800">{{ $gift->card->title }}</h3>
                <p class="text-sm text-gray-500">{{ $gift->card->category->name }}</p>
            </div>
        </div>
        
        <!-- Gift Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Status</h2>
                    @switch($gift->status)
                        @case('draft')
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-medium">Draft</span>
                            @break
                        @case('scheduled')
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full font-medium">Scheduled</span>
                            @break
                        @case('sent')
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-medium">Sent</span>
                            @break
                        @case('opened')
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full font-medium">Opened</span>
                            @break
                        @case('failed')
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full font-medium">Failed</span>
                            @break
                    @endswitch
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Created</span>
                        <span class="text-gray-800">{{ $gift->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @if($gift->scheduled_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Scheduled For</span>
                            <span class="text-gray-800">{{ $gift->scheduled_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif
                    @if($gift->sent_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Sent</span>
                            <span class="text-gray-800">{{ $gift->sent_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif
                    @if($gift->opened_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Opened</span>
                            <span class="text-gray-800">{{ $gift->opened_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Recipient Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-user text-primary mr-2"></i> Recipient
                </h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-gray-800 font-medium">{{ $gift->recipient_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-800">{{ $gift->recipient_email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Message -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-envelope text-primary mr-2"></i> Message
                </h2>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-700 italic">{{ $gift->message ?: 'No message' }}</p>
                </div>
                <p class="text-right text-gray-500 mt-4">- {{ $gift->sender_name }}</p>
            </div>
            
            <!-- Share Link -->
            @if($gift->status != 'draft')
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-link text-primary mr-2"></i> Share Link
                    </h2>
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               id="share-link"
                               value="{{ route('gifts.public', $gift->tracking_code) }}" 
                               readonly
                               class="flex-1 px-4 py-3 bg-gray-100 rounded-xl text-sm">
                        <button onclick="copyLink()" 
                                class="bg-primary text-white px-4 py-3 rounded-xl hover:bg-primary-dark transition">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            <!-- Actions -->
            <div class="flex gap-4">
                @if($gift->status == 'draft')
                    <form action="{{ route('gifts.send', $gift) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                            <i class="fas fa-paper-plane mr-2"></i> Send Now
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('gifts.destroy', $gift) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-100 text-red-600 px-6 py-4 rounded-xl font-semibold hover:bg-red-200 transition">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyLink() {
        const link = document.getElementById('share-link');
        link.select();
        document.execCommand('copy');
        alert('Link copied to clipboard!');
    }
</script>
@endpush
