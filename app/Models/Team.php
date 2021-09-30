<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'division_id', 'color_id'];

    protected $with = ['school', 'color'];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function league(): HasOneThrough
    {
        return $this->hasOneThrough(League::class, Division::class, 'id', 'id', 'division_id', 'league_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(TeamColor::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
