<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'birthday',
        'notification_settings',
        'is_premium',
        'stripe_customer_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
            'birthday' => 'date',
            'notification_settings' => 'array',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    public function upcomingEvents(): HasMany
    {
        return $this->hasMany(UpcomingEvent::class);
    }

    /**
     * Get user's subscriptions
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get user's payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->whereIn('status', ['active', 'trialing'])
            ->latest()
            ->first();
    }

    /**
     * Check if user has an active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Get user's current plan
     */
    public function currentPlan(): ?Plan
    {
        return $this->activeSubscription()?->plan;
    }

    /**
     * Check if user is on a specific plan
     */
    public function isOnPlan(string $planSlug): bool
    {
        $plan = $this->currentPlan();
        return $plan && $plan->slug === $planSlug;
    }

    /**
     * Check if user can send more cards this month
     */
    public function canSendCard(): bool
    {
        $subscription = $this->activeSubscription();
        
        if (!$subscription) {
            // Free tier - check against free plan limits
            $freePlan = Plan::getFreePlan();
            return $freePlan ? true : false; // Allow if free plan exists
        }

        return $subscription->canSendCard();
    }

    /**
     * Check if user can generate AI cards
     */
    public function canGenerateAi(): bool
    {
        $subscription = $this->activeSubscription();
        
        if (!$subscription) {
            return false; // AI requires subscription
        }

        return $subscription->canGenerateAi();
    }
}
