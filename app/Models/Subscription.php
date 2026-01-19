<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'status',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'cards_used_this_month',
        'ai_generations_used_this_month',
        'usage_reset_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'usage_reset_at' => 'datetime',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';
    const STATUS_PAST_DUE = 'past_due';
    const STATUS_TRIALING = 'trialing';

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get payments for this subscription
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE || $this->status === self::STATUS_TRIALING;
    }

    /**
     * Check if on trial
     */
    public function onTrial(): bool
    {
        return $this->status === self::STATUS_TRIALING && 
               $this->trial_ends_at && 
               $this->trial_ends_at->isFuture();
    }

    /**
     * Check if cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if expired
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED ||
               ($this->ends_at && $this->ends_at->isPast());
    }

    /**
     * Check if user can send more cards this month
     */
    public function canSendCard(): bool
    {
        $this->resetUsageIfNeeded();
        
        $limit = $this->plan->cards_per_month;
        
        if ($limit === -1) {
            return true; // Unlimited
        }
        
        return $this->cards_used_this_month < $limit;
    }

    /**
     * Check if user can generate more AI cards this month
     */
    public function canGenerateAi(): bool
    {
        $this->resetUsageIfNeeded();
        
        $limit = $this->plan->ai_generations_per_month;
        
        if ($limit === -1) {
            return true; // Unlimited
        }
        
        return $this->ai_generations_used_this_month < $limit;
    }

    /**
     * Increment card usage
     */
    public function incrementCardUsage(): void
    {
        $this->resetUsageIfNeeded();
        $this->increment('cards_used_this_month');
    }

    /**
     * Increment AI generation usage
     */
    public function incrementAiUsage(): void
    {
        $this->resetUsageIfNeeded();
        $this->increment('ai_generations_used_this_month');
    }

    /**
     * Reset usage counters if new month
     */
    public function resetUsageIfNeeded(): void
    {
        if (!$this->usage_reset_at || $this->usage_reset_at->isLastMonth()) {
            $this->update([
                'cards_used_this_month' => 0,
                'ai_generations_used_this_month' => 0,
                'usage_reset_at' => now(),
            ]);
        }
    }

    /**
     * Get remaining cards
     */
    public function getRemainingCardsAttribute(): int|string
    {
        $limit = $this->plan->cards_per_month;
        
        if ($limit === -1) {
            return 'Unlimited';
        }
        
        return max(0, $limit - $this->cards_used_this_month);
    }

    /**
     * Get remaining AI generations
     */
    public function getRemainingAiGenerationsAttribute(): int|string
    {
        $limit = $this->plan->ai_generations_per_month;
        
        if ($limit === -1) {
            return 'Unlimited';
        }
        
        return max(0, $limit - $this->ai_generations_used_this_month);
    }

    /**
     * Cancel subscription
     */
    public function cancel(): void
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_ACTIVE, self::STATUS_TRIALING]);
    }
}
