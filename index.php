<?php
require_once __DIR__ . '/includes/functions.php';

$isProjectPage = false;
$siteContent = getAllSiteContent();
$projects = getAllProjects();
$heroProjects = getHeroProjects();

$c = function($key, $default = '') use ($siteContent) {
    return $siteContent[$key] ?? $default;
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>11H16 — Creative Studio</title>
    <meta name="description" content="11H16 — Creative Studio based in Paris. In House Human Creativity.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wdth,wght@8..144,25..151,100..1000&family=Barlow+Condensed:wght@700&family=Bebas+Neue&&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Splash Screen -->
    <div class="splash" id="splash">
        <div class="splash-text">
            <span class="splash-word" style="--d:0"><?= e($c('splash_line_1', 'CREATING FOR')) ?></span>
            <span class="splash-word" style="--d:1"><?= e($c('splash_line_2', 'TOMORROW WITH')) ?></span>
            <span class="splash-word" style="--d:2"><?= e($c('splash_line_3', 'TOOLS OF TODAY')) ?></span>
        </div>
        <div class="splash-sub"><?= e($c('splash_sub', 'CREATIVE CGI STUDIO')) ?></div>
    </div>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Hero -->
    <section class="hero">
        <?php foreach ($heroProjects as $i => $hp): ?>
        <video class="hero-video <?= $i === 0 ? 'active' : '' ?>" <?= $i === 0 ? 'autoplay' : '' ?> muted loop playsinline data-project="<?= e($hp['name']) ?>">
            <source src="<?= e($hp['hero_video']) ?>" type="video/mp4">
        </video>
        <?php endforeach; ?>
        <div class="hero-text">
            <div class="hero-line"><span class="hero-word" style="--d:0"><?= e($c('hero_line_1', 'CREATING FOR')) ?></span></div>
            <div class="hero-line"><span class="hero-word" style="--d:1"><?= e($c('hero_line_2', 'TOMORROW WITH')) ?></span></div>
            <div class="hero-line"><span class="hero-word" style="--d:2"><?= e($c('hero_line_3', 'TOOLS OF TODAY')) ?></span></div>
        </div>
        <div class="hero-sub">
            <h1 class="hero-desc"><?= nl2br(e($c('hero_desc', "Creative CGI Studio,\nIn House Creativity."))) ?></h1>
            <p class="hero-tags"><?= e($c('hero_tags', 'CGI. AI. VFX. Production. Creative Direction.')) ?></p>
        </div>
        <div class="hero-progress">
            <span class="hero-progress-project"><?= !empty($heroProjects) ? e($heroProjects[0]['name']) : '' ?></span>
            <div class="hero-progress-bottom">
                <span class="hero-progress-count">01 / 0<?= count($heroProjects) ?></span>
                <div class="hero-progress-bar">
                    <div class="hero-progress-fill"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects -->
    <section class="section section-projects" id="projects">
        <div class="sec-head">
            <h2 class="sec-title reveal">Selected<br>Work</h2>
            <span class="sec-count reveal">(<?= str_pad(count($projects), 2, '0', STR_PAD_LEFT) ?>)</span>
        </div>
        <div class="proj-grid">
            <?php foreach ($projects as $i => $p): ?>
            <a href="project.php?slug=<?= e($p['slug']) ?>" class="proj <?= $p['is_wide'] ? 'proj--wide' : '' ?> reveal" style="--i:<?= $i ?>">
                <div class="proj-img" style="background-image:url('<?= e($p['thumbnail']) ?>');"></div>
                <?php if (!empty($p['preview_video'])): ?>
                <video class="proj-video" muted loop playsinline preload="none" src="<?= e($p['preview_video']) ?>"></video>
                <?php endif; ?>
                <div class="proj-meta">
                    <span class="proj-name"><?= e($p['name']) ?></span>
                    <span class="proj-cat"><?= e($p['type']) ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- About -->
    <section class="section section-about" id="about">
        <div class="about-hero reveal">
            <h2 class="fat-title">
                <span><?= e($c('about_title_1', 'IN HOUSE')) ?></span>
                <span><?= e($c('about_title_2', 'HUMAN')) ?></span>
                <span class="fat-outline"><?= e($c('about_title_3', 'CREATIVITY')) ?></span>
            </h2>
        </div>
        <div class="about-body">
            <div class="about-text reveal">
                <?php for ($i = 1; $i <= 4; $i++):
                    $p = $c("about_p$i");
                    if ($p): ?>
                    <p><?= e($p) ?></p>
                <?php endif; endfor; ?>
            </div>
            <div class="about-services" id="services">
                <?php for ($i = 0; $i <= 10; $i++):
                    $svcJson = $c("svc_$i");
                    if (!$svcJson) continue;
                    $svc = json_decode($svcJson, true);
                    if (!$svc) continue;
                ?>
                <div class="svc reveal" style="--i:<?= $i ?>">
                    <span class="svc-title"><?= e($svc['title']) ?></span>
                    <div class="svc-details">
                        <?php foreach ($svc['items'] as $item): ?>
                        <span><?= e($item) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="section section-contact" id="contact">
        <h2 class="fat-title contact-title reveal">
            <span>LET'S</span>
            <span>TALK</span>
        </h2>
        <div class="contact-info reveal">
            <a href="mailto:<?= e($c('contact_email', 'hello@11h16.studio')) ?>" class="contact-email"><?= e($c('contact_email', 'hello@11h16.studio')) ?></a>
            <div class="contact-links">
                <a href="<?= e($c('instagram_url', '#')) ?>">Instagram</a>
                <a href="<?= e($c('linkedin_url', '#')) ?>">LinkedIn</a>
                <a href="<?= e($c('behance_url', '#')) ?>">Behance</a>
            </div>
            <p class="contact-addr"><?= e($c('contact_address', '11H16 Studio — Paris, France')) ?></p>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
