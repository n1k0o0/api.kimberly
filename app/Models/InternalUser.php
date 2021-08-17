<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InternalUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_ADMIN = 0;
    const TYPE_JURY = 1;
    const TYPES = [
        self::TYPE_ADMIN,
        self::TYPE_JURY,
    ];

    protected $fillable = ['login', 'password', 'type', 'super_admin'];

    protected $casts = [
        'super_admin' => 'boolean'
    ];
}
