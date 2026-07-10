<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | Every frontend URL is prefixed with one of these locale codes
    | (e.g. /en, /ar, /ru). "dir" drives the <html dir=""> attribute so
    | Arabic renders right-to-left, exactly like the original static site.
    |
    */

    'supported' => [
        'en' => ['name' => 'English',  'native' => 'English',  'dir' => 'ltr'],
        'ar' => ['name' => 'Arabic',   'native' => 'العربية',  'dir' => 'rtl'],
        'ru' => ['name' => 'Russian',  'native' => 'Русский',  'dir' => 'ltr'],
    ],

    'default' => 'en',

];
