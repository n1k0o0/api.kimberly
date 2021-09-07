<?php

namespace App\Models;

use App\Notifications\User\PasswordRecoveryNotification;
use App\Notifications\User\VerifyEmail;
use App\Support\Media\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia;

    const AVATAR_MEDIA_COLLECTION = 'avatars';

    const STATUS_EMAIL_VERIFICATION = 'email_verification';
    const STATUS_APPROVED = 'approved';
    const STATUS_NOT_APPROVED = 'not_approved';
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';
    const STATUSES = [
        self::STATUS_EMAIL_VERIFICATION,
        self::STATUS_APPROVED,
        self::STATUS_NOT_APPROVED,
        self::STATUS_ACTIVE,
        self::STATUS_DISABLED
    ];

    const TYPE_SCHOOL = 'school';
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
        'first_name',
        'last_name',
        'patronymic',
        'phone',
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

    public function avatar(): MorphOne
    {
        return $this->mediaItem()->where('collection_name', self::AVATAR_MEDIA_COLLECTION);
    }

    /**
     * User email verifications
     *
     * @return HasMany
     */
    public function emailVerifications(): HasMany
    {
        return $this->hasMany(EmailVerification::class);
    }

    /**
     * User password recoveries
     *
     * @return HasMany
     */
    public function passwordRecoveries(): HasMany
    {
        return $this->hasMany(PasswordRecovery::class);
    }

    /**
     * Send email verify notification
     */
    public function notifyByEmailVerification(EmailVerification $emailVerification)
    {
        $this->notify(new VerifyEmail($emailVerification));
    }

    /**
     * Send password recovery notification
     */
    public function notifyByPasswordRecovery(PasswordRecovery $passwordRecovery)
    {
        $this->notify(new PasswordRecoveryNotification($passwordRecovery));
    }

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
}
