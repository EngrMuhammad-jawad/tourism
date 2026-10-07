<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['package', 'room', 'transport'])],
            'id' => ['required', 'integer'],
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'adults' => ['required', 'integer', 'min:1', 'max:100'],
            'children' => ['nullable', 'integer', 'min:0', 'max:100'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'customer_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
