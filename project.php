<?php
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$project = getProjectBySlug($slug);

if (!$project) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><head><title>404</title></head><body><h1>Project not found</h1><a href="index.php">Back to home</a></body></html>';
    exit;
}

$isProjectPage = true;
$siteContent = getAllSiteContent();
$mediaGroups = getGroupedMedia($project['id']);
$adjacent = getAdjacentProjects($project['display_order']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($project['name']) ?> — 11H16</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wdth,wght@8..144,25..151,100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="project.css">
</head>
<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <section class="proj-hero">
        <div class="proj-hero-content">
            <h1 class="proj-hero-title"><?= $project['title_html'] ?></h1>
            <div class="proj-hero-meta">
                <div class="proj-hero-detail"><span class="proj-hero-label">Client</span><span class="proj-hero-value"><?= e($project['client']) ?></span></div>
                <div class="proj-hero-detail"><span class="proj-hero-label">Type</span><span class="proj-hero-value"><?= e($project['type']) ?></span></div>
                <div class="proj-hero-detail"><span class="proj-hero-label">Year</span><span class="proj-hero-value"><?= $project['year'] ?></span></div>
            </div>
        </div>
    </section>

    <section class="proj-media">
        <?php foreach ($mediaGroups as $group => $items):
            $layout = $items[0]['layout'];

            if ($layout === 'full'):
                $m = $items[0]; ?>
                <div class="proj-media-full">
                    <?php if ($m['type'] === 'video'): ?>
                        <video autoplay muted loop playsinline>
                            <source src="<?= e($m['file_path']) ?>" type="video/mp4">
                        </video>
                    <?php else: ?>
                        <img src="<?= e($m['file_path']) ?>" alt="<?= e($m['alt_text']) ?>" loading="lazy">
                    <?php endif; ?>
                </div>
            <?php else:
                $gridClass = $layout === 'grid-1' ? ' grid-1' : ($layout === 'grid-3' ? ' grid-3' : '');
            ?>
                <div class="proj-media-grid<?= $gridClass ?>">
                    <?php foreach ($items as $m): ?>
                    <div class="proj-media-item">
                        <?php if ($m['type'] === 'video'): ?>
                            <video autoplay muted loop playsinline>
                                <source src="<?= e($m['file_path']) ?>" type="video/mp4">
                            </video>
                        <?php else: ?>
                            <img src="<?= e($m['file_path']) ?>" alt="<?= e($m['alt_text']) ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif;
        endforeach; ?>
    </section>

    <nav class="proj-nav">
        <?php if ($adjacent['prev']): ?>
        <a href="project.php?slug=<?= e($adjacent['prev']['slug']) ?>" class="proj-nav-link proj-nav-prev">
            <span class="proj-nav-label">Previous</span>
            <span class="proj-nav-name"><?= e($adjacent['prev']['name']) ?></span>
        </a>
        <?php endif; ?>
        <?php if ($adjacent['next']): ?>
        <a href="project.php?slug=<?= e($adjacent['next']['slug']) ?>" class="proj-nav-link proj-nav-next">
            <span class="proj-nav-label">Next</span>
            <span class="proj-nav-name"><?= e($adjacent['next']['name']) ?></span>
        </a>
        <?php endif; ?>
    </nav>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
