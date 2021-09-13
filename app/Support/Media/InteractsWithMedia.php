<?php

namespace App\Support\Media;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait InteractsWithMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;

    public function mediaFile(): MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function mediaImage(): MorphOne
    {
        return $this->morphOne(MediaImage::class, 'model');
    }

    /**
     * @param string|UploadedFile $file
     * @param string $collectionName
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function replaceMedia($file, string $collectionName='default')
    {
        $this->clearMediaCollection($collectionName)
            ->addMedia($file)
            ->toMediaCollection($collectionName);
    }
}
