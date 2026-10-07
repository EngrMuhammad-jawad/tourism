<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Concerns\HasResponsiveMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

#[Fillable([
    'destination_id', 'slug', 'name', 'summary', 'description',
    'price', 'sale_price', 'duration_days', 'duration_nights', 'max_guests',
    'included_services', 'excluded_services', 'available_from', 'available_to',
    'is_featured', 'status',
])]
class TourPackage extends Model implements HasMedia
{
    use HasFactory, HasResponsiveMedia, HasTranslations, SoftDeletes;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['name', 'summary', 'description', 'included_services', 'excluded_services'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'available_from' => 'date',
            'available_to' => 'date',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(PackageItinerary::class)->orderBy('day_number');
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function attractionTicket(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AttractionTicket::class);
    }

    /**
     * Price the customer actually pays (sale price wins when set).
     */
    public function effectivePrice(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true);
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    protected function filter(Builder $query, array $filters): void
    {
        $query
            ->when($filters['q'] ?? $filters['search'] ?? $filters['keyword'] ?? null, function ($q, $term) {
                $term = trim((string) $term);
                if ($term === '') {
                    return;
                }

                $lowerTerm = mb_strtolower($term, 'UTF-8');
                $keywords = preg_split('/\s+/', $lowerTerm, -1, PREG_SPLIT_NO_EMPTY);

                $q->where(function ($sub) use ($lowerTerm, $keywords) {
                    $sub->whereRaw("LOWER(name) LIKE ?", ["%{$lowerTerm}%"])
                        ->orWhereRaw("LOWER(summary) LIKE ?", ["%{$lowerTerm}%"])
                        ->orWhereRaw("LOWER(description) LIKE ?", ["%{$lowerTerm}%"])
                        ->orWhereHas('destination', fn ($d) => $d->whereRaw("LOWER(name) LIKE ?", ["%{$lowerTerm}%"])->orWhere('slug', 'like', "%{$lowerTerm}%"));

                    foreach ($keywords as $kw) {
                        $sub->orWhereRaw("LOWER(name) LIKE ?", ["%{$kw}%"])
                            ->orWhereRaw("LOWER(summary) LIKE ?", ["%{$kw}%"])
                            ->orWhereRaw("LOWER(description) LIKE ?", ["%{$kw}%"])
                            ->orWhereHas('destination', fn ($d) => $d->whereRaw("LOWER(name) LIKE ?", ["%{$kw}%"])->orWhere('slug', 'like', "%{$kw}%"));
                    }
                });
            })
            ->when($filters['destination'] ?? null, function ($q, $dest) {
                if (is_numeric($dest)) {
                    $q->where('destination_id', (int) $dest);
                } else {
                    $q->whereHas('destination', fn ($d) => $d->where('slug', $dest)->orWhere('name', 'like', "%{$dest}%"));
                }
            })
            ->when($filters['duration'] ?? null, fn ($q, $duration) => $q->where('duration_days', '>=', (int) $duration))
            ->when($filters['min_price'] ?? null, fn ($q, $min) => $q->where(fn ($sub) => $sub->where('sale_price', '>=', $min)->orWhere('price', '>=', $min)))
            ->when($filters['max_price'] ?? null, fn ($q, $max) => $q->where(fn ($sub) => $sub->where('sale_price', '<=', $max)->orWhere('price', '<=', $max)));
    }

    #[Scope]
    protected function orderByDubaiFirst(Builder $query, ?string $searchTerm = null): void
    {
        $dubaiId = Destination::where('slug', 'dubai')->value('id') ?? 2;

        if ($searchTerm && trim($searchTerm) !== '') {
            $term = '%' . strtolower(trim($searchTerm)) . '%';
            $query->orderByRaw("CASE WHEN LOWER(name) LIKE ? THEN 0 ELSE 1 END", [$term]);
        }

        // Put Dubai tours at the top of all listings
        $query->orderByRaw("CASE WHEN destination_id = ? THEN 0 ELSE 1 END", [(int) $dubaiId]);
        $query->orderByDesc('is_featured');
        $query->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
