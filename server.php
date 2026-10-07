<?php

/**
 * Laravel - Shared Hosting Entry Point
 *
 * Emulates mod_rewrite from the project root, strips /index.php
 * from all URL generators, and routes traffic safely into public/.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'
);

// If URL has /index.php, permanently redirect (301) to clean URL
if (str_starts_with($uri, '/index.php')) {
    $cleanUri = preg_replace('#^/index\.php#i', '', $uri);
    $cleanUri = ($cleanUri !== '' && $cleanUri !== '/') ? $cleanUri : '/en';
    $queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: ' . $cleanUri . $queryString, true, 301);
    exit;
}


// Strip index.php from SCRIPT_NAME and PHP_SELF so Laravel's route() & url() never generate /index.php
if (isset($_SERVER['SCRIPT_NAME']) && str_ends_with($_SERVER['SCRIPT_NAME'], 'index.php')) {
    $_SERVER['SCRIPT_NAME'] = preg_replace('#/index\.php$#i', '', $_SERVER['SCRIPT_NAME']) ?: '';
}
if (isset($_SERVER['PHP_SELF']) && str_ends_with($_SERVER['PHP_SELF'], 'index.php')) {
    $_SERVER['PHP_SELF'] = preg_replace('#/index\.php$#i', '', $_SERVER['PHP_SELF']) ?: '';
}

// Serve existing static files from public/ directly if they exist
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
