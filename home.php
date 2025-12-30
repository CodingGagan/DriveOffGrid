<?php
$page_title = "DriveOffGrid - Where Luxury Meets The Open Road";
include 'includes/header.php';

$drive_ideas = [
    'ireland' => [
        'name' => 'IRELAND',
        'theme' => 'Wild Atlantic',
        'hero_image' => 'assets/images/homepage/ireland_drive_idea_hp.png',
        'url' => 'ireland',
        'content' => 'Where wind, water, and ancient cliffs shape the spirit , a soulful drive along Ireland’s untamed edge.'
    ],
    'norway' => [
        'name' => 'Norway',
        'theme' => 'Fjord & Flame',
        'hero_image' => 'assets/images/homepage/norway_drive_ideas_hp.png',
        'url' => 'norway',
        'content' => 'Where icy fjords meet the fire of the midnight sun — a drive through nature’s most dramatic contrasts.'
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'ECHOES OF TIME',
        'hero_image' => 'assets/images/homepage/poland_drive_ideas_hp.png',
        'url' => 'poland',
        'content' => 'A journey through living history — where cobbled streets, forgotten stories, and modern soul meet on the open road.'
    ],
    'scotland' => [
        'name' => 'Scotland',
        'theme' => 'Loch & Glen',
        'hero_image' => 'assets/images/homepage/scotland_drive_idea_hp.png',
        'url' => 'scotland',
        'content' => 'Misty lochs, rugged glens, and roads that whisper legends, a drive into Scotland’s mysterious heart.'
    ],
    'uae_and_oman' => [
        'name' => 'UAE OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => 'assets/images/homepage/uae_oman_drive_idea_hp.png',
        'url' => 'uae-oman',
        'content' => 'From towering peaks to endless desert wadis, a journey carved through landscapes older than time itself.'
    ],
    'srilanka' => [
        'name' => 'Sri Lanka',
        'theme' => 'Serendipity',
        'hero_image' => 'assets/images/homepage/srilanka_drive_idea_hp.png',
        'url' => 'srilanka',
        'content' => 'An island of unexpected wonders, lush mountains, coastal calm, and roads that reveal magic at every turn.'
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Jebel Wadi',
        'hero_image' => 'assets/images/homepage/oman_drive_ideas_hp.png',
        'background_image' => 'assets/images/homepage/srilanka_memories_hp.png',
        'url' => 'oman',
        'content' => 'Golden dunes, hidden wadis, and timeless silence — a desert drive that feels both surreal and sacred.'
    ],
    'russia_artic' => [
        'name' => 'Russia',
        'theme' => 'Arctic Affair',
        'hero_image' => 'assets/images/homepage/russia_artic_drive_idea_hp.png',
        'url' => 'russia-artic',
        'content' => 'Chasing frozen horizons and northern lights, an affair with the Arctic you’ll never forget.'
    ],
    'russia_luxe_corridor' => [
        'name' => 'Russia',
        'theme' => 'Luxe Corridor',
        'hero_image' => 'assets/images/homepage/russia_luxe_drive_idea_hp.png',
        'url' => 'russia-luxe',
        'content' => 'A regal passage through Russia’s cultural crown, elegance, history, and grandeur woven into every mile.',
    ]
];
uasort($drive_ideas, fn($a, $b) => strcasecmp($a['name'], $b['name']));
$memories = [
    [
        'name' => 'Russia',
        'img_url' => 'assets/images/homepage/russia_Artic_memories_hp.png',
        'url' => 'russia-artic/memories',
    ],
    [
        'name' => 'Russia',
        'img_url' => 'assets/images/homepage/russia_memories_hp.png',
        'url' => 'russia-luxe/memories',
    ],
    [
        'name' => 'Srilanka',
        'img_url' => 'assets/images/homepage/srilanka_memories_hp.png',
        'url' => 'srilanka/memories',
    ],
    [
        'name' => 'Scotland',
        'img_url' => 'assets/images/homepage/scotland_memories_hp.png',
        'url' => 'scotland/memories',
    ],
    [
        'name' => 'UAE & Oman',
        'img_url' => 'assets/images/homepage/uae_oman_memories_hp.png',
        'url' => 'uae-oman/memories',
    ],
    [
        'name' => 'Oman',
        'img_url' => 'assets/images/homepage/oman_memories_hp.png',
        'url' => 'oman/memories',
    ],
    [
        'name' => 'Ireland',
        'img_url' => 'assets/images/homepage/ireland_memories_hp.png',
        'url' => 'ireland/memories',
    ],
    [
        'name' => 'Norway',
        'img_url' => 'assets/images/homepage/norway__memories_hp.png',
        'url' => 'norway/memories',
    ],
    [
        'name' => 'Poland',
        'img_url' => 'assets/images/homepage/poland_memories_hp.png',
        'url' => 'poland/memories',
    ],
];
uasort($memories, fn($a, $b) => strcasecmp($a['name'], $b['name']));

