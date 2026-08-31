const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const revealElements = document.querySelectorAll('.reveal');

if (reducedMotion || !('IntersectionObserver' in window)) {
  revealElements.forEach((element) => element.classList.add('is-visible'));
} else {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
  );

  revealElements.forEach((element) => observer.observe(element));
}

const portrait = document.querySelector('[data-parallax]');

if (portrait && !reducedMotion) {
  window.addEventListener(
    'pointermove',
    (event) => {
      const x = (event.clientX / window.innerWidth - 0.5) * 10;
      const y = (event.clientY / window.innerHeight - 0.5) * 10;
      portrait.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    },
    { passive: true },
  );
}

const year = document.querySelector('[data-year]');
if (year) year.textContent = String(new Date().getFullYear());
