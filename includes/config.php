<?php
/**
 * Base path helper for running the same code in:
 * - localhost subfolder:   http://localhost/DOG/...
 * - production root:       https://example.com/...
 */

// Calculate BASE_PATH from web path
// Use SCRIPT_NAME which should be the web path (e.g., /DOG/contact_us.php)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '';

// Normalize path separators
$scriptName = str_replace('\\', '/', $scriptName);

// Remove document root if it's accidentally included (some server configs include full path)
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
if ($documentRoot && strpos($scriptName, $documentRoot) === 0) {
    // Extract web path from filesystem path
    $scriptName = substr($scriptName, strlen($documentRoot));
}

// Also check REQUEST_URI as fallback if SCRIPT_NAME looks wrong
// REQUEST_URI is always the web path
if (empty($scriptName) || strpos($scriptName, '/opt/') === 0 || strpos($scriptName, 'C:\\') === 0 || strpos($scriptName, 'D:\\') === 0) {
    // SCRIPT_NAME seems to be filesystem path, use REQUEST_URI instead
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    if ($requestUri) {
        // Remove query string
        $requestUri = strtok($requestUri, '?');
        // Get the directory part
        $scriptName = dirname($requestUri);
        if ($scriptName === '.' || $scriptName === '/') {
            $scriptName = '';
        }
    }
}

// Get directory path and clean it up
$BASE_PATH = rtrim(dirname($scriptName), '/');
if ($BASE_PATH === '' || $BASE_PATH === '.' || $BASE_PATH === '/') {
    $BASE_PATH = '';
}

/**
 * Build a site URL path that automatically prefixes the deployment folder (if any).
 * Examples:
 * - url_path('css/style.css') => '/DOG/css/style.css' or '/css/style.css'
 * - url_path('index#destinations') => '/DOG/index#destinations' or '/index#destinations'
 * - url_path('') => '/DOG/' or '/'
 */
function url_path(string $path = ''): string
{
    global $BASE_PATH;

    $base = ($BASE_PATH === '') ? '' : $BASE_PATH;

    if ($path === '') {
        return ($base === '') ? '/' : ($base . '/');
    }

    // Keep query/hash working as expected
    if ($path[0] === '#' || $path[0] === '?') {
        return (($base === '') ? '/' : ($base . '/')) . $path;
    }

    return $base . '/' . ltrim($path, '/');
}