?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-background">
        <video class="hero-video" autoplay loop muted playsinline>
            <source src="assets/video/homepage/homepage_banner_hero_mobile_video.webm" type="video/webm" media="(max-width: 767px)">
            <source src="assets/video/homepage/homepage_banner_hero_video.webm" type="video/webm" media="(min-width: 768px)">
        </video>
        <!-- <img src="assets/images/homepage/banner-image.png" alt="Scenic mountain bridge landscape" class="hero-image" loading="eager" fetchpriority="high"> -->
    </div>
    <!-- <div class="hero-overlay"></div> -->
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-eyebrow">DriveOffGrid</h1>
            <h2 class="hero-title">where luxury meets the open road</h2>
        </div>
    </div>

    <button class="hero-video-control muted" id="heroVideoControl" aria-label="Toggle video sound">
        <svg class="video-control-icon video-control-icon-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 5L6 9H2v6h4l5 4V5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <line x1="2" y1="2" x2="22" y2="22" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <svg class="video-control-icon video-control-icon-unmuted" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 5L6 9H2v6h4l5 4V5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
</section>

<!-- How It Works Section -->
<section class="proposition">
    <div class="proposition-background">
        <img src="assets/images/homepage/how_it_works_bg.png" alt="Mountain landscape" class="proposition-image" loading="lazy">
    </div>
    <div class="container">
        <div class="proposition-content">
            <h2 class="proposition-title section-title">HOW IT WORKS</h2>
            <div class="proposition-card">
                <p class="card-text">
                Every DriveOffGrid journey begins with you. Your people, your pace, your destination. We don’t offer fixed itineraries, we craft bespoke self-drive expeditions shaped entirely around how you want to travel.
                </p>
                <!-- <p class="card-text">
                    Every expedition is personally led by us, the co-founders, no delegation, no outsourcing. We create experiences where travelers rediscover themselves behind the wheel, exploring places far removed from the ordinary tourist circuit.
                </p> -->
                <p class="card-text">The experience unfolds through <span class="card-ethos">four simple, thoughtful steps.</span></p>
                <a href="how-it-works" class="btn btn-read-more">READ MORE</a>
            </div>
        </div>
    </div>
</section>

