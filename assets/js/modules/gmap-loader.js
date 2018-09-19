export default function load(apiKey, callback = '__INIT_GMAP') {
    return new Promise(resolve => {
        if (isLoaded()) {
            resolve(window.google.maps);
        } else {
            window[callback] = () => resolve(window.google.maps);
            fetchApi(apiKey, callback);
        }
    });
}

function fetchApi(apiKey, callback) {
    const el = document.createElement('script');
    el.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=' + apiKey + '&callback=' + callback);
    document.querySelectorAll('body')[0].appendChild(el);
}

function isLoaded() {
    return typeof window.google !== 'undefined' && typeof window.google.maps !== 'undefined';
}
