<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case PayLater = 'pay_later';
    case Online = 'online';

    public function label(): string
    {
        return __('payment_method_'.$this->value);
    }
}
