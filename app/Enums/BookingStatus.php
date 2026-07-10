<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    /**
     * Statuses a customer may still cancel from their dashboard.
     */
    public function isCancellable(): bool
    {
        return in_array($this, [self::Pending, self::Approved], true);
    }

    public function label(): string
    {
        return __('booking_status_'.$this->value);
    }
}
