<?php

namespace App\Models;

use App\Enums\TransportType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

#[Fillable([
    'type', 'slug', 'name', 'description',
    'capacity', 'price', 'price_unit', 'status',
])]
class Transport extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, SoftDeletes;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'type' => TransportType::class,
            'price' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
