<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Services\BookingService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService
    ) {}

    public function index(Request $request)
    {
        SeoService::setNoIndex();

        return view('dashboard.index', [
            'bookings' => $request->user()->bookings()
                ->with([
                    'payments',
                    'bookable' => function ($morphTo) {
                        $morphTo->morphWith([
                            Room::class => ['hotel'],
                            TourPackage::class => ['destination'],
                        ]);
                    },
                ])
                ->latest()
                ->paginate(12),
            'serviceRequests' => \App\Models\ServiceRequest::query()
                ->where(function ($q) use ($request) {
                    $q->where('user_id', $request->user()->id)
                      ->orWhere('email', $request->user()->email);
                })
                ->latest()
                ->get(),
        ]);
    }

    public function create(Request $request)
    {
        SeoService::setNoIndex();

        $request->validate(['type' => ['required', Rule::in(['package', 'room', 'transport'])], 'id' => ['required', 'integer']]);

        return view('frontend.bookings.create', ['bookable' => $this->bookable($request->string('type')->toString(), $request->integer('id'))]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $bookable = $this->bookable($request->validated('type'), $request->validated('id'));
        $booking = $this->bookingService->createBooking($request->user(), $bookable, $request->validated());

        return redirect()->route('dashboard')->with('success', "Booking {$booking->booking_number} was submitted successfully.")
            ->with('tracking_event', [
                'event' => 'purchase',
                'transaction_id' => (string) $booking->booking_number,
                'value' => (float) $booking->total_price,
                'currency' => 'AED',
                'items' => [
                    [
                        'item_id' => (string) $bookable->id,
                        'item_name' => $bookable->name ?? $bookable->title ?? 'Booking Item',
                        'item_category' => (string) $request->validated('type'),
                        'price' => (float) $booking->total_price,
                        'quantity' => (int) ($booking->guest_count ?? 1),
                    ]
                ]
            ]);
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
        abort_unless($booking->status->isCancellable(), 422, 'This booking can no longer be cancelled.');

        $this->bookingService->cancelBooking($booking);

        return back()->with('success', 'Your booking has been cancelled.');
    }

    private function bookable(string $type, int $id): TourPackage|Room|Transport
    {
        $model = match ($type) {
            'package' => TourPackage::class,
            'room' => Room::class,
            'transport' => Transport::class,
        };
        $bookable = $model::findOrFail($id);

        abort_unless($bookable->status, 404);

        return $bookable;
    }
}
