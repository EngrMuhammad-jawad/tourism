<!-- Global Tracking & Analytics Layer (GTM / GA4 / Meta / Google Ads) -->
<script>
    window.dataLayer = window.dataLayer || [];

    /**
     * Helper to push structured conversion and engagement events to Google Tag Manager
     * @param {string} eventName
     * @param {object} eventParams
     */
    window.trackEvent = function(eventName, eventParams) {
        eventParams = eventParams || {};
        const payload = Object.assign({ event: eventName }, eventParams);
        window.dataLayer.push(payload);

        // Safe console output in local development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.log('%c[Tracking Event] ' + eventName, 'color: #D4AF37; font-weight: bold;', payload);
        }
    };

    // Auto-capture Phone calls & WhatsApp clicks across the entire site
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('click', function (e) {
            const anchor = e.target.closest('a');
            if (anchor) {
                const href = anchor.getAttribute('href') || '';

                // WhatsApp Clicks
                if (href.includes('wa.me') || href.includes('api.whatsapp.com') || anchor.hasAttribute('data-whatsapp-track')) {
                    window.trackEvent('contact_click', {
                        channel: 'whatsapp',
                        link_url: href,
                        click_text: (anchor.innerText || '').trim().substring(0, 60),
                        location: anchor.getAttribute('data-track-location') || 'page_content'
                    });
                }

                // Phone Call Clicks
                if (href.startsWith('tel:')) {
                    window.trackEvent('contact_click', {
                        channel: 'phone',
                        phone_number: href.replace('tel:', ''),
                        location: anchor.getAttribute('data-track-location') || 'header_or_contact'
                    });
                }
            }

            // Interactive WhatsApp Bot launcher click
            const botLauncher = e.target.closest('#wa-bot-launcher');
            if (botLauncher) {
                window.trackEvent('contact_click', {
                    channel: 'whatsapp_bot',
                    location: 'floating_widget'
                });
            }
        });
    });
</script>

{{-- Server-Dispatched Session Events (e.g., Form Redirects, Bookings, Submissions) --}}
@if(session('tracking_event'))
    @php
        $sessionEvent = session('tracking_event');
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.trackEvent === 'function') {
                @if(isset($sessionEvent['event']))
                    window.trackEvent('{{ $sessionEvent['event'] }}', {!! json_encode(array_diff_key($sessionEvent, ['event' => true])) !!});
                @else
                    window.dataLayer.push({!! json_encode($sessionEvent) !!});
                @endif
            }
        });
    </script>
@endif
