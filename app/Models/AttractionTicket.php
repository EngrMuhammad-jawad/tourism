<?php

namespace App\Models;

use App\Concerns\HasResponsiveMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class AttractionTicket extends Model implements HasMedia
{
    use HasFactory, HasResponsiveMedia, HasTranslations, SoftDeletes;

    protected $fillable = [
        'tour_package_id',
        'slug',
        'city',
        'category',
        'title',
        'attraction_name',
        'badge',
        'counter_price',
        'our_price',
        'currency',
        'summary',
        'description',
        'inclusions',
        'validity',
        'image',
        'sort_order',
        'is_featured',
        'status',
    ];

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = [
        'title',
        'attraction_name',
        'badge',
        'summary',
        'description',
        'validity',
    ];

    protected function casts(): array
    {
        return [
            'counter_price' => 'decimal:2',
            'our_price' => 'decimal:2',
            'inclusions' => 'array',
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    /**
     * Exact savings amount in currency.
     */
    public function savings(): float
    {
        return max(0, (float) $this->counter_price - (float) $this->our_price);
    }

    /**
     * Percentage discount vs gate counter rate.
     */
    public function savingsPercent(): int
    {
        if ((float) $this->counter_price <= 0) {
            return 0;
        }

        return (int) round((($this->counter_price - $this->our_price) / $this->counter_price) * 100);
    }

    /**
     * Formatted string for gate counter price.
     */
    public function formattedCounterPrice(): string
    {
        return number_format((float) $this->counter_price, 0) . ' ' . $this->currency;
    }

    /**
     * Formatted string for our discounted rate.
     */
    public function formattedOurPrice(): string
    {
        return number_format((float) $this->our_price, 0) . ' ' . $this->currency;
    }

    /**
     * Formatted savings string (e.g., "Save 75 AED").
     */
    public function formattedSavings(): string
    {
        return number_format($this->savings(), 0) . ' ' . $this->currency;
    }

    /**
     * WhatsApp direct reservation click URL.
     */
    public function whatsappUrl(): string
    {
        $rawPhone = Setting::get('contact.phone', '+971 4 321 8899');
        $cleanPhone = preg_replace('/[^0-9]/', '', (string) $rawPhone);
        $title = is_array($this->title) ? ($this->title['en'] ?? reset($this->title)) : (string) $this->title;
        $msg = "Hello Dubai Tour Book, I would like to book official tickets for: {$title} (Special Rate: {$this->our_price} {$this->currency}). Please share confirmation.";

        return "https://wa.me/{$cleanPhone}?text=" . rawurlencode($msg);
    }

    /**
     * Scope for active tickets.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Scope for featured tickets.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by category filter.
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
