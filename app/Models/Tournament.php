<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'city_id', 'started_at', 'ended_at',];

    const STATUS_NOT_STARTED = 'NOT_STARTED';
    const STATUS_CURRENT = 'CURRENT';
    const STATUS_ARCHIVED = 'ARCHIVED';
    const STATUSES = [
        self::STATUS_NOT_STARTED,
        self::STATUS_CURRENT,
        self::STATUS_ARCHIVED,
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

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
}
