document.addEventListener('DOMContentLoaded', () => {

    // ─── Mobile Menu ─────────────────────────────────
    const menuBtn = document.getElementById('menuBtn');
    const mobMenu = document.getElementById('mobMenu');
    const mobClose = document.getElementById('mobClose');

    if (menuBtn && mobMenu) {
        menuBtn.addEventListener('click', () => {
            mobMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        mobClose.addEventListener('click', () => {
            mobMenu.classList.remove('active');
            document.body.style.overflow = '';
        });

        document.querySelectorAll('.mob-link').forEach(link => {
            link.addEventListener('click', () => {
                mobMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }

    // ─── Hero Video Carousel ──────────────────────
    const heroVideos = document.querySelectorAll('.hero-video');
    const progressFill = document.querySelector('.hero-progress-fill');
    const progressCount = document.querySelector('.hero-progress-count');
    const progressProject = document.querySelector('.hero-progress-project');
    if (heroVideos.length > 1) {
        let current = 0;
        const duration = 6000;

        const switchVideo = () => {
            heroVideos[current].classList.remove('active');
            heroVideos[current].pause();
            current = (current + 1) % heroVideos.length;
            heroVideos[current].currentTime = 0;
            heroVideos[current].play();
            heroVideos[current].classList.add('active');
            if (progressCount) {
                progressCount.textContent = `0${current + 1} / 0${heroVideos.length}`;
            }
            if (progressProject) {
                progressProject.textContent = heroVideos[current].dataset.project;
            }
            if (progressFill) {
                progressFill.style.animation = 'none';
                progressFill.offsetHeight;
                progressFill.style.animation = `progressFill ${duration / 1000}s linear`;
            }
        };

        setInterval(switchVideo, duration);
    }

    // ─── Nav color toggle (light over hero video) ──
    const nav = document.getElementById('nav');
    const hero = document.querySelector('.hero');
    if (nav && hero) {
        const updateNav = () => {
            const heroBottom = hero.getBoundingClientRect().bottom;
            nav.classList.toggle('nav--light', heroBottom > 60);
            nav.classList.toggle('nav--scrolled', window.scrollY > 50);
        };
        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();
    }

    // ─── Scroll Reveal ───────────────────────────────
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.08,
        rootMargin: '0px 0px -30px 0px'
    });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // ─── Smooth Anchor Scroll ────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const y = target.getBoundingClientRect().top + window.scrollY - 50;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        });
    });
});
