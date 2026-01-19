@extends('layouts.app')

@section('title', 'Payment Successful - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white flex items-center justify-center py-12 px-6">
    <div class="max-w-md w-full text-center">
        <!-- Success Animation -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center animate-bounce-slow">
                <i class="fas fa-check text-4xl text-green-500"></i>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">
            Welcome to your new plan! Your subscription is now active and you have access to all the premium features.
        </p>

        <!-- Subscription Info -->
        @if(Auth::user()->activeSubscription())
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="font-bold text-gray-800 mb-4">Your Subscription</h3>
            <div class="text-left space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">Plan</span>
                    <span class="font-semibold text-gray-800">{{ Auth::user()->activeSubscription()->plan->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                        <i class="fas fa-circle text-xs"></i> Active
                    </span>
                </div>
                @if(Auth::user()->activeSubscription()->onTrial())
                <div class="flex justify-between">
                    <span class="text-gray-500">Trial ends</span>
                    <span class="text-gray-800">{{ Auth::user()->activeSubscription()->trial_ends_at->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="space-y-4">
            <a href="{{ route('cards.index') }}" 
               class="block w-full bg-gradient-to-r from-primary to-pink-400 text-white py-4 rounded-xl font-bold hover:opacity-90 transition">
                Start Creating Cards <i class="fas fa-arrow-right ml-2"></i>
            </a>
            <a href="{{ route('ai.generator') }}" 
               class="block w-full bg-gray-100 text-gray-800 py-4 rounded-xl font-semibold hover:bg-gray-200 transition">
                <i class="fas fa-wand-magic-sparkles mr-2"></i> Try AI Generator
            </a>
        </div>

        <!-- Receipt -->
        <p class="text-sm text-gray-500 mt-8">
            <i class="fas fa-envelope mr-1"></i>
            A confirmation email has been sent to your email address.
        </p>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
</style>
@endsection
