<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpcomingEventController;
use App\Http\Controllers\AiGeneratorController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages
Route::view('/help-center', 'pages.help-center')->name('help-center');
Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy-policy');
Route::view('/terms-of-service', 'pages.terms-of-service')->name('terms-of-service');

// Pricing (public)
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/pricing/{plan}', [PricingController::class, 'show'])->name('pricing.show');
Route::get('/pricing/compare', [PricingController::class, 'compare'])->name('pricing.compare');

// AI Generator routes
Route::get('/ai-generator', [AiGeneratorController::class, 'index'])->name('ai.generator');
Route::post('/ai-generator/generate', [AiGeneratorController::class, 'generate'])->name('ai.generate');
Route::post('/ai-generator/generate-card', [AiGeneratorController::class, 'generateCard'])->name('ai.generate-card');
Route::post('/ai-generator/save', [AiGeneratorController::class, 'save'])->name('ai.save')->middleware('auth');
Route::post('/ai-generator/use', [AiGeneratorController::class, 'useCard'])->name('ai.use');
Route::get('/ai-generator/my-cards', [AiGeneratorController::class, 'myCards'])->name('ai.my-cards')->middleware('auth');
Route::delete('/ai-generator/{card}', [AiGeneratorController::class, 'destroy'])->name('ai.destroy')->middleware('auth');

// Cards
Route::get('/shop', [CardController::class, 'index'])->name('cards.index');
Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');
Route::get('/cards/{card}/customize', [CardController::class, 'customize'])->name('cards.customize');
Route::post('/cards/{card}/preview', [CardController::class, 'preview'])->name('cards.preview');
Route::get('/category/{category}', [CardController::class, 'byCategory'])->name('cards.category');

// Public gift view
Route::get('/gift/{trackingCode}', [GiftController::class, 'view'])->name('gifts.public');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware('auth')->group(function () {
    // My Gifts
    Route::get('/my-gifts', [GiftController::class, 'index'])->name('gifts.index');
    Route::get('/gifts/create/{card}', [GiftController::class, 'create'])->name('gifts.create');
    Route::post('/gifts', [GiftController::class, 'store'])->name('gifts.store');
    Route::get('/gifts/{gift}/preview', [GiftController::class, 'preview'])->name('gifts.preview');
    Route::post('/gifts/{gift}/send', [GiftController::class, 'send'])->name('gifts.send');
    Route::get('/gifts/{gift}', [GiftController::class, 'show'])->name('gifts.show');
    Route::delete('/gifts/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');
    
    // Contacts
    Route::resource('contacts', ContactController::class);
    Route::post('/contacts/{contact}/toggle-favorite', [ContactController::class, 'toggleFavorite'])
        ->name('contacts.toggle-favorite');
    
    // Upcoming Events
    Route::resource('events', UpcomingEventController::class)->except(['show']);
    
    // Inbox (placeholder)
    Route::get('/inbox', function () {
        return view('inbox.index');
    })->name('inbox');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'showChangePassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Billing & Payments
    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/checkout/{plan}', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/subscribe/free', [PaymentController::class, 'subscribeFree'])->name('subscribe.free');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancelled', [PaymentController::class, 'cancelled'])->name('payment.cancelled');
    Route::get('/billing/history', [PaymentController::class, 'history'])->name('billing.history');
    Route::post('/subscription/cancel', [PaymentController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [PaymentController::class, 'resume'])->name('subscription.resume');
    Route::get('/billing/payment-method', [PaymentController::class, 'showPaymentMethod'])->name('billing.payment-method');
    Route::post('/billing/payment-method', [PaymentController::class, 'updatePaymentMethod'])->name('billing.payment-method.update');
});
