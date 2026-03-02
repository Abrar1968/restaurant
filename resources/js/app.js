import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine globally available
window.Alpine = Alpine;

// Start Alpine.js
Alpine.start();

/*
|--------------------------------------------------------------------------
| Scroll-Triggered Animation Observer
|--------------------------------------------------------------------------
| Elements with data-animate="animate-fade-in-up" (or any animation class)
| and optional data-delay="0.2s" will animate when scrolled into viewport.
*/
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.dataset.delay || '0s';
                el.style.animationDelay = delay;
                el.classList.add(el.dataset.animate);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('[data-animate]').forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
});
