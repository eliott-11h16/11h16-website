document.addEventListener('DOMContentLoaded', () => {

    // ─── Splash Screen ─────────────────────────────
    const splash = document.getElementById('splash');
    if (splash) {
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            splash.classList.add('fade-out');
            document.body.style.overflow = '';
        }, 3000);
        splash.addEventListener('animationend', (e) => {
            if (e.animationName === 'splashOut') {
                splash.remove();
            }
        });
    }

    // ─── Split-flap airport board effect ────────────
    const CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    const FLIP_INTERVAL = 50;   // ms between each random letter
    const CHAR_STAGGER = 80;    // ms stagger between characters
    const LINE_STAGGER = 200;   // ms stagger between lines

    function buildFlap(ch) {
        const el = document.createElement('span');
        el.className = 'flap-char' + (ch === ' ' ? ' is-space' : '');
        if (ch !== ' ') {
            const top = document.createElement('span');
            top.className = 'flap-top';
            top.innerHTML = `<span>${ch}</span>`;
            const bot = document.createElement('span');
            bot.className = 'flap-bottom';
            bot.innerHTML = `<span>${ch}</span>`;
            el.appendChild(top);
            el.appendChild(bot);
        }
        return el;
    }

    function setFlapChar(el, ch) {
        const top = el.querySelector('.flap-top span');
        const bot = el.querySelector('.flap-bottom span');
        if (top) top.textContent = ch;
        if (bot) bot.textContent = ch;
    }

    function spinFlap(el, target, flips, delay) {
        let count = 0;
        setTimeout(() => {
            const iv = setInterval(() => {
                const rand = CHARS[Math.floor(Math.random() * CHARS.length)];
                setFlapChar(el, rand);
                // quick top-half kick on each flip
                const topHalf = el.querySelector('.flap-top');
                if (topHalf) {
                    topHalf.style.transform = 'rotateX(-20deg)';
                    requestAnimationFrame(() => {
                        topHalf.style.transition = 'transform 0.04s ease-out';
                        topHalf.style.transform = 'rotateX(0)';
                        setTimeout(() => { topHalf.style.transition = ''; }, 50);
                    });
                }
                count++;
                if (count >= flips) {
                    clearInterval(iv);
                    setFlapChar(el, target);
                    el.classList.add('done');
                }
            }, FLIP_INTERVAL);
        }, delay);
    }

    function initFlaps(selector, baseDelay) {
        document.querySelectorAll(selector).forEach(word => {
            const text = word.textContent;
            const lineDelay = parseFloat(word.style.getPropertyValue('--d')) || 0;
            word.textContent = '';
            let charIndex = 0;
            for (const ch of text) {
                const flap = buildFlap(ch === ' ' ? ' ' : CHARS[Math.floor(Math.random() * CHARS.length)]);
                word.appendChild(flap);
                if (ch !== ' ') {
                    flap.dataset.target = ch;
                    const delay = baseDelay + lineDelay * LINE_STAGGER + charIndex * CHAR_STAGGER;
                    const flips = 6 + Math.floor(Math.random() * 6);
                    spinFlap(flap, ch, flips, delay);
                    charIndex++;
                }
            }
        });
    }

    // Hover effect on hero letters — cycle through "11H16" chars
    const LOGO_CHARS = ['1', '1', 'H', '1', '6'];
    function addHoverFlap(flap, originalChar) {
        let hoverInterval = null;
        flap.addEventListener('mouseenter', () => {
            if (hoverInterval) return;
            flap.classList.remove('done');
            let count = 0;
            hoverInterval = setInterval(() => {
                const rand = LOGO_CHARS[Math.floor(Math.random() * LOGO_CHARS.length)];
                setFlapChar(flap, rand);
                const topHalf = flap.querySelector('.flap-top');
                if (topHalf) {
                    topHalf.style.transform = 'rotateX(-20deg)';
                    requestAnimationFrame(() => {
                        topHalf.style.transition = 'transform 0.04s ease-out';
                        topHalf.style.transform = 'rotateX(0)';
                        setTimeout(() => { topHalf.style.transition = ''; }, 50);
                    });
                }
                count++;
            }, FLIP_INTERVAL);
        });
        flap.addEventListener('mouseleave', () => {
            // Let it spin a few more times before settling
            let remaining = 4 + Math.floor(Math.random() * 4); // 4-7 extra flips
            const slowDown = setInterval(() => {
                const rand = LOGO_CHARS[Math.floor(Math.random() * LOGO_CHARS.length)];
                setFlapChar(flap, rand);
                const topHalf = flap.querySelector('.flap-top');
                if (topHalf) {
                    topHalf.style.transform = 'rotateX(-20deg)';
                    requestAnimationFrame(() => {
                        topHalf.style.transition = 'transform 0.06s ease-out';
                        topHalf.style.transform = 'rotateX(0)';
                        setTimeout(() => { topHalf.style.transition = ''; }, 70);
                    });
                }
                remaining--;
                if (remaining <= 0) {
                    clearInterval(slowDown);
                    if (hoverInterval) {
                        clearInterval(hoverInterval);
                        hoverInterval = null;
                    }
                    setFlapChar(flap, originalChar);
                    flap.classList.add('done');
                }
            }, 80); // slower interval for the wind-down
            if (hoverInterval) {
                clearInterval(hoverInterval);
                hoverInterval = null;
            }
        });
    }

    // Apply to splash screen (immediate)
    initFlaps('.splash-word', 200);

    // Apply to hero text (delayed until after splash)
    initFlaps('.hero-word', 300);

    // Attach hover to hero flap chars
    document.querySelectorAll('.hero-word .flap-char:not(.is-space)').forEach(flap => {
        const originalChar = flap.dataset.target;
        addHoverFlap(flap, originalChar);
    });

    // ─── Project Video Hover ─────────────────────────
    document.querySelectorAll('.proj').forEach(proj => {
        const video = proj.querySelector('.proj-video');
        if (!video) return;
        proj.addEventListener('mouseenter', () => {
            video.currentTime = 0;
            video.play().catch(() => {});
        });
        proj.addEventListener('mouseleave', () => {
            video.pause();
        });
    });

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
