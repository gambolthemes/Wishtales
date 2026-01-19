@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-gift text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Create Account</h1>
                <p class="text-gray-500 mt-1">Join WishTales and start spreading joy</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Enter your name"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror"
                               required>
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="Enter your email"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror"
                               required>
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               placeholder="Create a password"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror"
                               required>
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               placeholder="Confirm your password"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                               required>
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" class="rounded text-primary focus:ring-primary mt-1" required>
                        <span class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="{{ route('terms-of-service') }}" class="text-primary hover:text-primary-dark">Terms of Service</a> 
                            and <a href="{{ route('privacy-policy') }}" class="text-primary hover:text-primary-dark">Privacy Policy</a>
                        </span>
                    </label>
                </div>
                
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Create Account
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <hr class="border-gray-200">
                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-sm text-gray-500">or</span>
            </div>
            
            <!-- Social Login -->
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center gap-3 border border-gray-200 py-3 rounded-xl hover:bg-gray-50 transition">
                    <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5">
                    <span class="text-gray-700 font-medium">Continue with Google</span>
                </button>
            </div>
            
            <!-- Login Link -->
            <p class="text-center mt-6 text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-primary-dark">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
