<?php
/**
 * One-time update: adds show_on_site column + 29 new book projects.
 * Run once, then delete this file.
 */
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$out = '';

// 1. Add show_on_site column if missing
try {
    $db->exec('ALTER TABLE projects ADD COLUMN show_on_site TINYINT(1) DEFAULT 0');
    $out .= "Column show_on_site added.<br>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        $out .= "Column show_on_site already exists.<br>";
    } else {
        $out .= "Error: " . $e->getMessage() . "<br>";
    }
}

// 2. Add preview_video column if missing
try {
    $db->exec('ALTER TABLE projects ADD COLUMN preview_video VARCHAR(255) DEFAULT NULL');
    $out .= "Column preview_video added.<br>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        $out .= "Column preview_video already exists.<br>";
    } else {
        $out .= "Error: " . $e->getMessage() . "<br>";
    }
}

// 3. Set existing 13 projects as visible on site
$db->exec('UPDATE projects SET show_on_site = 1');
$out .= "Existing projects set to show_on_site = 1.<br>";

// 4. Add preview_video to existing projects
$previews = [
    'almajed' => 'assets/projects/almajed_film.mp4',
    'bucherer' => 'assets/projects/bucherer_film.mp4',
    'marc-jacobs' => 'assets/projects/marcjacobs_film.mp4',
    'gucci' => 'assets/projects/gucci_film.mp4',
    'coperni' => 'assets/projects/coperni_film.mp4',
    'jhag' => 'assets/projects/jhag_film.mp4',
    'eleven-sixtine' => 'assets/projects/eleven_sixtine_film.mp4',
    'musee' => 'assets/projects/musee_film.mp4',
    'poche' => 'assets/projects/poche_film.mp4',
    'viktor-rolf' => 'assets/projects/viktorrolf_film.mp4',
    'valentino' => 'assets/projects/valentino_film.mp4',
];
$stmtPV = $db->prepare('UPDATE projects SET preview_video = ? WHERE slug = ?');
foreach ($previews as $slug => $video) {
    $stmtPV->execute([$video, $slug]);
}
$out .= "Preview videos updated.<br>";

