<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    protected $fillable = [
        'name',
        'audience',
        'starts_at',
        'ends_at',
        'description',
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

    public function getFormattedStartTimeAttribute(): ?string
    {
        return $this->starts_at
            ? Carbon::createFromFormat('H:i:s', $this->starts_at)
                ->locale('ar')
                ->translatedFormat('g:i a')
            : null;
    }

    public function getFormattedEndTimeAttribute(): ?string
    {
        return $this->ends_at
            ? Carbon::createFromFormat('H:i:s', $this->ends_at)
                ->locale('ar')
                ->translatedFormat('g:i a')
            : null;
    }

    public function getEndsNextDayAttribute(): bool
    {
        return $this->endsNextDay();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function endsNextDay(): bool
    {
        if (! $this->starts_at || ! $this->ends_at) {
            return false;
        }

        return $this->ends_at <= $this->starts_at;
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(
            Trainer::class,
            'training_session_trainer'
        );
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
