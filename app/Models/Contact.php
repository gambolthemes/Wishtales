<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'birthday',
        'anniversary',
        'relationship',
        'notes',
        'is_favorite',
    ];

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
            'anniversary' => 'date',
            'is_favorite' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    public function upcomingEvents(): HasMany
    {
        return $this->hasMany(UpcomingEvent::class);
    }

    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }
}
