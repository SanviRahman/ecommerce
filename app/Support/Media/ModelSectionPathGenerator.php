<?php

namespace App\Support\Media;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class ModelSectionPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->basePath($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->basePath($media).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->basePath($media).'/responsive-images/';
    }

    private function basePath(Media $media): string
    {
        $modelName = class_basename((string) $media->model_type);
        $modelFolder = Str::plural(Str::kebab($modelName ?: 'media'));
        $collectionFolder = Str::slug(str_replace('_', ' ', (string) ($media->collection_name ?: 'default')));
        $modelId = $media->model_id ?: 'unattached';
        $mediaId = $media->getKey() ?: $media->uuid ?: 'pending';

        return sprintf(
            '%s/%s/item-%s/media-%s',
            $modelFolder,
            $collectionFolder,
            $modelId,
            $mediaId
        );
    }
}
