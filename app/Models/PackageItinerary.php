<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

#[Fillable(['tour_package_id', 'day_number', 'title', 'description'])]
class PackageItinerary extends Model
{
    use HasTranslations;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['title', 'description'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
