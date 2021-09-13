<?php

namespace App\Support\Media;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaImage extends Media
{
    public const CONVERSION_TYPE_SMALL = 'small';
    public const CONVERSION_TYPE_MIDDLE = 'middle';
    public const CONVERSION_TYPE_BIG = 'big';

    public const CONVERSION_TYPES = [
        self::CONVERSION_TYPE_SMALL,
        self::CONVERSION_TYPE_MIDDLE,
        self::CONVERSION_TYPE_BIG,
    ];

    /**
     * @return array
     */
    public function getConversions(): array
    {
        $conversions = [];
        $fileExtension = 'jpg';
        $conversionsPath = $this->getConversionsFolderPath();
        $fileName = pathinfo($this->file_name, PATHINFO_FILENAME);
        foreach (self::CONVERSION_TYPES as $conversionType) {
            $conversions[$conversionType] = $this->getResourceCdnPath(
                $this->getConversionPaths($conversionsPath, $fileName, $conversionType, $fileExtension))
            ;
        }

        return $conversions;
    }

    /**
     * @return string
     */
    public function getConversionsFolderPath(): string
    {
        return Storage::url(config('media.directory_path')) . '/' . $this->id . '/conversions/';
    }

    /**
     * @param string $conversionsPath
     * @param string $fileName
     * @param string $conversionType
     * @param string $fileExtension
     *
     * @return string
     */
    protected function getConversionPaths(string $conversionsPath, string $fileName, string $conversionType, string $fileExtension): string
    {
        return $conversionsPath . $fileName . '-' . $conversionType . '.' . $fileExtension;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getResourceCdnPath(string $urn = ''): string
    {
        return url($urn);
    }
}
