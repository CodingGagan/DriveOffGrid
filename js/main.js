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
    const prevButton = document.querySelector('.nav-arrow-left');
    const nextButton = document.querySelector('.nav-arrow-right');

    if (testimonialsSlider && prevButton && nextButton) {
        let scrollAmount = 0;
        const cardWidth = 300; // Approximate card width + gap
        const maxScroll = testimonialsSlider.scrollWidth - testimonialsSlider.clientWidth;

        nextButton.addEventListener('click', function() {
            scrollAmount += cardWidth;
            if (scrollAmount > maxScroll) {
                scrollAmount = maxScroll;
            }
            testimonialsSlider.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        prevButton.addEventListener('click', function() {
            scrollAmount -= cardWidth;
            if (scrollAmount < 0) {
                scrollAmount = 0;
            }
            testimonialsSlider.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        // Update scroll position on scroll
        testimonialsSlider.addEventListener('scroll', function() {
            scrollAmount = this.scrollLeft;
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

