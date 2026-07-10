<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'icon'])]
class Amenity extends Model
{
    use HasTranslations;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['name'];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class);
    }
}
