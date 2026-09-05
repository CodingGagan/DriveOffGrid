<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/drive_memories_data.php';

$page_title = 'Self-Drive Tour Gallery | Real Travel Moments';
$meta_description = 'Browse real moments from self-drive tours across Oman, UAE, Ireland, Scotland, Sri Lanka, Russia and Poland. See authentic journeys and travel experiences.';
$meta_keywords = 'travel gallery photos, real travel moments, road trip photo gallery, adventure journey images, scenic travel photography, curated travel visuals, journey highlights gallery, travel experience photos';
include __DIR__ . '/includes/header.php';
?>
<style>
.galleries-listing-page .section-title { margin-bottom: 2rem; }
.galleries-listing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}
.galleries-listing-grid .memory-card-link { display: block; }
.galleries-listing-grid .memory-card {
    flex: none;
    width: 100%;
    min-width: unset;
}
</style>

<section class="memories galleries-listing-page" id="galleries">
    <div class="container">
        <h1 class="memories-title section-title">MEMORIES</h1>
        <div class="galleries-listing-grid">
            <?php foreach ($memories as $memory): ?>
                <?php $gallery_slug = explode('/', $memory['url'])[0]; ?>
                <a href="<?= htmlspecialchars(url_path('galleries/' . $gallery_slug), ENT_QUOTES, 'UTF-8') ?>" class="memory-card-link">
                    <article class="memory-card">
                        <div class="memory-image">
                            <img src="<?= get_image_path($memory['img_url']) ?>" alt="<?= htmlspecialchars($memory['name'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                        </div>
                        <div class="memory-label"><?= htmlspecialchars($memory['name'], ENT_QUOTES, 'UTF-8') ?></div>
                    </article>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
