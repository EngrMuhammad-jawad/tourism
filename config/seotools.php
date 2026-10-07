<?php

/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Dubai Tour Book',
            'titleBefore'  => false,
            'description'  => 'Discover luxury Dubai tours, VIP desert safaris, private yacht charters, Burj Khalifa tickets, and 7-star holiday packages in the UAE.',
            'separator'    => ' | ',
            'keywords'     => [
                'Dubai tours',
                'luxury Dubai travel',
                'desert safari Dubai',
                'Burj Khalifa tickets',
                'Dubai yacht rental',
                'UAE holiday packages',
                'GCC family holidays',
            ],
            'canonical'    => 'current',
            'robots'       => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
        ],
        /*
         * Webmaster tags are always added if present.
         */
        'webmaster_tags' => [
            'google'    => env('GOOGLE_SITE_VERIFICATION', null),
            'bing'      => env('BING_SITE_VERIFICATION', null),
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => env('YANDEX_VERIFICATION', null),
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Dubai Tour Book | Luxury Tours, Desert Safaris & VIP Experiences',
            'description' => 'Discover luxury Dubai tours, VIP desert safaris, private yacht charters, Burj Khalifa tickets, and 7-star holiday packages in the UAE.',
            'url'         => null, // Uses Url::current()
            'type'        => 'website',
            'site_name'   => 'Dubai Tour Book',
            'images'      => ['/assets/images/hero.jpg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
            'site'        => '@dubaitourbook',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Dubai Tour Book',
            'description' => 'Luxury Tours, Desert Safaris & VIP Experiences in Dubai and the UAE.',
            'url'         => null,
            'type'        => 'WebSite',
            'images'      => ['/assets/images/hero.jpg'],
        ],
    ],
];
