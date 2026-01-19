<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'stripe_payment_id',
        'stripe_invoice_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'card_last_four',
        'card_brand',
        'description',
        'metadata',
        'refund_amount',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'metadata' => 'array',
        'refunded_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        $symbol = match($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' ',
        };
        
        return $symbol . number_format($this->amount, 2);
    }

    /**
     * Get card display (brand + last 4)
     */
    public function getCardDisplayAttribute(): string
    {
        if (!$this->card_brand || !$this->card_last_four) {
            return 'N/A';
        }
        
        return ucfirst($this->card_brand) . ' •••• ' . $this->card_last_four;
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for user's payments
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
