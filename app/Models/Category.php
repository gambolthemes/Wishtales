<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function activeCards(): HasMany
    {
        return $this->hasMany(Card::class)->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
