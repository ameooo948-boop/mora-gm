<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trainer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'gender',
        'specialization',
        'bio',
        'image',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function trainingSessions(): BelongsToMany
    {
        return $this->belongsToMany(
            TrainingSession::class,
            'training_session_trainer'
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
