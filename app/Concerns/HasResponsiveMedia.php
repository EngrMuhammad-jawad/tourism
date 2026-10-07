<?php

namespace App\Concerns;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasResponsiveMedia
{
    use InteractsWithMedia {
        registerMediaConversions as parentRegisterMediaConversions;
    }

    /**
     * Register standard responsive WebP conversions for tourism media.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 260)
            ->format('webp')
            ->quality(82)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->fit(Fit::Crop, 800, 520)
            ->format('webp')
            ->quality(85)
            ->nonQueued();

        $this->addMediaConversion('hero')
            ->fit(Fit::Max, 1920, 1080)
            ->format('webp')
            ->quality(88)
            ->nonQueued();
    }
}
