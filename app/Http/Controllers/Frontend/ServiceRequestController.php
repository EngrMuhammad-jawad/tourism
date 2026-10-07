<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Submit a new service request from the frontend menu / modal.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'service_type' => ['required', 'string', 'in:' . implode(',', array_keys(ServiceRequest::SERVICE_TYPES))],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'service_date' => ['nullable', 'date'],
            'return_date' => ['nullable', 'date', 'after_or_equal:service_date'],
            'guests_count' => ['nullable', 'integer', 'min:1', 'max:500'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'pickup_location' => ['nullable', 'string', 'max:255'],
            'dropoff_location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:3000'],
            'details' => ['nullable', 'array'],
        ]);

        $serviceRequest = ServiceRequest::create([
            ...$validated,
            'user_id' => $request->user()?->id,
            'status' => 'pending',
            'details' => $request->input('details', []),
        ]);

        $serviceLabel = ServiceRequest::SERVICE_TYPES[$serviceRequest->service_type] ?? 'Service';
        $message = "Your request for {$serviceLabel} (Ref: {$serviceRequest->reference_no}) has been received! Our VIP concierge team will reach out to you within minutes.";

        $trackingEvent = [
            'event' => 'generate_lead',
            'lead_type' => 'vip_service_request',
            'service_type' => $serviceRequest->service_type,
            'reference_no' => $serviceRequest->reference_no,
            'currency' => 'AED',
            'value' => (float) ($serviceRequest->budget ?? 0),
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'reference_no' => $serviceRequest->reference_no,
                'service_type' => $serviceRequest->service_type,
                'tracking_event' => $trackingEvent,
            ]);
        }

        return back()->with('success', $message)->with('tracking_event', $trackingEvent);
    }
}
