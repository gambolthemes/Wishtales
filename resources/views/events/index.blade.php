@extends('layouts.app')

@section('title', 'Upcoming Events')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Upcoming Events</h1>
            <p class="text-gray-600 mt-1">Never miss an important date</p>
        </div>
        <a href="{{ route('events.create') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
            <i class="fas fa-plus mr-2"></i> Add Event
        </a>
    </div>
    
    <!-- Events Timeline -->
    <div class="space-y-4">
        @forelse($events as $event)
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start gap-4">
                    <!-- Date Badge -->
                    <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-xl flex flex-col items-center justify-center text-white">
                        <span class="text-2xl font-bold">{{ $event->event_date->format('d') }}</span>
                        <span class="text-xs uppercase">{{ $event->event_date->format('M') }}</span>
                    </div>
                    
                    <!-- Event Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $event->title }}</h3>
                            @switch($event->event_type)
                                @case('birthday')
                                    <span class="text-lg">🎂</span>
                                    @break
                                @case('anniversary')
                                    <span class="text-lg">💕</span>
                                    @break
                                @case('holiday')
                                    <span class="text-lg">🎉</span>
                                    @break
                                @default
                                    <span class="text-lg">📅</span>
                            @endswitch
                        </div>
                        
                        @if($event->contact)
                            <p class="text-sm text-gray-500 mb-2">
                                <i class="fas fa-user mr-1"></i> {{ $event->contact->name }}
                            </p>
                        @endif
                        
                        @if($event->description)
                            <p class="text-gray-600 text-sm">{{ $event->description }}</p>
                        @endif
                        
                        <div class="flex items-center gap-4 mt-3 text-sm">
                            @if($event->is_recurring)
                                <span class="text-gray-500">
                                    <i class="fas fa-sync-alt mr-1"></i> Recurring
                                </span>
                            @endif
                            <span class="text-gray-500">
                                <i class="fas fa-bell mr-1"></i> {{ $event->remind_days_before }} days before
                            </span>
                            <span class="text-primary font-medium">
                                {{ $event->event_date->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('cards.index') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                            Send Card
                        </a>
                        <a href="{{ route('events.edit', $event) }}" class="p-2 text-gray-400 hover:text-primary transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                <i class="fas fa-calendar-alt text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No upcoming events</h3>
                <p class="text-gray-500 mb-6">Add important dates to never miss an occasion</p>
                <a href="{{ route('events.create') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Add Event
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection
