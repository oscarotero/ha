import carousel from './modules/carousel.js';
import favicon from './modules/favicon.js';
import filterForm from './modules/filter-form.js';
import gmapPoints from './modules/gmap-points.js';
import GridDrag from './modules/grid-drag.js';
import pageLoader from './modules/page-loader.js';
import search from './modules/search.js';
import Carousel from './vendor/@oom/carousel/carousel.js';

//Main script
window.polyfillsLoaded.then(() => {
    //Custom elements
    customElements.define('ha-carousel', Carousel);
    customElements.define('ha-grid-drag', GridDrag);

    //Detect touch devices
    window.addEventListener('touchstart', () => document.documentElement.classList.add('is-touch'), {
        capture: true,
        once: true
    });

    //Detect disabled javascript
    document.documentElement.classList.remove('no-js');

    const nav = pageLoader(start);
    start();

    //Function executed in each history point
    function start(element = document) {
        //Favicon
        const style = getComputedStyle(document.body);
        const foreground = style.getPropertyValue('--foreground-color');
        const background = style.getPropertyValue('--background-color');
        favicon(foreground, background);

        //Carousel
        element.querySelectorAll('ha-carousel').forEach(el => carousel(el));

        //Forms
        element.querySelectorAll('.searchForm').forEach(el => filterForm(el, start));

        //Gmap
        element.querySelectorAll('.js-gmap').forEach(el => gmapPoints(element.querySelectorAll('.js-gmap-point'), el));

        //Search
        element.querySelectorAll('.js-search').forEach(el => search(el, (url, ev) => nav.go(url, ev)));
    }
});

//Service worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(error => console.log('Registration failed with ' + error));
}
