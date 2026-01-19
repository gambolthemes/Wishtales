@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-gift text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back!</h1>
                <p class="text-gray-500 mt-1">Login to continue sending beautiful cards</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
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
                               placeholder="Enter your password"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror"
                               required>
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:text-primary-dark">Forgot password?</a>
                </div>
                
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Login
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
            
            <!-- Register Link -->
            <p class="text-center mt-6 text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:text-primary-dark">Sign up</a>
            </p>
        </div>
    </div>
</div>
@endsection
