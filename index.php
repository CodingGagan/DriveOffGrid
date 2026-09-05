<?php
require_once __DIR__ . '/includes/config.php';
$page_title = "DriveOffGrid - Where Luxury Meets The Open Road";
$additional_css = [url_path('css/landing.css?v=1.0.4')];
$page_title = "Luxury Self-Drive Tours | Ultimate Road Trip Experiences";
$meta_description = "Discover luxury self-drive tours across Oman, UAE, Ireland, Scotland and Sri Lanka. Enjoy curated road trips with expert support and seamless journeys.";
$meta_keywords = "luxury self drive tours, ultimate road trip experiences, premium travel journeys, curated travel routes, guided driving adventures, international road trips, luxury adventure journeys, boutique travel planning";
include __DIR__ . '/includes/header.php';
?>

<!-- Full-screen landing modal (same content as former index.php, closes on logo/CTA click) -->
<div id="landing-modal" class="landing-modal" role="dialog" aria-label="Welcome">
    <div class="landing-modal-inner landing-page">
        <main class="landing-container">
            <h1 class="landing-title">
                Let's go on a <span class="title-accent">drive</span>...
            </h1>
            <div class="steps-container">
                <div class="step-card">
                    <div class="step-icon">
                        <img src="<?php echo url_path('assets/images/landing_page/step-1.png'); ?>" alt="Step 1 - Choose your group" class="step-image" loading="eager">
                    </div>
                    <p class="step-text">
                        Step 1 - You choose <span class="text-accent">your own group</span>
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <img src="<?php echo url_path('assets/images/landing_page/step-2.png'); ?>" alt="Step 2 - Pick a destination" class="step-image" loading="eager">
                    </div>
                    <p class="step-text">
                        Step 2 - You pick a point on the map <span class="text-accent">anywhere in the world</span>
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <img src="<?php echo url_path('assets/images/landing_page/step-3.png'); ?>" alt="Step 3 - Define your moments" class="step-image" loading="eager">
                    </div>
                    <p class="step-text">
                        Step 3 - You define the moments, <span class="text-accent">you decide the pace</span>
                    </p>
                </div>
            </div>
            <div class="brand-section">
                <div class="logo-container">
                    <a href="#" class="logo-link js-close-landing-modal" aria-label="Go to homepage">
                        <img src="<?php echo url_path('assets/images/Logo/DoG Logo Final 22nd Jan 2024 1.png'); ?>" alt="DriveOffGrid logo" class="brand-logo" loading="eager">
                    </a>
                </div>
                <p class="brand-slogan">We make it happen!</p>
            </div>
            <div class="cta-section">
                <a href="#" class="cta-button js-close-landing-modal">Ready? Click on the logo</a>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/includes/home_content.php'; ?>
<script>
(function() {
    var modal = document.getElementById('landing-modal');
    if (!modal) return;
    var storageKey = 'dog_landing_seen';
    function closeModal() {
        modal.style.display = 'none';
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
        try { sessionStorage.setItem(storageKey, '1'); } catch (e) {}
    }
    if (sessionStorage.getItem(storageKey)) {
        modal.style.display = 'none';
    } else {
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
    }
    document.querySelectorAll('.js-close-landing-modal').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal();
        });
    });
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
