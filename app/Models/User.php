<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_EMAIL_VERIFICATION = 0;
    const STATUS_APPROVED = 1;
    const STATUS_NOT_APPROVED = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_DISABLED = 4;
    const STATUSES = [
        self::STATUS_EMAIL_VERIFICATION,
        self::STATUS_APPROVED,
        self::STATUS_NOT_APPROVED,
        self::STATUS_ACTIVE,
        self::STATUS_DISABLED
    ];

    const TYPE_SCHOOL = 0;
    const TYPES = [
        self::TYPE_SCHOOL,
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'type',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
