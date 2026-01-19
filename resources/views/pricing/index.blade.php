@extends('layouts.app')

@section('title', 'Pricing - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
                Simple, Transparent <span class="text-primary">Pricing</span>
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">
                Choose the perfect plan for your greeting card needs. Upgrade or downgrade anytime.
            </p>
        </div>

        <!-- Billing Toggle -->
        <div class="flex items-center justify-center gap-4 mb-12">
            <span class="text-gray-800 font-semibold transition" id="monthlyLabel">Monthly</span>
            <button type="button" 
                    id="billingToggle"
                    class="relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    role="switch" 
                    aria-checked="false">
                <span class="translate-x-0 pointer-events-none relative inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" id="toggleDot"></span>
            </button>
            <span class="text-gray-500 font-medium transition" id="yearlyLabel">
                Yearly <span class="text-green-600 font-bold">(Save 20%)</span>
            </span>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            
            <!-- Free Plan -->
            @php $freePlan = $plans->where('billing_cycle', 'free')->first(); @endphp
            @if($freePlan)
            <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden transition-transform hover:scale-105">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Free</h3>
                    <p class="text-gray-500 text-sm mb-6">Perfect for getting started</p>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold text-gray-800">Free</span>
                        </div>
                    </div>

                    @if($currentSubscription && $currentSubscription->plan_id === $freePlan->id)
                    <button disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-600 font-semibold cursor-not-allowed">
                        Current Plan
                    </button>
                    @else
                    <form action="{{ route('subscribe.free') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 px-6 rounded-xl bg-gray-100 text-gray-800 font-semibold text-center hover:bg-gray-200 transition">
                            Get Started
                        </button>
                    </form>
                    @endif
                </div>

                <div class="px-8 pb-8">
                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-4">What's included:</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm"><strong>5</strong> cards per month</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-gray-400 text-sm">AI card generation</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-gray-400 text-sm">Premium templates</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-gray-400 text-sm">No watermarks</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-gray-400 text-sm">Priority support</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Basic card templates</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Email delivery</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Standard support</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Pro Plan -->
            @php 
                $proMonthly = $plans->where('slug', 'pro-monthly')->first();
                $proYearly = $plans->where('slug', 'pro-yearly')->first();
            @endphp
            @if($proMonthly)
            <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden transition-transform hover:scale-105 ring-2 ring-primary">
                <div class="absolute top-0 right-0 bg-gradient-to-r from-primary to-pink-400 text-white px-4 py-1 rounded-bl-xl text-sm font-bold">
                    Most Popular
                </div>

                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Pro</h3>
                    <p class="text-gray-500 text-sm mb-6">Best for regular users</p>

                    <div class="mb-6">
                        <!-- Monthly Price -->
                        <div id="proPriceMonthly" class="price-display">
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-bold text-gray-800">${{ number_format($proMonthly->price, 0) }}</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                        </div>
                        <!-- Yearly Price -->
                        <div id="proPriceYearly" class="price-display hidden">
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-bold text-gray-800">${{ number_format($proYearly->price ?? 96, 0) }}</span>
                                <span class="text-gray-500">/year</span>
                            </div>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-tag mr-1"></i>Save ${{ number_format(($proMonthly->price * 12) - ($proYearly->price ?? 96), 0) }} per year
                            </p>
                        </div>
                    </div>

                    @php
                        $isCurrentProMonthly = $currentSubscription && $currentSubscription->plan_id === $proMonthly->id;
                        $isCurrentProYearly = $currentSubscription && $proYearly && $currentSubscription->plan_id === $proYearly->id;
                    @endphp

                    <!-- Monthly Button -->
                    <div id="proButtonMonthly" class="button-display">
                        @if($isCurrentProMonthly)
                        <button disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-600 font-semibold cursor-not-allowed">
                            Current Plan
                        </button>
                        @else
                        <a href="{{ route('payment.checkout', $proMonthly) }}" 
                           class="block w-full py-3 px-6 rounded-xl bg-gradient-to-r from-primary to-pink-400 text-white font-semibold text-center hover:opacity-90 transition">
                            {{ $currentSubscription ? 'Upgrade' : 'Start Free Trial' }}
                        </a>
                        @endif
                    </div>
                    <!-- Yearly Button -->
                    <div id="proButtonYearly" class="button-display hidden">
                        @if($isCurrentProYearly)
                        <button disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-600 font-semibold cursor-not-allowed">
                            Current Plan
                        </button>
                        @elseif($proYearly)
                        <a href="{{ route('payment.checkout', $proYearly) }}" 
                           class="block w-full py-3 px-6 rounded-xl bg-gradient-to-r from-primary to-pink-400 text-white font-semibold text-center hover:opacity-90 transition">
                            {{ $currentSubscription ? 'Upgrade' : 'Start Free Trial' }}
                        </a>
                        @endif
                    </div>

                    <p class="text-center text-xs text-gray-400 mt-2">7-day free trial included</p>
                </div>

                <div class="px-8 pb-8">
                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-4">What's included:</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm"><strong>50</strong> cards per month</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm"><strong>20</strong> AI generations/month</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Premium templates</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">No watermarks</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-gray-400 text-sm">Priority support</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">All premium templates</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">AI card generator</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Schedule delivery</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Track card views</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Remove watermarks</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Premium Plan -->
            @php 
                $premiumMonthly = $plans->where('slug', 'premium-monthly')->first();
                $premiumYearly = $plans->where('slug', 'premium-yearly')->first();
            @endphp
            @if($premiumMonthly)
            <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden transition-transform hover:scale-105">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Premium</h3>
                    <p class="text-gray-500 text-sm mb-6">For power users & businesses</p>

                    <div class="mb-6">
                        <!-- Monthly Price -->
                        <div id="premiumPriceMonthly" class="price-display">
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-bold text-gray-800">${{ number_format($premiumMonthly->price, 0) }}</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                        </div>
                        <!-- Yearly Price -->
                        <div id="premiumPriceYearly" class="price-display hidden">
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-bold text-gray-800">${{ number_format($premiumYearly->price ?? 192, 0) }}</span>
                                <span class="text-gray-500">/year</span>
                            </div>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-tag mr-1"></i>Save ${{ number_format(($premiumMonthly->price * 12) - ($premiumYearly->price ?? 192), 0) }} per year
                            </p>
                        </div>
                    </div>

                    @php
                        $isCurrentPremiumMonthly = $currentSubscription && $currentSubscription->plan_id === $premiumMonthly->id;
                        $isCurrentPremiumYearly = $currentSubscription && $premiumYearly && $currentSubscription->plan_id === $premiumYearly->id;
                    @endphp

                    <!-- Monthly Button -->
                    <div id="premiumButtonMonthly" class="button-display">
                        @if($isCurrentPremiumMonthly)
                        <button disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-600 font-semibold cursor-not-allowed">
                            Current Plan
                        </button>
                        @else
                        <a href="{{ route('payment.checkout', $premiumMonthly) }}" 
                           class="block w-full py-3 px-6 rounded-xl bg-primary text-white font-semibold text-center hover:opacity-90 transition">
                            {{ $currentSubscription ? 'Upgrade' : 'Start Free Trial' }}
                        </a>
                        @endif
                    </div>
                    <!-- Yearly Button -->
                    <div id="premiumButtonYearly" class="button-display hidden">
                        @if($isCurrentPremiumYearly)
                        <button disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-600 font-semibold cursor-not-allowed">
                            Current Plan
                        </button>
                        @elseif($premiumYearly)
                        <a href="{{ route('payment.checkout', $premiumYearly) }}" 
                           class="block w-full py-3 px-6 rounded-xl bg-primary text-white font-semibold text-center hover:opacity-90 transition">
                            {{ $currentSubscription ? 'Upgrade' : 'Start Free Trial' }}
                        </a>
                        @endif
                    </div>

                    <p class="text-center text-xs text-gray-400 mt-2">7-day free trial included</p>
                </div>

                <div class="px-8 pb-8">
                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-4">What's included:</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm"><strong>Unlimited</strong> cards per month</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm"><strong>Unlimited</strong> AI generations</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Premium templates</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">No watermarks</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Priority support</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Custom branding</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Everything in Pro</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Priority support</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">API access</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span class="text-gray-600 text-sm">Team collaboration</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- FAQ Section -->
        <div class="mt-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <details class="bg-white rounded-2xl shadow-md group">
                    <summary class="px-6 py-4 cursor-pointer flex items-center justify-between font-semibold text-gray-800">
                        Can I cancel anytime?
                        <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="px-6 pb-4 text-gray-600">
                        Yes! You can cancel your subscription at any time. Your access will continue until the end of your billing period.
                    </div>
                </details>

                <details class="bg-white rounded-2xl shadow-md group">
                    <summary class="px-6 py-4 cursor-pointer flex items-center justify-between font-semibold text-gray-800">
                        Is there a free trial?
                        <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="px-6 pb-4 text-gray-600">
                        Yes! All paid plans come with a 7-day free trial. No credit card required to start with our Free plan.
                    </div>
                </details>

                <details class="bg-white rounded-2xl shadow-md group">
                    <summary class="px-6 py-4 cursor-pointer flex items-center justify-between font-semibold text-gray-800">
                        What payment methods do you accept?
                        <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="px-6 pb-4 text-gray-600">
                        We accept all major credit cards (Visa, MasterCard, American Express) through our secure Stripe payment system.
                    </div>
                </details>

                <details class="bg-white rounded-2xl shadow-md group">
                    <summary class="px-6 py-4 cursor-pointer flex items-center justify-between font-semibold text-gray-800">
                        Can I upgrade or downgrade my plan?
                        <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="px-6 pb-4 text-gray-600">
                        Absolutely! You can change your plan at any time. When upgrading, you'll be charged the prorated amount. When downgrading, changes take effect at the next billing cycle.
                    </div>
                </details>

                <details class="bg-white rounded-2xl shadow-md group">
                    <summary class="px-6 py-4 cursor-pointer flex items-center justify-between font-semibold text-gray-800">
                        What happens to my cards if I downgrade?
                        <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="px-6 pb-4 text-gray-600">
                        All cards you've created remain yours forever. You'll just have the limits of your new plan for creating new cards.
                    </div>
                </details>
            </div>
        </div>

        <!-- Money Back Guarantee -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-4 bg-green-50 border border-green-200 rounded-2xl px-8 py-4">
                <i class="fas fa-shield-alt text-green-500 text-2xl"></i>
                <div class="text-left">
                    <h4 class="font-bold text-gray-800">30-Day Money Back Guarantee</h4>
                    <p class="text-sm text-gray-600">Not satisfied? Get a full refund, no questions asked.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Billing toggle
    const toggle = document.getElementById('billingToggle');
    const dot = document.getElementById('toggleDot');
    const monthlyLabel = document.getElementById('monthlyLabel');
    const yearlyLabel = document.getElementById('yearlyLabel');
    
    let isYearly = false;

    function updateDisplay() {
        // Toggle button appearance
        if (isYearly) {
            toggle.classList.remove('bg-gray-200');
            toggle.classList.add('bg-primary');
            dot.classList.remove('translate-x-0');
            dot.classList.add('translate-x-6');
            monthlyLabel.classList.remove('text-gray-800', 'font-semibold');
            monthlyLabel.classList.add('text-gray-500', 'font-medium');
            yearlyLabel.classList.remove('text-gray-500', 'font-medium');
            yearlyLabel.classList.add('text-gray-800', 'font-semibold');
        } else {
            toggle.classList.add('bg-gray-200');
            toggle.classList.remove('bg-primary');
            dot.classList.add('translate-x-0');
            dot.classList.remove('translate-x-6');
            monthlyLabel.classList.add('text-gray-800', 'font-semibold');
            monthlyLabel.classList.remove('text-gray-500', 'font-medium');
            yearlyLabel.classList.add('text-gray-500', 'font-medium');
            yearlyLabel.classList.remove('text-gray-800', 'font-semibold');
        }

        // Toggle price and button displays
        const monthlyPrices = ['proPriceMonthly', 'premiumPriceMonthly'];
        const yearlyPrices = ['proPriceYearly', 'premiumPriceYearly'];
        const monthlyButtons = ['proButtonMonthly', 'premiumButtonMonthly'];
        const yearlyButtons = ['proButtonYearly', 'premiumButtonYearly'];

        monthlyPrices.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden', isYearly);
        });
        yearlyPrices.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden', !isYearly);
        });
        monthlyButtons.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden', isYearly);
        });
        yearlyButtons.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden', !isYearly);
        });
    }

    toggle?.addEventListener('click', () => {
        isYearly = !isYearly;
        updateDisplay();
    });

    // Initialize display
    updateDisplay();
</script>
@endsection
