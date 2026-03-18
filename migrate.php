<?php
/**
 * One-time migration script to populate the database with existing project data.
 * Run AFTER install.php. Delete after use.
 */
require_once __DIR__ . '/includes/functions.php';

$db = getDB();

// ─── Projects ─────────────────────────────────
$projects = [
    // ─── 13 projets du site (show_on_site = 1) ───
    ['slug'=>'almajed', 'name'=>'Almajed Boisée', 'title_html'=>'Almajed<br>Boisée', 'client'=>'Almajed', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/ALMAJED_BOISEE_KV_4_16x9_V1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/almajed_film.mp4', 'show_on_site'=>1],
    ['slug'=>'bucherer', 'name'=>'Bucherer Noël', 'title_html'=>'Bucherer<br>Noël', 'client'=>'Bucherer', 'type'=>'Campagne & Capsules', 'year'=>2026, 'thumbnail'=>'assets/projects/BUCHERER_NOEL_KV_RINGS_VERTICAL_V1.jpg', 'is_wide'=>0, 'is_hero'=>1, 'hero_video'=>'assets/projects/bucherer_film.mp4', 'preview_video'=>'assets/projects/bucherer_film.mp4', 'show_on_site'=>1],
    ['slug'=>'marc-jacobs', 'name'=>'Marc Jacobs Daisy', 'title_html'=>'Marc Jacobs<br>Daisy', 'client'=>'Marc Jacobs', 'type'=>'Film & Direction Artistique', 'year'=>2026, 'thumbnail'=>'assets/projects/MARC_JACOBS_DAISY_CAPTURE_3_16x9_V1.jpg', 'is_wide'=>1, 'is_hero'=>1, 'hero_video'=>'assets/projects/marcjacobs_film.mp4', 'preview_video'=>'assets/projects/marcjacobs_film.mp4', 'show_on_site'=>1],
    ['slug'=>'gucci', 'name'=>'Gucci', 'title_html'=>'Gucci', 'client'=>'Gucci', 'type'=>'Capture & Film', 'year'=>2026, 'thumbnail'=>'assets/projects/GUCCI_RD_CAPTURE_3_17x24_V1.jpg', 'is_wide'=>0, 'is_hero'=>1, 'hero_video'=>'assets/projects/gucci_film.mp4', 'preview_video'=>'assets/projects/gucci_film.mp4', 'show_on_site'=>1],
    ['slug'=>'coperni', 'name'=>'Coperni Foot Print', 'title_html'=>'Coperni<br>Foot Print', 'client'=>'Coperni', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/COPERNI_KV_2.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/coperni_film.mp4', 'show_on_site'=>1],
    ['slug'=>'dr-jart', 'name'=>'Dr. Jart+', 'title_html'=>'Dr. Jart+<br>Skincare', 'client'=>'Dr. Jart+', 'type'=>'Key Visuals Skincare', 'year'=>2026, 'thumbnail'=>'assets/projects/DR_JART_SKIN_KV_01-Korean_Skincare_16x9_V1.jpg', 'is_wide'=>1, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>1],
    ['slug'=>'jhag', 'name'=>'JHAG Powder Love', 'title_html'=>'JHAG<br>Powder Love', 'client'=>'Juliette Has A Gun', 'type'=>'Capture & Direction Artistique', 'year'=>2026, 'thumbnail'=>'assets/projects/JHAG_POWDERLOVE_CAPTURE_4_16X9_V1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/jhag_film.mp4', 'show_on_site'=>1],
    ['slug'=>'eleven-sixtine', 'name'=>'Eleven Sixtine', 'title_html'=>'Eleven<br>Sixtine', 'client'=>'11H16', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/ELEVEN_SIXTINE_CAPTURE_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/eleven_sixtine_film.mp4', 'show_on_site'=>1],
    ['slug'=>'musee', 'name'=>'Musée', 'title_html'=>'Musée', 'client'=>'11H16', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/MUSEE_CAPTURE_3.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/musee_film.mp4', 'show_on_site'=>1],
    ['slug'=>'poche', 'name'=>'Poche', 'title_html'=>'Poche', 'client'=>'11H16', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/POCHE_CAPTURE_3.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/poche_film.mp4', 'show_on_site'=>1],
    ['slug'=>'viktor-rolf', 'name'=>'Viktor & Rolf Flowerbomb', 'title_html'=>'Viktor &amp; Rolf<br>Flowerbomb', 'client'=>'Viktor & Rolf', 'type'=>'Key Visuals & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/VIKTOR_ROLF_KV_1.jpg', 'is_wide'=>1, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/viktorrolf_film.mp4', 'show_on_site'=>1],
    ['slug'=>'valentino', 'name'=>'Valentino Beauty', 'title_html'=>'Valentino<br>Beauty', 'client'=>'Valentino', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/VALENTINO_CAPTURE_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/valentino_film.mp4', 'show_on_site'=>1],
    ['slug'=>'givenchy', 'name'=>'Givenchy', 'title_html'=>'Givenchy', 'client'=>'Givenchy', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/GIVENCHY_LINTERDIT_KV_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>1],
    // ─── 29 projets du book (show_on_site = 0) ───
    ['slug'=>'givenchy-ri', 'name'=>'Givenchy RI', 'title_html'=>'Givenchy<br>RI', 'client'=>'Givenchy', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/givenchy-ri_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>'assets/projects/givenchy-ri_film.mp4', 'show_on_site'=>0],
    ['slug'=>'burberry', 'name'=>'Burberry', 'title_html'=>'Burberry', 'client'=>'Burberry', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/burberry_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'dior', 'name'=>'Dior', 'title_html'=>'Dior', 'client'=>'Dior', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/dior_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'cartier', 'name'=>'Cartier', 'title_html'=>'Cartier', 'client'=>'Cartier', 'type'=>'Film', 'year'=>2026, 'thumbnail'=>'assets/projects/burberry_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'louboutin', 'name'=>'Louboutin', 'title_html'=>'Louboutin', 'client'=>'Louboutin', 'type'=>'Campagne & Édito', 'year'=>2026, 'thumbnail'=>'assets/projects/louboutin_kv_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'diesel', 'name'=>'Diesel', 'title_html'=>'Diesel', 'client'=>'Diesel', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/diesel_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'byredo', 'name'=>'Byredo', 'title_html'=>'Byredo', 'client'=>'Byredo', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/byredo_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'dom-perignon', 'name'=>'Dom Pérignon', 'title_html'=>'Dom<br>Pérignon', 'client'=>'Dom Pérignon', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/dom-perignon_kv_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'la-colline', 'name'=>'La Colline', 'title_html'=>'La Colline', 'client'=>'La Colline', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/la-colline_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'hajar', 'name'=>'Hajar', 'title_html'=>'Hajar', 'client'=>'Hajar', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/hajar_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'paulas-choice', 'name'=>'Paula\'s Choice', 'title_html'=>'Paula\'s<br>Choice', 'client'=>'Paula\'s Choice', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/paulas-choice_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'rimowa', 'name'=>'Rimowa', 'title_html'=>'Rimowa', 'client'=>'Rimowa', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/rimowa_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'staud', 'name'=>'Staud', 'title_html'=>'Staud', 'client'=>'Staud', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/staud_kv_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'maitrepierre', 'name'=>'Maitrepierre', 'title_html'=>'Maitrepierre', 'client'=>'Maitrepierre', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/maitrepierre_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'mini', 'name'=>'Mini', 'title_html'=>'Mini', 'client'=>'Mini', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/mini_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'fortnite', 'name'=>'Fortnite', 'title_html'=>'Fortnite', 'client'=>'Epic Games', 'type'=>'Film & Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/fortnite_kv_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'gymshark', 'name'=>'Gymshark', 'title_html'=>'Gymshark', 'client'=>'Gymshark', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/gymshark_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'adidas', 'name'=>'Adidas', 'title_html'=>'Adidas', 'client'=>'Adidas', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/adidas_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'red-bull', 'name'=>'Red Bull', 'title_html'=>'Red Bull', 'client'=>'Red Bull', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/red-bull_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'wilson', 'name'=>'Wilson', 'title_html'=>'Wilson', 'client'=>'Wilson', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/wilson_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'decathlon', 'name'=>'Decathlon', 'title_html'=>'Decathlon', 'client'=>'Decathlon', 'type'=>'Film', 'year'=>2026, 'thumbnail'=>'assets/projects/decathlon_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'chivas', 'name'=>'Chivas', 'title_html'=>'Chivas', 'client'=>'Chivas', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/chivas_kv_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'remy-martin', 'name'=>'Rémy Martin', 'title_html'=>'Rémy<br>Martin', 'client'=>'Rémy Martin', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/remy-martin_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'ace-club', 'name'=>'Ace Club', 'title_html'=>'Ace Club', 'client'=>'Ace Club', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/ace-club_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'martin-solveig', 'name'=>'Martin Solveig', 'title_html'=>'Martin<br>Solveig', 'client'=>'Martin Solveig', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/martin-solveig_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'aamour-ocean', 'name'=>'Aamour Océan', 'title_html'=>'Aamour<br>Océan', 'client'=>'Aamour Océan', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/aamour-ocean_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'wsn', 'name'=>'WSN', 'title_html'=>'WSN', 'client'=>'WSN', 'type'=>'Film & Capture', 'year'=>2026, 'thumbnail'=>'assets/projects/wsn_capture_1.jpg', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'rhyme', 'name'=>'Rhyme', 'title_html'=>'Rhyme', 'client'=>'Rhyme', 'type'=>'Key Visuals', 'year'=>2026, 'thumbnail'=>'assets/projects/rhyme_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
    ['slug'=>'playground', 'name'=>'Playground', 'title_html'=>'Playground', 'client'=>'11H16', 'type'=>'Direction Artistique', 'year'=>2026, 'thumbnail'=>'assets/projects/playground_kv_1.png', 'is_wide'=>0, 'is_hero'=>0, 'hero_video'=>null, 'preview_video'=>null, 'show_on_site'=>0],
];

$stmt = $db->prepare('INSERT INTO projects (slug, name, title_html, client, type, year, thumbnail, is_wide, display_order, is_hero, hero_video, preview_video, show_on_site) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

foreach ($projects as $order => $p) {
    $stmt->execute([$p['slug'], $p['name'], $p['title_html'], $p['client'], $p['type'], $p['year'], $p['thumbnail'], $p['is_wide'], $order, $p['is_hero'], $p['hero_video'], $p['preview_video'], $p['show_on_site']]);
    echo "Project: {$p['name']}<br>";
}

// ─── Project Media ────────────────────────────
$mediaData = [
    'almajed' => [
        ['type'=>'video', 'file'=>'assets/projects/almajed_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/ALMAJED_BOISEE_KV_2_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/ALMAJED_BOISEE_KV_3_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
    ],
    'bucherer' => [
        ['type'=>'video', 'file'=>'assets/projects/bucherer_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/BUCHERER_NOEL_KV_RINGS_VERTICAL_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/BUCHERER_NOEL_KV_WATCHES_VERTICAL_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/BUCHERER_NOEL_CAPTURE_1_16x9_V1.jpg', 'layout'=>'grid-1', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/BUCHERER_NOEL_CAPTURE_4_16x9_V1.jpg', 'layout'=>'grid-1', 'group'=>3],
    ],
    'marc-jacobs' => [
        ['type'=>'video', 'file'=>'assets/projects/marcjacobs_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/MARC_JACOBS_DAISY_CAPTURE_1_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/MARC_JACOBS_DAISY_CAPTURE_2_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/MARC_JACOBS_DAISY_CAPTURE_3_16x9_V1.jpg', 'layout'=>'grid-1', 'group'=>2],
    ],
    'gucci' => [
        ['type'=>'video', 'file'=>'assets/projects/gucci_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/GUCCI_RD_CAPTURE_1_17x24_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/GUCCI_RD_CAPTURE_2_17x24_V1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/GUCCI_RD_CAPTURE_3_17x24_V1.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/GUCCI_RD_CAPTURE_4_17x24_V1.jpg', 'layout'=>'grid-2', 'group'=>2],
    ],
    'coperni' => [
        ['type'=>'image', 'file'=>'assets/projects/COPERNI_KV_2.png', 'layout'=>'grid-2', 'group'=>0],
    ],
    'dr-jart' => [
        ['type'=>'image', 'file'=>'assets/projects/DR_JART_SKIN_KV_01-Korean_Skincare_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/DR_JART_SKIN_KV_02-Korean_Skincare_16x9_V1.jpg', 'layout'=>'grid-2', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/DR_JART_SKIN_KV_03-Korean_Layering_16x9_V1.jpg', 'layout'=>'grid-1', 'group'=>1],
    ],
    'jhag' => [
        ['type'=>'image', 'file'=>'assets/projects/JHAG_POWDERLOVE_CAPTURE_1_16X9_V1.jpg', 'layout'=>'grid-2', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/JHAG_POWDERLOVE_CAPTURE_4_16X9_V1.jpg', 'layout'=>'grid-2', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/JHAG_POWDERLOVE_CAPTURE_5_16X9_V1.jpg', 'layout'=>'grid-1', 'group'=>1],
    ],
    'eleven-sixtine' => [
        ['type'=>'video', 'file'=>'assets/projects/eleven_sixtine_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/ELEVEN_SIXTINE_CAPTURE_1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/ELEVEN_SIXTINE_CAPTURE_2.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/ELEVEN_SIXTINE_CAPTURE_3.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/ELEVEN_SIXTINE_CAPTURE_4.jpg', 'layout'=>'grid-2', 'group'=>2],
    ],
    'musee' => [
        ['type'=>'video', 'file'=>'assets/projects/musee_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/MUSEE_CAPTURE_1.jpg', 'layout'=>'grid-1', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/MUSEE_CAPTURE_2.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/MUSEE_CAPTURE_3.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/MUSEE_CAPTURE_4.jpg', 'layout'=>'grid-1', 'group'=>3],
    ],
    'poche' => [
        ['type'=>'video', 'file'=>'assets/projects/poche_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/POCHE_CAPTURE_1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/POCHE_CAPTURE_2.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/POCHE_CAPTURE_3.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/POCHE_CAPTURE_4.jpg', 'layout'=>'grid-2', 'group'=>2],
    ],
    'viktor-rolf' => [
        ['type'=>'video', 'file'=>'assets/projects/viktorrolf_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_KV_1.jpg', 'layout'=>'grid-3', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_KV_2.jpg', 'layout'=>'grid-3', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_KV_3.jpg', 'layout'=>'grid-3', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_CAPTURE_1.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_CAPTURE_2.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/VIKTOR_ROLF_CAPTURE_3.jpg', 'layout'=>'grid-1', 'group'=>3],
    ],
    'valentino' => [
        ['type'=>'video', 'file'=>'assets/projects/valentino_film.mp4', 'layout'=>'full', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/VALENTINO_CAPTURE_1.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/VALENTINO_CAPTURE_2.jpg', 'layout'=>'grid-2', 'group'=>1],
        ['type'=>'image', 'file'=>'assets/projects/VALENTINO_CAPTURE_3.jpg', 'layout'=>'grid-2', 'group'=>2],
        ['type'=>'image', 'file'=>'assets/projects/VALENTINO_CAPTURE_4.jpg', 'layout'=>'grid-2', 'group'=>2],
    ],
    'givenchy' => [
        ['type'=>'image', 'file'=>'assets/projects/GIVENCHY_IRRESISTIBLE_KV_3.png', 'layout'=>'grid-3', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/GIVENCHY_LINTERDIT_KV_1.png', 'layout'=>'grid-3', 'group'=>0],
        ['type'=>'image', 'file'=>'assets/projects/GIVENCHY_LINTERDIT_KV_2.png', 'layout'=>'grid-3', 'group'=>0],
    ],
];

$stmtMedia = $db->prepare('INSERT INTO project_media (project_id, type, file_path, layout, grid_group, display_order) VALUES (?, ?, ?, ?, ?, ?)');

foreach ($mediaData as $slug => $items) {
    $project = getProjectBySlug($slug);
    if (!$project) { echo "SKIP: $slug not found<br>"; continue; }
    foreach ($items as $order => $m) {
        $stmtMedia->execute([$project['id'], $m['type'], $m['file'], $m['layout'], $m['group'], $order]);
    }
    echo "Media for: {$project['name']}<br>";
}

// ─── Site Content ─────────────────────────────
$contentData = [
    'hero_line_1' => 'CREATING FOR',
    'hero_line_2' => 'TOMORROW WITH',
    'hero_line_3' => 'TOOLS OF TODAY',
    'hero_desc' => "Creative CGI Studio,\nIn House Creativity.",
    'hero_tags' => 'CGI. AI. VFX. Production. Creative Direction.',
    'splash_line_1' => 'CREATING FOR',
    'splash_line_2' => 'TOMORROW WITH',
    'splash_line_3' => 'TOOLS OF TODAY',
    'splash_sub' => 'CREATIVE CGI STUDIO',
    'about_title_1' => 'IN HOUSE',
    'about_title_2' => 'HUMAN',
    'about_title_3' => 'CREATIVITY',
    'about_p1' => 'At 11h16, creativity has no bounds. 3D, CGI and mixed media allow us to build worlds, propose bold ideas, and create work that feels both modern and sensory, designed to resonate with every viewer\'s sensitivity.',
    'about_p2' => 'We are a creative agency and post-production studio specialized in 3D, CGI and mixed media, with an international in-house team built for agility and craft. We support projects at every scale: from artistic explorations to global campaigns and high-volume production rollouts.',
    'about_p3' => 'Our process is collaborative and structured. We work hand-in-hand with clients to define objectives, then translate them into a strong visual direction through brainstorming, sketching and storyboarding. This phase produces a precise creative brief that anchors the full pipeline, from design to final delivery.',
    'about_p4' => 'To meet real-world campaign demands, we operate with clear schedules, milestone-based planning, and dependable delivery timelines ensuring consistency, quality, and speed across all assets.',
    'contact_email' => 'hello@11h16.studio',
    'contact_address' => '11H16 Studio — Paris, France',
    'instagram_url' => '#',
    'linkedin_url' => '#',
    'behance_url' => '#',
    'svc_0' => json_encode(['title'=>'3D & CGI Production', 'items'=>['3D Product Modeling','Look Development & Shading','Lighting & Rendering','Photorealistic Packshots','Environment & Set Creation','Camera Matching & Virtual Shooting']]),
    'svc_1' => json_encode(['title'=>'Stills Post-Production', 'items'=>['High-End Retouch','Image Compositing & Extension','Colour Grading & Product Matching','Pre-Production Consultation','On-Set Supervision & Retouching','Digital Capture','Re-Shoot','Certified Fogra Proof Printing']]),
    'svc_2' => json_encode(['title'=>'CGI Post-Production', 'items'=>['Compositing & Integration','Texture & Realism Enhancing','Upscaling & Large Format','Image Extension & Background Creation','Colour Matching & Final Grading']]),
    'svc_3' => json_encode(['title'=>'Film Post-Production', 'items'=>['Film Editing & Color Grading','Sound Design & Composition','3D CGI VFX Motion Graphics','Film Retouching & Clean-Up','Compositing & Visual Effects']]),
    'svc_4' => json_encode(['title'=>'Mix Media', 'items'=>['Photo & CGI Hybrid Compositing','Custom Technical & Creative Resources','Still & Motion Integration','Campaign Adaptations']]),
    'svc_5' => json_encode(['title'=>'AI Generation & Enhancing', 'items'=>['Image Generation & Variations','Large Format Upscaling','Texture & Realism Enhancing','Compositing & Extension','Concept Exploration & Mood Images']]),
    'svc_6' => json_encode(['title'=>'Creative Services', 'items'=>['Creative Direction','Art Direction & Visual Concepts','Pre-Production & Storyboarding','Custom Creative & Technical Resources']]),
];

foreach ($contentData as $key => $value) {
    setSiteContent($key, $value);
    echo "Content: $key<br>";
}

echo '<br><strong>Migration complete!</strong> <a href="index.php">View site</a> | <a href="admin/">Admin panel</a>';
echo '<br><em>Delete this file (migrate.php) now.</em>';
