/**
 * Alpine.js Counter Directive
 * Animates numbers counting up from 0 to final value
 * Usage: <span x-data x-counter="123">0</span>
 */
document.addEventListener('alpine:init', () => {
    Alpine.directive('counter', (el, { expression }, { evaluate }) => {
        const target = parseInt(evaluate(expression)) || 0;
        const duration = 1500;
        const frameDuration = 1000 / 60;
        const totalFrames = Math.round(duration / frameDuration);
        let frame = 0;
        let hasAnimated = false;

        const easeOutQuad = (t) => t * (2 - t);

        const animate = () => {
            if (hasAnimated) return;
            hasAnimated = true;

            const counter = setInterval(() => {
                frame++;
                const progress = easeOutQuad(frame / totalFrames);
                el.textContent = Math.round(target * progress).toLocaleString();

                if (frame === totalFrames) {
                    clearInterval(counter);
                    el.textContent = target.toLocaleString();
                }
            }, frameDuration);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate();
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(el);
    });
});
