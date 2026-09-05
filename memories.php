<?php
require_once __DIR__ . '/includes/config.php';
// Get destination from query parameter (set by .htaccess rewrite rules)
$destination = isset($_GET['dest']) ? $_GET['dest'] : 'norway';

// Memories data - maps destinations to their memory assets
$memories_data = [
    'ireland' => [
        'name' => 'IRELAND',
        'theme' => 'Wild Atlantic',
        'hero_image' => '/assets/images/banner_location_page/ireland.webp',
        'images_path' => 'assets/images/memories/ireland',
        'videos' => [],
        'hero_video' => '/assets/video/memories/ireland_memories.mp4'
    ],
    'norway' => [
        'name' => 'NORWAY',
        'theme' => 'Fjord & Flame',
        'hero_image' => '/assets/images/banner_location_page/norway.webp',
        'images_path' => 'assets/images/memories/norway',
        'hero_video' => '/assets/video/memories/norway_memories.mp4' // Can add video paths here
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'Echoes of Time',
        'hero_image' => '/assets/images/banner_location_page/poland.webp',
        'images_path' => 'assets/images/memories/poland',
        'hero_video' => '/assets/video/memories/poland_memories.mp4'
    ],
    'scotland' => [
        'name' => 'SCOTLAND',
        'theme' => 'Loch & Glen',
        'hero_image' => '/assets/images/banner_location_page/scotland.webp',
        'images_path' => 'assets/images/memories/scotland',
        'videos' => '',
        'hero_video' => '/assets/video/memories/scotland_memories.mp4'
    ],
    'uae_and_oman' => [
        'name' => 'UAE & OMAN',
        'theme' => 'Jebel Wadi',
        'hero_image' => '/assets/images/banner_location_page/uae.webp',
        'images_path' => 'assets/images/memories/uae_oman',
        'videos' => '',
        'hero_video' => '/assets/video/memories/uae_and_oman_memories.mp4'
    ],
    'srilanka' => [
        'name' => 'SRI LANKA',
        'theme' => 'Serendipity',
        'hero_image' => '/assets/images/banner_location_page/srilanks.webp',
        'images_path' => 'assets/images/memories/srilanka',
        'hero_video' => '/assets/video/memories/srilanka_memories.mp4'
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => '/assets/images/banner_location_page/oman.webp',
        'images_path' => 'assets/images/memories/oman',
        'hero_video' => '/assets/video/memories/oman_memories.mp4'
    ],
    'russia_artic' => [
        'name' => 'RUSSIA',
        'theme' => 'Arctic Affair',
        'hero_image' => '/assets/images/banner_location_page/russia arctic.webp',
        'images_path' => 'assets/images/memories/russia_artic',
        'hero_video' => '/DOG/assets/video/memories/russia_arctic_affair_memories.mp4'
    ],
    'russia_luxe_corridor' => [
        'name' => 'RUSSIA',
        'theme' => 'Luxe Corridor',
        'hero_image' => '/assets/images/banner_location_page/russia luxe.webp',
        'images_path' => 'assets/images/memories/russia_luxe',
        'hero_video' => '/assets/video/memories/russia_luxe_corridor_memories.mp4'
    ],
    'mongolia' => [
        'name' => 'MONGOLIA',
        'theme' => 'Steppe & Sky',
        'hero_image' => '/assets/images/locations/mongolia/homepage/mongolia.png',
        'images_path' => 'assets/images/locations/mongolia',
        'videos' => [],
        'hero_video' => ''
    ],
    'tibet' => [
        'name' => 'TIBET',
        'theme' => 'Mystic Pass',
        'hero_image' => '/assets/images/locations/tibet/homepage/tibet.png',
        'images_path' => 'assets/images/locations/tibet',
        'videos' => [],
        'hero_video' => ''
    ],
    'iceland' => [
        'name' => 'ICELAND',
        'theme' => 'Arctic Odyssey',
        'hero_image' => '/assets/images/locations/iceland/homepage/iceland.png',
        'images_path' => 'assets/images/locations/iceland/gallery',
        'videos' => [],
        'hero_video' => ''
    ]
];

