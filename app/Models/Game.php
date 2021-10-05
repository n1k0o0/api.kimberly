<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'tournament_id',
        'division_id',
        'stadium_id',
        'status',
        'scheduled_start_at',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'team_1_id' => 'integer',
        'team_2_id' => 'integer',
        'tournament_id' => 'integer',
        'division_id' => 'integer',
        'stadium_id' => 'integer',
        'scheduled_start_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';
    const STATUSES = [
        self::STATUS_NOT_STARTED,
        self::STATUS_STARTED,
        self::STATUS_FINISHED,
    ];

    public function firstTeam(): belongsTo
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function secondTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function league(): HasOneThrough
    {
        return $this->hasOneThrough(League::class, Division::class, 'id', 'id', 'division_id', 'league_id');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    public function pauses(): HasMany
    {
        return $this->hasMany(GamePause::class);
    }

    public function getTeamsAttribute(): Collection
    {
        $firstTeam = $this->firstTeam()->first();
        $secondTeam = $this->secondTeam()->first();

        return Collection::make([
            'team_1' => $firstTeam,
            'team_2' => $secondTeam,
        ]);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->pauses()->whereNull('finished_at')->exists();
    }
}
