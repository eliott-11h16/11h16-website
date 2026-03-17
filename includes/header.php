    <nav class="nav" id="nav">
        <div class="nav-left">
            <a href="<?= $isProjectPage ? 'index.php' : '#' ?>" class="nav-logo">
                <img src="assets/logo.png" alt="11H16" class="logo-img">
            </a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#projects" class="nav-link">Projects</a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#about" class="nav-link">About</a>
        </div>
        <div class="nav-right">
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#services" class="nav-link">Services</a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#contact" class="nav-link">Contact</a>
        </div>
        <button class="menu-btn" id="menuBtn" aria-label="Menu">
            <span class="menu-text">menu</span>
        </button>
    </nav>

    <div class="mob-menu" id="mobMenu">
        <button class="mob-close" id="mobClose">close</button>
        <div class="mob-inner">
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#projects" class="mob-link"><span>Projects</span></a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#about" class="mob-link"><span>About</span></a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#services" class="mob-link"><span>Services</span></a>
            <a href="<?= $isProjectPage ? 'index.php' : '' ?>#contact" class="mob-link"><span>Contact</span></a>
        </div>
        <div class="mob-bottom">
            <a href="<?= e($siteContent['instagram_url'] ?? '#') ?>">Instagram</a>
            <a href="<?= e($siteContent['linkedin_url'] ?? '#') ?>">LinkedIn</a>
        </div>
    </div>
