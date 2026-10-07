<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Webhook verification endpoint for Meta WhatsApp Cloud API (GET).
     */
    public function verify(Request $request)
    {
        $verifyToken = config('services.whatsapp.verify_token', 'dubai_tour_book_verify_token_2026');
        
        $hubMode = $request->query('hub_mode');
        $hubToken = $request->query('hub_verify_token');
        $hubChallenge = $request->query('hub_challenge');

        if ($hubMode === 'subscribe' && $hubToken === $verifyToken) {
            return response($hubChallenge, 200);
        }

        return response('Unauthorized verification token', 403);
    }

    /**
     * Webhook message handler for incoming WhatsApp messages and interactive button clicks (POST).
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();
        Log::info('WhatsApp Webhook Incoming:', $payload);

        $entry = $payload['entry'][0]['changes'][0]['value'] ?? null;
        if (! $entry || empty($entry['messages'])) {
            return response()->json(['status' => 'ignored']);
        }

        $message = $entry['messages'][0];
        $from = $message['from']; // User's WhatsApp number
        $type = $message['type'] ?? 'text';
        $body = trim($message['text']['body'] ?? '');
        $interactiveId = $message['interactive']['button_reply']['id'] ?? ($message['interactive']['list_reply']['id'] ?? null);

        // Process message through hierarchical state machine
        $reply = $this->resolveResponse($from, $body, $interactiveId);

        // Return JSON response or dispatch to WhatsApp Cloud API Client
        return response()->json([
            'status' => 'success',
            'recipient' => $from,
            'reply' => $reply,
        ]);
    }

    /**
     * State machine for bot flows.
     */
    protected function resolveResponse(string $from, string $text, ?string $interactiveId): array
    {
        $action = $interactiveId ?: strtolower($text);

        // 1. FLIGHTS
        if (str_contains($action, 'flight')) {
            return [
                'type' => 'text',
                'body' => "✈️ *Flight Booking Concierge*\nPlease send your flight details in this format:\n\n• From:\n• To:\n• Departure Date:\n• Arrival Date:\n• Passengers:\n• WhatsApp:\n\nOr click below to speak directly with our ticketing desk.",
                'buttons' => [
                    ['id' => 'direct_agent_flights', 'title' => 'Direct Agent Chat'],
                    ['id' => 'main_menu', 'title' => 'Main Menu'],
                ],
            ];
        }

        // 2. TRANSFER, TAXI
        if (str_contains($action, 'transfer') || str_contains($action, 'taxi')) {
            return [
                'type' => 'text',
                'body' => "🚖 *VIP Transfer & Taxi Service*\nWe provide airport pickups, intercity luxury cars, and 24/7 transfers across the UAE.\n\nReply with your pickup date, time, and locations.",
                'buttons' => [
                    ['id' => 'direct_agent_transfer', 'title' => 'Book Now with Agent'],
                    ['id' => 'main_menu', 'title' => 'Main Menu'],
                ],
            ];
        }

        // 3. FOOD
        if (str_contains($action, 'food') || str_contains($action, 'dine') || str_contains($action, 'dining')) {
            return [
                'type' => 'text',
                'body' => "🍽️ *Food & Fine Dining*\nWe arrange table reservations at top venues, Michelin-star restaurants, and luxury Marina dinner cruises.\n\nReply with your preferred date, cuisine, and party size.",
                'buttons' => [
                    ['id' => 'direct_agent_food', 'title' => 'Reserve Table'],
                    ['id' => 'main_menu', 'title' => 'Main Menu'],
                ],
            ];
        }

        // 4. CITY TOURS
        if (str_contains($action, 'city tour') || $action === 'menu_city_tours') {
            return [
                'type' => 'interactive_list',
                'body' => "🏙️ *Select a City Tour Destination:*\nChoose the city you would like to explore:",
                'options' => [
                    ['id' => 'tour_dubai', 'title' => 'Dubai'],
                    ['id' => 'tour_abu_dhabi', 'title' => 'Abu Dhabi'],
                    ['id' => 'tour_fujairah', 'title' => 'Fujairah & RAK with UAQ'],
                    ['id' => 'tour_sharjah', 'title' => 'Sharjah & Ajman'],
                ],
            ];
        }

        // 4.1 Dubai Tour Options
        if ($action === 'tour_dubai') {
            return [
                'type' => 'interactive_buttons',
                'body' => "🇦🇪 *Dubai City Tour*\nPlease choose your tour style:",
                'buttons' => [
                    ['id' => 'dubai_sharing', 'title' => 'Sharing (55 AED)'],
                    ['id' => 'dubai_private', 'title' => 'Private Car'],
                    ['id' => 'menu_city_tours', 'title' => 'Other Cities'],
                ],
            ];
        }

        if ($action === 'dubai_sharing') {
            return [
                'type' => 'text',
                'body' => "🇦🇪 *Dubai Sharing City Tour*\n\n*Price: 55 AED* 💵\n\n*Terms & Conditions:*\n1. Sharing Dubai city tour is available only from Dubai, Sharjah & Ajman\n2. We will pick you up from your hotel or any location which you will send us\n3. We will provide water & some local style snacks during tour\n4. Payment is after tour only\n5. You can pay by card or cash in any currency but according to currency exchange rates\n\n_Programs for tour are always discussed in WhatsApp chat._\n\nReply *CONFIRM DUBAI SHARING* with your hotel name and date to book!",
            ];
        }

        if ($action === 'dubai_private') {
            return [
                'type' => 'text',
                'body' => "🇦🇪 *Dubai Private Car City Tour*\n\n*Price:* Depends on the model of the car\n\n*Terms & Conditions:*\n1. Guests can choose any from available private cars for Dubai city tours, price will depend from the model of the car\n2. We will pick you up from your hotel or any location which you will send us\n3. We will provide water & some local style snacks during tour\n4. Payment is after tour only\n5. You can pay by card or cash in any currency but according to currency exchange rates\n6. We can provide long dresses or other kinds of requisite for photos & videos without additional charges\n\n_Programs for tour are always discussed in WhatsApp chat._\n\nReply *CONFIRM DUBAI PRIVATE* with your desired date and car preference!",
            ];
        }

        // 4.2 Abu Dhabi Tour Options
        if ($action === 'tour_abu_dhabi') {
            return [
                'type' => 'interactive_buttons',
                'body' => "🕌 *Abu Dhabi City Tour*\nPlease choose your tour style:",
                'buttons' => [
                    ['id' => 'abu_dhabi_sharing', 'title' => 'Sharing (70 AED)'],
                    ['id' => 'abu_dhabi_private', 'title' => 'Private Car'],
                    ['id' => 'menu_city_tours', 'title' => 'Other Cities'],
                ],
            ];
        }

        if ($action === 'abu_dhabi_sharing') {
            return [
                'type' => 'text',
                'body' => "🕌 *Abu Dhabi Sharing City Tour*\n\n*Price: 70 AED* 💵\n\n*Terms & Conditions:*\n1. Sharing Abu Dhabi city tour is available only from Dubai, Abu Dhabi, Sharjah & Ajman\n2. We will pick you up from your hotel or any location which you will send us\n3. We will provide water & some local style snacks during tour\n4. Payment is after tour only\n5. You can pay by card or cash in any currency but according to currency exchange rates\n6. Abu Dhabi city tour includes visiting Grand Mosque, men are kindly requested not to wear shorts (only trousers & any kind of shirt or t-shirt), and women are kindly requested to cover their hair & wear the modest, opaque dresses which are loose-fitting & provides full coverage\n\n_Programs for tour are always discussed in WhatsApp chat._\n\nReply *CONFIRM ABU DHABI SHARING* with your hotel name and date to book!",
            ];
        }

        if ($action === 'abu_dhabi_private') {
            return [
                'type' => 'text',
                'body' => "🕌 *Abu Dhabi Private Car City Tour*\n\n*Price:* Depends on the model of the car\n\n*Terms & Conditions:*\n1. Guests can choose any from available private cars for Abu Dhabi city tours, price will depend from the model of the car\n2. We will pick you up from your hotel or any location which you will send us\n3. We will provide water & some local style snacks during tour\n4. Payment is after tour only\n5. You can pay by card or cash in any currency but according to currency exchange rates\n6. We can provide long dresses, abayas, or other kinds of requisite for photos & videos without additional charges\n7. Abu Dhabi city tour includes visiting Grand Mosque, men are kindly requested not to wear shorts (only trousers & any kind of shirt or t-shirt), and women are kindly requested to cover their hair & wear the modest, opaque dresses which are loose-fitting & provides full coverage\n\n_Programs for tour are always discussed in WhatsApp chat._\n\nReply *CONFIRM ABU DHABI PRIVATE* with your date and hotel location!",
            ];
        }

        // 5. DESERT SAFARI
        if (str_contains($action, 'safari') || $action === 'menu_desert_safari') {
            return [
                'type' => 'interactive_buttons',
                'body' => "🏜️ *Desert Safari & Arabian Adventures*\nSelect an option below to view galleries, cars, or book your adventure:",
                'buttons' => [
                    ['id' => 'safari_gallery', 'title' => 'Photo & Video Gallery'],
                    ['id' => 'safari_cars', 'title' => 'Cars for Adventure'],
                    ['id' => 'safari_book', 'title' => 'Book Desert Safari'],
                ],
            ];
        }

        // DEFAULT: MAIN MENU
        return [
            'type' => 'interactive_list',
            'body' => "🇦🇪 *Welcome to Dubai Tour Concierge!*\nPlease select an option below:",
            'options' => [
                ['id' => 'menu_flights', 'title' => '✈️ Flights'],
                ['id' => 'menu_transfer', 'title' => '🚖 Transfer, Taxi'],
                ['id' => 'menu_food', 'title' => '🍽️ Food'],
                ['id' => 'menu_city_tours', 'title' => '🏙️ City Tours'],
                ['id' => 'menu_desert_safari', 'title' => '🏜️ Desert Safari'],
            ],
        ];
    }
}
