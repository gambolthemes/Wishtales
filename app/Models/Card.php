<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'thumbnail',
        'category_id',
        'is_premium',
        'is_featured',
        'is_active',
        'price',
        'background_color',
        'design_elements',
        'views',
        'uses',
    ];

    protected function casts(): array
    {
        return [
            'is_premium' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'design_elements' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function incrementUses(): void
    {
        $this->increment('uses');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }
}
