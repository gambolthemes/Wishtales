<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_url',
        'prompt',
        'style',
        'recipe',
        'is_favorite',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
