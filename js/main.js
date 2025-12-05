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
    const navLinks = document.querySelectorAll('.nav-link');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function() {
            const isActive = nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', isActive);
            document.body.style.overflow = isActive ? 'hidden' : '';
        });

        // Close menu when clicking on a link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
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
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '#!') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
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
        const cardsPerSlide = 4; // 2x2 grid = 4 cards per slide
        const totalSlides = Math.ceil(totalCards / cardsPerSlide);

        // Make sure all cards are visible
        cards.forEach(card => {
            card.style.display = 'block';
        });

        function getWrapperWidth() {
            return testimonialsSliderWrapper.offsetWidth || testimonialsSliderWrapper.clientWidth;
        }

        function updateSlider() {
            const wrapperWidth = getWrapperWidth();
            if (wrapperWidth === 0) {
                // Retry if width is not available yet
                setTimeout(updateSlider, 50);
                return;
            }
            
            // Each slide shows 4 cards (2 rows x 2 columns)
            // Since 2 cards per row = 100% width, each slide = wrapperWidth
            const translateX = -(currentSlide * wrapperWidth);
            testimonialsSlider.style.transform = `translateX(${translateX}px)`;
        }

        function handleNext(e) {
            if (e) e.preventDefault();
            if (isTransitioning) return;
            
            isTransitioning = true;
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

    // Observe elements for fade-in animation
    const animateElements = document.querySelectorAll('.destination-card, .testimonial-card, .team-card');
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
    // Console Welcome Message
    // ============================================
    console.log('%cDriveOffGrid', 'font-size: 20px; font-weight: bold; color: #FF6B35;');
    console.log('%cWelcome to DriveOffGrid - Where Luxury Meets The Open Road', 'color: #1A1A1A;');

})();

