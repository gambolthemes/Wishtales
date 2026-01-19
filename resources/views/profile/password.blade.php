@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="p-6 lg:p-8 max-w-lg mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('profile.show') }}" class="text-primary hover:text-primary-dark mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Change Password</h1>
        <p class="text-gray-600 mt-1">Keep your account secure</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Current Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password *</label>
                <div class="relative">
                    <input type="password" 
                           name="current_password" 
                           id="current_password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('current_password') border-red-500 @enderror"
                           required>
                    <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- New Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password *</label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror"
                           required>
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Minimum 8 characters</p>
            </div>
            
            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password *</label>
                <div class="relative">
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                           required>
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <!-- Submit -->
            <div class="flex gap-4">
                <a href="{{ route('profile.show') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>
    
    <!-- Security Tips -->
    <div class="mt-6 bg-blue-50 rounded-xl p-4">
        <h4 class="font-semibold text-blue-800 mb-2">
            <i class="fas fa-shield-alt mr-2"></i> Security Tips
        </h4>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>• Use a mix of letters, numbers, and symbols</li>
            <li>• Don't use personal information</li>
            <li>• Don't reuse passwords from other sites</li>
            <li>• Consider using a password manager</li>
        </ul>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
