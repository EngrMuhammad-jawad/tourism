<!-- Luxury Service Request Modal -->
<div id="service-request-modal" class="fixed inset-0 overflow-y-auto transition-all duration-300 items-center justify-center p-3 sm:p-6" style="display: none; position: fixed; inset: 0; z-index: 99999; background-color: rgba(11, 15, 23, 0.88); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);" role="dialog" aria-modal="true" aria-labelledby="service-modal-title">
    <div class="relative w-full max-w-3xl rounded-3xl bg-white border border-gold/40 shadow-2xl overflow-hidden transition-all duration-300 transform scale-95 opacity-0 my-auto" id="service-modal-card" style="background-color: #ffffff; color: #0b0f17; z-index: 100000; position: relative;">
        
        <!-- Modal Header Banner -->
        <div class="relative bg-gradient-to-r from-deepblack via-black to-deepblack text-white p-6 sm:p-8 border-b border-gold/30">
            <button type="button" id="close-service-modal" class="absolute top-5 right-5 text-gray-400 hover:text-white rounded-full p-2 bg-white/10 hover:bg-white/20 transition-colors focus:outline-none" aria-label="Close modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold/20 border border-gold/40 text-gold text-xs font-bold uppercase tracking-wider mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
                VIP Concierge & Service Request
            </div>
            <h2 id="service-modal-title" class="text-2xl sm:text-3xl font-extrabold text-white">Book & Inquire Services</h2>
            <p id="service-modal-subtitle" class="text-xs sm:text-sm text-gray-300 mt-1">Select your desired service and let our VIP concierge arrange every detail for you.</p>

            <!-- 9 Service Pill Selection Carousel -->
            <div class="mt-5 flex gap-2 overflow-x-auto pb-2 scrollbar-none text-xs font-bold" id="service-pills-bar">
                <button type="button" data-service-pill="flights" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Flights</span>
                </button>
                <button type="button" data-service-pill="hotels" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Hotels</span>
                </button>
                <button type="button" data-service-pill="transfer_taxi" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Transfer, Taxi</span>
                </button>
                <button type="button" data-service-pill="food" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Food</span>
                </button>
                <button type="button" data-service-pill="city_tours" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>City Tours</span>
                </button>
                <button type="button" data-service-pill="desert_safari" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Desert Safari</span>
                </button>
                <button type="button" data-service-pill="tickets" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Tickets</span>
                </button>
                <button type="button" data-service-pill="relocation" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>Relocation</span>
                </button>
                <button type="button" data-service-pill="to_buy_property" class="service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center justify-center">
                    <span>To Buy Property</span>
                </button>
            </div>
        </div>

        <!-- Success Container (hidden by default) -->
        <div id="service-modal-success" class="hidden p-8 sm:p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-3xl shadow-lg shadow-emerald-500/10">
                ✓
            </div>
            <h3 class="text-2xl font-bold text-deepblack mb-2">Request Submitted Successfully!</h3>
            <p class="text-gray-600 text-sm max-w-md mx-auto mb-4" id="service-success-message">
                Your request has been received. Our dedicated luxury concierge will contact you via WhatsApp and Email shortly.
            </p>
            <div class="inline-block bg-amber-50 border border-gold/40 rounded-2xl px-6 py-3 text-gold font-extrabold text-base mb-6 tracking-wide" id="service-success-ref">
                Reference: REQ-2026-XXXXXX
            </div>
            <div>
                <button type="button" id="close-success-btn" class="bg-deepblack text-white hover:bg-gold hover:text-deepblack transition font-bold px-8 py-3 rounded-xl shadow-lg">
                    Done
                </button>
            </div>
        </div>

        <!-- Request Form -->
        <form id="service-request-form" method="POST" action="{{ route('service-requests.store', ['locale' => app()->getLocale()]) }}" class="p-6 sm:p-8 space-y-6">
            @csrf
            <input type="hidden" name="service_type" id="modal-service-type" value="flights">

            <!-- Dynamic Fields Container -->
            <div id="dynamic-service-fields" class="space-y-4 rounded-2xl bg-amber-50/40 p-4 sm:p-5 border border-gold/20">
                <!-- Javascript will render specific inputs here -->
            </div>

            <!-- Customer Contact Information -->
            <div class="border-t border-gray-100 pt-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gold mb-3">Your Contact Details</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required value="{{ auth()->user()?->name }}" placeholder="e.g. Mohammed Al Mansoor" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required value="{{ auth()->user()?->email }}" placeholder="name@example.com" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Phone / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="tel" name="phone" required value="{{ auth()->user()?->phone }}" placeholder="+971 50 123 4567" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Additional Notes / Preferences -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Special Requirements / Notes (Optional)</label>
                <textarea name="notes" rows="2" placeholder="Any specific wishes, dietary requirements, preferred airlines, property preferences..." class="w-full rounded-xl border border-gray-300 p-3 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition resize-none"></textarea>
            </div>

            <!-- Error Banner -->
            <div id="service-modal-error" class="hidden rounded-xl border border-rose-200 bg-rose-50 p-3 text-xs text-rose-700 font-semibold"></div>

            <!-- Actions -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-2">
                <div id="service-catalog-link-container">
                    <!-- Dynamic link if catalog exists (e.g. view hotels or transport) -->
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="button" id="cancel-modal-btn" class="w-full sm:w-auto px-5 py-3 rounded-xl border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit" id="submit-request-btn" class="w-full sm:w-auto px-7 py-3 rounded-xl bg-gold text-deepblack font-extrabold text-sm hover:bg-deepblack hover:text-white transition-all shadow-lg shadow-gold/20 flex items-center justify-center gap-2">
                        <span id="submit-btn-text">Submit Request</span>
                        <svg id="submit-btn-spinner" class="hidden w-4 h-4 animate-spin text-current" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('service-request-modal');
        const card = document.getElementById('service-modal-card');
        const closeBtn = document.getElementById('close-service-modal');
        const cancelBtn = document.getElementById('cancel-modal-btn');
        const closeSuccessBtn = document.getElementById('close-success-btn');
        const pills = document.querySelectorAll('.service-pill-btn');
        const serviceTypeInput = document.getElementById('modal-service-type');
        const dynamicContainer = document.getElementById('dynamic-service-fields');
        const catalogLinkContainer = document.getElementById('service-catalog-link-container');
        const form = document.getElementById('service-request-form');
        const successBox = document.getElementById('service-modal-success');
        const errorBox = document.getElementById('service-modal-error');
        const submitBtn = document.getElementById('submit-request-btn');
        const submitText = document.getElementById('submit-btn-text');
        const submitSpinner = document.getElementById('submit-btn-spinner');

        const serviceConfigs = {
            flights: {
                title: 'Flights & Private Jet Booking',
                subtitle: 'Request commercial flights or private VIP charter flights to/from Dubai and across the globe.',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Departure City / Airport</label>
                            <input type="text" name="pickup_location" placeholder="e.g. Riyadh (RUH) / London (LHR)" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Destination</label>
                            <input type="text" name="dropoff_location" value="Dubai International (DXB)" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Departure Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Return Date (Optional)</label>
                            <input type="date" name="return_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Passengers</label>
                            <input type="number" name="guests_count" min="1" max="50" value="1" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Travel Class</label>
                            <select name="details[class]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="First Class">First Class</option>
                                <option value="Business Class" selected>Business Class</option>
                                <option value="Economy Class">Economy Class</option>
                                <option value="Private Jet Charter">Private Jet Charter</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Trip Type</label>
                            <select name="details[trip_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Round Trip">Round Trip</option>
                                <option value="One Way">One Way</option>
                                <option value="Multi-City">Multi-City</option>
                            </select>
                        </div>
                    </div>
                `
            },
            hotels: {
                title: 'Luxury Hotels & Resorts',
                subtitle: 'VIP bookings at Burj Al Arab, Atlantis The Royal, Armani Hotel, and premier Dubai suites.',
                catalogUrl: '{{ route("hotels.index", ["locale" => app()->getLocale()]) }}',
                catalogText: 'Or browse Luxury Hotels Catalog →',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Preferred Hotel or Area</label>
                            <input type="text" name="details[hotel_preference]" placeholder="e.g. Palm Jumeirah / Atlantis / Downtown" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Star Rating</label>
                            <select name="details[star_rating]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="5-Star Ultra Luxury" selected>5-Star Ultra Luxury (7-Star Experience)</option>
                                <option value="5-Star Hotel">5-Star Luxury</option>
                                <option value="4-Star Premium">4-Star Premium</option>
                                <option value="Private Luxury Villa">Private Luxury Villa</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Check-in Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Check-out Date</label>
                            <input type="date" name="return_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Guests / Rooms</label>
                            <input type="number" name="guests_count" min="1" max="30" value="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            transfer_taxi: {
                title: 'Transfer & VIP Taxi Service',
                subtitle: 'Seamless airport pickups, luxury chauffeur driven limousines, Rolls Royce, and city transfers.',
                catalogUrl: '{{ route("transports.index", ["locale" => app()->getLocale()]) }}',
                catalogText: 'Or browse Transport Fleet Catalog →',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Pickup Location / Airport</label>
                            <input type="text" name="pickup_location" placeholder="e.g. Dubai DXB Terminal 3 or Hotel name" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Drop-off Destination</label>
                            <input type="text" name="dropoff_location" placeholder="e.g. Atlantis The Royal, Palm Jumeirah" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Pickup Time</label>
                            <input type="time" name="details[pickup_time]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Vehicle Preference</label>
                            <select name="details[vehicle_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Mercedes S-Class">Mercedes S-Class VIP</option>
                                <option value="Rolls Royce / Bentley">Rolls Royce / Bentley</option>
                                <option value="Cadillac Escalade SUV">Cadillac Escalade SUV</option>
                                <option value="Mercedes V-Class VIP Van">Mercedes V-Class Van (Family)</option>
                                <option value="Standard Luxury Sedan">Executive Luxury Sedan</option>
                            </select>
                        </div>
                    </div>
                `
            },
            food: {
                title: 'Food & Fine Dining Concierge',
                subtitle: 'VIP table reservations at Michelin-star restaurants, luxury dhow dinner cruises, and private chefs.',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Restaurant or Dining Type</label>
                            <input type="text" name="details[dining_type]" placeholder="e.g. At.mosphere Burj Khalifa, Zuma, Nobu, Dhow Cruise" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Cuisine / Experience</label>
                            <select name="details[cuisine]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Fine Dining Michelin Star">Fine Dining & Michelin Star</option>
                                <option value="Luxury Dhow Dinner Cruise">Luxury Marina Dhow Cruise</option>
                                <option value="Romantic Beachside Dinner">Romantic Beachside Dinner</option>
                                <option value="Traditional Arabian Royal Feast">Traditional Arabian Royal Feast</option>
                                <option value="Private Villa Chef">Private Villa Chef</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Reservation Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Time (Lunch / Dinner)</label>
                            <input type="time" name="details[meal_time]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Party Size (Guests)</label>
                            <input type="number" name="guests_count" min="1" max="100" value="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            city_tours: {
                title: 'Dubai & Emirates City Tours',
                subtitle: 'Curated private city excursions: Dubai Old & Modern, Abu Dhabi Grand Mosque, Sharjah & East Coast.',
                catalogUrl: '{{ route("packages.index", ["locale" => app()->getLocale()]) }}',
                catalogText: 'Or browse All Tour Packages →',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">City Tour Interest</label>
                            <select name="details[tour_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Dubai Full Day Private Tour">Dubai Full Day Highlights Tour</option>
                                <option value="Abu Dhabi Grand Mosque & Louvre">Abu Dhabi Grand Mosque & Louvre Tour</option>
                                <option value="Dubai Old Town & Gold Souk Heritage">Old Dubai & Gold Souk Heritage Walk</option>
                                <option value="Helicopter Dubai Skyline Tour">Helicopter Dubai Skyline Tour</option>
                                <option value="Private Yacht Tour Dubai Marina">Private Luxury Yacht Tour</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tour Style</label>
                            <select name="details[tour_style]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Private VIP Tour (Exclusive Vehicle & Guide)">Private VIP Tour (Vehicle + Guide)</option>
                                <option value="Small Luxury Group">Small Luxury Group</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Preferred Tour Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Total Guests</label>
                            <input type="number" name="guests_count" min="1" max="50" value="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            desert_safari: {
                title: 'VIP Desert Safari & Adventures',
                subtitle: 'Red dune bashing, luxury Royal desert camps, dune buggies, stargazing, and private BBQ.',
                catalogUrl: '{{ route("packages.index", ["locale" => app()->getLocale()]) }}',
                catalogText: 'Or browse Desert Safari Packages →',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Safari Experience</label>
                            <select name="details[safari_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="VIP Royal Evening Desert Safari" selected>VIP Royal Evening Desert Safari (Private Majlis)</option>
                                <option value="Overnight Desert Stargazing Safari">Overnight Desert Glamping Safari</option>
                                <option value="Morning Dune Bashing & Camel Trek">Morning Dune Bashing & Camel Trek</option>
                                <option value="High-Power Dune Buggy & Quad Adventure">High-Power Dune Buggy & Quad Adventure</option>
                                <option value="Heritage Falconry & Wildlife Conservation">Heritage Falconry & Conservation Safari</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Transport Option</label>
                            <select name="details[transport_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Private 4x4 Land Cruiser Pickup">Private 4x4 Land Cruiser Hotel Pickup</option>
                                <option value="Shared 4x4 Luxury Transfer">Shared 4x4 Luxury Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Safari Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Number of People</label>
                            <input type="number" name="guests_count" min="1" max="40" value="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            tickets: {
                title: 'Attractions & Theme Park Tickets',
                subtitle: 'Skip-the-line VIP tickets for Burj Khalifa, Museum of the Future, Aquaventure, and Ferrari World.',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Attraction or Event</label>
                            <input type="text" name="details[attraction_name]" placeholder="e.g. Burj Khalifa Level 148, Museum of the Future" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Ticket Category</label>
                            <select name="details[ticket_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="VIP Fast Track / Skip-The-Line">VIP Fast Track / Skip-The-Line</option>
                                <option value="General Admission Standard">General Admission Standard</option>
                                <option value="Combo Attraction Pass">Combo Multi-Attraction Pass</option>
                                <option value="Private Guided Tour Access">Private Guided Tour Access</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Visit Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Ticket Count (Adults + Kids)</label>
                            <input type="number" name="guests_count" min="1" max="50" value="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            relocation: {
                title: 'UAE Relocation & Golden Visa Assistance',
                subtitle: 'Full-service settling in Dubai: 10-year Golden Visa, family residency, company setup, and relocation.',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Primary Relocation Service</label>
                            <select name="details[relocation_service]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="UAE Golden Visa (10 Years)" selected>UAE Golden Visa (10 Years)</option>
                                <option value="Company Formation & Business Visa">Company Formation & Business Visa</option>
                                <option value="Family Residency & School Enrollment">Family Residency & School Enrollment</option>
                                <option value="Full VIP Relocation & Home Search">Full VIP Relocation & Home Search</option>
                                <option value="Banking & Tax Residency Consulting">Banking & Tax Residency Consulting</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Current Country of Residence</label>
                            <input type="text" name="pickup_location" placeholder="e.g. United Kingdom, USA, Germany, Saudi Arabia" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Anticipated Move Date</label>
                            <input type="date" name="service_date" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Family Members Relocating</label>
                            <input type="number" name="guests_count" min="1" max="20" value="1" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                `
            },
            to_buy_property: {
                title: 'To Buy Property - Dubai Real Estate',
                subtitle: 'Direct developer access (Emaar, Nakheel, Damac), luxury beachfront villas, penthouses, and high-ROI investments.',
                render: () => `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Property Type</label>
                            <select name="details[property_type]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Luxury Villa / Mansion">Luxury Villa / Mansion</option>
                                <option value="Waterfront Penthouse">Waterfront Penthouse</option>
                                <option value="Prime Apartment (Downtown/Marina)" selected>Prime Apartment (Downtown/Marina)</option>
                                <option value="Off-Plan High-ROI Investment">Off-Plan High-ROI Investment</option>
                                <option value="Commercial / Whole Building">Commercial / Whole Building</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Preferred Location</label>
                            <input type="text" name="details[preferred_area]" placeholder="e.g. Palm Jumeirah, Downtown, Dubai Hills, Marina" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Target Budget (AED)</label>
                            <input type="text" name="details[budget_range]" placeholder="e.g. 1,000,000 - 3,000,000 AED" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Purchase Timeline</label>
                            <select name="details[purchase_timeline]" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-gold outline-none bg-white">
                                <option value="Immediately (Within 30 days)">Immediately (Within 30 days)</option>
                                <option value="1 - 3 Months">1 - 3 Months</option>
                                <option value="3 - 6 Months">3 - 6 Months</option>
                                <option value="Exploring & Market Research">Exploring & Market Research</option>
                            </select>
                        </div>
                    </div>
                `
            }
        };

        window.openServiceModal = function(serviceKey) {
            const config = serviceConfigs[serviceKey] || serviceConfigs.flights;
            serviceTypeInput.value = serviceKey in serviceConfigs ? serviceKey : 'flights';

            // Update Titles
            document.getElementById('service-modal-title').textContent = config.title;
            document.getElementById('service-modal-subtitle').textContent = config.subtitle;

            // Update Dynamic Fields
            dynamicContainer.innerHTML = config.render();

            // Update Catalog Link if any
            if (config.catalogUrl) {
                catalogLinkContainer.innerHTML = `<a href="${config.catalogUrl}" class="text-xs font-bold text-gold hover:underline flex items-center gap-1">${config.catalogText}</a>`;
            } else {
                catalogLinkContainer.innerHTML = '';
            }

            // Update Active Pill
            pills.forEach(p => {
                if (p.getAttribute('data-service-pill') === serviceTypeInput.value) {
                    p.className = 'service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center gap-1.5 bg-gold text-deepblack border-gold shadow-md font-extrabold';
                } else {
                    p.className = 'service-pill-btn whitespace-nowrap px-3.5 py-2 rounded-xl transition-all border flex items-center gap-1.5 bg-white/10 text-white border-white/20 hover:bg-white/20';
                }
            });

            // Reset forms and view
            form.classList.remove('hidden');
            successBox.classList.add('hidden');
            errorBox.classList.add('hidden');

            // Open modal
            modal.style.display = 'flex';
            document.body.classList.add('overflow-hidden');

            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 20);
        };

        window.closeServiceModal = function() {
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.classList.remove('overflow-hidden');
            }, 250);
        };

        // Event listeners for close
        closeBtn?.addEventListener('click', closeServiceModal);
        cancelBtn?.addEventListener('click', closeServiceModal);
        closeSuccessBtn?.addEventListener('click', closeServiceModal);
        modal?.addEventListener('click', (e) => {
            if (e.target === modal) closeServiceModal();
        });

        // Pill switches
        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                const s = pill.getAttribute('data-service-pill');
                openServiceModal(s);
            });
        });

        // Global triggers via data-service-modal attribute
        document.querySelectorAll('[data-service-modal]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const service = trigger.getAttribute('data-service-modal');
                openServiceModal(service);
            });
        });

        // Form Submission via Fetch AJAX
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorBox.classList.add('hidden');
            submitBtn.disabled = true;
            submitText.textContent = 'Processing...';
            submitSpinner.classList.remove('hidden');

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Track Lead Conversion event
                    if (typeof window.trackEvent === 'function') {
                        window.trackEvent('generate_lead', {
                            lead_type: 'vip_service_request',
                            service_type: data.service_type || 'service',
                            reference_no: data.reference_no || '',
                            currency: 'AED'
                        });
                    }

                    form.classList.add('hidden');
                    successBox.classList.remove('hidden');
                    document.getElementById('service-success-message').textContent = data.message;
                    document.getElementById('service-success-ref').textContent = `Reference: ${data.reference_no}`;
                    form.reset();
                } else {
                    let errMsg = data.message || 'An error occurred while submitting your request.';
                    if (data.errors) {
                        errMsg = Object.values(data.errors).flat().join('<br>');
                    }
                    errorBox.innerHTML = errMsg;
                    errorBox.classList.remove('hidden');
                }
            } catch (err) {
                errorBox.textContent = 'Network or server error. Please try again or reach out to our WhatsApp directly.';
                errorBox.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Request';
                submitSpinner.classList.add('hidden');
            }
        });
    });
</script>
