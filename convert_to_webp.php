<?php
/**
 * Image to WebP Converter Script
 * Converts all JPG, JPEG, and PNG images to WebP format
 * 
 * Usage: Run this script once via browser or CLI: php convert_to_webp.php
 */

// Check if GD library supports WebP
if (!function_exists('imagewebp')) {
    die("Error: WebP support is not available in your PHP installation. Please enable GD library with WebP support.\n");
}

// Configuration
$base_dir = __DIR__;
$image_extensions = ['jpg', 'jpeg', 'png'];
$quality = 85; // WebP quality (0-100, 85 is a good balance)
$min_size_kb = 50; // Only convert images larger than 50KB

// Statistics
$converted = 0;
$skipped = 0;
$errors = 0;
$total_size_saved = 0;

/**
 * Convert image to WebP
 */
function convertToWebP($source, $destination, $quality) {
    $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
    
    // Create image resource based on file type
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'png':
            $image = imagecreatefrompng($source);
            // Preserve transparency for PNG
            imagealphablending($image, false);
            imagesavealpha($image, true);
            break;
        default:
            return false;
    }
    
    if (!$image) {
        return false;
    }
    
    // Convert to WebP
    $result = imagewebp($image, $destination, $quality);
    imagedestroy($image);
    
    return $result;
}

/**
 * Recursively find and convert images
 */
function processDirectory($dir, $base_dir, $quality, $min_size_kb, &$converted, &$skipped, &$errors, &$total_size_saved) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $filepath = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($filepath)) {
            // Recursively process subdirectories
            processDirectory($filepath, $base_dir, $quality, $min_size_kb, $converted, $skipped, $errors, $total_size_saved);
        } else {
            // Check if it's an image file
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $file_size_kb = filesize($filepath) / 1024;
                
                // Skip if file is too small
                if ($file_size_kb < $min_size_kb) {
                    $skipped++;
                    continue;
                }
                
                // Check if WebP already exists
                $webp_path = $filepath . '.webp';
                if (file_exists($webp_path)) {
                    $skipped++;
                    echo "Skipped (WebP exists): " . str_replace($base_dir . DIRECTORY_SEPARATOR, '', $filepath) . "\n";
                    continue;
                }
                
                // Convert to WebP
                echo "Converting: " . str_replace($base_dir . DIRECTORY_SEPARATOR, '', $filepath) . " (" . round($file_size_kb, 2) . " KB)... ";
                
                if (convertToWebP($filepath, $webp_path, $quality)) {
                    $original_size = filesize($filepath);
                    $webp_size = filesize($webp_path);
                    $saved = $original_size - $webp_size;
                    $saved_percent = round(($saved / $original_size) * 100, 1);
                    
                    $total_size_saved += $saved;
                    $converted++;
                    
                    echo "✓ Saved " . round($saved / 1024, 2) . " KB (" . $saved_percent . "%)\n";
                } else {
                    $errors++;
                    echo "✗ Failed\n";
                }
            }
        }
    }
}

// Start conversion
echo "=== Image to WebP Converter ===\n";
echo "Starting conversion...\n\n";

$start_time = microtime(true);

// Process images directory
$images_dir = $base_dir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images';
if (is_dir($images_dir)) {
    processDirectory($images_dir, $base_dir, $quality, $min_size_kb, $converted, $skipped, $errors, $total_size_saved);
} else {
    echo "Error: Images directory not found: $images_dir\n";
}

$end_time = microtime(true);
$execution_time = round($end_time - $start_time, 2);

// Print summary
echo "\n=== Conversion Complete ===\n";
echo "Converted: $converted images\n";
echo "Skipped: $skipped images\n";
echo "Errors: $errors images\n";
echo "Total size saved: " . round($total_size_saved / 1024 / 1024, 2) . " MB\n";
echo "Execution time: $execution_time seconds\n";
echo "\nDone!\n";

