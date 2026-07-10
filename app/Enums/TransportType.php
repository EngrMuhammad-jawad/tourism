<?php

namespace App\Enums;

enum TransportType: string
{
    case Car = 'car';
    case Van = 'van';
    case Bus = 'bus';
    case Flight = 'flight';
    case Pickup = 'pickup';

    public function label(): string
    {
        return __('transport_type_'.$this->value);
    }
}
