@extends('layouts.app')

@section('title', 'Edit Contact')

@section('content')
<div class="p-6 lg:p-8 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('contacts.index') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Contacts
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Contact</h1>
    </div>
    
    <form action="{{ route('contacts.update', $contact) }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Basic Info -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-user text-primary mr-2"></i> Basic Info
            </h2>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $contact->name) }}"
                           placeholder="Enter name"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                    <select name="relationship" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Select relationship</option>
                        <option value="Friend" {{ old('relationship', $contact->relationship) == 'Friend' ? 'selected' : '' }}>Friend</option>
                        <option value="Family" {{ old('relationship', $contact->relationship) == 'Family' ? 'selected' : '' }}>Family</option>
                        <option value="Partner" {{ old('relationship', $contact->relationship) == 'Partner' ? 'selected' : '' }}>Partner</option>
                        <option value="Colleague" {{ old('relationship', $contact->relationship) == 'Colleague' ? 'selected' : '' }}>Colleague</option>
                        <option value="Other" {{ old('relationship', $contact->relationship) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Contact Details -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-address-card text-primary mr-2"></i> Contact Details
            </h2>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $contact->email) }}"
                           placeholder="Enter email"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone', $contact->phone) }}"
                           placeholder="Enter phone number"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Important Dates -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar text-primary mr-2"></i> Important Dates
            </h2>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Birthday</label>
                    <input type="date" 
                           name="birthday" 
                           value="{{ old('birthday', $contact->birthday?->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('birthday') border-red-500 @enderror">
                    @error('birthday')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anniversary</label>
                    <input type="date" 
                           name="anniversary" 
                           value="{{ old('anniversary', $contact->anniversary?->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('anniversary') border-red-500 @enderror">
                    @error('anniversary')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Notes -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" 
                      rows="3"
                      placeholder="Any notes about this contact..."
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary resize-none @error('notes') border-red-500 @enderror">{{ old('notes', $contact->notes) }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Submit -->
        <div class="flex gap-4 pt-4">
            <a href="{{ route('contacts.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-4 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                <i class="fas fa-save mr-2"></i> Update Contact
            </button>
        </div>
    </form>
</div>
@endsection
