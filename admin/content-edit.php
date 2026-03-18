<?php require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    foreach ($_POST as $key => $value) {
        if ($key === 'csrf_token') continue;
        setSiteContent($key, $value);
    }
    header('Location: content-edit.php?msg=saved');
    exit;
}

$content = getAllSiteContent();
$c = function($key, $default = '') use ($content) {
    return $content[$key] ?? $default;
};

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Content — 11H16 Admin</title>
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
                <a href="content-edit.php" class="active">Site Content</a>
                <div class="nav-sep"></div>
                <a href="../" target="_blank">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>
        <main class="admin-main">
            <div class="admin-header">
                <h1>Site Content</h1>
            </div>

            <?php if ($msg === 'saved'): ?><div class="alert alert-success">Content saved.</div><?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

                <div class="card">
                    <h3>Hero Section</h3>
                    <div class="form-row-3">
                        <div>
                            <label>Line 1</label>
                            <input type="text" name="hero_line_1" value="<?= e($c('hero_line_1', 'IN HOUSE')) ?>">
                        </div>
                        <div>
                            <label>Line 2</label>
                            <input type="text" name="hero_line_2" value="<?= e($c('hero_line_2', 'HUMAN')) ?>">
                        </div>
                        <div>
                            <label>Line 3</label>
                            <input type="text" name="hero_line_3" value="<?= e($c('hero_line_3', 'CREATIVITY')) ?>">
                        </div>
                    </div>
                    <label>Description</label>
                    <textarea name="hero_desc"><?= e($c('hero_desc', 'Creative CGI Studio, Creating for tomorrow with tools of today.')) ?></textarea>
                    <label>Tags</label>
                    <input type="text" name="hero_tags" value="<?= e($c('hero_tags', 'CGI. AI. VFX. Production. Creative Direction.')) ?>">
                </div>

                <div class="card">
                    <h3>About Section</h3>
                    <label>Title Line 1</label>
                    <input type="text" name="about_title_1" value="<?= e($c('about_title_1', 'WE CRAFT')) ?>">
                    <label>Title Line 2</label>
                    <input type="text" name="about_title_2" value="<?= e($c('about_title_2', 'BRANDS THAT')) ?>">
                    <label>Title Line 3 (outline)</label>
                    <input type="text" name="about_title_3" value="<?= e($c('about_title_3', 'MATTER')) ?>">

                    <label>Paragraph 1</label>
                    <textarea name="about_p1"><?= e($c('about_p1', 'At 11h16, creativity has no bounds...')) ?></textarea>
                    <label>Paragraph 2</label>
                    <textarea name="about_p2"><?= e($c('about_p2', 'We are a creative agency...')) ?></textarea>
                    <label>Paragraph 3</label>
                    <textarea name="about_p3"><?= e($c('about_p3', 'Our process is collaborative...')) ?></textarea>
                    <label>Paragraph 4</label>
                    <textarea name="about_p4"><?= e($c('about_p4', 'To meet real-world campaign demands...')) ?></textarea>
                </div>

                <div class="card">
                    <h3>Contact</h3>
                    <div class="form-row">
                        <div>
                            <label>Email</label>
                            <input type="email" name="contact_email" value="<?= e($c('contact_email', 'hello@11h16.studio')) ?>">
                        </div>
                        <div>
                            <label>Address</label>
                            <input type="text" name="contact_address" value="<?= e($c('contact_address', '11H16 Studio — Paris, France')) ?>">
                        </div>
                    </div>
                    <div class="form-row-3">
                        <div>
                            <label>Instagram URL</label>
                            <input type="text" name="instagram_url" value="<?= e($c('instagram_url', '#')) ?>">
                        </div>
                        <div>
                            <label>LinkedIn URL</label>
                            <input type="text" name="linkedin_url" value="<?= e($c('linkedin_url', '#')) ?>">
                        </div>
                        <div>
                            <label>Behance URL</label>
                            <input type="text" name="behance_url" value="<?= e($c('behance_url', '#')) ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save All Content</button>
            </form>
        </main>
    </div>
</body>
</html>
