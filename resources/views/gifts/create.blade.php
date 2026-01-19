@extends('layouts.app')

@section('title', 'Send Card')

@php
    // Get customization data from query string (passed from customize page)
    $customMessage = request('message', '');
    $customRecipient = request('recipient_name', '');
    $customSender = request('sender_name', auth()->user()->name ?? '');
    $customEnvelope = request('envelope_style', 'default');
@endphp

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('cards.customize', $card) }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to customize
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Send Your Card</h1>
        <p class="text-gray-600 mt-1">Fill in the details to send your greeting card</p>
    </div>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Card Preview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-4 sticky top-24">
                <div class="aspect-[3/4] rounded-xl overflow-hidden mb-4">
                    <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-gray-800">{{ $card->title }}</h3>
                <p class="text-sm text-gray-500">{{ $card->category->name }}</p>
            </div>
        </div>
        
        <!-- Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('gifts.store') }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
                @csrf
                <input type="hidden" name="card_id" value="{{ $card->id }}">
                
                <!-- Recipient Details -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-user text-primary mr-2"></i> Recipient
                    </h2>
                    
                    @if($contacts->count() > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Choose from contacts</label>
                            <select name="contact_id" 
                                    id="contact_select"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="">-- Select a contact --</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" 
                                            data-name="{{ $contact->name }}"
                                            data-email="{{ $contact->email }}">
                                        {{ $contact->name }} {{ $contact->email ? "({$contact->email})" : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="relative mb-4">
                            <hr class="border-gray-200">
                            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-sm text-gray-500">or enter manually</span>
                        </div>
                    @endif
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Name *</label>
                            <input type="text" 
                                   name="recipient_name" 
                                   id="recipient_name"
                                   value="{{ old('recipient_name', $customRecipient) }}"
                                   placeholder="Enter recipient's name"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('recipient_name') border-red-500 @enderror"
                                   required>
                            @error('recipient_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Email *</label>
                            <input type="email" 
                                   name="recipient_email" 
                                   id="recipient_email"
                                   value="{{ old('recipient_email') }}"
                                   placeholder="Enter recipient's email"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('recipient_email') border-red-500 @enderror"
                                   required>
                            @error('recipient_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="save_contact" value="1" class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600">Save this recipient to my contacts</span>
                        </label>
                    </div>
                </div>
                
                <!-- Your Message -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-envelope text-primary mr-2"></i> Your Message
                    </h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" 
                                  rows="5"
                                  placeholder="Write your personal message here..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary resize-none @error('message') border-red-500 @enderror">{{ old('message', $customMessage) }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Name *</label>
                        <input type="text" 
                               name="sender_name" 
                               value="{{ old('sender_name', $customSender) }}"
                               placeholder="Enter your name"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('sender_name') border-red-500 @enderror"
                               required>
                        @error('sender_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Envelope Style -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-gift text-primary mr-2"></i> Envelope Style
                    </h2>
                    
                    <div class="grid grid-cols-3 md:grid-cols-5 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="envelope_style" value="default" class="hidden peer" {{ $customEnvelope == 'default' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center">
                                <div class="w-12 h-8 mx-auto mb-2 bg-gradient-to-r from-amber-200 to-amber-300 rounded"></div>
                                <span class="text-sm text-gray-600">Classic</span>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="envelope_style" value="gold" class="hidden peer" {{ $customEnvelope == 'gold' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center">
                                <div class="w-12 h-8 mx-auto mb-2 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded"></div>
                                <span class="text-sm text-gray-600">Gold</span>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="envelope_style" value="pink" class="hidden peer" {{ $customEnvelope == 'pink' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center">
                                <div class="w-12 h-8 mx-auto mb-2 bg-gradient-to-r from-pink-300 to-pink-400 rounded"></div>
                                <span class="text-sm text-gray-600">Pink</span>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="envelope_style" value="blue" class="hidden peer" {{ $customEnvelope == 'blue' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center">
                                <div class="w-12 h-8 mx-auto mb-2 bg-gradient-to-r from-blue-300 to-blue-500 rounded"></div>
                                <span class="text-sm text-gray-600">Blue</span>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="envelope_style" value="red" class="hidden peer" {{ $customEnvelope == 'red' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition text-center">
                                <div class="w-12 h-8 mx-auto mb-2 bg-gradient-to-r from-red-400 to-red-500 rounded"></div>
                                <span class="text-sm text-gray-600">Red</span>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Schedule (Optional) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-clock text-primary mr-2"></i> Delivery Time
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="delivery_type" value="now" class="hidden peer" checked>
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition">
                                <i class="fas fa-paper-plane text-primary text-xl mb-2"></i>
                                <p class="font-semibold text-gray-800">Send Now</p>
                                <p class="text-sm text-gray-500">Deliver immediately</p>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="delivery_type" value="schedule" class="hidden peer" id="schedule_radio">
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary peer-checked:bg-opacity-10 transition">
                                <i class="fas fa-calendar text-primary text-xl mb-2"></i>
                                <p class="font-semibold text-gray-800">Schedule</p>
                                <p class="text-sm text-gray-500">Pick a date & time</p>
                            </div>
                        </label>
                    </div>
                    
                    <div id="schedule_datetime" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Schedule Date & Time</label>
                        <input type="datetime-local" 
                               name="scheduled_at"
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i> Preview & Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Contact select autofill
    const contactSelect = document.getElementById('contact_select');
    if (contactSelect) {
        contactSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (selected.value) {
                document.getElementById('recipient_name').value = selected.dataset.name || '';
                document.getElementById('recipient_email').value = selected.dataset.email || '';
            }
        });
    }
    
    // Schedule toggle
    const scheduleRadio = document.getElementById('schedule_radio');
    const scheduleDatetime = document.getElementById('schedule_datetime');
    
    document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'schedule') {
                scheduleDatetime.classList.remove('hidden');
            } else {
                scheduleDatetime.classList.add('hidden');
            }
        });
    });
</script>
@endpush