// Get memory data or default to norway
$memory = isset($memories_data[$destination]) ? $memories_data[$destination] : $memories_data['norway'];

// Get all images from the directory (store raw paths for WebP conversion)
$images = [];
$images_dir = __DIR__ . '/' . ltrim($memory['images_path'], '/');
if (is_dir($images_dir)) {
    $files = scandir($images_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp|heif|JPG|JPEG|PNG|GIF|WEBP|HEIF)$/i', $file)) {
            // Store raw path (will use get_image_path() when displaying for WebP support)
            $images[] = $memory['images_path'] . '/' . $file;
        }
    }
    // Sort images for consistent display
    sort($images);
}

$page_title = $memory['name'] . " Memories - DriveOffGrid";
include 'includes/header.php';
?>

<!-- Memories Hero Section -->
<section class="destination-hero">
    <div class="destination-hero-background">
        <img src="<?php echo get_image_path($memory['hero_image']); ?>" alt="<?php echo $memory['name']; ?> Memories" class="destination-hero-image" loading="eager" fetchpriority="high">
    </div>
    <div class="destination-hero-overlay"></div>
    <div class="container">
        <div class="destination-hero-content">
            <?php
            // Use same theme class logic as destination page
            $themeClasses = 'destination-theme';
            // Add compact class for longer theme names if needed
            if (in_array($destination, ['scotland', 'uae_and_oman'])) {
                $themeClasses .= ' destination-theme--compact';
            }
            ?>
            <p class="<?php echo $themeClasses; ?>"><?php echo $memory['theme']; ?></p>
            <h1 class="destination-name"><?php echo $memory['name']; ?></h1>
        </div>
    </div>
</section>

<!-- Memories Gallery Section -->
<section class="memories-gallery">
    <div class="container">
        <div class="memories-gallery-grid">
            <?php
            // Display images in collage (videos will be mixed in)
            $allItems = [];

            // Add videos to the mix
            if (!empty($memory['videos'])) {
                foreach ($memory['videos'] as $video) {
                    $allItems[] = ['type' => 'video', 'src' => $video];
                }
            }

            // Add images to the mix
            foreach ($images as $image) {
                $allItems[] = ['type' => 'image', 'src' => $image];
            }

            // Shuffle items for better distribution (optional - can remove if you want videos first)
            // shuffle($allItems);

            // Display all items in collage with better gap-filling pattern
            // Progressive loading: show first batch immediately, rest load on scroll
            $totalItems = count($allItems);
            $initialLoadCount = 16; // Load first 16 items immediately
            $itemsPerLoad = 12; // Load 12 more items each time
            
            foreach ($allItems as $index => $item) {
                // Determine if item should load immediately or lazily
                $shouldLoadImmediately = $index < $initialLoadCount;
                $lazyClass = $shouldLoadImmediately ? '' : 'memories-item-lazy';
                $dataIndex = $index;
                
                if ($item['type'] === 'video') {
                    // Derive thumbnail path by convention: filename-thumbnail.jpg
                    $thumbnail = preg_replace('/\.mp4$/i', '-thumbnail.jpg', $item['src']);
                    $thumbnail = preg_replace('/\.webm$/i', '-thumbnail.jpg', $thumbnail);
                    $thumbnailPath = get_image_path($thumbnail);
            ?>
                    <button class="memories-item memories-video memories-item-regular <?php echo $lazyClass; ?>" 
                            type="button" 
                            data-type="video" 
                            data-src="<?php echo htmlspecialchars(url_path($item['src']), ENT_QUOTES); ?>"
                            data-image-path="<?php echo htmlspecialchars($thumbnailPath, ENT_QUOTES); ?>"
                            data-index="<?php echo $dataIndex; ?>">
                        <?php if ($shouldLoadImmediately): ?>
                            <img src="<?php echo htmlspecialchars($thumbnailPath, ENT_QUOTES); ?>" 
                                 alt="<?php echo htmlspecialchars($memory['name'], ENT_QUOTES); ?> Video Memory" 
                                 loading="lazy"
                                 decoding="async">
                        <?php else: ?>
                            <div class="memories-item-placeholder"></div>
                        <?php endif; ?>
                        <div class="memories-video-overlay">
                            <div class="memories-video-play-icon" aria-hidden="true">
                                <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="24" r="23" fill="none" stroke="white" stroke-width="2" opacity="0.9" />
                                    <polygon points="20,16 34,24 20,32" fill="white" />
                                </svg>
                            </div>
                        </div>
                    </button>
                <?php
                } else {
                    // Image item - improved pattern to reduce gaps
                    $image = $item['src'];
                    $size_class = '';
                    $itemIndex = $index;
                    
                    // Better distribution pattern that fills gaps more efficiently
                    // Pattern: large every 8th, tall every 6th, wide every 4th, rest regular
                    // This creates a more balanced layout
                    if ($itemIndex % 8 == 0 && $itemIndex > 0) {
                        $size_class = 'memories-item-large';
                    } elseif ($itemIndex % 6 == 0 && $itemIndex > 0) {
                        $size_class = 'memories-item-tall';
                    } elseif ($itemIndex % 4 == 0 && $itemIndex > 0) {
                        $size_class = 'memories-item-wide';
                    } else {
                        $size_class = 'memories-item-regular';
                    }
                    
                    // Ensure we don't have too many large items at the end
                    $remainingItems = $totalItems - $itemIndex;
                    if ($remainingItems < 3 && $size_class === 'memories-item-large') {
                        $size_class = 'memories-item-regular';
                    }
                    
                    $imagePath = get_image_path($image);
                    $imageUrl = url_path($image);
                ?>
                    <button class="memories-item <?php echo $size_class; ?> <?php echo $lazyClass; ?>" 
                            type="button" 
                            data-type="image" 
                            data-src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES); ?>"
                            data-image-path="<?php echo htmlspecialchars($imagePath, ENT_QUOTES); ?>"
                            data-index="<?php echo $dataIndex; ?>">
                        <?php if ($shouldLoadImmediately): ?>
                            <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES); ?>" 
                                 alt="<?php echo htmlspecialchars($memory['name'], ENT_QUOTES); ?> Memory <?php echo $itemIndex + 1; ?>" 
                                 loading="lazy"
                                 decoding="async">
                        <?php else: ?>
                            <div class="memories-item-placeholder"></div>
                        <?php endif; ?>
                    </button>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Memories Hero Video Section -->
