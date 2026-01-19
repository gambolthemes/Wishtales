<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'contact_id',
        'recipient_name',
        'recipient_email',
        'message',
        'sender_name',
        'status',
        'scheduled_at',
        'sent_at',
        'opened_at',
        'customization',
        'envelope_style',
        'tracking_code',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'opened_at' => 'datetime',
            'customization' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($gift) {
            if (empty($gift->tracking_code)) {
                $gift->tracking_code = Str::uuid()->toString();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function markAsOpened(): void
    {
        $this->update([
            'status' => 'opened',
            'opened_at' => now(),
        ]);
    }

    public function scopeDrafts($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
}
