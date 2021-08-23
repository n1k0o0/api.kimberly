<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InternalUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_SUPER_ADMIN = 'super_admin';
    const TYPE_ADMIN = 'admin';
    const TYPE_JURY = 'jury';
    const TYPES = [
        self::TYPE_ADMIN,
        self::TYPE_JURY,
    ];

    protected $fillable = ['login', 'first_name', 'last_name', 'middle_name', 'password', 'phone', 'type'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getFullNameAttribute(): string
    {
        return implode(" ", [
            $this->last_name ?? '',
            $this->first_name ?? '',
            $this->middle_name ?? '',
        ]);
    }
}