<?php if (!empty($memory['hero_video'])): 
    $heroVideoPath = ltrim($memory['hero_video'], '/'); // Remove leading slash for url_path
    // echo $heroVideoPath; die;
    $videoExtension = strtolower(pathinfo($heroVideoPath, PATHINFO_EXTENSION));
    $videoType = ($videoExtension === 'webm') ? 'video/webm' : (($videoExtension === 'mp4') ? 'video/mp4' : 'video/mp4');
?>
<section class="memories-hero-video-section">
    <div class="memories-hero-video-wrapper">
        <video 
            class="memories-hero-video-player" 
            muted 
            loop 
            playsinline
            preload="metadata"
            data-src="<?php echo htmlspecialchars(url_path($heroVideoPath), ENT_QUOTES); ?>"
            aria-label="<?php echo htmlspecialchars($memory['name'], ENT_QUOTES); ?> Hero Video">
            <source data-src="<?php echo htmlspecialchars(url_path($heroVideoPath), ENT_QUOTES); ?>" type="<?php echo $videoType; ?>">
            Your browser does not support the video tag.
        </video>
        <!-- Video Controls -->
        <div class="memories-video-controls">
            <button class="video-control-btn video-play-pause-btn" type="button" aria-label="Play/Pause">
                <svg class="play-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 5V19L19 12L8 5Z" fill="currentColor"/>
                </svg>
                <svg class="pause-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <rect x="6" y="4" width="4" height="16" fill="currentColor"/>
                    <rect x="14" y="4" width="4" height="16" fill="currentColor"/>
                </svg>
            </button>
            <button class="video-control-btn video-mute-btn" type="button" aria-label="Mute/Unmute">
                <svg class="mute-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9V15H7L12 20V4L7 9H3Z" fill="currentColor"/>
                    <path d="M16.5 12C16.5 10.23 15.5 8.71 14 7.97V16.03C15.5 15.29 16.5 13.77 16.5 12Z" fill="currentColor"/>
                    <path d="M19 12C19 9.23 17.5 6.86 15.5 5.5V18.5C17.5 17.14 19 14.77 19 12Z" fill="currentColor"/>
                    <path d="M21 12C21 8.13 18.5 4.86 15.5 3.5V20.5C18.5 19.14 21 15.87 21 12Z" fill="currentColor"/>
                </svg>
                <svg class="unmute-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path d="M3 9V15H7L12 20V4L7 9H3Z" fill="currentColor"/>
                    <line x1="16" y1="9" x2="22" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="22" y1="9" x2="16" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Memories Video Scroll Control Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroVideoSection = document.querySelector('.memories-hero-video-section');
    const heroVideo = document.querySelector('.memories-hero-video-player');
    const playPauseBtn = document.querySelector('.video-play-pause-btn');
    const muteBtn = document.querySelector('.video-mute-btn');
    const playIcon = document.querySelector('.video-play-pause-btn .play-icon');
    const pauseIcon = document.querySelector('.video-play-pause-btn .pause-icon');
    const muteIcon = document.querySelector('.video-mute-btn .mute-icon');
    const unmuteIcon = document.querySelector('.video-mute-btn .unmute-icon');
    
    if (!heroVideoSection || !heroVideo) {
        return; // No video section, exit
    }
    
    // Remove autoplay attribute initially - we'll control it with JavaScript
    heroVideo.removeAttribute('autoplay');
    heroVideo.pause();
    
    // Update play/pause button state
    function updatePlayPauseButton() {
        if (heroVideo.paused) {
            playIcon.style.display = 'block';
            pauseIcon.style.display = 'none';
            // Show controls when paused
            if (heroVideoSection) {
                heroVideoSection.classList.add('video-paused');
            }
        } else {
            playIcon.style.display = 'none';
            pauseIcon.style.display = 'block';
            // Hide controls after a delay when playing
            setTimeout(() => {
                if (heroVideoSection && !heroVideo.paused) {
                    heroVideoSection.classList.remove('video-paused');
                }
            }, 2000);
        }
    }
    
    // Update mute button state
    function updateMuteButton() {
        if (heroVideo.muted) {
            muteIcon.style.display = 'block';
            unmuteIcon.style.display = 'none';
        } else {
            muteIcon.style.display = 'none';
            unmuteIcon.style.display = 'block';
        }
    }
    
    // Play/Pause button handler
    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (heroVideo.paused) {
                heroVideo.play().then(() => {
                    updatePlayPauseButton();
                }).catch(error => {
                    console.log('Video play failed:', error);
                });
            } else {
                heroVideo.pause();
                updatePlayPauseButton();
            }
        });
    }
    
    // Mute/Unmute button handler
    if (muteBtn) {
        muteBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            heroVideo.muted = !heroVideo.muted;
            updateMuteButton();
        });
    }
    
    // Update button states when video state changes
    heroVideo.addEventListener('play', updatePlayPauseButton);
    heroVideo.addEventListener('pause', updatePlayPauseButton);
    heroVideo.addEventListener('volumechange', updateMuteButton);
    
    // Initial button states
    updatePlayPauseButton();
    updateMuteButton();
    
    // Lazy load video source when it enters viewport
    const videoSrc = heroVideo.getAttribute('data-src');
    if (videoSrc) {
        const videoSource = heroVideo.querySelector('source');
        if (videoSource) {
            // Don't set src initially - wait for viewport entry
            const videoLoadObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Video section entered viewport - load video source
                        if (!heroVideo.src && videoSource.getAttribute('data-src')) {
                            heroVideo.src = videoSrc;
                            videoSource.src = videoSrc;
                            heroVideo.load(); // Reload video with new source
                        }
                        videoLoadObserver.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '100px' // Start loading 100px before video enters viewport
            });
            
            videoLoadObserver.observe(heroVideoSection);
        }
    }
    
    // Intersection Observer to detect when video enters/exits viewport for playback
    const observerOptions = {
        root: null, // Use viewport as root
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% of video is visible
    };
    
    const videoObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Video is in viewport - ensure it's loaded, then play
                if (!heroVideo.src && videoSrc) {
                    heroVideo.src = videoSrc;
                    const videoSource = heroVideo.querySelector('source');
                    if (videoSource) videoSource.src = videoSrc;
                    heroVideo.load();
                }
                
                // Wait a bit for video to load, then play
                setTimeout(() => {
                    heroVideo.play().then(() => {
                        if (playPauseBtn) updatePlayPauseButton();
                    }).catch(error => {
                        console.log('Video play failed:', error);
                    });
                }, 300);
            } else {
                // Video is out of viewport - pause it
                heroVideo.pause();
                if (playPauseBtn) updatePlayPauseButton();
            }
        });
    }, observerOptions);
    
    // Start observing the video section
    videoObserver.observe(heroVideoSection);
    
    // Also handle scroll events for more precise control
    let isPlaying = false;
    let scrollTimeout;
    
    function checkVideoVisibility() {
        const rect = heroVideoSection.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        
        // Check if video section is in viewport
        const isVisible = rect.top < windowHeight && rect.bottom > 0;
        
        if (isVisible && !isPlaying) {
            // Video entered viewport
            heroVideo.play().then(() => {
                isPlaying = true;
                if (playPauseBtn) updatePlayPauseButton();
            }).catch(error => {
                console.log('Video play failed:', error);
            });
        } else if (!isVisible && isPlaying) {
            // Video left viewport
            heroVideo.pause();
            isPlaying = false;
            if (playPauseBtn) updatePlayPauseButton();
        }
    }
    
    // Throttled scroll handler
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(checkVideoVisibility, 100);
    }, { passive: true });
    
    // Initial check
    checkVideoVisibility();
    
    // Handle visibility change (when user switches tabs)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            heroVideo.pause();
        } else {
            checkVideoVisibility();
        }
    });
});
</script>

