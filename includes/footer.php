<style>
    .footer-links a {
        text-transform: uppercase;

    }
</style>
<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <!-- <h3 class="footer-brand-name">DriveOffGrid</h3> -->
                        <img src="<?php echo url_path('assets/images/Logo/DoG Logo Final 22nd Jan 2024 1.png'); ?>" alt="DriveOffGrid logo" class="footer-logo-image" loading="lazy">
                    </div>
                    <div class="social-links">
                        <a href="https://in.linkedin.com/company/driveoffgrid" class="social-link" aria-label="LinkedIn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                <rect x="2" y="9" width="4" height="12"/>
                                <circle cx="4" cy="4" r="2"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/driveoffgrid?igsh=dTd5cXc3eWRzbTVh" class="social-link" aria-label="Instagram">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/people/Driveoffgrid/61562935980455/" class="social-link" aria-label="Facebook">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3 class="footer-title">Home</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo url_path('how-it-works'); ?>">How it Works</a></li>
                        <li><a href="<?php echo url_path('/home#destinations'); ?>">Drive Ideas</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3 class="footer-title">Memories</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo url_path('/contact-us'); ?>">Reach Out</a></li>
                        <li><a href="<?php echo url_path('/home#testimonials'); ?>">What Guests Say</a></li>
                        <li><a href="<?php echo url_path('founders'); ?>">Who We Are</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3 class="footer-title">Contact</h3>
                    <ul class="footer-contact">
                        <li><a href="tel:+919323167788">+91-9323167788</a></li>
                        <li>DriveOffGrid, 417 Gold Crest Business Park, Lal Bahadur Shastri Marg, Ghatkopar West, Mumbai, Maharashtra 400086</li>
                        <li><a href="mailto:hello@driveoffgrid.com">hello@driveoffgrid.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <a href="<?php echo url_path('terms-and-conditions'); ?>" class="footer-link">Terms & Conditions</a>
                <span class="footer-separator">|</span>
                <a href="<?php echo url_path('privacy-policy'); ?>" class="footer-link">Privacy Policy</a>
            </div>
        </div>
    </footer>

    <!-- Tiny Slider JS - Load before main.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <script src="<?php echo url_path('js/main.js'); ?>?v=2.0.1" defer></script>
   
</body>
</html>

