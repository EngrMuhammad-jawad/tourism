<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

#[Fillable(['album_id', 'title', 'video_url', 'sort_order', 'status'])]
class GalleryVideo extends Model
{
    use HasTranslations, SoftDeletes;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['title'];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
