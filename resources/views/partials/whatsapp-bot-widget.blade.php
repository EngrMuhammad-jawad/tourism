<!-- Floating WhatsApp Concierge & Interactive Booking Bot Widget -->
@php
    $waPhone = \App\Models\Setting::get('contact.whatsapp', '+971 50 888 7766');
    $cleanWaPhone = preg_replace('/[^0-9]/', '', $waPhone);
    if (!str_starts_with($cleanWaPhone, '971') && strlen($cleanWaPhone) === 9) {
        $cleanWaPhone = '971' . $cleanWaPhone;
    }
    if (empty($cleanWaPhone)) {
        $cleanWaPhone = '971508887766';
    }
@endphp

<!-- WhatsApp Floating Button -->
<div id="wa-bot-widget-container" class="fixed bottom-6 right-6 z-[90] font-sans">
    <!-- Chat Launcher Button -->
    <button id="wa-bot-launcher" type="button" class="group relative flex items-center gap-2.5 rounded-full bg-[#25D366] text-white p-3.5 sm:px-5 sm:py-3.5 shadow-2xl hover:bg-[#20bd5a] transition-all duration-300 transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-[#25D366]/40" aria-label="Open WhatsApp Tour Assistant">
        <!-- WhatsApp Icon -->
        <svg class="w-7 h-7 sm:w-6 sm:h-6 fill-current" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-10.416c-5.503 0-9.972 4.471-9.97 9.974.001 1.76.46 3.48 1.332 5.002l-1.416 5.176 5.309-1.393c1.471.808 3.136 1.235 4.743 1.236h.004c5.502 0 9.971-4.471 9.97-9.974-.001-2.662-1.037-5.164-2.92-7.049-1.884-1.884-4.387-2.922-7.052-2.922z"/>
        </svg>
        <span class="hidden sm:inline font-bold text-sm tracking-wide">WhatsApp Tours Bot</span>
        
        <!-- Live Online Pulse Indicator -->
        <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-white border-2 border-[#25D366]"></span>
        </span>
    </button>

    <!-- WhatsApp Chatbot Dialog Window -->
    <div id="wa-bot-window" class="hidden absolute bottom-16 right-0 w-[92vw] sm:w-[420px] max-h-[85vh] h-[640px] bg-[#EFEAE2] rounded-3xl shadow-2xl border border-gray-200 overflow-hidden flex-col z-50 transition-all duration-300 transform scale-95 opacity-0" style="display: none;">
        
        <!-- WhatsApp Green Header -->
        <div class="bg-[#075E54] text-white p-3.5 sm:p-4 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-black text-amber-300 border border-white/30 text-lg">
                        D
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-[#25D366] border-2 border-[#075E54]"></span>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-bold text-sm text-white leading-tight">Dubai Tours Concierge</h3>
                        <span class="text-xs bg-[#25D366] text-white rounded-full px-1.5 py-0.2 text-[10px] font-bold">✓ Verified</span>
                    </div>
                    <p class="text-[11px] text-emerald-100">Typically replies instantly</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="wa-bot-reset" class="text-white/80 hover:text-white p-1 rounded hover:bg-white/10 text-xs font-semibold" title="Reset Bot to Main Menu">
                    Main Menu
                </button>
                <button type="button" id="wa-bot-close" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 focus:outline-none" aria-label="Close Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Chat Feed Area -->
        <div id="wa-bot-messages" class="flex-1 overflow-y-auto p-4 space-y-3.5 scrollbar-thin" style="background-image: radial-gradient(#d1d7db 1px, transparent 1px); background-size: 16px 16px;">
            <!-- Chat screen state will be dynamically rendered here -->
        </div>

        <!-- Chat Bottom Bar (Direct WhatsApp Link fallback) -->
        <div class="bg-[#F0F2F5] p-2.5 px-4 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
            <span>Powered by WhatsApp Business API</span>
            <a href="https://wa.me/{{ $cleanWaPhone }}" target="_blank" rel="noopener noreferrer" class="text-[#075E54] hover:underline font-bold flex items-center gap-1">
                Direct Chat ↗
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const launcher = document.getElementById('wa-bot-launcher');
        const botWindow = document.getElementById('wa-bot-window');
        const closeBtn = document.getElementById('wa-bot-close');
        const resetBtn = document.getElementById('wa-bot-reset');
        const feed = document.getElementById('wa-bot-messages');
        const waNumber = '{{ $cleanWaPhone }}';

        let chatState = 'main_menu';
        let tourDestination = 'dubai';

        function buildWaLink(message) {
            return `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
        }

        function toggleWindow(show) {
            if (show) {
                botWindow.style.display = 'flex';
                botWindow.classList.remove('hidden');
                botWindow.classList.add('flex');
                setTimeout(() => {
                    botWindow.classList.remove('scale-95', 'opacity-0');
                    botWindow.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                botWindow.classList.remove('scale-100', 'opacity-100');
                botWindow.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    botWindow.style.display = 'none';
                    botWindow.classList.add('hidden');
                    botWindow.classList.remove('flex');
                }, 200);
            }
        }

        launcher?.addEventListener('click', () => {
            const isClosed = botWindow.style.display === 'none' || botWindow.classList.contains('hidden');
            if (isClosed) {
                renderScreen(chatState);
                toggleWindow(true);
            } else {
                toggleWindow(false);
            }
        });

        closeBtn?.addEventListener('click', () => toggleWindow(false));
        resetBtn?.addEventListener('click', () => renderScreen('main_menu'));

        // Core Screen Render Engine
        function renderScreen(screen, params = {}) {
            chatState = screen;
            feed.innerHTML = '';

            if (screen === 'main_menu') {
                renderMainMenu();
            } else if (screen === 'flights') {
                renderFlightsForm();
            } else if (screen === 'transfer_taxi') {
                renderTransferTaxi();
            } else if (screen === 'food') {
                renderFood();
            } else if (screen === 'city_tours_destinations') {
                renderCityToursDestinations();
            } else if (screen === 'city_tour_details') {
                renderCityTourDetails(params.destination, params.type);
            } else if (screen === 'desert_safari') {
                renderDesertSafari();
            } else if (screen === 'desert_gallery') {
                renderDesertGallery();
            } else if (screen === 'desert_cars') {
                renderDesertCars();
            } else if (screen === 'desert_tours_overview') {
                renderDesertToursOverview();
            }

            feed.scrollTop = feed.scrollHeight;
        }

        // 1. MAIN MENU
        function renderMainMenu() {
            feed.innerHTML = `
                <!-- Bot Welcome Bubble -->
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[90%] text-sm text-gray-800 border border-gray-100">
                        <p class="font-bold text-gray-900 mb-1">Welcome to Dubai & UAE Tour Concierge!</p>
                        <p class="text-xs text-gray-600 mb-2">We provide luxury travel, desert safaris, city tours, private VIP transfers, and bespoke experiences.</p>
                        <p class="text-xs font-semibold text-[#075E54]">Please choose a service from the menu below:</p>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 ml-1">Just now</span>
                </div>

                <!-- Interactive Menu Buttons -->
                <div class="space-y-2 pt-2">
                    <button type="button" onclick="window.waBotNav('flights')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-sm flex items-center justify-between group">
                        <span class="text-gray-900 group-hover:text-[#075E54]">Flights</span>
                        <span class="text-gray-400 text-xs">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('transfer_taxi')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-sm flex items-center justify-between group">
                        <span class="text-gray-900 group-hover:text-[#075E54]">Transfer, Taxi</span>
                        <span class="text-gray-400 text-xs">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('food')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-sm flex items-center justify-between group">
                        <span class="text-gray-900 group-hover:text-[#075E54]">Food</span>
                        <span class="text-gray-400 text-xs">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('city_tours_destinations')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-sm flex items-center justify-between group">
                        <span class="text-gray-900 group-hover:text-[#075E54]">City Tours</span>
                        <span class="text-gray-400 text-xs">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('desert_safari')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-sm flex items-center justify-between group">
                        <span class="text-gray-900 group-hover:text-[#075E54]">Desert Safari</span>
                        <span class="text-gray-400 text-xs">›</span>
                    </button>
                </div>
            `;
        }

        // 2. FLIGHTS FLOW
        function renderFlightsForm() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[95%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Flight Booking & Inquiries</p>
                        <p class="text-gray-600 mb-3">Please fill out your flight preferences below or speak directly with our ticketing agent on WhatsApp:</p>

                        <form id="wa-flight-form" class="space-y-2">
                            <div>
                                <label class="block font-bold text-gray-700 text-[11px] mb-0.5">From</label>
                                <input type="text" id="fl-from" required placeholder="e.g. London, Riyadh, Moscow" class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-gray-700 text-[11px] mb-0.5">To</label>
                                <input type="text" id="fl-to" required value="Dubai (DXB)" class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block font-bold text-gray-700 text-[11px] mb-0.5">Departure date</label>
                                    <input type="date" id="fl-dep" required class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 text-[11px] mb-0.5">Arrival date</label>
                                    <input type="date" id="fl-ret" class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block font-bold text-gray-700 text-[11px] mb-0.5">Number of passengers</label>
                                    <input type="number" id="fl-pass" min="1" max="50" value="1" required class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 text-[11px] mb-0.5">Your WhatsApp</label>
                                    <input type="tel" id="fl-wa" required placeholder="+971 50..." class="w-full p-2 text-xs rounded-xl border border-gray-300 focus:border-[#25D366] outline-none">
                                </div>
                            </div>

                            <div class="pt-2 space-y-2">
                                <!-- Action 1: Send a request -->
                                <button type="submit" id="fl-submit-btn" class="w-full bg-[#075E54] hover:bg-[#054c44] text-white font-bold py-2.5 rounded-xl text-xs transition shadow flex items-center justify-center">
                                    Send a request
                                </button>

                                <!-- Action 2: Ask about flights in WhatsApp -->
                                <a id="fl-direct-wa" href="${buildWaLink('Hello! I would like to inquire about flights.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold py-2.5 rounded-xl text-xs transition shadow flex items-center justify-center">
                                    Ask about flights in WhatsApp
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Main Menu
                    </button>
                </div>
            `;

            // Setup form submission
            const form = document.getElementById('wa-flight-form');
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const from = document.getElementById('fl-from').value;
                const to = document.getElementById('fl-to').value;
                const dep = document.getElementById('fl-dep').value;
                const ret = document.getElementById('fl-ret').value;
                const pass = document.getElementById('fl-pass').value;
                const wa = document.getElementById('fl-wa').value;

                const submitBtn = document.getElementById('fl-submit-btn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';

                try {
                    const res = await fetch('{{ route("service-requests.store", ["locale" => app()->getLocale()]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            service_type: 'flights',
                            name: 'Flight Inquirer (' + wa + ')',
                            email: 'guest.' + Date.now() + '@dubaitourbook.com',
                            phone: wa,
                            pickup_location: from,
                            dropoff_location: to,
                            service_date: dep || null,
                            return_date: ret || null,
                            guests_count: pass || 1,
                            notes: `Flight inquiry from ${from} to ${to}, ${pass} passengers, Contact: ${wa}`
                        })
                    });
                    const data = await res.json();
                    feed.innerHTML += `
                        <div class="flex flex-col items-start pt-2">
                            <div class="bg-emerald-50 border border-emerald-300 rounded-2xl rounded-tl-sm p-3 text-xs text-emerald-800 shadow-sm max-w-[90%]">
                                <p class="font-bold">✓ Flight Request Received!</p>
                                <p class="mt-0.5">Reference: <strong>${data.reference_no || 'CONFIRMED'}</strong></p>
                                <p class="mt-1 text-[11px] text-emerald-700">Our ticketing specialist will review options and contact you on WhatsApp shortly.</p>
                            </div>
                        </div>
                    `;
                    submitBtn.textContent = 'Request Sent!';
                } catch(err) {
                    // Fallback to direct WhatsApp
                    window.open(buildWaLink(`Hello! I would like to inquire about flights from ${from} to ${to}, Departure: ${dep}, Passengers: ${pass}. WhatsApp: ${wa}`), '_blank');
                }
            });
        }

        // 3. TRANSFER, TAXI
        function renderTransferTaxi() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm max-w-[90%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Transfer & VIP Taxi Service</p>
                        <p class="text-gray-600 mb-3 leading-relaxed">
                            Airport meet & greet, hotel pickups, intercity private luxury cars, and 24/7 transfers across Dubai, Abu Dhabi, Sharjah, and all Emirates.
                        </p>
                        
                        <a href="${buildWaLink('Hello! I would like to book a transfer or taxi in the UAE.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-3 rounded-xl text-xs transition shadow-md flex items-center justify-center">
                            Book transfer or taxi
                        </a>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 ml-1">Just now</span>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Main Menu
                    </button>
                </div>
            `;
        }

        // 4. FOOD
        function renderFood() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm max-w-[90%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Food & Dining Reservations</p>
                        <p class="text-gray-600 mb-3 leading-relaxed">
                            VIP tables at Burj Khalifa At.mosphere, Michelin-star restaurants, luxury Dubai Marina Dhow dinner cruises, and private dining arrangements.
                        </p>

                        <a href="${buildWaLink('Hello! I would like to order food / reserve dining in the UAE.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-3 rounded-xl text-xs transition shadow-md flex items-center justify-center">
                            Order food
                        </a>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 ml-1">Just now</span>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Main Menu
                    </button>
                </div>
            `;
        }

        // 5. CITY TOURS: DESTINATIONS
        function renderCityToursDestinations() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[90%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Select City Tour Destination</p>
                        <p class="text-gray-600">Please choose the destination you want to explore:</p>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <button type="button" onclick="window.waSelectDestination('dubai')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span>Dubai</span>
                        <span class="text-gray-400">›</span>
                    </button>
                    <button type="button" onclick="window.waSelectDestination('abu_dhabi')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span>Abu Dhabi</span>
                        <span class="text-gray-400">›</span>
                    </button>
                    <button type="button" onclick="window.waSelectDestination('fujairah')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span>Fujairah & Ras Al Khaimah with Um Al Quwain</span>
                        <span class="text-gray-400">›</span>
                    </button>
                    <button type="button" onclick="window.waSelectDestination('sharjah')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span>Sharjah & Ajman</span>
                        <span class="text-gray-400">›</span>
                    </button>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Main Menu
                    </button>
                </div>
            `;
        }

        window.waSelectDestination = function(dest) {
            tourDestination = dest;
            const destNames = {
                dubai: 'Dubai',
                abu_dhabi: 'Abu Dhabi',
                fujairah: 'Fujairah & Ras Al Khaimah with Um Al Quwain',
                sharjah: 'Sharjah & Ajman'
            };

            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[90%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">${destNames[dest]} City Tour</p>
                        <p class="text-gray-600">Please choose your preferred tour style:</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2.5 pt-2">
                    <button type="button" onclick="window.waBotTourType('${dest}', 'sharing')" class="bg-white hover:bg-[#F0F2F5] p-3.5 rounded-2xl shadow-sm border border-gray-200 text-center font-bold text-xs text-gray-900 transition">
                        Sharing
                    </button>
                    <button type="button" onclick="window.waBotTourType('${dest}', 'private')" class="bg-white hover:bg-[#F0F2F5] p-3.5 rounded-2xl shadow-sm border border-gray-200 text-center font-bold text-xs text-gray-900 transition">
                        Private car
                    </button>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('city_tours_destinations')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Choose Another Destination
                    </button>
                </div>
            `;
        };

        window.waBotTourType = function(dest, type) {
            renderCityTourDetails(dest, type);
        };

        // RENDER EXACT COMBINATIONS WITH T&C, PRICES, AND PREFILLED BUTTONS
        function renderCityTourDetails(dest, type) {
            let tcHtml = '';
            let priceHtml = '';
            let btnLabel = '';
            let autoMsg = '';
            let title = '';

            if (dest === 'dubai' && type === 'sharing') {
                title = 'Dubai — Sharing City Tour';
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions for sharing city tour in Dubai</p>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-gray-700 leading-normal">
                        <li>Sharing Dubai city tour is available only from Dubai, Sharjah & Ajman</li>
                        <li>We will pick you up from your hotel or any location which you will send us</li>
                        <li>We will provide water & some local style snacks during tour</li>
                        <li>Payment is after tour only</li>
                        <li>You can pay by card or cash in any currency but according to currency exchange rates</li>
                    </ol>
                `;
                priceHtml = `
                    <div class="my-3 py-2 px-3 bg-amber-50 rounded-xl border border-amber-200 text-center">
                        <span class="text-xs text-gray-500 uppercase tracking-wide block">Prominent Tour Price</span>
                        <span class="text-2xl font-black text-amber-700">55 AED</span>
                    </div>
                `;
                btnLabel = 'BOOK SHARING TOUR';
                autoMsg = 'Hello! I am interested in sharing tour in Dubai';
            } else if (dest === 'dubai' && type === 'private') {
                title = 'Dubai — Private Car City Tour';
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions for private city tour in Dubai</p>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-gray-700 leading-normal">
                        <li>Guests can choose any from available private cars for Dubai city tours, price will depend from the model of the car</li>
                        <li>We will pick you up from your hotel or any location which you will send us</li>
                        <li>We will provide water & some local style snacks during tour</li>
                        <li>Payment is after tour only</li>
                        <li>You can pay by card or cash in any currency but according to currency exchange rates</li>
                        <li>We can provide long dresses or other kinds of requisite for photos & videos without additional charges</li>
                    </ol>
                `;
                priceHtml = `
                    <div class="my-3 py-2 px-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                        <span class="text-xs text-gray-500 block">Price depends from the model of the car</span>
                    </div>
                `;
                btnLabel = 'BOOK PRIVATE TOUR IN DUBAI';
                autoMsg = 'Hello! I am interested in private tour in Dubai';
            } else if (dest === 'abu_dhabi' && type === 'sharing') {
                title = 'Abu Dhabi — Sharing City Tour';
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions for sharing city tour in Abu Dhabi</p>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-gray-700 leading-normal">
                        <li>Sharing Abu Dhabi city tour is available only from Dubai, Abu Dhabi, Sharjah & Ajman</li>
                        <li>We will pick you up from your hotel or any location which you will send us</li>
                        <li>We will provide water & some local style snacks during tour</li>
                        <li>Payment is after tour only</li>
                        <li>You can pay by card or cash in any currency but according to currency exchange rates</li>
                        <li>Abu Dhabi city tour includes visiting Grand Mosque, men are kindly requested not to wear shorts (only trousers & any kind of shirt or t-shirt), and women are kindly requested to cover their hair & wear the modest, opaque dresses which are loose-fitting & provides full coverage</li>
                    </ol>
                `;
                priceHtml = `
                    <div class="my-3 py-2 px-3 bg-amber-50 rounded-xl border border-amber-200 text-center">
                        <span class="text-xs text-gray-500 uppercase tracking-wide block">Prominent Tour Price</span>
                        <span class="text-2xl font-black text-amber-700">70 AED</span>
                    </div>
                `;
                btnLabel = 'BOOK SHARING TOUR';
                autoMsg = 'Hello! I am interested in sharing tour in Abu Dhabi';
            } else if (dest === 'abu_dhabi' && type === 'private') {
                title = 'Abu Dhabi — Private Car City Tour';
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions for private city tour in Abu Dhabi</p>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-gray-700 leading-normal">
                        <li>Guests can choose any from available private cars for Abu Dhabi city tours, price will depend from the model of the car</li>
                        <li>We will pick you up from your hotel or any location which you will send us</li>
                        <li>We will provide water & some local style snacks during tour</li>
                        <li>Payment is after tour only</li>
                        <li>You can pay by card or cash in any currency but according to currency exchange rates</li>
                        <li>We can provide long dresses, abayas, or other kinds of requisite for photos & videos without additional charges</li>
                        <li>Abu Dhabi city tour includes visiting Grand Mosque, men are kindly requested not to wear shorts (only trousers & any kind of shirt or t-shirt), and women are kindly requested to cover their hair & wear the modest, opaque dresses which are loose-fitting & provides full coverage</li>
                    </ol>
                `;
                priceHtml = `
                    <div class="my-3 py-2 px-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                        <span class="text-xs text-gray-500 block">Price depends from the model of the car</span>
                    </div>
                `;
                btnLabel = 'BOOK PRIVATE TOUR IN ABU DHABI';
                autoMsg = 'Hello! I am interested in private tour in Abu Dhabi';
            } else if (dest === 'fujairah') {
                title = `Fujairah & RAK with UAQ (${type === 'sharing' ? 'Sharing' : 'Private Car'})`;
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions</p>
                    <p class="text-[11px] text-gray-700">Pick up from your hotel/residence. Water and snacks provided during the tour. Payment after tour only by cash or card.</p>
                `;
                btnLabel = type === 'sharing' ? 'BOOK SHARING TOUR' : 'BOOK PRIVATE TOUR';
                autoMsg = `Hello! I am interested in ${type} tour in Fujairah, Ras Al Khaimah & Um Al Quwain`;
            } else {
                title = `Sharjah & Ajman (${type === 'sharing' ? 'Sharing' : 'Private Car'})`;
                tcHtml = `
                    <p class="font-bold text-xs text-gray-900 mb-1.5">Terms & Conditions</p>
                    <p class="text-[11px] text-gray-700">Pick up from your hotel/residence. Water and snacks provided during the tour. Payment after tour only by cash or card.</p>
                `;
                btnLabel = type === 'sharing' ? 'BOOK SHARING TOUR' : 'BOOK PRIVATE TOUR';
                autoMsg = `Hello! I am interested in ${type} tour in Sharjah & Ajman`;
            }

            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm max-w-[95%] text-xs text-gray-800 border border-gray-100">
                        <h4 class="font-bold text-sm text-[#075E54] mb-2">${title}</h4>
                        
                        ${tcHtml}

                        <div class="my-2.5 p-2.5 bg-yellow-50/90 rounded-xl border border-yellow-200 text-xs text-yellow-950 font-medium italic">
                            "Programs for tour are always discussed in WhatsApp chat"
                        </div>

                        ${priceHtml}

                        <a href="${buildWaLink(autoMsg)}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-3 rounded-xl text-xs transition shadow-md mt-3 flex items-center justify-center">
                            ${btnLabel}
                        </a>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <button type="button" onclick="window.waSelectDestination('${dest}')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Tour Style
                    </button>
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        Main Menu
                    </button>
                </div>
            `;
        }

        // 6. DESERT SAFARI
        function renderDesertSafari() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[90%] text-xs text-gray-800 border border-gray-100">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Desert Safari & Adventures</p>
                        <p class="text-gray-600 mb-2">Explore high red dune bashing, VIP Bedouin camps, camel trekking, quad buggies, and sunset dinners.</p>
                        <p class="font-semibold text-gray-800">Please choose an option below:</p>
                    </div>
                </div>

                <!-- 3 Primary Buttons -->
                <div class="space-y-2 pt-2">
                    <button type="button" onclick="window.waBotNav('desert_gallery')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span class="text-gray-900">Photo & video desert gallery</span>
                        <span class="text-gray-400">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('desert_cars')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span class="text-gray-900">Cars for desert adventure</span>
                        <span class="text-gray-400">›</span>
                    </button>

                    <button type="button" onclick="window.waBotNav('desert_tours_overview')" class="w-full bg-white hover:bg-[#F0F2F5] text-left p-3.5 rounded-2xl shadow-sm border border-gray-200 transition-all font-semibold text-xs flex items-center justify-between">
                        <span class="text-gray-900">Desert tours</span>
                        <span class="text-gray-400">›</span>
                    </button>
                </div>

                <!-- Secondary Button: Book desert safari -->
                <div class="pt-3 border-t border-gray-300/60 mt-3">
                    <a href="${buildWaLink('Hello! I would like to book a desert safari adventure.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-3 rounded-xl text-xs transition shadow-md flex items-center justify-center">
                        Book desert safari
                    </a>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Main Menu
                    </button>
                </div>
            `;
        }

        // Desert Gallery with Photos
        function renderDesertGallery() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3 shadow-sm max-w-[95%] text-xs text-gray-800 border border-gray-100 mb-2">
                        <p class="font-bold text-sm text-[#075E54]">Photo & Video Desert Gallery</p>
                        <p class="text-gray-600 text-[11px]">Real captures of our VIP desert safari experiences:</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 w-full">
                        <div class="rounded-xl overflow-hidden shadow-sm bg-white border border-gray-200">
                            <img src="/assets/images/hero.jpg" alt="Sunset Desert Safari" class="w-full h-24 object-cover">
                            <p class="p-1.5 text-[10px] font-bold text-gray-700">Red Dune Sunset</p>
                        </div>
                        <div class="rounded-xl overflow-hidden shadow-sm bg-white border border-gray-200">
                            <img src="/assets/images/tour_jais.jpg" alt="Desert Mountain Safari" class="w-full h-24 object-cover">
                            <p class="p-1.5 text-[10px] font-bold text-gray-700">Desert Mountains</p>
                        </div>
                        <div class="rounded-xl overflow-hidden shadow-sm bg-white border border-gray-200">
                            <img src="/assets/images/transport_buggy.jpg" alt="Dune Buggy Safari" class="w-full h-24 object-cover">
                            <p class="p-1.5 text-[10px] font-bold text-gray-700">Can-Am Buggy</p>
                        </div>
                        <div class="rounded-xl overflow-hidden shadow-sm bg-white border border-gray-200">
                            <img src="/assets/images/transport_cruiser.jpg" alt="4x4 Dune Bashing" class="w-full h-24 object-cover">
                            <p class="p-1.5 text-[10px] font-bold text-gray-700">Land Cruiser 4x4</p>
                        </div>
                    </div>

                    <div class="w-full mt-3">
                        <a href="${buildWaLink('Hello! I viewed the desert gallery and would like to book a desert safari.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-2.5 rounded-xl text-xs transition shadow flex items-center justify-center">
                            Book desert safari
                        </a>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <button type="button" onclick="window.waBotNav('desert_safari')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Desert Safari
                    </button>
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        Main Menu
                    </button>
                </div>
            `;
        }

        // Desert Cars Fleet with Photos
        function renderDesertCars() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3 shadow-sm max-w-[95%] text-xs text-gray-800 border border-gray-100 mb-2">
                        <p class="font-bold text-sm text-[#075E54]">Cars for Desert Adventure</p>
                        <p class="text-gray-600 text-[11px]">Choose from our high-power 4x4 fleet:</p>
                    </div>

                    <div class="space-y-2 w-full">
                        <div class="flex items-center gap-2.5 bg-white p-2 rounded-xl border border-gray-200 shadow-sm">
                            <img src="/assets/images/transport_cruiser.jpg" alt="Toyota Land Cruiser" class="w-16 h-12 rounded-lg object-cover">
                            <div class="flex-1">
                                <p class="font-bold text-xs text-gray-900">Toyota Land Cruiser V8</p>
                                <p class="text-[10px] text-gray-500">Roll-caged & specialized for high dune bashing</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 bg-white p-2 rounded-xl border border-gray-200 shadow-sm">
                            <img src="/assets/images/transport_buggy.jpg" alt="Can-Am Maverick Buggy" class="w-16 h-12 rounded-lg object-cover">
                            <div class="flex-1">
                                <p class="font-bold text-xs text-gray-900">Can-Am Maverick 1000cc</p>
                                <p class="text-[10px] text-gray-500">Self-drive turbo dune buggy adventure</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 bg-white p-2 rounded-xl border border-gray-200 shadow-sm">
                            <img src="/assets/images/transport_van.jpg" alt="VIP Family Van" class="w-16 h-12 rounded-lg object-cover">
                            <div class="flex-1">
                                <p class="font-bold text-xs text-gray-900">Mercedes V-Class VIP Van</p>
                                <p class="text-[10px] text-gray-500">Hotel transfer to desert camp</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-3">
                        <a href="${buildWaLink('Hello! I would like to book a desert car adventure / dune buggy.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-2.5 rounded-xl text-xs transition shadow flex items-center justify-center">
                            Book desert safari
                        </a>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <button type="button" onclick="window.waBotNav('desert_safari')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Desert Safari
                    </button>
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        Main Menu
                    </button>
                </div>
            `;
        }

        // Desert Tours Overview
        function renderDesertToursOverview() {
            feed.innerHTML = `
                <div class="flex flex-col items-start">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-3.5 shadow-sm max-w-[95%] text-xs text-gray-800 border border-gray-100 mb-2">
                        <p class="font-bold text-sm text-[#075E54] mb-1">Available Desert Tours</p>
                        <ul class="space-y-2 text-[11px] text-gray-700">
                            <li>• <strong>Evening VIP Red Dune Safari:</strong> Dune bashing, camel ride, BBQ buffet dinner, fire & Tanoura show.</li>
                            <li>• <strong>Morning Desert Safari:</strong> Sunrise dune bashing, sandboarding & camel farm visit.</li>
                            <li>• <strong>Private Royal Majlis Safari:</strong> Exclusive private tent with waiter service.</li>
                            <li>• <strong>Overnight Stargazing Camp:</strong> Sleep in desert glamping tent with breakfast.</li>
                        </ul>
                    </div>

                    <div class="w-full mt-2">
                        <a href="${buildWaLink('Hello! I would like to book a desert safari tour.')}" target="_blank" rel="noopener noreferrer" class="w-full block text-center bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold py-3 rounded-xl text-xs transition shadow flex items-center justify-center">
                            Book desert safari
                        </a>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <button type="button" onclick="window.waBotNav('desert_safari')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        ← Back to Desert Safari
                    </button>
                    <button type="button" onclick="window.waBotNav('main_menu')" class="text-xs text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        Main Menu
                    </button>
                </div>
            `;
        }

        // Global Navigation Helper
        window.waBotNav = function(screen, params) {
            renderScreen(screen, params);
        };

        // Open bot window directly from any menu button or external link
        window.openWhatsAppBotScreen = function(screen, params) {
            renderScreen(screen || 'main_menu', params || {});
            toggleWindow(true);
        };
    });
</script>
