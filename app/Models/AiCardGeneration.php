<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AiCardGeneration Model
 * 
 * Tracks AI card generation requests and their results.
 * Used for async job tracking and history.
 */
class AiCardGeneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'occasion',
        'mood',
        'art_style',
        'orientation',
        'params',
        'image_url',
        'image_path',
        'prompt_used',
        'negative_prompt_used',
        'card_dna',
        'seed',
        'metadata',
        'error_message',
        'started_at',
        'completed_at',
        'failed_at',
    ];

    protected $casts = [
        'params' => 'array',
        'metadata' => 'array',
        'seed' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    /**
     * Get the user that owns this generation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if generation is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if generation is processing
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if generation is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if generation failed
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Get processing duration in seconds
     */
    public function getProcessingDuration(): ?int
    {
        if (!$this->started_at) {
            return null;
        }

        $endTime = $this->completed_at ?? $this->failed_at ?? now();
        
        return $this->started_at->diffInSeconds($endTime);
    }

    /**
     * Scope for completed generations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for pending generations
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for failed generations
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Get the short DNA code
     */
    public function getShortCodeAttribute(): string
    {
        return $this->card_dna ? substr($this->card_dna, 0, 12) : '';
    }
}
