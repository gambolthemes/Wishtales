<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'stripe_price_id',
        'features',
        'cards_per_month',
        'ai_generations_per_month',
        'premium_templates',
        'no_watermark',
        'priority_support',
        'custom_branding',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'premium_templates' => 'boolean',
        'no_watermark' => 'boolean',
        'priority_support' => 'boolean',
        'custom_branding' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Check if plan is free
     */
    public function isFree(): bool
    {
        return $this->price == 0 || $this->billing_cycle === 'free';
    }

    /**
     * Check if cards are unlimited
     */
    public function hasUnlimitedCards(): bool
    {
        return $this->cards_per_month === -1;
    }

    /**
     * Check if AI generations are unlimited
     */
    public function hasUnlimitedAiGenerations(): bool
    {
        return $this->ai_generations_per_month === -1;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->isFree()) {
            return 'Free';
        }

        $price = '$' . number_format($this->price, 2);
        
        return match($this->billing_cycle) {
            'monthly' => $price . '/month',
            'yearly' => $price . '/year',
            'lifetime' => $price . ' one-time',
            default => $price,
        };
    }

    /**
     * Get monthly equivalent price (for comparison)
     */
    public function getMonthlyPriceAttribute(): float
    {
        return match($this->billing_cycle) {
            'yearly' => $this->price / 12,
            default => $this->price,
        };
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the free plan
     */
    public static function getFreePlan(): ?Plan
    {
        return static::where('slug', 'free')->first();
    }
}
