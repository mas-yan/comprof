const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function initCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((carousel) => {
        const slides = Array.from(carousel.querySelectorAll('[data-carousel-slide]'));
        const dots = Array.from(carousel.querySelectorAll('[data-carousel-dot]'));
        const prevButton = carousel.querySelector('[data-carousel-prev]');
        const nextButton = carousel.querySelector('[data-carousel-next]');
        const autoplayMs = Number(carousel.dataset.autoplay || 0);

        if (slides.length < 2) {
            return;
        }

        let index = 0;
        let timer = null;

        const show = (newIndex) => {
            slides[index]?.classList.replace('opacity-100', 'opacity-0');
            slides[index]?.classList.add('pointer-events-none');
            dots[index]?.setAttribute('data-active', 'false');

            index = (newIndex + slides.length) % slides.length;

            slides[index]?.classList.replace('opacity-0', 'opacity-100');
            slides[index]?.classList.remove('pointer-events-none');
            dots[index]?.setAttribute('data-active', 'true');
        };

        const next = () => show(index + 1);
        const prev = () => show(index - 1);

        const stop = () => clearInterval(timer);
        const start = () => {
            stop();
            if (autoplayMs && !prefersReducedMotion()) {
                timer = setInterval(next, autoplayMs);
            }
        };

        prevButton?.addEventListener('click', () => {
            prev();
            start();
        });
        nextButton?.addEventListener('click', () => {
            next();
            start();
        });
        dots.forEach((dot, dotIndex) => {
            dot.addEventListener('click', () => {
                show(dotIndex);
                start();
            });
        });

        carousel.addEventListener('mouseenter', stop);
        carousel.addEventListener('mouseleave', start);
        carousel.addEventListener('focusin', stop);
        carousel.addEventListener('focusout', start);

        start();
    });
}

function initScrollReveal() {
    const items = document.querySelectorAll('[data-reveal]');

    if (!items.length) {
        return;
    }

    if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('opacity-100', 'translate-y-0'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-6');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.15 },
    );

    items.forEach((el) => observer.observe(el));
}

function initSliders() {
    document.querySelectorAll('[data-slider]').forEach((slider) => {
        const track = slider.querySelector('[data-slider-track]');
        const items = track ? Array.from(track.children) : [];
        const prevButton = slider.querySelector('[data-slider-prev]');
        const nextButton = slider.querySelector('[data-slider-next]');
        const autoplayMs = Number(slider.dataset.autoplay || 0);

        if (!track || items.length < 2) {
            return;
        }

        const step = (direction) => {
            const gap = parseFloat(getComputedStyle(track).columnGap || '0');
            const amount = (items[0].offsetWidth + gap) * direction;
            const maxScroll = track.scrollWidth - track.clientWidth;
            const behavior = prefersReducedMotion() ? 'auto' : 'smooth';

            if (direction > 0 && track.scrollLeft >= maxScroll - 4) {
                track.scrollTo({ left: 0, behavior });
            } else if (direction < 0 && track.scrollLeft <= 4) {
                track.scrollTo({ left: maxScroll, behavior });
            } else {
                track.scrollBy({ left: amount, behavior });
            }
        };

        let timer = null;
        const stop = () => clearInterval(timer);
        const start = () => {
            stop();
            if (autoplayMs && !prefersReducedMotion()) {
                timer = setInterval(() => step(1), autoplayMs);
            }
        };

        prevButton?.addEventListener('click', () => {
            step(-1);
            start();
        });
        nextButton?.addEventListener('click', () => {
            step(1);
            start();
        });

        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        slider.addEventListener('focusin', stop);
        slider.addEventListener('focusout', start);

        start();
    });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const panel = document.querySelector('[data-menu-panel]');

    if (!toggle || !panel) {
        return;
    }

    const openPanel = () => {
        panel.classList.remove('hidden');
        panel.classList.add('flex');
        toggle.setAttribute('aria-expanded', 'true');
    };

    const closePanel = () => {
        panel.classList.add('hidden');
        panel.classList.remove('flex');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        if (panel.classList.contains('hidden')) {
            openPanel();
        } else {
            closePanel();
        }
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', closePanel);
    });
}

function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');

    if (!button) {
        return;
    }

    const toggleVisibility = () => {
        button.classList.toggle('opacity-0', window.scrollY < 400);
        button.classList.toggle('pointer-events-none', window.scrollY < 400);
        button.classList.toggle('opacity-100', window.scrollY >= 400);
    };

    window.addEventListener('scroll', toggleVisibility, { passive: true });
    toggleVisibility();

    button.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
    });
}

function initScrollTopLinks() {
    document.querySelectorAll('[data-scroll-top]').forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
        });
    });
}

function initHeaderShadowOnScroll() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    const toggleShadow = () => {
        header.classList.toggle('shadow-sm', window.scrollY > 8);
    };

    window.addEventListener('scroll', toggleShadow, { passive: true });
    toggleShadow();
}

function initThemeToggle() {
    const root = document.documentElement;
    const toggle = document.querySelector('[data-theme-toggle]');

    if (!toggle) {
        return;
    }

    toggle.setAttribute('aria-pressed', String(root.classList.contains('dark')));

    toggle.addEventListener('click', () => {
        const isDark = !root.classList.contains('dark');
        root.classList.toggle('dark', isDark);
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        toggle.setAttribute('aria-pressed', String(isDark));
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
        if (localStorage.getItem('theme')) {
            return;
        }

        root.classList.toggle('dark', event.matches);
        toggle.setAttribute('aria-pressed', String(event.matches));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initCarousels();
    initSliders();
    initScrollReveal();
    initMobileMenu();
    initBackToTop();
    initScrollTopLinks();
    initHeaderShadowOnScroll();
    initThemeToggle();
});
