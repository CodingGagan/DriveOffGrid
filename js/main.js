/**
 * DriveOffGrid - Main JavaScript
 * Performance optimized, mobile-first approach
 */

(function() {
    'use strict';

    // ============================================
    // Mobile Menu Toggle
    // ============================================
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');
    const navOverlay = document.querySelector('.nav-overlay');
    const navLinks = document.querySelectorAll('.nav-link');

    function toggleMenu(isActive) {
        if (isActive) {
            nav.classList.add('active');
            if (navOverlay) navOverlay.classList.add('active');
            menuToggle.classList.add('active');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        } else {
            nav.classList.remove('active');
            if (navOverlay) navOverlay.classList.remove('active');
            menuToggle.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isActive = !nav.classList.contains('active');
            toggleMenu(isActive);
        });

        // Close menu when clicking on overlay
        if (navOverlay) {
            navOverlay.addEventListener('click', function() {
                toggleMenu(false);
            });
        }

        // Close menu when clicking on a link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                toggleMenu(false);
            });
        });

        // Close menu when clicking outside (but not on toggle button)
        document.addEventListener('click', function(e) {
            if (nav.classList.contains('active') && 
                !nav.contains(e.target) && 
                !menuToggle.contains(e.target)) {
                toggleMenu(false);
            }
        });
    }

    // ============================================
    // Lazy Loading Images
    // ============================================
    if ('loading' in HTMLImageElement.prototype) {
        // Native lazy loading supported
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        lazyImages.forEach(img => {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
            // If already loaded
            if (img.complete) {
                img.classList.add('loaded');
            }
        });
    } else {
        // Fallback for browsers without native lazy loading
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ============================================
    // Smooth Scrolling for Anchor Links
    // ============================================
    function scrollToTarget(hash, smooth = true) {
        if (!hash || hash === '#' || hash === '#!') return;
        
        // Remove leading # if present
        const targetId = hash.replace(/^#/, '');
        const target = document.getElementById(targetId) || document.querySelector(hash);
        
        if (target) {
            const headerOffset = 80;
            // Get the absolute position of the element from the top of the document
            const elementTop = target.offsetTop;
            const offsetPosition = elementTop - headerOffset;

            window.scrollTo({
                top: Math.max(0, offsetPosition), // Ensure we don't scroll to negative position
                behavior: smooth ? 'smooth' : 'auto'
            });
        }
    }

    // Handle links with hash (both #target and page#target formats)
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (!href || href === '#' || href === '#!') return;
            
            // Extract hash from href (handles both "#target" and "page#target" formats)
            const hashMatch = href.match(/#([^#]+)$/);
            if (hashMatch) {
                const hash = '#' + hashMatch[1];
                
                // Check if it's a same-page link or cross-page link
                const url = new URL(href, window.location.origin);
                const isSamePage = url.pathname === window.location.pathname || 
                                   url.pathname === '' || 
                                   url.pathname === '/' ||
                                   href.startsWith('#');
                
                if (isSamePage) {
                    e.preventDefault();
                    scrollToTarget(hash);
                } else {
                    // For cross-page navigation, let the browser navigate
                    // The hashchange event will handle scrolling after page load
                }
            }
        });
    });

    // Handle hash on page load and hash changes
    function handleHashScroll() {
        if (window.location.hash) {
            // Small delay to ensure page is fully loaded
            setTimeout(() => {
                scrollToTarget(window.location.hash, false);
            }, 100);
        }
    }

    // Handle initial page load with hash
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', handleHashScroll);
    } else {
        handleHashScroll();
    }

    // Handle hash changes (for same-page navigation)
    window.addEventListener('hashchange', function() {
        scrollToTarget(window.location.hash);
    });

    // ============================================
    // Testimonials Slider Navigation
    // ============================================
    const testimonialsSlider = document.querySelector('.testimonials-slider');
    const testimonialsSliderWrapper = document.querySelector('.testimonials-slider-wrapper');
    const prevButton = document.querySelector('.nav-arrow-left');
    const nextButton = document.querySelector('.nav-arrow-right');

    if (testimonialsSlider && testimonialsSliderWrapper && prevButton && nextButton) {
        let currentCardIndex = 0;
        let isTransitioning = false;
        const cards = Array.from(testimonialsSlider.querySelectorAll('.testimonial-card'));
        const totalCards = cards.length;

        // Make sure all cards are visible
        cards.forEach(card => {
            card.style.display = 'block';
        });

        function getCardsPerView() {
            const width = window.innerWidth;
            if (width <= 767) {
                return 1; // Mobile: 1 card per view
            } else if (width <= 1024) {
                return 2; // Tablet: 2 cards per view
            } else if (width <= 1200) {
                return 2; // Small desktop: 2 cards per view
            } else {
                return 3; // Large desktop: 3 cards per view
            }
        }

        function getWrapperWidth() {
            return testimonialsSliderWrapper.offsetWidth || testimonialsSliderWrapper.clientWidth;
        }

        function getSingleCardWidth() {
            if (cards.length === 0) return 0;
            const firstCard = cards[0];
            const cardRect = firstCard.getBoundingClientRect();
            const gap = 0.5 * 16; // gap in pixels (0.5rem = 8px)
            return cardRect.width + gap;
        }

        function setupSlider() {
            const wrapperWidth = getWrapperWidth();
            if (wrapperWidth === 0) {
                setTimeout(setupSlider, 50);
                return;
            }
            }
            
        function getMaxCardIndex() {
            const cardsPerView = getCardsPerView();
            // Maximum index ensures we don't show empty space
            // If we have 10 cards and show 3 at a time, max index is 7 (showing cards 7,8,9)
            return Math.max(0, totalCards - cardsPerView);
        }

        function updateSlider() {
            const wrapperWidth = getWrapperWidth();
            if (wrapperWidth === 0) {
                // Retry if width is not available yet
                setTimeout(updateSlider, 50);
                return;
            }
            
            // Calculate single card width (one card + gap)
            const cardWidth = getSingleCardWidth();
            
            // Move by one card at a time
            const translateX = -(currentCardIndex * cardWidth);
            testimonialsSlider.style.transform = `translateX(${translateX}px)`;
        }

        function handleNext(e) {
            if (e) e.preventDefault();
            if (isTransitioning) return;
            
            isTransitioning = true;
            
            const maxIndex = getMaxCardIndex();
            
            // Always increment to next card
            currentCardIndex++;
            
            // If we've reached or passed the maximum valid index, loop back to start seamlessly
            if (currentCardIndex > maxIndex) {
                // Reset to start without animation for seamless loop
                currentCardIndex = 0;
                testimonialsSlider.style.transition = 'none';
                updateSlider();
                // Force reflow
                void testimonialsSlider.offsetWidth;
                // Re-enable transition
                testimonialsSlider.style.transition = 'transform 0.6s ease';
            } else {
            updateSlider();
            }
            
            // Reset transition lock after animation
            setTimeout(function() {
                isTransitioning = false;
            }, 600);
        }

        function handlePrev(e) {
            if (e) e.preventDefault();
            if (isTransitioning) return;
            
            isTransitioning = true;
            
            const maxIndex = getMaxCardIndex();
            
            // Always decrement to previous card
            currentCardIndex--;
            
            // If we've gone before start, loop to last valid position seamlessly
            if (currentCardIndex < 0) {
                // Jump to last valid position without animation for seamless loop
                currentCardIndex = maxIndex;
                testimonialsSlider.style.transition = 'none';
                updateSlider();
                // Force reflow
                void testimonialsSlider.offsetWidth;
                // Re-enable transition
                testimonialsSlider.style.transition = 'transform 0.6s ease';
            } else {
            updateSlider();
            }
            
            // Reset transition lock after animation
            setTimeout(function() {
                isTransitioning = false;
            }, 600);
        }

        // Initial setup
        setupSlider();
        // Ensure initial index is valid
        currentCardIndex = Math.min(currentCardIndex, getMaxCardIndex());
        updateSlider();

        // Update on window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Clamp current index to valid range after resize
                currentCardIndex = Math.min(currentCardIndex, getMaxCardIndex());
                setupSlider();
                updateSlider();
            }, 250);
        });

        // ============================================
        // Auto-scroll functionality
        // ============================================
        let autoScrollInterval = null;
        const autoScrollDelay = 5000; // 5 seconds between slides
        let isPaused = false;

        function startAutoScroll() {
            // Clear any existing interval
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
            }
            
            // Start auto-scroll
            autoScrollInterval = setInterval(function() {
                if (!isPaused && !isTransitioning) {
                    handleNext();
                }
            }, autoScrollDelay);
        }

        function stopAutoScroll() {
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
                autoScrollInterval = null;
            }
        }

        function pauseAutoScroll() {
            isPaused = true;
        }

        function resumeAutoScroll() {
            isPaused = false;
        }

        // Wrap handleNext and handlePrev to pause auto-scroll on manual navigation
        const originalHandleNext = handleNext;
        const originalHandlePrev = handlePrev;
        
        function handleNextWithPause(e) {
            pauseAutoScroll();
            originalHandleNext(e);
            // Resume after a delay (user might want to read)
            setTimeout(function() {
                resumeAutoScroll();
            }, autoScrollDelay * 2); // Wait 2x the normal delay before resuming
        }

        function handlePrevWithPause(e) {
            pauseAutoScroll();
            originalHandlePrev(e);
            // Resume after a delay
            setTimeout(function() {
                resumeAutoScroll();
            }, autoScrollDelay * 2);
        }

        // Add event listeners with pause-aware versions
        nextButton.addEventListener('click', handleNextWithPause);
        prevButton.addEventListener('click', handlePrevWithPause);

        // Pause auto-scroll on hover
        if (testimonialsSliderWrapper) {
            testimonialsSliderWrapper.addEventListener('mouseenter', function() {
                pauseAutoScroll();
            });

            testimonialsSliderWrapper.addEventListener('mouseleave', function() {
                resumeAutoScroll();
            });
        }

        // Initialize
        function init() {
            setTimeout(function() {
                updateSlider();
                // Start auto-scroll after initialization
                startAutoScroll();
            }, 200);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            stopAutoScroll();
        });
    }

    // ============================================
    // Form Handling
    // ============================================
    const journeyForm = document.querySelector('.journey-form');
    if (journeyForm) {
        journeyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form submission logic would go here
            const formData = new FormData(this);
            console.log('Form submitted:', Object.fromEntries(formData));
            
            // Show success message (you can customize this)
            alert('Thank you! We will contact you soon.');
            this.reset();
        });
    }

    // ============================================
    // Memories Modal (Image / Video Lightbox)
    // ============================================
    const memoriesGrid = document.querySelector('.memories-gallery-grid');
    const memoriesModal = document.getElementById('memoriesModal');
    const memoriesModalContent = document.getElementById('memoriesModalContent');
    const memoriesModalClose = memoriesModal ? memoriesModal.querySelector('.memories-modal-close') : null;

    if (memoriesGrid && memoriesModal && memoriesModalContent && memoriesModalClose) {
        function openMemoriesModal(type, src) {
            // Clear previous content
            memoriesModalContent.innerHTML = '';

            if (type === 'video') {
                const video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.autoplay = true;
                video.playsInline = true;
                video.className = 'memories-modal-video';
                memoriesModalContent.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = src;
                img.alt = 'Memory preview';
                img.className = 'memories-modal-image';
                memoriesModalContent.appendChild(img);
            }

            memoriesModal.classList.add('is-open');
            memoriesModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeMemoriesModal() {
            const video = memoriesModalContent.querySelector('video');
            if (video) {
                video.pause();
                video.currentTime = 0;
            }

            memoriesModal.classList.remove('is-open');
            memoriesModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        memoriesGrid.addEventListener('click', function (e) {
            const button = e.target.closest('.memories-item');
            if (!button) return;

            const type = button.getAttribute('data-type') || 'image';
            const src = button.getAttribute('data-src');
            if (!src) return;

            openMemoriesModal(type, src);
        });

        memoriesModalClose.addEventListener('click', closeMemoriesModal);

        memoriesModal.addEventListener('click', function (e) {
            if (e.target.hasAttribute('data-modal-close')) {
                closeMemoriesModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && memoriesModal.classList.contains('is-open')) {
                closeMemoriesModal();
            }
        });
    }

    // ============================================
    // Header Scroll Effect
    // ============================================
    const header = document.querySelector('.header');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
        } else {
            header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        }
        
        lastScroll = currentScroll;
    }, { passive: true });

    // ============================================
    // Intersection Observer for Animations
    // ============================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for fade-in animation (exclude destination-card as it uses slider transform)
    const animateElements = document.querySelectorAll('.testimonial-card, .team-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // ============================================
    // Performance: Preload Critical Resources
    // ============================================
    function preloadImage(src) {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = src;
        document.head.appendChild(link);
    }

    // Preload hero image if not already loaded
    const heroImage = document.querySelector('.hero-image');
    if (heroImage && heroImage.complete === false) {
        preloadImage(heroImage.src);
    }

    // ============================================
    // Destinations Slider Navigation (using Tiny Slider)
    // ============================================
    function initDestinationsSlider() {
        const destinationsSlider = document.querySelector('.destinations-slider');
        const destinationsSliderWrapper = document.querySelector('.destinations-slider-wrapper');
        const destPrevButton = document.querySelector('.dest-nav-arrow-left');
        const destNextButton = document.querySelector('.dest-nav-arrow-right');

        if (destinationsSlider && destinationsSliderWrapper && destPrevButton && destNextButton) {
            // Wait for tiny-slider to be available
            if (typeof tns === 'undefined') {
                // Retry after a short delay if tiny-slider hasn't loaded yet
                setTimeout(initDestinationsSlider, 100);
                return;
            }

            // Wait for critical images to load before initializing slider
            // Load first 4 and last 4 images (for forward and backward navigation)
            const images = destinationsSlider.querySelectorAll('img');
            const totalImages = images.length;
            const criticalImages = [];
            
            // Add first 4 images
            if (totalImages > 0) {
                criticalImages.push(...Array.from(images).slice(0, Math.min(4, totalImages)));
            }
            
            // Add last 4 images (for backward navigation)
            if (totalImages > 4) {
                const lastFour = Array.from(images).slice(-4);
                lastFour.forEach(img => {
                    if (!criticalImages.includes(img)) {
                        criticalImages.push(img);
                    }
                });
            }
            
            let loadedCount = 0;
            const totalCritical = criticalImages.length;

            function initializeSlider() {
                // Initialize Tiny Slider with infinite loop
                try {
                    const destSlider = tns({
                        container: '.destinations-slider',
                        items: 1, // Mobile: 1 item
                        slideBy: 1,
                        autoplay: false,
                        controls: true,
                        controlsContainer: false,
                        prevButton: destPrevButton,
                        nextButton: destNextButton,
                        nav: false,
                        loop: true,
                        rewind: false,
                        speed: 500,
                        gutter: 24,
                        mouseDrag: true,
                        swipeAngle: false,
                        preventScrollOnTouch: 'auto',
                        responsive: {
                            768: {  // Tablet: 2 items
                                items: 2,
                                gutter: 24
                            },
                            1024: { // Laptop: 3 items
                                items: 3,
                                gutter: 24
                            },
                            1400: { // Desktop: 4 items
                                items: 4,
                                gutter: 24
                            }
                        },
                        onIndexChanged: function(info) {
                            // Ensure cloned images load when slider moves
                            ensureClonedImagesLoad(destinationsSlider);
                        }
                    });
                    
                    // Ensure cloned images load after initialization
                    setTimeout(function() {
                        ensureClonedImagesLoad(destinationsSlider);
                    }, 100);
                } catch (error) {
                    console.error('Error initializing destinations slider:', error);
                }
            }
            
            // Function to ensure all images in slider (including clones) are loaded
            function ensureClonedImagesLoad(slider) {
                if (!slider) return;
                
                const allImages = slider.querySelectorAll('img');
                allImages.forEach(img => {
                    // If image hasn't loaded and has a src, force it to load
                    if (!img.complete && img.src && !img.dataset.loading) {
                        img.dataset.loading = 'true';
                        // Force image to load by setting src again or triggering load
                        const originalSrc = img.src;
                        img.src = '';
                        img.src = originalSrc;
                        
                        // Also ensure loading attribute is set if missing
                        if (!img.hasAttribute('loading')) {
                            img.loading = 'eager';
                        }
                    }
                });
            }

            // Check if critical images are already loaded
            if (totalCritical === 0) {
                // No images, initialize immediately
                initializeSlider();
                return;
            }

            criticalImages.forEach(img => {
                if (img.complete && img.naturalHeight !== 0) {
                    // Image already loaded
                    loadedCount++;
                } else {
                    // Wait for image to load
                    img.addEventListener('load', function() {
                        loadedCount++;
                        if (loadedCount === totalCritical) {
                            initializeSlider();
                        }
                    });
                    img.addEventListener('error', function() {
                        // Even if image fails, count it as loaded to proceed
                        loadedCount++;
                        if (loadedCount === totalCritical) {
                            initializeSlider();
                        }
                    });
                }
            });

            // If all critical images are already loaded
            if (loadedCount === totalCritical) {
                // Small delay to ensure layout is ready
                setTimeout(initializeSlider, 50);
            }

            // Fallback: initialize after max wait time even if images haven't loaded
            setTimeout(function() {
                if (loadedCount < totalCritical) {
                    console.warn('Some images did not load, initializing slider anyway');
                    initializeSlider();
                }
            }, 3000);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initDestinationsSlider, 100);
        });
    } else {
        // DOM already loaded, but wait a bit for tiny-slider to be available
        setTimeout(initDestinationsSlider, 100);
    }

    // ============================================
    // Memories Slider Navigation (using Tiny Slider)
    // ============================================
    function initMemoriesSlider() {
        const memoriesSlider = document.querySelector('.memories-slider');
        const memoriesSliderWrapper = document.querySelector('.memories-slider-wrapper');
        const memPrevButton = document.querySelector('.mem-nav-arrow-left');
        const memNextButton = document.querySelector('.mem-nav-arrow-right');

        if (memoriesSlider && memoriesSliderWrapper && memPrevButton && memNextButton) {
            // Wait for tiny-slider to be available
            if (typeof tns === 'undefined') {
                // Retry after a short delay if tiny-slider hasn't loaded yet
                setTimeout(initMemoriesSlider, 100);
                return;
            }

            // Wait for critical images to load before initializing slider
            // Load first 4 and last 4 images (for forward and backward navigation)
            const images = memoriesSlider.querySelectorAll('img');
            const totalImages = images.length;
            const criticalImages = [];
            
            // Add first 4 images
            if (totalImages > 0) {
                criticalImages.push(...Array.from(images).slice(0, Math.min(4, totalImages)));
            }
            
            // Add last 4 images (for backward navigation)
            if (totalImages > 4) {
                const lastFour = Array.from(images).slice(-4);
                lastFour.forEach(img => {
                    if (!criticalImages.includes(img)) {
                        criticalImages.push(img);
                    }
                });
            }
            
            let loadedCount = 0;
            const totalCritical = criticalImages.length;

            function initializeSlider() {
                // Initialize Tiny Slider with infinite loop
                try {
                    const memSlider = tns({
                        container: '.memories-slider',
                        items: 1, // Mobile: 1 item
                        slideBy: 1,
                        autoplay: false,
                        controls: true,
                        controlsContainer: false,
                        prevButton: memPrevButton,
                        nextButton: memNextButton,
                        nav: false,
                        loop: true,
                        rewind: false,
                        speed: 500,
                        gutter: 24,
                        mouseDrag: true,
                        swipeAngle: false,
                        preventScrollOnTouch: 'auto',
                        responsive: {
                            768: {  // Tablet: 2 items
                                items: 2,
                                gutter: 24
                            },
                            1024: { // Laptop: 3 items
                                items: 3,
                                gutter: 24
                            },
                            1400: { // Desktop: 4 items
                                items: 4,
                                gutter: 24
                            }
                        },
                        onIndexChanged: function(info) {
                            // Ensure cloned images load when slider moves
                            ensureClonedImagesLoad(memoriesSlider);
                        }
                    });
                    
                    // Ensure cloned images load after initialization
                    setTimeout(function() {
                        ensureClonedImagesLoad(memoriesSlider);
                    }, 100);
                } catch (error) {
                    console.error('Error initializing memories slider:', error);
                }
            }
            
            // Function to ensure all images in slider (including clones) are loaded
            function ensureClonedImagesLoad(slider) {
                if (!slider) return;
                
                const allImages = slider.querySelectorAll('img');
                allImages.forEach(img => {
                    // If image hasn't loaded and has a src, force it to load
                    if (!img.complete && img.src && !img.dataset.loading) {
                        img.dataset.loading = 'true';
                        // Force image to load by setting src again or triggering load
                        const originalSrc = img.src;
                        img.src = '';
                        img.src = originalSrc;
                        
                        // Also ensure loading attribute is set if missing
                        if (!img.hasAttribute('loading')) {
                            img.loading = 'eager';
                        }
                    }
                });
            }

            // Check if critical images are already loaded
            if (totalCritical === 0) {
                // No images, initialize immediately
                initializeSlider();
                return;
            }

            criticalImages.forEach(img => {
                if (img.complete && img.naturalHeight !== 0) {
                    // Image already loaded
                    loadedCount++;
                } else {
                    // Wait for image to load
                    img.addEventListener('load', function() {
                        loadedCount++;
                        if (loadedCount === totalCritical) {
                            initializeSlider();
                        }
                    });
                    img.addEventListener('error', function() {
                        // Even if image fails, count it as loaded to proceed
                        loadedCount++;
                        if (loadedCount === totalCritical) {
                            initializeSlider();
                        }
                    });
                }
            });

            // If all critical images are already loaded
            if (loadedCount === totalCritical) {
                // Small delay to ensure layout is ready
                setTimeout(initializeSlider, 50);
            }

            // Fallback: initialize after max wait time even if images haven't loaded
            setTimeout(function() {
                if (loadedCount < totalCritical) {
                    console.warn('Some images did not load, initializing slider anyway');
                    initializeSlider();
                }
            }, 3000);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initMemoriesSlider, 100);
        });
    } else {
        // DOM already loaded, but wait a bit for tiny-slider to be available
        setTimeout(initMemoriesSlider, 100);
    }

    // ============================================
    // Itinerary Slider Navigation
    // ============================================
    const itinerarySlider = document.querySelector('.itinerary-slider');
    const itinerarySliderWrapper = document.querySelector('.itinerary-slider-wrapper');
    const itineraryPrevButton = document.querySelector('.itinerary-nav-arrow-left');
    const itineraryNextButton = document.querySelector('.itinerary-nav-arrow-right');

    if (itinerarySlider && itinerarySliderWrapper && itineraryPrevButton && itineraryNextButton) {
        let currentItinerarySlide = 0;
        let isItineraryTransitioning = false;
        const itineraryCards = Array.from(itinerarySlider.querySelectorAll('.itinerary-day-card'));
        const totalItineraryCards = itineraryCards.length;

        function getItineraryCardWidth() {
            if (itineraryCards.length === 0) return 320;
            const firstCard = itineraryCards[0];
            const cardRect = firstCard.getBoundingClientRect();
            const gap = 32; // 2rem = 32px
            return cardRect.width + gap;
        }

        function updateItinerarySlider() {
            if (itineraryCards.length === 0) return;
            
            const cardWidth = getItineraryCardWidth();
            const translateX = -(currentItinerarySlide * cardWidth);
            
            itinerarySlider.style.transform = `translateX(${translateX}px)`;
        }

        function handleItineraryNext(e) {
            if (e) e.preventDefault();
            if (isItineraryTransitioning) return;
            
            isItineraryTransitioning = true;
            
            currentItinerarySlide++;
            
            if (currentItinerarySlide >= totalItineraryCards) {
                currentItinerarySlide = 0;
                itinerarySlider.style.transition = 'none';
                updateItinerarySlider();
                void itinerarySlider.offsetWidth;
                itinerarySlider.style.transition = 'transform 0.5s ease';
            } else {
                updateItinerarySlider();
            }
            
            setTimeout(function() {
                isItineraryTransitioning = false;
            }, 500);
        }

        function handleItineraryPrev(e) {
            if (e) e.preventDefault();
            if (isItineraryTransitioning) return;
            
            isItineraryTransitioning = true;
            
            currentItinerarySlide--;
            
            if (currentItinerarySlide < 0) {
                currentItinerarySlide = totalItineraryCards - 1;
                itinerarySlider.style.transition = 'none';
                updateItinerarySlider();
                void itinerarySlider.offsetWidth;
                itinerarySlider.style.transition = 'transform 0.5s ease';
            } else {
                updateItinerarySlider();
            }
            
            setTimeout(function() {
                isItineraryTransitioning = false;
            }, 500);
        }

        itineraryNextButton.addEventListener('click', handleItineraryNext);
        itineraryPrevButton.addEventListener('click', handleItineraryPrev);

        // Handle window resize
        let itineraryResizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(itineraryResizeTimer);
            itineraryResizeTimer = setTimeout(function() {
                currentItinerarySlide = 0;
                updateItinerarySlider();
            }, 250);
        });

        // Initialize after layout is complete
        function initItinerarySlider() {
            setTimeout(updateItinerarySlider, 100);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initItinerarySlider, 100);
            });
        } else {
            setTimeout(initItinerarySlider, 100);
        }
    }

    // ============================================
    // Hero Video Mute/Unmute Control
    // ============================================
    const heroVideo = document.querySelector('.hero-video');
    const heroVideoControl = document.getElementById('heroVideoControl');

    if (heroVideo && heroVideoControl) {
        // Initialize: video starts muted
        heroVideo.muted = true;
        heroVideoControl.classList.add('muted');

        // Toggle mute/unmute on button click
        heroVideoControl.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (heroVideo.muted) {
                // Unmute
                heroVideo.muted = false;
                heroVideoControl.classList.remove('muted');
                heroVideoControl.setAttribute('aria-label', 'Mute video');
            } else {
                // Mute
                heroVideo.muted = true;
                heroVideoControl.classList.add('muted');
                heroVideoControl.setAttribute('aria-label', 'Unmute video');
            }
        });

        // Update button state if video mute state changes externally
        heroVideo.addEventListener('volumechange', function() {
            if (heroVideo.muted) {
                heroVideoControl.classList.add('muted');
            } else {
                heroVideoControl.classList.remove('muted');
            }
        });
    }

    // ============================================
    // Console Welcome Message
    // ============================================
    console.log('%cDriveOffGrid', 'font-size: 20px; font-weight: bold; color: #FF6B35;');
    console.log('%cWelcome to DriveOffGrid - Where Luxury Meets The Open Road', 'color: #1A1A1A;');

})();