// 5. Add 29 new book projects (skip if already exist)
$newProjects = [
    ['slug'=>'givenchy-ri', 'name'=>'Givenchy RI', 'title_html'=>'Givenchy<br>RI', 'client'=>'Givenchy', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/givenchy-ri_capture_1.jpg'],
    ['slug'=>'burberry', 'name'=>'Burberry', 'title_html'=>'Burberry', 'client'=>'Burberry', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/burberry_capture_1.jpg'],
    ['slug'=>'dior', 'name'=>'Dior', 'title_html'=>'Dior', 'client'=>'Dior', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/dior_capture_1.jpg'],
    ['slug'=>'cartier', 'name'=>'Cartier', 'title_html'=>'Cartier', 'client'=>'Cartier', 'type'=>'Film', 'year'=>2026, 'thumbnail'=>'assets/projects/burberry_capture_1.jpg'],
    ['slug'=>'louboutin', 'name'=>'Louboutin', 'title_html'=>'Louboutin', 'client'=>'Louboutin', 'type'=>'Campagne & Édito', 'year'=>2026, 'thumbnail'=>'assets/projects/louboutin_kv_1.jpg'],
    ['slug'=>'diesel', 'name'=>'Diesel', 'title_html'=>'Diesel', 'client'=>'Diesel', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/diesel_kv_1.png'],
    ['slug'=>'byredo', 'name'=>'Byredo', 'title_html'=>'Byredo', 'client'=>'Byredo', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/byredo_capture_1.jpg'],
    ['slug'=>'dom-perignon', 'name'=>'Dom Pérignon', 'title_html'=>'Dom<br>Pérignon', 'client'=>'Dom Pérignon', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/dom-perignon_kv_1.jpg'],
    ['slug'=>'la-colline', 'name'=>'La Colline', 'title_html'=>'La Colline', 'client'=>'La Colline', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/la-colline_kv_1.png'],
    ['slug'=>'hajar', 'name'=>'Hajar', 'title_html'=>'Hajar', 'client'=>'Hajar', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/hajar_kv_1.png'],
    ['slug'=>'paulas-choice', 'name'=>'Paula\'s Choice', 'title_html'=>'Paula\'s<br>Choice', 'client'=>'Paula\'s Choice', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/paulas-choice_capture_1.jpg'],
    ['slug'=>'rimowa', 'name'=>'Rimowa', 'title_html'=>'Rimowa', 'client'=>'Rimowa', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/rimowa_capture_1.jpg'],
    ['slug'=>'staud', 'name'=>'Staud', 'title_html'=>'Staud', 'client'=>'Staud', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/staud_kv_1.jpg'],
    ['slug'=>'maitrepierre', 'name'=>'Maitrepierre', 'title_html'=>'Maitrepierre', 'client'=>'Maitrepierre', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/maitrepierre_capture_1.jpg'],
    ['slug'=>'mini', 'name'=>'Mini', 'title_html'=>'Mini', 'client'=>'Mini', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/mini_kv_1.png'],
    ['slug'=>'fortnite', 'name'=>'Fortnite', 'title_html'=>'Fortnite', 'client'=>'Epic Games', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/fortnite_kv_1.jpg'],
    ['slug'=>'gymshark', 'name'=>'Gymshark', 'title_html'=>'Gymshark', 'client'=>'Gymshark', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/gymshark_capture_1.jpg'],
    ['slug'=>'adidas', 'name'=>'Adidas', 'title_html'=>'Adidas', 'client'=>'Adidas', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/adidas_capture_1.jpg'],
    ['slug'=>'red-bull', 'name'=>'Red Bull', 'title_html'=>'Red Bull', 'client'=>'Red Bull', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/red-bull_capture_1.jpg'],
    ['slug'=>'wilson', 'name'=>'Wilson', 'title_html'=>'Wilson', 'client'=>'Wilson', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/wilson_capture_1.jpg'],
    ['slug'=>'decathlon', 'name'=>'Decathlon', 'title_html'=>'Decathlon', 'client'=>'Decathlon', 'type'=>'Film', 'year'=>2026, 'thumbnail'=>'assets/projects/decathlon_capture_1.jpg'],
    ['slug'=>'chivas', 'name'=>'Chivas', 'title_html'=>'Chivas', 'client'=>'Chivas', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/chivas_kv_1.jpg'],
    ['slug'=>'remy-martin', 'name'=>'Rémy Martin', 'title_html'=>'Rémy<br>Martin', 'client'=>'Rémy Martin', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/remy-martin_capture_1.jpg'],
    ['slug'=>'ace-club', 'name'=>'Ace Club', 'title_html'=>'Ace Club', 'client'=>'Ace Club', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/ace-club_capture_1.jpg'],
    ['slug'=>'martin-solveig', 'name'=>'Martin Solveig', 'title_html'=>'Martin<br>Solveig', 'client'=>'Martin Solveig', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/martin-solveig_capture_1.jpg'],
    ['slug'=>'aamour-ocean', 'name'=>'Aamour Océan', 'title_html'=>'Aamour<br>Océan', 'client'=>'Aamour Océan', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/aamour-ocean_capture_1.jpg'],
    ['slug'=>'wsn', 'name'=>'WSN', 'title_html'=>'WSN', 'client'=>'WSN', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/wsn_capture_1.jpg'],
    ['slug'=>'rhyme', 'name'=>'Rhyme', 'title_html'=>'Rhyme', 'client'=>'Rhyme', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/rhyme_kv_1.png'],
    ['slug'=>'playground', 'name'=>'Playground', 'title_html'=>'Playground', 'client'=>'11H16', 'type'=>'Direction Artistique', 'year'=>2026, 'thumbnail'=>'assets/projects/playground_kv_1.png'],
];

$maxOrder = $db->query('SELECT COALESCE(MAX(display_order), 0) FROM projects')->fetchColumn();
$stmtInsert = $db->prepare('INSERT IGNORE INTO projects (slug, name, title_html, client, type, year, thumbnail, is_wide, display_order, is_hero, hero_video, preview_video, show_on_site) VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, 0, NULL, NULL, 0)');

$added = 0;
foreach ($newProjects as $p) {
    $maxOrder++;
    $stmtInsert->execute([$p['slug'], $p['name'], $p['title_html'], $p['client'], $p['type'], $p['year'], $p['thumbnail'], $maxOrder]);
    if ($stmtInsert->rowCount() > 0) $added++;
}

$out .= "$added new projects added.<br>";

// 6. Update site content with new texts
$contentUpdates = [
    'hero_line_1' => 'CREATING FOR',
    'hero_line_2' => 'TOMORROW WITH',
    'hero_line_3' => 'TOOLS OF TODAY',
    'hero_desc' => "Creative CGI Studio,\nIn House Creativity.",
    'splash_line_1' => 'CREATING FOR',
    'splash_line_2' => 'TOMORROW WITH',
    'splash_line_3' => 'TOOLS OF TODAY',
    'splash_sub' => 'CREATIVE CGI STUDIO',
    'about_title_1' => 'IN HOUSE',
    'about_title_2' => 'HUMAN',
    'about_title_3' => 'CREATIVITY',
];
foreach ($contentUpdates as $key => $value) {
    setSiteContent($key, $value);
}
$out .= "Site content updated.<br>";

echo "<h2>Update complete</h2>$out";
echo '<br><a href="admin/">Go to admin</a> | <a href="index.php">View site</a>';
echo '<br><em>Delete this file (update.php) now.</em>';
