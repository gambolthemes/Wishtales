@extends('layouts.app')

@section('title', 'Help Center - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-primary to-pink-400 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-question-circle text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Help Center</h1>
            <p class="text-gray-500 max-w-lg mx-auto">Find answers to common questions and learn how to make the most of WishTales</p>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-10">
            <div class="relative">
                <input type="text" 
                       placeholder="Search for help..." 
                       class="w-full px-6 py-4 pl-14 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <a href="#getting-started" class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-rocket text-blue-500 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Getting Started</h3>
                <p class="text-gray-500 text-sm">Learn the basics of creating and sending cards</p>
            </a>
            <a href="#account" class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-user-circle text-green-500 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Account & Profile</h3>
                <p class="text-gray-500 text-sm">Manage your account settings and preferences</p>
            </a>
            <a href="#billing" class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-credit-card text-purple-500 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Billing & Premium</h3>
                <p class="text-gray-500 text-sm">Questions about payments and subscriptions</p>
            </a>
        </div>

        <!-- FAQs -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Frequently Asked Questions</h2>
            </div>

            <!-- Getting Started -->
            <div id="getting-started" class="border-b border-gray-100">
                <h3 class="px-6 py-4 bg-gray-50 font-semibold text-gray-700">
                    <i class="fas fa-rocket text-blue-500 mr-2"></i> Getting Started
                </h3>
                
                <div class="divide-y divide-gray-100">
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">How do I create my first card?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>Creating your first card is easy! Simply:</p>
                            <ol class="list-decimal ml-5 mt-2 space-y-1">
                                <li>Browse our card collection in the Shop</li>
                                <li>Click on a card you like to preview it</li>
                                <li>Click "Customize" to add your personal message</li>
                                <li>Choose an envelope style and send!</li>
                            </ol>
                        </div>
                    </details>
                    
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">Can I schedule cards to be sent later?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>Yes! When customizing your card, you can choose to schedule delivery for a specific date and time. Perfect for birthdays, anniversaries, and special occasions!</p>
                        </div>
                    </details>

                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">How does the AI Card Generator work?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>Our AI Card Generator creates unique card designs based on your description. Simply:</p>
                            <ol class="list-decimal ml-5 mt-2 space-y-1">
                                <li>Go to AI Generator from the sidebar</li>
                                <li>Choose a style (Realistic, Painting, Drawing, 3D)</li>
                                <li>Select a recipe/theme for inspiration</li>
                                <li>Type your prompt describing the card you want</li>
                                <li>Click Generate and choose your favorite!</li>
                            </ol>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Account -->
            <div id="account" class="border-b border-gray-100">
                <h3 class="px-6 py-4 bg-gray-50 font-semibold text-gray-700">
                    <i class="fas fa-user-circle text-green-500 mr-2"></i> Account & Profile
                </h3>
                
                <div class="divide-y divide-gray-100">
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">How do I change my password?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>To change your password:</p>
                            <ol class="list-decimal ml-5 mt-2 space-y-1">
                                <li>Go to Profile from the sidebar</li>
                                <li>Click on "Change Password"</li>
                                <li>Enter your current password and new password</li>
                                <li>Click "Update Password" to save</li>
                            </ol>
                        </div>
                    </details>
                    
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">How do I delete my account?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>We're sorry to see you go! To delete your account:</p>
                            <ol class="list-decimal ml-5 mt-2 space-y-1">
                                <li>Go to Profile from the sidebar</li>
                                <li>Scroll down to "Danger Zone"</li>
                                <li>Click "Delete Account"</li>
                                <li>Confirm your decision</li>
                            </ol>
                            <p class="mt-2 text-red-500 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> This action is permanent and cannot be undone.</p>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Billing -->
            <div id="billing">
                <h3 class="px-6 py-4 bg-gray-50 font-semibold text-gray-700">
                    <i class="fas fa-credit-card text-purple-500 mr-2"></i> Billing & Premium
                </h3>
                
                <div class="divide-y divide-gray-100">
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">What's included in Premium?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>Premium members get access to:</p>
                            <ul class="list-disc ml-5 mt-2 space-y-1">
                                <li>All premium card designs</li>
                                <li>Unlimited AI card generations</li>
                                <li>Priority email support</li>
                                <li>No watermarks on cards</li>
                                <li>Early access to new features</li>
                            </ul>
                        </div>
                    </details>
                    
                    <details class="group">
                        <summary class="px-6 py-4 cursor-pointer flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="font-medium text-gray-800">Is there a free trial?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="px-6 pb-4 text-gray-600">
                            <p>Yes! New users get access to a 7-day free trial of Premium features. No credit card required to start.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-12 bg-gradient-to-r from-primary to-pink-400 rounded-2xl p-8 text-center text-white">
            <h3 class="text-2xl font-bold mb-3">Still need help?</h3>
            <p class="text-white/80 mb-6">Our support team is here to assist you</p>
            <a href="mailto:support@wishtales.com" 
               class="inline-flex items-center gap-2 bg-white text-primary px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg">
                <i class="fas fa-envelope"></i> Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
