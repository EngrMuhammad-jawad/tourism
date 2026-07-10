<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\AdminMenu;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $canViewBookings = $user->can('bookings.view');
        $canViewUsers = $user->can('users.view');

        $cards = collect([
            $this->card('Destinations', Destination::count(), 'destinations.view', 'map', 'gold'),
            $this->card('Tour packages', TourPackage::count(), 'packages.view', 'ticket', 'violet'),
            $this->card('Bookings', $canViewBookings ? Booking::count() : null, 'bookings.view', 'calendar', 'blue'),
            $this->card('Pending bookings', $canViewBookings ? Booking::pending()->count() : null, 'bookings.view', 'clock', 'amber'),
            $this->card('Customers', $canViewUsers ? User::role('Customer')->count() : null, 'users.view', 'users', 'emerald'),
        ])->filter(fn (array $card) => $user->can($card['permission']))->values();

        return view('admin.dashboard', [
            'adminMenu' => AdminMenu::sidebarFor($user),
            'cards' => $cards,
            'latestBookings' => $canViewBookings
                ? Booking::query()->with(['user', 'bookable'])->latest()->take(6)->get()
                : collect(),
            'latestCustomers' => $canViewUsers
                ? User::role('Customer')->latest()->take(6)->get()
                : collect(),
            'monthlyBookings' => $canViewBookings ? $this->monthlyBookings() : ['labels' => [], 'values' => []],
            'bookingStatuses' => $canViewBookings ? $this->bookingStatuses() : ['labels' => [], 'values' => []],
        ]);
    }

    private function card(string $label, ?int $value, string $permission, string $icon, string $color): array
    {
        return compact('label', 'value', 'permission', 'icon', 'color');
    }

    private function monthlyBookings(): array
    {
        $months = collect(range(5, 0))->map(fn (int $offset) => CarbonImmutable::now()->startOfMonth()->subMonths($offset));
        $counts = Booking::query()
            ->whereBetween('created_at', [$months->first(), CarbonImmutable::now()->endOfMonth()])
            ->get(['id', 'created_at'])
            ->countBy(fn (Booking $booking) => $booking->created_at->format('Y-m'));

        return [
            'labels' => $months->map(fn (CarbonImmutable $month) => $month->format('M Y'))->all(),
            'values' => $months->map(fn (CarbonImmutable $month) => $counts->get($month->format('Y-m'), 0))->all(),
        ];
    }

    private function bookingStatuses(): array
    {
        $counts = Booking::query()
            ->get(['id', 'status'])
            ->countBy(fn (Booking $booking) => $booking->status->value);

        return [
            'labels' => collect(BookingStatus::cases())->map(fn (BookingStatus $status) => ucfirst($status->value))->all(),
            'values' => collect(BookingStatus::cases())->map(fn (BookingStatus $status) => $counts->get($status->value, 0))->all(),
        ];
    }
}
