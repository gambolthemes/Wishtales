@extends('layouts.app')

@section('title', 'Checkout - ' . $plan->name . ' Plan')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('pricing') }}" class="inline-flex items-center text-gray-600 hover:text-primary mb-8">
            <i class="fas fa-arrow-left mr-2"></i> Back to Pricing
        </a>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
                
                <div class="border border-gray-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $plan->name }} Plan</h3>
                            <p class="text-gray-500 text-sm">{{ $plan->billing_cycle === 'yearly' ? 'Annual' : 'Monthly' }} subscription</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-800">${{ number_format($plan->price, 2) }}</span>
                            <span class="text-gray-500">/{{ $plan->billing_cycle === 'yearly' ? 'year' : 'month' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check text-green-500"></i>
                            @if($plan->hasUnlimitedCards())
                            Unlimited cards
                            @else
                            {{ $plan->cards_per_month }} cards/month
                            @endif
                        </div>
                        @if($plan->ai_generations_per_month > 0 || $plan->hasUnlimitedAiGenerations())
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check text-green-500"></i>
                            @if($plan->hasUnlimitedAiGenerations())
                            Unlimited AI generations
                            @else
                            {{ $plan->ai_generations_per_month }} AI generations/month
                            @endif
                        </div>
                        @endif
                        @if($plan->premium_templates)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check text-green-500"></i>
                            Premium templates
                        </div>
                        @endif
                        @if($plan->no_watermark)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check text-green-500"></i>
                            No watermarks
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Trial Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-gift text-blue-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800">7-Day Free Trial</h4>
                            <p class="text-sm text-gray-600">You won't be charged until your trial ends. Cancel anytime.</p>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($plan->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Trial discount</span>
                        <span class="text-green-600">-${{ number_format($plan->price, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between text-lg font-bold text-gray-800">
                        <span>Due today</span>
                        <span class="text-green-600">$0.00</span>
                    </div>
                    <p class="text-xs text-gray-500">
                        After trial, you'll be charged ${{ number_format($plan->price, 2) }}/{{ $plan->billing_cycle === 'yearly' ? 'year' : 'month' }}
                    </p>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Payment Details</h2>

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
                @endif

                <form id="payment-form" action="{{ route('payment.process', $plan) }}" method="POST">
                    @csrf

                    <!-- Card Element -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Card Information
                        </label>
                        <div id="card-element" class="border border-gray-300 rounded-xl px-4 py-4 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20">
                            <!-- Stripe Card Element will be inserted here -->
                        </div>
                        <div id="card-errors" class="text-red-500 text-sm mt-2" role="alert"></div>
                    </div>

                    <!-- Cardholder Name -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Cardholder Name
                        </label>
                        <input type="text" 
                               id="cardholder-name" 
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                               placeholder="John Doe"
                               required>
                    </div>

                    <!-- Billing Address (Optional) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Country
                        </label>
                        <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="GB">United Kingdom</option>
                            <option value="AU">Australia</option>
                            <option value="DE">Germany</option>
                            <option value="FR">France</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <input type="hidden" name="payment_method_id" id="payment-method-id">

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submit-button"
                            class="w-full bg-gradient-to-r from-primary to-pink-400 text-white py-4 rounded-xl font-bold text-lg hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="button-text">Start Free Trial</span>
                        <span id="spinner" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Processing...
                        </span>
                    </button>
                </form>

                <!-- Security Badges -->
                <div class="mt-6 flex items-center justify-center gap-4 text-gray-400">
                    <i class="fab fa-cc-visa text-2xl"></i>
                    <i class="fab fa-cc-mastercard text-2xl"></i>
                    <i class="fab fa-cc-amex text-2xl"></i>
                    <div class="flex items-center gap-1 text-sm">
                        <i class="fas fa-lock"></i>
                        <span>Secured by Stripe</span>
                    </div>
                </div>

                <!-- Terms -->
                <p class="text-xs text-gray-500 text-center mt-4">
                    By subscribing, you agree to our 
                    <a href="{{ route('terms-of-service') }}" class="text-primary hover:underline">Terms of Service</a>
                    and 
                    <a href="{{ route('privacy-policy') }}" class="text-primary hover:underline">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();

    // Custom styling
    const style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Inter", -apple-system, BlinkMacSystemFont, sans-serif',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    const cardElement = elements.create('card', { style });
    cardElement.mount('#card-element');

    // Handle errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');

        const cardholderName = document.getElementById('cardholder-name').value;

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: cardholderName
            }
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        } else {
            document.getElementById('payment-method-id').value = paymentMethod.id;
            form.submit();
        }
    });
</script>
@endsection
