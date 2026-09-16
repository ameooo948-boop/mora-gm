<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GymProfile extends Model
{
    protected $fillable = [
        'name',
        'eyebrow',
        'about_title',
        'about_description',
        'mission_title',
        'mission',
        'vision_title',
        'vision',
        'image',
        'space_size',
        'trainer_count',
        'is_active',
        'phone',
        'whatsapp',
        'email',
        'address',
        'instagram_url',
        'vodafone_cash',
    ];

    protected function casts(): array
    {
        return [
            'space_size' => 'integer',
            'trainer_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
