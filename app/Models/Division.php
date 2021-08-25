<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'league_id'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

}
