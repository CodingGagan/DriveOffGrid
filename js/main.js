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
        let currentSlide = 0;
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

        function getCardWidth() {
            const wrapperWidth = getWrapperWidth();
            const cardsPerView = getCardsPerView();
            const gap = 0.5; // gap in rem, converted to pixels (assuming 16px base)
            const gapPx = gap * 16;
            return (wrapperWidth - (gapPx * (cardsPerView - 1))) / cardsPerView;
        }

        function setupSlider() {
            const wrapperWidth = getWrapperWidth();
            if (wrapperWidth === 0) {
                setTimeout(setupSlider, 50);
                return;
            }
            
            const cardsPerView = getCardsPerView();
            const cardWidth = getCardWidth();
            const gap = 0.5 * 16; // gap in pixels
            const totalWidth = (cardWidth + gap) * totalCards - gap; // Total width for all cards
            
            // Set slider width to accommodate all cards
            // testimonialsSlider.style.width = `${totalWidth}px`;
        }

        function updateSlider() {
            const wrapperWidth = getWrapperWidth();
            if (wrapperWidth === 0) {
                // Retry if width is not available yet
                setTimeout(updateSlider, 50);
                return;
            }
            
            const cardsPerView = getCardsPerView();
            const cardWidth = getCardWidth();
            const gap = 0.5 * 16; // gap in pixels
            const slideWidth = (cardWidth + gap) * cardsPerView;
            
            const translateX = -(currentSlide * slideWidth);
            testimonialsSlider.style.transform = `translateX(${translateX}px)`;
        }

        function getTotalSlides() {
            const cardsPerView = getCardsPerView();
            return Math.ceil(totalCards / cardsPerView);
        }

        function handleNext(e) {
            if (e) e.preventDefault();
            if (isTransitioning) return;
            
            isTransitioning = true;
            const totalSlides = getTotalSlides();
            
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
            } else {
                // Loop back to start
                currentSlide = 0;
            }
            updateSlider();
            
            // Reset transition lock after animation
            setTimeout(function() {
                isTransitioning = false;
            }, 600);
        }

        function handlePrev(e) {
            if (e) e.preventDefault();
            if (isTransitioning) return;
            
            isTransitioning = true;
            const totalSlides = getTotalSlides();
            
            if (currentSlide > 0) {
                currentSlide--;
            } else {
                // Loop to end
                currentSlide = totalSlides - 1;
            }
            updateSlider();
            
            // Reset transition lock after animation
            setTimeout(function() {
                isTransitioning = false;
            }, 600);
        }

        // Initial setup
        setupSlider();
        updateSlider();

        // Update on window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                currentSlide = 0; // Reset to first slide on resize
                setupSlider();
                updateSlider();
            }, 250);
        });

        // Add event listeners (using once: false so they work every time)
        nextButton.addEventListener('click', handleNext);
        prevButton.addEventListener('click', handlePrev);

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                updateSlider();
            }, 250);
        });

        // Initialize
        function init() {
            setTimeout(function() {
                updateSlider();
            }, 200);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
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
    // Destinations Slider Navigation
    // ============================================
    const destinationsSlider = document.querySelector('.destinations-slider');
    const destinationsSliderWrapper = document.querySelector('.destinations-slider-wrapper');
    const destPrevButton = document.querySelector('.dest-nav-arrow-left');
    const destNextButton = document.querySelector('.dest-nav-arrow-right');

    if (destinationsSlider && destinationsSliderWrapper && destPrevButton && destNextButton) {
        let currentDestSlide = 0;
        let isDestTransitioning = false;
        const destCards = Array.from(destinationsSlider.querySelectorAll('.destination-card'));
        const totalDestCards = destCards.length;

        function getCardWidth() {
            if (destCards.length === 0) return 304;
            const firstCard = destCards[0];
            const cardRect = firstCard.getBoundingClientRect();
            const gap = 24; // 1.5rem = 24px
            return cardRect.width + gap;
        }

        function getCardsPerView() {
            if (destCards.length === 0) return 1;
            const wrapperWidth = destinationsSliderWrapper.offsetWidth;
            const cardWidth = getCardWidth();
            const cardsPerView = Math.floor(wrapperWidth / cardWidth);
            return cardsPerView > 0 ? cardsPerView : 1;
        }

        function updateDestSlider() {
            if (destCards.length === 0) return;
            
            const cardWidth = getCardWidth();
            const translateX = -(currentDestSlide * cardWidth);
            
            destinationsSlider.style.transform = `translateX(${translateX}px)`;
        }

        function handleDestNext(e) {
            if (e) e.preventDefault();
            if (isDestTransitioning) return;
            
            isDestTransitioning = true;
            
            // Always allow sliding, even if all cards are visible (for looping effect)
            currentDestSlide++;
            
            // If we've gone past all cards, loop back to start
            if (currentDestSlide >= totalDestCards) {
                // Reset to start without animation for seamless loop
                currentDestSlide = 0;
                destinationsSlider.style.transition = 'none';
                updateDestSlider();
                // Force reflow
                void destinationsSlider.offsetWidth;
                // Re-enable transition
                destinationsSlider.style.transition = 'transform 0.5s ease';
            } else {
                updateDestSlider();
            }
            
            setTimeout(function() {
                isDestTransitioning = false;
            }, 500);
        }

        function handleDestPrev(e) {
            if (e) e.preventDefault();
            if (isDestTransitioning) return;
            
            isDestTransitioning = true;
            
            // Always allow sliding backwards
            currentDestSlide--;
            
            // If we've gone before start, loop to end
            if (currentDestSlide < 0) {
                // Jump to end without animation for seamless loop
                currentDestSlide = totalDestCards - 1;
                destinationsSlider.style.transition = 'none';
                updateDestSlider();
                // Force reflow
                void destinationsSlider.offsetWidth;
                // Re-enable transition
                destinationsSlider.style.transition = 'transform 0.5s ease';
            } else {
                updateDestSlider();
            }
            
            setTimeout(function() {
                isDestTransitioning = false;
            }, 500);
        }

        destNextButton.addEventListener('click', handleDestNext);
        destPrevButton.addEventListener('click', handleDestPrev);

        // Handle window resize
        let destResizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(destResizeTimer);
            destResizeTimer = setTimeout(function() {
                currentDestSlide = 0; // Reset to start on resize
                updateDestSlider();
            }, 250);
        });

        // Initialize after layout is complete
        function initDestSlider() {
            // Wait for images to load
            const images = destinationsSlider.querySelectorAll('img');
            let imagesLoaded = 0;
            
            if (images.length === 0) {
                updateDestSlider();
                return;
            }
            
            images.forEach(function(img) {
                if (img.complete) {
                    imagesLoaded++;
                } else {
                    img.addEventListener('load', function() {
                        imagesLoaded++;
                        if (imagesLoaded === images.length) {
                            updateDestSlider();
                        }
                    });
                }
            });
            
            if (imagesLoaded === images.length) {
                updateDestSlider();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initDestSlider, 100);
            });
        } else {
            setTimeout(initDestSlider, 100);
        }
    }

    // ============================================
    // Memories Slider Navigation
    // ============================================
    const memoriesSlider = document.querySelector('.memories-slider');
    const memoriesSliderWrapper = document.querySelector('.memories-slider-wrapper');
    const memPrevButton = document.querySelector('.mem-nav-arrow-left');
    const memNextButton = document.querySelector('.mem-nav-arrow-right');

    if (memoriesSlider && memoriesSliderWrapper && memPrevButton && memNextButton) {
        let currentMemSlide = 0;
        let isMemTransitioning = false;
        const memCards = Array.from(memoriesSlider.querySelectorAll('.memory-card'));
        const totalMemCards = memCards.length;

        function getMemCardWidth() {
            if (memCards.length === 0) return 304;
            const firstCard = memCards[0];
            const cardRect = firstCard.getBoundingClientRect();
            const gap = 24; // 1.5rem = 24px
            return cardRect.width + gap;
        }

        function updateMemSlider() {
            if (memCards.length === 0) return;
            
            const cardWidth = getMemCardWidth();
            const translateX = -(currentMemSlide * cardWidth);
            
            memoriesSlider.style.transform = `translateX(${translateX}px)`;
        }

        function handleMemNext(e) {
            if (e) e.preventDefault();
            if (isMemTransitioning) return;
            
            isMemTransitioning = true;
            
            // Always allow sliding, even if all cards are visible (for looping effect)
            currentMemSlide++;
            
            // If we've gone past all cards, loop back to start
            if (currentMemSlide >= totalMemCards) {
                // Reset to start without animation for seamless loop
                currentMemSlide = 0;
                memoriesSlider.style.transition = 'none';
                updateMemSlider();
                // Force reflow
                void memoriesSlider.offsetWidth;
                // Re-enable transition
                memoriesSlider.style.transition = 'transform 0.5s ease';
            } else {
                updateMemSlider();
            }
            
            setTimeout(function() {
                isMemTransitioning = false;
            }, 500);
        }

        function handleMemPrev(e) {
            if (e) e.preventDefault();
            if (isMemTransitioning) return;
            
            isMemTransitioning = true;
            
            // Always allow sliding backwards
            currentMemSlide--;
            
            // If we've gone before start, loop to end
            if (currentMemSlide < 0) {
                // Jump to end without animation for seamless loop
                currentMemSlide = totalMemCards - 1;
                memoriesSlider.style.transition = 'none';
                updateMemSlider();
                // Force reflow
                void memoriesSlider.offsetWidth;
                // Re-enable transition
                memoriesSlider.style.transition = 'transform 0.5s ease';
            } else {
                updateMemSlider();
            }
            
            setTimeout(function() {
                isMemTransitioning = false;
            }, 500);
        }

        memNextButton.addEventListener('click', handleMemNext);
        memPrevButton.addEventListener('click', handleMemPrev);

        // Handle window resize
        let memResizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(memResizeTimer);
            memResizeTimer = setTimeout(function() {
                currentMemSlide = 0; // Reset to start on resize
                updateMemSlider();
            }, 250);
        });

        // Initialize after layout is complete
        function initMemSlider() {
            // Wait for images to load
            const images = memoriesSlider.querySelectorAll('img');
            let imagesLoaded = 0;
            
            if (images.length === 0) {
                updateMemSlider();
                return;
            }
            
            images.forEach(function(img) {
                if (img.complete) {
                    imagesLoaded++;
                } else {
                    img.addEventListener('load', function() {
                        imagesLoaded++;
                        if (imagesLoaded === images.length) {
                            updateMemSlider();
                        }
                    });
                }
            });
            
            if (imagesLoaded === images.length) {
                updateMemSlider();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initMemSlider, 100);
            });
        } else {
            setTimeout(initMemSlider, 100);
        }
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

