<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Free Plan
        Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'description' => 'Perfect for getting started',
            'price' => 0,
            'billing_cycle' => 'free',
            'stripe_price_id' => null,
            'cards_per_month' => 5,
            'ai_generations_per_month' => 0,
            'premium_templates' => false,
            'no_watermark' => false,
            'priority_support' => false,
            'custom_branding' => false,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 1,
            'features' => [
                'Basic card templates',
                'Email delivery',
                'Standard support',
            ],
        ]);

        // Pro Plan (Monthly)
        Plan::create([
            'name' => 'Pro',
            'slug' => 'pro-monthly',
            'description' => 'Best for regular users',
            'price' => 9.99,
            'billing_cycle' => 'monthly',
            'stripe_price_id' => 'price_pro_monthly', // Replace with actual Stripe price ID
            'cards_per_month' => 50,
            'ai_generations_per_month' => 20,
            'premium_templates' => true,
            'no_watermark' => true,
            'priority_support' => false,
            'custom_branding' => false,
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
            'features' => [
                'All premium templates',
                'AI card generator',
                'Schedule delivery',
                'Track card views',
                'Remove watermarks',
            ],
        ]);

        // Premium Plan (Monthly)
        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium-monthly',
            'description' => 'For power users & businesses',
            'price' => 19.99,
            'billing_cycle' => 'monthly',
            'stripe_price_id' => 'price_premium_monthly', // Replace with actual Stripe price ID
            'cards_per_month' => -1, // Unlimited
            'ai_generations_per_month' => -1, // Unlimited
            'premium_templates' => true,
            'no_watermark' => true,
            'priority_support' => true,
            'custom_branding' => true,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 3,
            'features' => [
                'Everything in Pro',
                'Unlimited cards',
                'Unlimited AI generations',
                'Custom branding',
                'Priority support',
                'API access',
                'Team collaboration',
            ],
        ]);

        // Pro Plan (Yearly - 20% off)
        Plan::create([
            'name' => 'Pro',
            'slug' => 'pro-yearly',
            'description' => 'Best for regular users',
            'price' => 95.90, // $7.99/month equivalent
            'billing_cycle' => 'yearly',
            'stripe_price_id' => 'price_pro_yearly', // Replace with actual Stripe price ID
            'cards_per_month' => 50,
            'ai_generations_per_month' => 20,
            'premium_templates' => true,
            'no_watermark' => true,
            'priority_support' => false,
            'custom_branding' => false,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 4,
            'features' => [
                'All premium templates',
                'AI card generator',
                'Schedule delivery',
                'Track card views',
                'Remove watermarks',
            ],
        ]);

        // Premium Plan (Yearly - 20% off)
        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium-yearly',
            'description' => 'For power users & businesses',
            'price' => 191.90, // $15.99/month equivalent
            'billing_cycle' => 'yearly',
            'stripe_price_id' => 'price_premium_yearly', // Replace with actual Stripe price ID
            'cards_per_month' => -1, // Unlimited
            'ai_generations_per_month' => -1, // Unlimited
            'premium_templates' => true,
            'no_watermark' => true,
            'priority_support' => true,
            'custom_branding' => true,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 5,
            'features' => [
                'Everything in Pro',
                'Unlimited cards',
                'Unlimited AI generations',
                'Custom branding',
                'Priority support',
                'API access',
                'Team collaboration',
            ],
        ]);
    }
}
