@extends('layouts.app')

@section('title', 'Inbox')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Inbox</h1>
        <p class="text-gray-600 mt-1">Cards you've received from others</p>
    </div>
    
    <!-- Empty State -->
    <div class="text-center py-16 bg-white rounded-2xl shadow-md">
        <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Your inbox is empty</h3>
        <p class="text-gray-500 mb-6">When someone sends you a card, it will appear here</p>
        <a href="{{ route('cards.index') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
            Send a Card Yourself
        </a>
    </div>
</div>
@endsection
