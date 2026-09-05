<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/drive_memories_data.php';

$page_title = 'Self-Drive Adventure Tour Destinations | Luxury Road Trips Worldwide';
$meta_description = 'Explore DriveOffGrid self-drive adventure destinations including Oman, UAE, Ireland, Scotland and Sri Lanka. Discover luxury 4x4 road trips and curated overland travel experiences.';
$meta_keywords = 'self drive tour destinations,luxury adventure destinations,off road adventure destinations,overland travel destinations,luxury road trip destinations,international self drive tours,Oman road trip,Ireland self drive tour,Scotland road trip,Sri Lanka self drive adventure';
include __DIR__ . '/includes/header.php';
?>
<style>
.destinations-listing-page .section-title { margin-bottom: 2rem; }
.destinations-listing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}
.destinations-listing-grid .destination-card-link { min-width: unset; }
</style>

<section class="destinations destinations-listing-page" id="destinations">
    <div class="container">
        <h1 class="section-title">DRIVE IDEAS</h1>
        <div class="destinations-listing-grid">
            <?php foreach ($drive_ideas as $drive_idea): ?>
                <a href="<?= htmlspecialchars(url_path('destinations/' . $drive_idea['url']), ENT_QUOTES, 'UTF-8') ?>" class="destination-card-link">
                    <article class="destination-card">
                        <div class="destination-image">
                            <img src="<?= get_image_path($drive_idea['hero_image']) ?>" alt="<?= htmlspecialchars($drive_idea['theme'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                        </div>
                        <div class="destination-overlay">
                            <div class="destination-content">
                                <span class="destination-icon" aria-hidden="true"></span>
                                <div class="destination-text">
                                    <h2 class="home-destination-theme destination-theme"><?= htmlspecialchars($drive_idea['theme'], ENT_QUOTES, 'UTF-8') ?></h2>
                                    <p class="destination-country"><?= htmlspecialchars($drive_idea['name'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p class="destination-description"><?= htmlspecialchars($drive_idea['content'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
