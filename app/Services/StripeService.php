<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Stripe\Invoice;
use Stripe\Exception\ApiErrorException;

/**
 * StripeService - Handles all Stripe payment operations
 */
class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Get or create a Stripe customer for a user
     */
    public function getOrCreateCustomer(User $user): string
    {
        // Check if user already has a Stripe customer ID
        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        try {
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'metadata' => [
                    'user_id' => $user->id,
                ],
            ]);

            $user->update(['stripe_customer_id' => $customer->id]);

            return $customer->id;
        } catch (ApiErrorException $e) {
            Log::error('Stripe customer creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Attach a payment method to a customer
     */
    public function attachPaymentMethod(string $customerId, string $paymentMethodId): PaymentMethod
    {
        try {
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $customerId]);

            // Set as default payment method
            Customer::update($customerId, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId,
                ],
            ]);

            return $paymentMethod;
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment method attachment failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a subscription
     */
    public function createSubscription(
        string $customerId, 
        string $priceId, 
        string $paymentMethodId,
        int $trialDays = 7
    ): Subscription {
        try {
            $subscriptionData = [
                'customer' => $customerId,
                'items' => [
                    ['price' => $priceId],
                ],
                'default_payment_method' => $paymentMethodId,
                'expand' => ['latest_invoice.payment_intent'],
            ];

            // Add trial period
            if ($trialDays > 0) {
                $subscriptionData['trial_period_days'] = $trialDays;
            }

            return Subscription::create($subscriptionData);
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(string $subscriptionId, bool $immediately = false): Subscription
    {
        try {
            $subscription = Subscription::retrieve($subscriptionId);

            if ($immediately) {
                return $subscription->cancel();
            }

            // Cancel at period end
            return Subscription::update($subscriptionId, [
                'cancel_at_period_end' => true,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription cancellation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Resume a cancelled subscription
     */
    public function resumeSubscription(string $subscriptionId): Subscription
    {
        try {
            return Subscription::update($subscriptionId, [
                'cancel_at_period_end' => false,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription resume failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update subscription to a new plan
     */
    public function updateSubscription(string $subscriptionId, string $newPriceId): Subscription
    {
        try {
            $subscription = Subscription::retrieve($subscriptionId);

            return Subscription::update($subscriptionId, [
                'items' => [
                    [
                        'id' => $subscription->items->data[0]->id,
                        'price' => $newPriceId,
                    ],
                ],
                'proration_behavior' => 'create_prorations',
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get an invoice
     */
    public function getInvoice(string $invoiceId): Invoice
    {
        try {
            return Invoice::retrieve($invoiceId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe invoice retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update default payment method
     */
    public function updateDefaultPaymentMethod(string $customerId, string $paymentMethodId): void
    {
        try {
            $this->attachPaymentMethod($customerId, $paymentMethodId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment method update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get customer's payment methods
     */
    public function getPaymentMethods(string $customerId): array
    {
        try {
            $paymentMethods = PaymentMethod::all([
                'customer' => $customerId,
                'type' => 'card',
            ]);

            return $paymentMethods->data;
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment methods retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get subscription status
     */
    public function getSubscriptionStatus(string $subscriptionId): string
    {
        try {
            $subscription = Subscription::retrieve($subscriptionId);
            return $subscription->status;
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription status check failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
