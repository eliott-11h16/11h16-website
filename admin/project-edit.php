<?php require_once 'auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = $id ? getProjectById($id) : null;
$media = $id ? getProjectMedia($id) : [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'slug' => trim($_POST['slug'] ?? ''),
        'title_html' => trim($_POST['title_html'] ?? ''),
        'client' => trim($_POST['client'] ?? ''),
        'type' => trim($_POST['type'] ?? ''),
        'year' => (int)($_POST['year'] ?? date('Y')),
        'is_wide' => isset($_POST['is_wide']) ? 1 : 0,
        'is_hero' => isset($_POST['is_hero']) ? 1 : 0,
        'show_on_site' => isset($_POST['show_on_site']) ? 1 : 0,
        'thumbnail' => $project['thumbnail'] ?? '',
        'hero_video' => $project['hero_video'] ?? null,
        'preview_video' => $project['preview_video'] ?? null,
    ];

    if (!$data['slug']) $data['slug'] = generateSlug($data['name']);
    if (!$data['title_html']) $data['title_html'] = $data['name'];

    // Handle thumbnail upload
    if (!empty($_FILES['thumbnail']['name'])) {
        $path = uploadFile($_FILES['thumbnail'], $data['slug'] . '_thumb');
        if ($path) $data['thumbnail'] = $path;
    }

    // Handle hero video upload
    if (!empty($_FILES['hero_video']['name'])) {
        $path = uploadFile($_FILES['hero_video'], $data['slug'] . '_hero');
        if ($path) $data['hero_video'] = $path;
    }

    // Handle preview video upload
    if (!empty($_FILES['preview_video']['name'])) {
        $path = uploadFile($_FILES['preview_video'], $data['slug'] . '_preview');
        if ($path) $data['preview_video'] = $path;
    }

    if (empty($data['name'])) {
        $error = 'Project name is required.';
    } else {
        $id = saveProject($data, $id ?: null);
        header('Location: project-edit.php?id=' . $id . '&msg=saved');
        exit;
    }
}

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $project ? 'Edit' : 'New' ?> Project — 11H16 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wdth,wght@8..144,25..151,100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-wrap">
        <aside class="admin-sidebar">
            <h2>11H16</h2>
            <nav class="admin-nav">
                <a href="index.php">Projects</a>
                <a href="content-edit.php">Site Content</a>
                <div class="nav-sep"></div>
                <a href="../" target="_blank">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>
        <main class="admin-main">
            <div class="admin-header">
                <h1><?= $project ? 'Edit: ' . e($project['name']) : 'New Project' ?></h1>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>

            <?php if ($msg === 'saved'): ?><div class="alert alert-success">Project saved.</div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

            <div class="card">
                <h3>Project Info</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

                    <div class="form-row">
                        <div>
                            <label>Project Name</label>
                            <input type="text" name="name" value="<?= e($project['name'] ?? '') ?>" required>
                        </div>
                        <div>
                            <label>Slug (URL)</label>
                            <input type="text" name="slug" value="<?= e($project['slug'] ?? '') ?>" placeholder="auto-generated">
                        </div>
                    </div>

                    <label>Title HTML (for display, use &lt;br&gt; for line breaks)</label>
                    <input type="text" name="title_html" value="<?= e($project['title_html'] ?? '') ?>" placeholder="Bucherer<br>Noël">

                    <div class="form-row-3">
                        <div>
                            <label>Client</label>
                            <input type="text" name="client" value="<?= e($project['client'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Type</label>
                            <input type="text" name="type" value="<?= e($project['type'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Year</label>
                            <input type="number" name="year" value="<?= e($project['year'] ?? date('Y')) ?>">
                        </div>
                    </div>

                    <label>Thumbnail (for project grid)</label>
                    <?php if (!empty($project['thumbnail'])): ?>
                        <p style="margin-bottom:8px"><img src="../<?= e($project['thumbnail']) ?>" style="max-height:80px;border-radius:4px"></p>
                    <?php endif; ?>
                    <input type="file" name="thumbnail" accept="image/*">

                    <div class="checkbox-row">
                        <input type="checkbox" name="is_wide" id="isWide" <?= !empty($project['is_wide']) ? 'checked' : '' ?>>
                        <label for="isWide">Wide layout in project grid</label>
                    </div>

                    <div class="checkbox-row">
                        <input type="checkbox" name="show_on_site" id="showOnSite" <?= !empty($project['show_on_site']) ? 'checked' : '' ?>>
                        <label for="showOnSite">Visible on website</label>
                    </div>

                    <div class="checkbox-row">
                        <input type="checkbox" name="is_hero" id="isHero" <?= !empty($project['is_hero']) ? 'checked' : '' ?>>
                        <label for="isHero">Show in hero carousel</label>
                    </div>

                    <label>Hero Video (for homepage carousel)</label>
                    <?php if (!empty($project['hero_video'])): ?>
                        <p style="margin-bottom:8px;color:var(--admin-muted);font-size:12px">Current: <?= e($project['hero_video']) ?></p>
                    <?php endif; ?>
                    <input type="file" name="hero_video" accept="video/*">

                    <label>Preview Video (hover on project grid)</label>
                    <?php if (!empty($project['preview_video'])): ?>
                        <p style="margin-bottom:8px;color:var(--admin-muted);font-size:12px">Current: <?= e($project['preview_video']) ?></p>
                    <?php endif; ?>
                    <input type="file" name="preview_video" accept="video/*">

                    <div style="margin-top:24px">
                        <button type="submit" class="btn btn-primary">Save Project</button>
                    </div>
                </form>
            </div>

            <?php if ($project): ?>
            <div class="card">
                <h3>Media</h3>
                <div class="media-list" id="mediaList">
                    <?php foreach ($media as $m): ?>
                    <div class="media-item" data-id="<?= $m['id'] ?>">
                        <?php if ($m['type'] === 'video'): ?>
                            <video src="../<?= e($m['file_path']) ?>" muted></video>
                        <?php else: ?>
                            <img src="../<?= e($m['file_path']) ?>" alt="<?= e($m['alt_text']) ?>">
                        <?php endif; ?>
                        <div class="media-item-actions">
                            <select onchange="updateMediaLayout(<?= $m['id'] ?>, this.value)">
                                <option value="full" <?= $m['layout']==='full'?'selected':'' ?>>Full</option>
                                <option value="grid-1" <?= $m['layout']==='grid-1'?'selected':'' ?>>1 col</option>
                                <option value="grid-2" <?= $m['layout']==='grid-2'?'selected':'' ?>>2 col</option>
                                <option value="grid-3" <?= $m['layout']==='grid-3'?'selected':'' ?>>3 col</option>
                            </select>
                            <button class="btn btn-danger btn-sm" onclick="deleteMediaItem(<?= $m['id'] ?>)">X</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="upload-area" onclick="document.getElementById('mediaUpload').click()">
                    <p>Click to upload images or videos</p>
                    <input type="file" id="mediaUpload" multiple accept="image/*,video/*" onchange="uploadMedia(this.files, <?= $project['id'] ?>)">
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    <script src="admin.js"></script>
</body>
</html>
