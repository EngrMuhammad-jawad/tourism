<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

#[Fillable([
    'user_id', 'bookable_type', 'bookable_id', 'travel_date',
    'adults', 'children', 'unit_price', 'total_price',
    'payment_method', 'status', 'customer_note', 'admin_note', 'cancelled_at',
])]
class Booking extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'payment_method' => PaymentMethod::class,
            'status' => BookingStatus::class,
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->booking_number ??= self::generateBookingNumber();
        });
    }

    /**
     * Human-friendly unique reference, e.g. BK-2026-8F3KQZ.
     */
    public static function generateBookingNumber(): string
    {
        do {
            $number = 'BK-'.now()->format('Y').'-'.Str::upper(Str::random(6));
        } while (self::where('booking_number', $number)->exists());

        return $number;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function totalGuests(): int
    {
        return $this->adults + $this->children;
    }

    #[Scope]
    protected function pending(Builder $query): void
    {
        $query->where('status', BookingStatus::Pending);
    }
}
