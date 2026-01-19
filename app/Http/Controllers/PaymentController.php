<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Show checkout page for a plan
     */
    public function checkout(Plan $plan)
    {
        if ($plan->isFree()) {
            return $this->subscribeFree($plan);
        }

        $user = Auth::user();
        
        // Check if user already has this plan
        $currentSub = $user->activeSubscription();
        if ($currentSub && $currentSub->plan_id === $plan->id) {
            return redirect()->route('pricing')
                ->with('info', 'You are already subscribed to this plan.');
        }

        return view('payment.checkout', compact('plan'));
    }

    /**
     * Process payment
     */
    public function process(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        $user = Auth::user();

        try {
            // Create or update Stripe customer
            $customerId = $this->stripeService->getOrCreateCustomer($user);

            // Attach payment method
            $this->stripeService->attachPaymentMethod(
                $customerId, 
                $request->payment_method_id
            );

            // Create subscription
            $stripeSubscription = $this->stripeService->createSubscription(
                $customerId,
                $plan->stripe_price_id,
                $request->payment_method_id
            );

            // Cancel existing subscription if any
            $existingSub = $user->activeSubscription();
            if ($existingSub) {
                $existingSub->cancel();
            }

            // Create local subscription record
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => $stripeSubscription->id,
                'stripe_customer_id' => $customerId,
                'status' => $stripeSubscription->status === 'trialing' ? 'trialing' : 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(), // Will be updated by webhook
                'trial_ends_at' => $stripeSubscription->trial_end 
                    ? \Carbon\Carbon::createFromTimestamp($stripeSubscription->trial_end) 
                    : null,
            ]);

            // Record payment
            if ($stripeSubscription->latest_invoice) {
                $invoice = $this->stripeService->getInvoice($stripeSubscription->latest_invoice);
                
                Payment::create([
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'stripe_payment_id' => $invoice->payment_intent,
                    'stripe_invoice_id' => $invoice->id,
                    'amount' => $invoice->amount_paid / 100,
                    'currency' => strtoupper($invoice->currency),
                    'status' => 'completed',
                    'payment_method' => 'card',
                    'description' => "Subscription to {$plan->name} plan",
                ]);
            }

            return redirect()->route('payment.success')
                ->with('success', 'Payment successful! Welcome to ' . $plan->name . '!');

        } catch (\Exception $e) {
            Log::error('Payment failed: ' . $e->getMessage());
            
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Subscribe to free plan
     */
    protected function subscribeFree(Plan $plan)
    {
        $user = Auth::user();
        
        // Cancel existing subscription if any
        $existingSub = $user->activeSubscription();
        if ($existingSub) {
            $existingSub->cancel();
        }

        // Create free subscription
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
        ]);

        return redirect()->route('pricing')
            ->with('success', 'You are now on the Free plan!');
    }

    /**
     * Payment success page
     */
    public function success()
    {
        return view('payment.success');
    }

    /**
     * Payment cancelled
     */
    public function cancelled()
    {
        return view('payment.cancelled');
    }

    /**
     * Show billing history
     */
    public function history()
    {
        $payments = Payment::forUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.history', compact('payments'));
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        try {
            // Cancel in Stripe if applicable
            if ($subscription->stripe_subscription_id) {
                $this->stripeService->cancelSubscription($subscription->stripe_subscription_id);
            }

            $subscription->cancel();

            return back()->with('success', 'Your subscription has been cancelled.');
        } catch (\Exception $e) {
            Log::error('Subscription cancellation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to cancel subscription.');
        }
    }

    /**
     * Update payment method
     */
    public function updatePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        $user = Auth::user();
        $subscription = $user->activeSubscription();

        if (!$subscription || !$subscription->stripe_customer_id) {
            return back()->with('error', 'No active subscription found.');
        }

        try {
            $this->stripeService->updateDefaultPaymentMethod(
                $subscription->stripe_customer_id,
                $request->payment_method_id
            );

            return back()->with('success', 'Payment method updated successfully.');
        } catch (\Exception $e) {
            Log::error('Payment method update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update payment method.');
        }
    }
}
