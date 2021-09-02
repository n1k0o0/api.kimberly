<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Media\InteractsWithMedia;

class School extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'city_id', 'status', 'name', 'description', 'email', 'phone', 'branch_count'];

    const AVATAR_MEDIA_COLLECTION = 'avatars';

    const STATUS_MODERATION = 'MODERATION';
    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUSES = [
        self::STATUS_MODERATION,
        self::STATUS_PUBLISHED,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
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

    /**
     * @return HasMany
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return HasMany
     */
    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class);
    }

    /**
     * @return MorphMany
     */
    public function social_links(): MorphMany
    {
        return $this->morphMany(SocialLink::class, 'social_linkable');
    }

    /**
     * @return MorphOne
     */
    public function media_avatar(): MorphOne
    {
        return $this->mediaItem()->where('collection_name', self::AVATAR_MEDIA_COLLECTION);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeModerated(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_MODERATION);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_MEDIA_COLLECTION);
    }
}
