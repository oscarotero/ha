export default function initCarousel(carousel) {
    if (document.documentElement.classList.contains('is-touch')) {
        return;
    }
    carousel.parentNode.classList.add('has-scroll-hidden');

    let step = calculateStep();

    //Botón seguinte
    const next = document.createElement('button');
    next.classList.add('carousel-button', 'is-next');
    next.innerHTML = `
    <svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" fill="none" class="icon">
        <polyline points="7,0 15,9 7,17"></polyline>
        <line x1="0" y1="9" x2="15" y2="9"></line>
    </svg>
    `;
    next.setAttribute('aria-label', 'Siguiente');
    next.setAttribute('tabindex', 0);
    next.addEventListener('click', () => (carousel.index += calculateStep()));
    carousel.before(next);

    //Botón anterior
    const prev = document.createElement('button');
    prev.classList.add('carousel-button', 'is-prev');
    prev.innerHTML = `
    <svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" fill="none" class="icon">
        <polyline points="10,0 2,9 10,17"></polyline>
        <line x1="2" y1="9" x2="17" y2="9"></line>
    </svg>
    `;
    next.setAttribute('aria-label', 'Anterior');
    prev.setAttribute('tabindex', 0);
    prev.disabled = true;
    prev.addEventListener('click', () => (carousel.index -= calculateStep()));
    carousel.after(prev);

    //Ocultar botóns ao inicio/fin
    let isScrolling;

    carousel.addEventListener(
        'scroll',
        event => {
            clearTimeout(isScrolling);
            isScrolling = setTimeout(showHideButtons, 100);
        },
        false
    );

    carousel.addEventListener('mouseenter', showHideButtons);

    function calculateStep() {
        if (!carousel.dataset.carouselWidth) {
            return 1;
        }

        return Math.ceil(carousel.clientWidth / parseInt(carousel.dataset.carouselWidth)) || 1;
    }

    function showHideButtons() {
        prev.disabled = carousel.scrollFromLeft < 5;
        next.disabled = carousel.scrollFromRight < 5;
    }

    function checkImages() {
        const img = carousel.querySelectorAll('img');
        let total = img.length;

        img.forEach(img => {
            img.addEventListener('load', () => {
                --total;

                if (!total) {
                    showHideButtons();
                }
            });
        });
    }

    showHideButtons();
    checkImages();
}
