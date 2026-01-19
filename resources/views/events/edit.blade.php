@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="p-6 lg:p-8 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('events.index') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Events
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Event</h1>
    </div>
    
    <form action="{{ route('events.update', $event) }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Event Details -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar-plus text-primary mr-2"></i> Event Details
            </h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $event->title) }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                        <input type="date" 
                               name="event_date" 
                               value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('event_date') border-red-500 @enderror"
                               required>
                        @error('event_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                        <select name="event_type" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                                required>
                            <option value="birthday" {{ old('event_type', $event->event_type) == 'birthday' ? 'selected' : '' }}>🎂 Birthday</option>
                            <option value="anniversary" {{ old('event_type', $event->event_type) == 'anniversary' ? 'selected' : '' }}>💕 Anniversary</option>
                            <option value="holiday" {{ old('event_type', $event->event_type) == 'holiday' ? 'selected' : '' }}>🎉 Holiday</option>
                            <option value="custom" {{ old('event_type', $event->event_type) == 'custom' ? 'selected' : '' }}>📅 Custom</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary resize-none @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Link to Contact -->
        @if($contacts->count() > 0)
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-user text-primary mr-2"></i> Link to Contact
                </h2>
                
                <select name="contact_id" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">-- None --</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ old('contact_id', $event->contact_id) == $contact->id ? 'selected' : '' }}>
                            {{ $contact->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        
        <!-- Reminder Settings -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-bell text-primary mr-2"></i> Reminder
            </h2>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Remind me</label>
                    <select name="remind_days_before" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="1" {{ old('remind_days_before', $event->remind_days_before) == '1' ? 'selected' : '' }}>1 day before</option>
                        <option value="3" {{ old('remind_days_before', $event->remind_days_before) == '3' ? 'selected' : '' }}>3 days before</option>
                        <option value="7" {{ old('remind_days_before', $event->remind_days_before) == '7' ? 'selected' : '' }}>1 week before</option>
                        <option value="14" {{ old('remind_days_before', $event->remind_days_before) == '14' ? 'selected' : '' }}>2 weeks before</option>
                        <option value="30" {{ old('remind_days_before', $event->remind_days_before) == '30' ? 'selected' : '' }}>1 month before</option>
                    </select>
                </div>
                
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="is_recurring" 
                               value="1"
                               {{ old('is_recurring', $event->is_recurring) ? 'checked' : '' }}
                               class="rounded text-primary focus:ring-primary mr-3">
                        <div>
                            <span class="text-gray-800 font-medium">Recurring Event</span>
                            <p class="text-sm text-gray-500">Repeat every year</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Submit -->
        <div class="flex gap-4 pt-4">
            <a href="{{ route('events.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-4 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                <i class="fas fa-save mr-2"></i> Update Event
            </button>
        </div>
    </form>
</div>
@endsection
