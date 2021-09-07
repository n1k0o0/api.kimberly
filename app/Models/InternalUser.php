<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class InternalUser extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'internal_users';

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getFullNameAttribute(): string
    {
        return implode(" ", [
            $this->last_name ?? '',
            $this->first_name ?? '',
            $this->middle_name ?? '',
        ]);
    }
}
