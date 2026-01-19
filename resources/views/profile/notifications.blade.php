@extends('layouts.app')

@section('title', 'Notification Settings')

@section('content')
<div class="p-6 lg:p-8 max-w-lg mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('profile.show') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Notifications</h1>
        <p class="text-gray-600 mt-1">Manage how you receive updates</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('profile.notifications.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            @php
                $settings = $user->notification_settings ?? [];
            @endphp
            
            <!-- Email Notifications -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Email Notifications</h3>
                
                <div class="space-y-4">
                    <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                        <div>
                            <p class="font-medium text-gray-800">Gift Opened</p>
                            <p class="text-sm text-gray-500">Get notified when someone opens your card</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" 
                                   name="email_gift_opened" 
                                   value="1"
                                   {{ ($settings['email_gift_opened'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary rounded-full peer peer-focus:ring-2 peer-focus:ring-primary transition"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                        <div>
                            <p class="font-medium text-gray-800">Event Reminders</p>
                            <p class="text-sm text-gray-500">Receive reminders for upcoming events</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" 
                                   name="email_reminders" 
                                   value="1"
                                   {{ ($settings['email_reminders'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary rounded-full peer peer-focus:ring-2 peer-focus:ring-primary transition"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                        <div>
                            <p class="font-medium text-gray-800">Newsletter</p>
                            <p class="text-sm text-gray-500">Receive updates about new features and cards</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" 
                                   name="email_newsletter" 
                                   value="1"
                                   {{ ($settings['email_newsletter'] ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary rounded-full peer peer-focus:ring-2 peer-focus:ring-primary transition"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Submit -->
            <button type="submit" 
                    class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                Save Preferences
            </button>
        </form>
    </div>
</div>

<style>
    /* Custom toggle switch */
    input:checked + div + div {
        transform: translateX(1.25rem);
    }
</style>
@endsection
