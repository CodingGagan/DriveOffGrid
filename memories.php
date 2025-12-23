<?php
require_once __DIR__ . '/includes/config.php';
// Get destination from query parameter (set by .htaccess rewrite rules)
$destination = isset($_GET['dest']) ? $_GET['dest'] : 'norway';

// Memories data - maps destinations to their memory assets
$memories_data = [
    'ireland' => [
        'name' => 'IRELAND',
        'theme' => 'Wild Atlantic',
        'hero_image' => 'assets/images/memory_page_banner/ireland.png',
        'images_path' => 'assets/images/memories/ireland',
        'videos' => [],
        'hero_video' => '/assets/images/memories/ireland/ireland-memories-video-1.webm'
    ],
    'norway' => [
        'name' => 'NORWAY',
        'theme' => 'Fjord & Flame',
        'hero_image' => 'assets/images/memory_page_banner/norway.png',
        'images_path' => 'assets/images/memories/norway',
        'videos' => [] // Can add video paths here
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'Echoes of Time',
        'hero_image' => 'assets/images/memory_page_banner/poland.png',
        'images_path' => 'assets/images/memories/poland',
        'videos' => []
    ],
    'scotland' => [
        'name' => 'SCOTLAND',
        'theme' => 'Loch & Glen',
        'hero_image' => 'assets/images/memory_page_banner/scotland.png',
        'images_path' => 'assets/images/memories/scotland',
        'videos' => [],
        'hero_video' => '/assets/images/memories/scotland/scotland-memories-video-1.webm'
    ],
    'uae_and_oman' => [
        'name' => 'UAE & OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => 'assets/images/memory_page_banner/uae.png',
        'images_path' => 'assets/images/memories/uae_oman',
        'videos' => [],
        'hero_video' => '/assets/video/memories/uae_oman_memories.mp4'
    ],
    'srilanka' => [
        'name' => 'SRI LANKA',
        'theme' => 'Serendipity',
        'hero_image' => 'assets/images/memory_page_banner/srilanka.png',
        'images_path' => 'assets/images/memories/srilanka',
        'videos' => []
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => 'assets/images/memory_page_banner/oman.png',
        'images_path' => 'assets/images/memories/oman',
        'videos' => []
    ],
    'russia_artic' => [
        'name' => 'RUSSIA',
        'theme' => 'Arctic Affair',
        'hero_image' => 'assets/images/memory_page_banner/russia_arctic.png',
        'images_path' => 'assets/images/memories/russia_artic',
        'videos' => []
    ],
    'russia_luxe_corridor' => [
        'name' => 'RUSSIA',
        'theme' => 'Luxe Corridor',
        'hero_image' => 'assets/images/memory_page_banner/russia_luxe.png',
        'images_path' => 'assets/images/memories/russia_luxe',
        'videos' => []
    ]
];

// Get memory data or default to norway
$memory = isset($memories_data[$destination]) ? $memories_data[$destination] : $memories_data['norway'];

// Get all images from the directory
$images = [];
$images_dir = __DIR__ . '/' . ltrim($memory['images_path'], '/');
if (is_dir($images_dir)) {
    $files = scandir($images_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp|heif|JPG|JPEG|PNG|GIF|WEBP|HEIF)$/i', $file)) {
            $images[] = url_path($memory['images_path'] . '/' . $file);
        }
    }
    // Sort images for consistent display
    sort($images);
}

$page_title = $memory['name'] . " Memories - DriveOffGrid";
include 'includes/header.php';
?>

<!-- Memories Hero Section -->
<section class="memories-hero">
    <div class="memories-hero-background">
        <img src="<?php echo url_path($memory['hero_image']); ?>" alt="<?php echo $memory['name']; ?> Memories" class="memories-hero-image" loading="eager" fetchpriority="high">
    </div>
    <div class="memories-hero-overlay"></div>
    <div class="container">
        <div class="memories-hero-content">
            <p class="memories-theme"><?php echo $memory['theme']; ?></p>
            <h1 class="memories-name"><?php echo $memory['name']; ?></h1>
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

            // Display all items in collage
            foreach ($allItems as $index => $item) {
                if ($item['type'] === 'video') {
                    // Derive thumbnail path by convention: filename-thumbnail.jpg
                    $thumbnail = preg_replace('/\.mp4$/i', '-thumbnail.jpg', $item['src']);
                    $thumbnail = preg_replace('/\.webm$/i', '-thumbnail.jpg', $thumbnail);
            ?>
                    <button class="memories-item memories-video memories-item-regular" type="button" data-type="video" data-src="<?php echo htmlspecialchars(url_path($item['src']), ENT_QUOTES); ?>">
                        <img src="<?php echo htmlspecialchars(url_path($thumbnail), ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($memory['name'], ENT_QUOTES); ?> Video Memory" loading="lazy">
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
                    // Image item
                    $image = $item['src'];
                    // Create varied sizes for collage effect - use actual index in allItems array
                    $size_class = '';
                    $itemIndex = $index; // Index in the combined array
                    if ($itemIndex % 7 == 0) {
                        $size_class = 'memories-item-large';
                    } elseif ($itemIndex % 5 == 0) {
                        $size_class = 'memories-item-tall';
                    } elseif ($itemIndex % 3 == 0) {
                        $size_class = 'memories-item-wide';
                    } else {
                        $size_class = 'memories-item-regular';
                    }
                ?>
                    <button class="memories-item <?php echo $size_class; ?>" type="button" data-type="image" data-src="<?php echo $image; ?>">
                        <img src="<?php echo $image; ?>" alt="<?php echo $memory['name']; ?> Memory <?php echo $itemIndex + 1; ?>" loading="lazy">
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
            preload="auto"
            aria-label="<?php echo htmlspecialchars($memory['name'], ENT_QUOTES); ?> Hero Video">
            <source src="<?php echo htmlspecialchars(url_path($heroVideoPath), ENT_QUOTES); ?>" type="<?php echo $videoType; ?>">
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
    
    // Intersection Observer to detect when video enters/exits viewport
    const observerOptions = {
        root: null, // Use viewport as root
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% of video is visible
    };
    
    const videoObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Video is in viewport - play it
                heroVideo.play().then(() => {
                    if (playPauseBtn) updatePlayPauseButton();
                }).catch(error => {
                    console.log('Video play failed:', error);
                    // If autoplay fails, try again with user interaction
                });
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

<?php include 'includes/footer.php'; ?>