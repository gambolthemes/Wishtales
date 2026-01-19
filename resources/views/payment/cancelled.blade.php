@extends('layouts.app')

@section('title', 'Payment Cancelled - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white flex items-center justify-center py-12 px-6">
    <div class="max-w-md w-full text-center">
        <!-- Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-times text-4xl text-gray-400"></i>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Cancelled</h1>
        <p class="text-gray-600 mb-8">
            No worries! Your payment was cancelled and you haven't been charged. You can try again whenever you're ready.
        </p>

        <!-- Actions -->
        <div class="space-y-4">
            <a href="{{ route('pricing') }}" 
               class="block w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-primary-dark transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Pricing
            </a>
            <a href="{{ route('home') }}" 
               class="block w-full bg-gray-100 text-gray-800 py-4 rounded-xl font-semibold hover:bg-gray-200 transition">
                Continue with Free Plan
            </a>
        </div>

        <!-- Help -->
        <p class="text-sm text-gray-500 mt-8">
            Having trouble? 
            <a href="{{ route('help-center') }}" class="text-primary hover:underline">Contact our support team</a>
        </p>
    </div>
</div>
@endsection
