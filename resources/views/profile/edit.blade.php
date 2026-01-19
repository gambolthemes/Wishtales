@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="p-6 lg:p-8 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('profile.show') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
        <p class="text-gray-600 mt-1">Update your personal information</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Avatar -->
            <div class="mb-6 text-center">
                <div class="relative inline-block">
                    <div class="w-24 h-24 rounded-full overflow-hidden mx-auto">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder" class="w-full h-full bg-primary flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <label class="absolute bottom-0 right-0 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white cursor-pointer hover:bg-primary-dark transition">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-2">Click the camera icon to change photo</p>
                @error('avatar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Phone -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" 
                       name="phone" 
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="+1 (555) 123-4567"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Birthday -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Birthday</label>
                <input type="date" 
                       name="birthday" 
                       value="{{ old('birthday', $user->birthday?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('birthday') border-red-500 @enderror">
                @error('birthday')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Submit -->
            <div class="flex gap-4">
                <a href="{{ route('profile.show') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
