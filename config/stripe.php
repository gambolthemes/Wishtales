<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | Your Stripe publishable and secret API keys. Get these from:
    | https://dashboard.stripe.com/apikeys
    |
    */

    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhook Secret
    |--------------------------------------------------------------------------
    |
    | Your Stripe webhook signing secret for verifying webhook payloads.
    | Get this from: https://dashboard.stripe.com/webhooks
    |
    */

    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | The default currency for all Stripe transactions.
    |
    */

    'currency' => 'usd',

    /*
    |--------------------------------------------------------------------------
    | Trial Period
    |--------------------------------------------------------------------------
    |
    | The default trial period in days for new subscriptions.
    | Set to 0 to disable trial periods.
    |
    */

    'trial_days' => 7,

    /*
    |--------------------------------------------------------------------------
    | Tax Configuration
    |--------------------------------------------------------------------------
    |
    | Whether to enable automatic tax calculation.
    |
    */

    'automatic_tax' => false,

    /*
    |--------------------------------------------------------------------------
    | Invoice Settings
    |--------------------------------------------------------------------------
    */

    'invoice' => [
        'paper_size' => 'letter',
        'footer' => 'Thank you for choosing WishTales!',
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Grace Period
    |--------------------------------------------------------------------------
    |
    | The number of days after a subscription expires that the user
    | can still access premium features.
    |
    */

    'grace_period_days' => 3,
];
