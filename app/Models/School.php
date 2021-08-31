<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class School extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'city_id', 'status', 'name', 'description', 'email', 'phone', 'branch_count'];

    const STATUS_MODERATION = 'MODERATION';
    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUSES = [
        self::STATUS_MODERATION,
        self::STATUS_PUBLISHED,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return HasOneThrough
     */
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(Country::class, City::class, 'id', 'id', 'city_id', 'country_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class);
    }

    public function social_links(): MorphMany
    {
        return $this->morphMany(SocialLink::class, 'social_linkable');
    }

    public function scopeModerated(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_MODERATION);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }
}
