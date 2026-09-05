<?php
/**
 * Image Helper Functions
 * Provides WebP support with fallback to original format
 */

/**
 * Get the best image source (WebP with fallback)
 * Returns an array with 'webp' and 'fallback' keys for use in <picture> tag
 * 
 * @param string $image_path Relative path to image (e.g., 'assets/images/logo.png')
 * @return array|string Returns array with webp and fallback, or original path if WebP not available
 */
function get_webp_image($image_path) {
    // Remove leading slash if present
    $image_path = ltrim($image_path, '/');
    
    // Get full path
    $full_path = __DIR__ . '/../' . $image_path;
    $webp_path = $full_path . '.webp';
    
    // Check if WebP version exists
    if (file_exists($webp_path)) {
        $path_info = pathinfo($image_path);
        $webp_url = $path_info['dirname'] . '/' . $path_info['basename'] . '.webp';
        
        return [
            'webp' => url_path($webp_url),
            'fallback' => url_path($image_path),
            'type' => mime_content_type($full_path)
        ];
    }
    
    // Return original if WebP doesn't exist
    return [
        'webp' => null,
        'fallback' => url_path($image_path),
        'type' => mime_content_type($full_path)
    ];
}

/**
 * Generate <picture> tag with WebP support and fallback
 * 
 * @param string $image_path Relative path to image
 * @param string $alt Alt text
 * @param string $class CSS class
 * @param string $loading Loading attribute (lazy/eager)
 * @param string $fetchpriority Fetch priority (high/low/auto)
 * @return string HTML <picture> tag
 */
function picture_webp($image_path, $alt = '', $class = '', $loading = 'lazy', $fetchpriority = '') {
    $sources = get_webp_image($image_path);
    
    $class_attr = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
    $loading_attr = $loading ? ' loading="' . htmlspecialchars($loading) . '"' : '';
    $fetchpriority_attr = $fetchpriority ? ' fetchpriority="' . htmlspecialchars($fetchpriority) . '"' : '';
    
    $html = '<picture>';
    
    // Add WebP source if available
    if ($sources['webp']) {
        $html .= '<source srcset="' . htmlspecialchars($sources['webp']) . '" type="image/webp">';
    }
    
    // Add fallback image
    $html .= '<img src="' . htmlspecialchars($sources['fallback']) . '" alt="' . htmlspecialchars($alt) . '"' . $class_attr . $loading_attr . $fetchpriority_attr . '>';
    
    $html .= '</picture>';
    
    return $html;
}

/**
 * Generate <img> tag that automatically uses WebP if available
 * Simpler version - just returns img tag, browser will handle WebP if available via .htaccess
 * 
 * @param string $image_path Relative path to image
 * @param string $alt Alt text
 * @param string $class CSS class
 * @param string $loading Loading attribute
 * @param string $fetchpriority Fetch priority
 * @return string HTML <img> tag
 */
function img_webp($image_path, $alt = '', $class = '', $loading = 'lazy', $fetchpriority = '') {
    $sources = get_webp_image($image_path);
    
    // Use WebP if available, otherwise fallback
    $src = $sources['webp'] ? $sources['webp'] : $sources['fallback'];
    
    $class_attr = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
    $loading_attr = $loading ? ' loading="' . htmlspecialchars($loading) . '"' : '';
    $fetchpriority_attr = $fetchpriority ? ' fetchpriority="' . htmlspecialchars($fetchpriority) . '"' : '';
    
    return '<img src="' . htmlspecialchars($src) . '" alt="' . htmlspecialchars($alt) . '"' . $class_attr . $loading_attr . $fetchpriority_attr . '>';
}

/**
 * Get WebP image path if available, otherwise return original
 * Simple helper to get the best image path
 * 
 * @param string $image_path Relative path to image
 * @return string Path to WebP if available, otherwise original path
 */
function get_image_path($image_path) {
    // Remove leading slash if present
    $image_path = ltrim($image_path, '/');
    
    // Get full path
    $full_path = __DIR__ . '/../' . $image_path;
    $webp_path = $full_path . '.webp';
    
    // Check if WebP version exists
    if (file_exists($webp_path)) {
        $path_info = pathinfo($image_path);
        $webp_url = $path_info['dirname'] . '/' . $path_info['basename'] . '.webp';
        return url_path($webp_url);
    }
    
    // Return original path
    return url_path($image_path);
}

