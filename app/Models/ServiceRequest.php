<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ServiceRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_no',
        'user_id',
        'service_type',
        'name',
        'email',
        'phone',
        'service_date',
        'return_date',
        'guests_count',
        'budget',
        'pickup_location',
        'dropoff_location',
        'details',
        'notes',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'return_date' => 'date',
            'details' => 'array',
            'budget' => 'decimal:2',
            'guests_count' => 'integer',
        ];
    }

    public const SERVICE_TYPES = [
        'flights' => 'Flights',
        'hotels' => 'Hotels',
        'transfer_taxi' => 'Transfer, Taxi',
        'food' => 'Food & Dining',
        'city_tours' => 'City Tours',
        'desert_safari' => 'Desert Safari',
        'tickets' => 'Tickets & Attractions',
        'relocation' => 'Relocation & Visa',
        'to_buy_property' => 'To Buy Property',
    ];

    public const STATUSES = [
        'pending' => 'Pending Review',
        'contacted' => 'Contacted / Follow-up',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected static function booted(): void
    {
        static::creating(function (ServiceRequest $request) {
            $request->reference_no ??= self::generateReferenceNumber();
        });
    }

    public static function generateReferenceNumber(): string
    {
        do {
            $number = 'REQ-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (self::where('reference_no', $number)->exists());

        return $number;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceLabelAttribute(): string
    {
        return self::SERVICE_TYPES[$this->service_type] ?? ucwords(str_replace('_', ' ', $this->service_type));
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
