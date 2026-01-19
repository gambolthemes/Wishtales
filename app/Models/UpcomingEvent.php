<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpcomingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_id',
        'title',
        'description',
        'event_date',
        'event_type',
        'is_recurring',
        'reminder_sent',
        'remind_days_before',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_recurring' => 'boolean',
            'reminder_sent' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())->orderBy('event_date');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('event_date', [now(), now()->addWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('event_date', [now(), now()->addMonth()]);
    }
}
