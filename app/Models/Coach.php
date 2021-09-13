<?php

namespace App\Models;

use App\Support\Media\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;

class Coach extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['school_id', 'first_name', 'last_name', 'patronymic'];

    const AVATAR_MEDIA_COLLECTION = 'avatar';

    /**
     * @return MorphOne
     */
    public function avatar(): MorphOne
    {
        return $this->mediaImage()->where('collection_name', self::AVATAR_MEDIA_COLLECTION);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_MEDIA_COLLECTION);
    }
}