<!-- Memories Modal -->
<div class="memories-modal" id="memoriesModal" aria-hidden="true">
    <div class="memories-modal-backdrop" data-modal-close></div>
    <div class="memories-modal-dialog" role="dialog" aria-modal="true" aria-label="Memory preview">
        <button class="memories-modal-close" type="button" aria-label="Close">
            <span>&times;</span>
        </button>
        <div class="memories-modal-content" id="memoriesModalContent">
            <!-- Filled dynamically with image or video -->
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // Progressive image loading - load images as user scrolls
    function initProgressiveLoading() {
        const galleryGrid = document.querySelector('.memories-gallery-grid');
        if (!galleryGrid) return;
        
        const lazyItems = galleryGrid.querySelectorAll('.memories-item-lazy');
        if (lazyItems.length === 0) return;
        
            // Intersection Observer for lazy loading
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const item = entry.target;
                        const imagePath = item.getAttribute('data-image-path');
                        const dataSrc = item.getAttribute('data-src');
                        const dataType = item.getAttribute('data-type');
                        
                        // Remove lazy class
                        item.classList.remove('memories-item-lazy');
                        
                        // Load image or video thumbnail
                        const placeholder = item.querySelector('.memories-item-placeholder');
                        if (placeholder) {
                            const img = document.createElement('img');
                            // For images, use data-image-path; for videos, use data-src (thumbnail)
                            img.src = imagePath || dataSrc;
                            img.alt = item.getAttribute('alt') || 'Memory';
                            img.loading = 'lazy';
                            img.decoding = 'async';
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            img.style.display = 'block';
                            
                            // Handle image load error
                            img.onerror = function() {
                                // If image fails, try data-src as fallback
                                if (imagePath && this.src !== dataSrc) {
                                    this.src = dataSrc;
                                }
                            };
                            
                            // Replace placeholder with image
                            placeholder.replaceWith(img);
                        }
                        
                        // Stop observing this item
                        observer.unobserve(item);
                    }
                });
            }, {
                rootMargin: '200px' // Start loading 200px before item enters viewport
            });
        
        // Observe all lazy items
        lazyItems.forEach(item => {
            imageObserver.observe(item);
        });
    }
    
    // Function to optimize gallery grid layout and fill gaps
    function optimizeGalleryLayout() {
        const galleryGrid = document.querySelector('.memories-gallery-grid');
        if (!galleryGrid) return;
        
        // Force a reflow to ensure grid recalculates
        void galleryGrid.offsetWidth;
        
        // Check for empty spaces by examining grid items
        const items = galleryGrid.querySelectorAll('.memories-item');
        if (items.length === 0) return;
        
        // CSS Grid with dense flow should handle most cases,
        // but we can ensure items are properly positioned
        items.forEach(item => {
            // Ensure all items are visible and properly sized
            if (item.offsetHeight === 0 || item.offsetWidth === 0) {
                item.style.display = 'block';
            }
        });
    }
    
    // Run optimization after initial images load
    function initGalleryOptimization() {
        const galleryGrid = document.querySelector('.memories-gallery-grid');
        if (!galleryGrid) return;
        
        // Only count initially loaded images (not lazy ones)
        const images = galleryGrid.querySelectorAll('img:not(.memories-item-lazy img)');
        let loadedCount = 0;
        const totalImages = images.length;
        
        if (totalImages === 0) {
            optimizeGalleryLayout();
            return;
        }
        
        images.forEach(img => {
            if (img.complete) {
                loadedCount++;
            } else {
                img.addEventListener('load', function() {
                    loadedCount++;
                    if (loadedCount === totalImages) {
                        setTimeout(optimizeGalleryLayout, 100);
                    }
                });
                img.addEventListener('error', function() {
                    loadedCount++;
                    if (loadedCount === totalImages) {
                        setTimeout(optimizeGalleryLayout, 100);
                    }
                });
            }
        });
        
        if (loadedCount === totalImages) {
            setTimeout(optimizeGalleryLayout, 100);
        }
    }
    
    // Initialize gallery optimization and progressive loading
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                initGalleryOptimization();
                initProgressiveLoading();
            }, 200);
        });
    } else {
        setTimeout(function() {
            initGalleryOptimization();
            initProgressiveLoading();
        }, 200);
    }
    
    // Re-optimize on window resize
    let galleryResizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(galleryResizeTimeout);
        galleryResizeTimeout = setTimeout(optimizeGalleryLayout, 300);
    });
    
    // Function to equalize alignment by adjusting font sizes
    // Makes smaller text bigger and larger text smaller so they align
    function equalizeMemoriesAlignment() {
        const themeElement = document.querySelector('.destination-theme');
        const nameElement = document.querySelector('.destination-name');
        
        if (!themeElement || !nameElement) return;
        
        // Reset font sizes to CSS defaults first
        themeElement.style.fontSize = '';
        nameElement.style.fontSize = '';
        
        // Force a reflow to get accurate measurements
        void themeElement.offsetWidth;
        void nameElement.offsetWidth;
        
        // Helper function to measure actual text width accurately
        function measureTextWidth(element) {
            const text = element.textContent.trim();
            if (!text) return 0;
            
            // Use Range API to measure the actual text node width
            const range = document.createRange();
            const textNode = element.firstChild;
            
            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                range.selectNodeContents(element);
                const rect = range.getBoundingClientRect();
                return rect.width;
            }
            
            // Fallback: use computed style approach
            const style = window.getComputedStyle(element);
            
            // Create a temporary span with exact same styling to measure text width
            const tempSpan = document.createElement('span');
            tempSpan.textContent = text;
            tempSpan.style.position = 'absolute';
            tempSpan.style.visibility = 'hidden';
            tempSpan.style.whiteSpace = 'nowrap';
            tempSpan.style.top = '-9999px';
            tempSpan.style.left = '-9999px';
            tempSpan.style.fontSize = style.fontSize;
            tempSpan.style.fontWeight = style.fontWeight;
            tempSpan.style.fontFamily = style.fontFamily;
            tempSpan.style.fontStyle = style.fontStyle;
            tempSpan.style.textTransform = style.textTransform;
            tempSpan.style.letterSpacing = style.letterSpacing;
            tempSpan.style.padding = '0';
            tempSpan.style.margin = '0';
            tempSpan.style.border = '0';
            tempSpan.style.lineHeight = style.lineHeight;
            
            document.body.appendChild(tempSpan);
            const width = tempSpan.getBoundingClientRect().width;
            document.body.removeChild(tempSpan);
            return width;
        }
        
        // Smallest the theme line may be scaled to before we stop honouring the
        // name's CSS size and simply fit the container instead.
        const MIN_THEME_FONT_PX = 24;

        // Width/font-size the element would have from CSS alone, ignoring any
        // inline size this script has already applied.
        function measureNaturalSize(element) {
            const inlineFontSize = element.style.fontSize;
            element.style.fontSize = '';
            void element.offsetWidth;
            const natural = {
                width: measureTextWidth(element),
                fontSize: parseFloat(window.getComputedStyle(element).fontSize)
            };
            element.style.fontSize = inlineFontSize;
            void element.offsetWidth;
            return natural;
        }

        function measureNaturalWidth(element) {
            return measureNaturalSize(element).width;
        }

        // Measure initial text widths
        let themeWidth = measureTextWidth(themeElement);
        let nameWidth = measureTextWidth(nameElement);
        
        // Get computed styles
        const themeStyle = window.getComputedStyle(themeElement);
        const nameStyle = window.getComputedStyle(nameElement);
        
        // Get current font sizes in pixels
        let themeFontSize = parseFloat(themeStyle.fontSize);
        let nameFontSize = parseFloat(nameStyle.fontSize);
        
        // Store original font sizes
        const originalThemeFontSize = themeFontSize;
        const originalNameFontSize = nameFontSize;
        
        // Calculate target width (use the wider one)
        const targetWidth = Math.max(themeWidth, nameWidth);
        
        // Binary search approach to find exact font sizes
        function adjustFontSizeToTarget(element, currentWidth, currentFontSize, targetWidth, maxIterations = 10) {
            let minFontSize = currentFontSize * 0.5; // Can shrink to 50%
            let maxFontSize = currentFontSize * 3.0;  // Can grow to 300%
            let bestFontSize = currentFontSize;
            let bestWidth = currentWidth;
            let bestDiff = Math.abs(currentWidth - targetWidth);
            
            for (let i = 0; i < maxIterations; i++) {
                const testFontSize = (minFontSize + maxFontSize) / 2;
                element.style.fontSize = testFontSize + 'px';
                void element.offsetWidth; // Force reflow
                
                const testWidth = measureTextWidth(element);
                const testDiff = Math.abs(testWidth - targetWidth);
                
                if (testDiff < bestDiff) {
                    bestDiff = testDiff;
                    bestFontSize = testFontSize;
                    bestWidth = testWidth;
                }
                
                if (testWidth < targetWidth) {
                    minFontSize = testFontSize;
                } else {
                    maxFontSize = testFontSize;
                }
                
                // If we're very close, break early
                if (testDiff < 0.5) {
                    break;
                }
            }
            
            element.style.fontSize = bestFontSize + 'px';
            void element.offsetWidth;
            return { fontSize: bestFontSize, width: bestWidth };
        }
        
        // Adjust both elements to match target width
        // If theme is smaller, make it bigger; if name is larger, make it smaller
        if (themeWidth < targetWidth && nameWidth >= targetWidth) {
            // Only theme needs to grow
            const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, targetWidth);
            themeWidth = result.width;
        } else if (nameWidth > targetWidth && themeWidth <= targetWidth) {
            // Only name needs to shrink
            const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, targetWidth);
            nameWidth = result.width;
        } else {
            // Both need adjustment - adjust both to meet in the middle
            const midTarget = (themeWidth + nameWidth) / 2;
            
            if (themeWidth < midTarget) {
                const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, midTarget);
                themeWidth = result.width;
            }
            
            if (nameWidth > midTarget) {
                const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, midTarget);
                nameWidth = result.width;
            }
        }
        
        // Final fine-tuning: ensure both are exactly the same width
        const finalTarget = Math.max(themeWidth, nameWidth);
        
        // Re-measure current widths
        themeWidth = measureTextWidth(themeElement);
        nameWidth = measureTextWidth(nameElement);
        themeFontSize = parseFloat(window.getComputedStyle(themeElement).fontSize);
        nameFontSize = parseFloat(window.getComputedStyle(nameElement).fontSize);
        
        if (Math.abs(themeWidth - finalTarget) > 0.5) {
            const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, finalTarget, 8);
            themeWidth = result.width;
        }
        
        if (Math.abs(nameWidth - finalTarget) > 0.5) {
            const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, finalTarget, 8);
            nameWidth = result.width;
        }

        // Keep the equalised block inside the hero container.
        //
        // .destination-hero is a flex container, so .container is a flex item
        // with the default min-width:auto and cannot shrink below its
        // min-content width. Both lines are white-space:nowrap, so their
        // min-content width IS the full text width - an oversized line stretches
        // .container to match it. Measuring .container (or its child) would
        // therefore just report the oversized width straight back and the guard
        // below would never fire. Derive the width .container is *meant* to have
        // from the hero section, which never grows, plus the container's own
        // max-width and horizontal padding.
        const heroContent = nameElement.parentElement;
        const containerEl = heroContent ? heroContent.parentElement : null;
        const heroSection = nameElement.closest('.destination-hero');
        let availableWidth = 0;

        if (containerEl && heroSection) {
            const containerStyle = window.getComputedStyle(containerEl);
            const paddingX = (parseFloat(containerStyle.paddingLeft) || 0) +
                             (parseFloat(containerStyle.paddingRight) || 0);
            const maxWidth = parseFloat(containerStyle.maxWidth);
            const outerWidth = Math.min(
                heroSection.clientWidth,
                isNaN(maxWidth) ? Infinity : maxWidth
            );
            availableWidth = Math.max(0, outerWidth - paddingX);
        }

        const widestWidth = Math.max(themeWidth, nameWidth);

        // A very long theme paired with a short name (e.g. Tibet) matches at a
        // width wider than the page. Only then do we intervene - every other
        // destination already settles well inside the container and is left
        // exactly as the equalising pass produced it.
        if (availableWidth > 0 && widestWidth > availableWidth) {
            // Prefer to land on the name's own CSS size rather than merely
            // fitting the container: matching a long theme would otherwise
            // inflate the name far beyond every other destination's hero and
            // run it off the bottom of the section. The theme shrinks instead.
            const naturalNameWidth = measureNaturalWidth(nameElement);
            const naturalTheme = measureNaturalSize(themeElement);

            // ...but keep the theme readable. If honouring the name's size
            // would push the theme under MIN_THEME_FONT_PX (which happens on
            // narrow screens, where the name's CSS size is small), fall back to
            // whatever the container allows.
            const minThemeWidth = naturalTheme.fontSize > 0
                ? naturalTheme.width * (MIN_THEME_FONT_PX / naturalTheme.fontSize)
                : 0;

            const targetWidth = Math.min(
                availableWidth,
                Math.max(naturalNameWidth, minThemeWidth)
            );

            const fitScale = targetWidth / widestWidth;
            themeElement.style.fontSize = (parseFloat(window.getComputedStyle(themeElement).fontSize) * fitScale) + 'px';
            nameElement.style.fontSize = (parseFloat(window.getComputedStyle(nameElement).fontSize) * fitScale) + 'px';
        }
    }
    
    // Run on page load
    function initAlignment() {
        // Wait for fonts and layout to be ready
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                setTimeout(equalizeMemoriesAlignment, 150);
            });
        } else {
            setTimeout(equalizeMemoriesAlignment, 400);
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAlignment);
        window.addEventListener('load', equalizeMemoriesAlignment);
    } else {
        initAlignment();
        window.addEventListener('load', equalizeMemoriesAlignment);
    }
    
    // Recalculate on window resize (with debounce)
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(equalizeMemoriesAlignment, 300);
    });
})();
</script>

<?php include 'includes/footer.php'; ?>