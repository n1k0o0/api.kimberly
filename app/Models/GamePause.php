<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePause extends Model
{
    use HasFactory;

    protected $fillable = ['started_at', 'finished_at'];

    public $timestamps = false;

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function getDurationAttribute()
    {
        return $this->finished_at->diffInMinuted($this->started_at);
    }
}