<!-- Drive Ideas Section -->
<section class="destinations" id="destinations">
    <div class="container">
        <h2 class="section-title">DRIVE IDEAS</h2>
        <div class="destinations-slider-wrapper">
            <div class="destinations-slider">
                <?php
                foreach ($drive_ideas as $key => $drive_idea) {
                ?>
                    <a href="<?= $drive_idea['url'] ?>" class="destination-card-link">
                        <article class="destination-card">
                            <div class="destination-image">
                                <img src="<?= $drive_idea['hero_image'] ?>" alt="<?= $drive_idea['theme'] ?>" loading="lazy">
                            </div>
                            <div class="destination-overlay">
                                <div class="destination-content">
                                    <span class="destination-icon" aria-hidden="true"></span>
                                    <div class="destination-text">
                                        <h3 class="destination-theme"><?= $drive_idea['theme'] ?></h3>
                                        <p class="destination-country"><?= $drive_idea['name'] ?></p>
                                        <p class="destination-description"><?= $drive_idea['content'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </a>
                <?php
                } ?>
            </div>
            <div class="destinations-nav">
                <button class="dest-nav-arrow dest-nav-arrow-left" aria-label="Previous destination">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="dest-nav-arrow dest-nav-arrow-right" aria-label="Next destination">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Memories Section -->
<section class="memories" id="memories">
    <div class="container">
        <h2 class="memories-title section-title">MEMORIES</h2>
        <div class="memories-slider-wrapper">
            <div class="memories-slider">
                <?php
                foreach ($memories as $key => $memory) {
                ?>
                    <a href="<?= $memory['url'] ?>" class="memory-card-link">
                        <article class="memory-card">
                            <div class="memory-image">
                                <img src="<?= $memory['img_url'] ?>" alt="<?= $memory['name'] ?>" loading="lazy">
                            </div>
                            <div class="memory-label"><?= $memory['name'] ?></div>
                        </article>
                    </a>
                <?php
                }
                ?>
            </div>
            <div class="memories-nav">
                <button class="mem-nav-arrow mem-nav-arrow-left" aria-label="Previous memory">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="mem-nav-arrow mem-nav-arrow-right" aria-label="Next memory">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Plan Journey Section -->
<section class="plan-journey" id="book-tour">
    <div class="plan-journey-background">
        <img src="assets/images/homepage/conttact_us_hp.jpg" alt="Mountain lake landscape" class="plan-journey-image" loading="lazy">
    </div>
    <div class="container plan-journey-container">
        <div class="plan-journey-content">
            <div class="plan-journey-panel">
                <h2 class="plan-journey-title">Let's plan <span class="highlight">your next journey</span></h2>
                <div class="plan-journey-cta">
                    <a href="contact_us" class="btn btn-primary journey-cta-btn">REACH OUT</a>
                </div>
                <!-- <div class="plan-journey-contact-info">
                    <div class="plan-contact-card">
                        <div class="plan-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3>Visit Us</h3>
                        <p>C-20, G Block, Near MCA<br>Bandra Kurla Complex, Bandra (East)<br>Mumbai - 400051</p>
                    </div>
                    <div class="plan-contact-card">
                        <div class="plan-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7292C21.7209 20.9841 21.5573 21.2126 21.3518 21.3999C21.1463 21.5872 20.9033 21.7293 20.6391 21.8167C20.3749 21.9041 20.0955 21.9351 19.82 21.9077C16.7428 21.4986 13.787 20.4471 11.19 18.8377C8.77382 17.4017 6.72533 15.3522 5.29001 12.935C3.67995 10.3373 2.62824 7.38031 2.22 4.302C2.19262 4.02659 2.22364 3.74726 2.31101 3.48319C2.39838 3.21912 2.54038 2.97626 2.72764 2.77089C2.9149 2.56552 3.14337 2.40208 3.39831 2.29064C3.65325 2.1792 3.92892 2.12228 4.20732 2.12345H7.20732C7.68197 2.12054 8.13755 2.30657 8.47732 2.64345C8.81709 2.98033 9.01526 3.44312 9.02732 3.92745C9.17244 5.05919 9.45672 6.16981 9.87232 7.23245C10.0079 7.60364 10.0761 8.00018 10.0723 8.39945C10.0685 8.79872 9.9929 9.19359 9.84932 9.56245L8.38932 12.9525C10.1019 15.6252 12.3748 17.8981 15.0473 19.6105L18.4373 18.1505C18.8062 18.0069 19.201 17.9313 19.6003 17.9275C19.9996 17.9237 20.3961 17.9919 20.7673 18.1275C21.8299 18.5431 22.9405 18.8274 24.0723 18.9725C24.5582 18.9845 25.0224 19.1832 25.3603 19.5235C25.6982 19.8638 25.8842 20.3208 25.8803 20.7975L22.8803 20.7975" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3>Call Us</h3>
                        <p><a href="tel:+919323167788">+91-9323167788</a></p>
                    </div>
                    <div class="plan-contact-card">
                        <div class="plan-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3>Email Us</h3>
                        <p><a href="mailto:hello@driveoffgrid.com">hello@driveoffgrid.com</a></p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="testimonials-header">
            <h2 class="testimonials-title">WHAT GUESTS SAY</h2>
            <div class="testimonials-nav-wrapper">
                <div class="testimonials-nav">
                    <button class="nav-arrow nav-arrow-left" aria-label="Previous testimonial">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="nav-arrow nav-arrow-right" aria-label="Next testimonial">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <p class="testimonials-nav-text">Next Slide Page</p>
            </div>
        </div>

        <div class="testimonials-slider-wrapper">
            <div class="testimonials-slider">
                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/amit-testimonials.webp'); ?>" alt="Amit" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                        The driving experience was just brilliant. I had no idea that the countryside in Oman
                        was so beautiful. I would never have explored these on my own. Looking forward to the
                        next one!</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Amit</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/anubhav-testimonials.jpg'); ?>" alt="Anubhav" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                        The most luxurious trip I have ever been on yet. I still can’t believe I had dinner at a
                        Michelin star restaurant.</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Anubhav</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                    <img src="<?php echo url_path('assets/images/homepage/shikha-testimonials.webp'); ?>" alt="Shikha" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                        The routes that were selected were outstanding. We got to see new landscapes every day.
                        Loved it!</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Shikha</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/chhavi-testimonials.webp'); ?>" alt="Chhavi" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                        I really enjoyed the fact that we travelled in a convoy of life-minded adventurers who
                        were all game to experience this off-grid driving trip. Can’t wait for the next
                        trip!</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Chhavi</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/ashwini-testimonials.webp'); ?>" alt="Ashwini" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                        The planning and preparation were exemplary. No 2 days were same in terms of roads or
                        terrains.</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Ashwini</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/mickey-testimonials.jpg'); ?>" alt="Mickey" loading="lazy">
                    </div>
                    <p class="testimonial-text">

                        The trip was really luxury, the spots, the hotels, the lunch, dinner was excellent. In
                        our wildest dreams, we would never have thought of going to such places.</p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Mickey</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/manjul-testimonials.jpg'); ?>" alt="Manjul" loading="lazy">
                    </div>
                    <p class="testimonial-text">

                        Very honestly, the places which you chose for a night stays were amazing. The best.
                        Somehow wo ye lagta hai ki kahin kuchh kam karke kuchh stay badha dete, but wo kam kya
                        karen wo dikkat hai, as they were all amazing and won’t want to miss any of the
                        locations.

                    </p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Manjul</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>
                
                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/sujata-testimonials.webp'); ?>" alt="Sujata" loading="lazy">
                    </div>
                    <p class="testimonial-text">

                    What a fantastic experience it was! I love this trip, thank you so much!
                                

                    </p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Sujata</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>
                
                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/sonum-testimonial.jpg'); ?>" alt="Sonum" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                    Very professional and believe me, the most friendliest professionals. Yeah, it was like
                                a family vacation. Believe me, dil se sabke saath connect!!!      
                    </p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Sonum</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>
                
                <article class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="<?php echo url_path('assets/images/homepage/farzad-testimonials.jpg'); ?>" alt="Farzad" loading="lazy">
                    </div>
                    <p class="testimonial-text">
                    
                    Never ever thought that there were such places where you could drive vehicles. That was
                                amazing! The ups and downs, the curves, parking on the side for the other opposite
                                vehicle to pass by us was like amazing.
                                 
                    </p>
                    <div class="testimonial-meta">
                        <span class="testimonial-name">Farzad</span>
                        <div class="testimonial-rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Who Are We Section -->
<section class="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2 class="about-heading">WHO WE ARE</h2>
                <p class="about-description">
                    <strong class="highlight-text">DriveOffGrid</strong> is led by two former career professionals who at the peak of their career, chose the open road over corner offices, individuals who swapped excel sheets for road maps, and suits and ties for khakis and bandanas.
                </p>
                <p class="about-description">
                They realised that their true passion didn't live in boardrooms or balance sheets. It lived behind the wheel, chasing horizons.
                </p>
                <p class="about-description">
                We're not in the business of sending people on vacations, we're in the business of taking them with us.
                </p>
                <p class="about-description">
                Every DriveOffGrid expedition is personally led by the co-founders. We don't delegate the experience. We live it. If it's not something we'd love to do ourselves, it never makes it to the itinerary.

                </p>
                <p class="about-description">
                This isn't just a travel company, it's a way of life. And when you drive with us, you're not just a guest. <strong class="highlight-text">You're part of our convoy. Part of our story.</strong>
                </p>
                <a href="who-we-are" style="display: block; margin-top: 2rem;">
                <button class="btn btn-reach-out" style="display: block; margin: auto;">Read more</button>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>