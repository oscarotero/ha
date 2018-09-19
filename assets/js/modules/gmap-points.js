import gmapLoader from './gmap-loader.js';
import styles from './gmap-style.js';

export default function initGmapPoints(elements, target) {
    gmapLoader('AIzaSyDm-D6oGEL6QwoEF4L05mvSTQ3hdmTYJMc').then(gmaps => {
        const markerBounds = new gmaps.LatLngBounds();
        const map = new gmaps.Map(target, {
            zoom: 16,
            gestureHandling: 'cooperate',
            scrollwheel: false,
            mapTypeControl: false,
            fullscreenControl: false,
            styles
        });

        map.setOptions({
            minZoom: 3
        });

        let center;

        elements.forEach((el, index) => {
            const position = createPosition(el);

            if (!position) {
                return;
            }

            const link = el.tagName === 'A';

            const marker = new gmaps.Marker({
                position,
                map,
                title: el.getAttribute('title'),
                //icon: link ? undefined : {path: google.maps.SymbolPath.CIRCLE,scale: 20},
                animation: gmaps.Animation.DROP
            });

            markerBounds.extend(position);

            if (!link) {
                center = position;
                return;
            }

            const infowindow = new gmaps.InfoWindow({
                content: el.outerHTML,
                maxWidth: 200
            });

            let timeout;

            marker.addListener('click', () => {
                clearTimeout(timeout);
                infowindow.open(map, marker);
            });

            el.addEventListener('mouseenter', () => {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    marker.setAnimation(gmaps.Animation.BOUNCE);
                    marker.setZIndex(999);
                    map.setZoom(15);

                    if (!map.getBounds().contains(position)) {
                        map.panTo(position);
                    }
                }, 1000);
            });

            el.addEventListener('mouseleave', () => {
                clearTimeout(timeout);

                marker.setAnimation(null);
                marker.setZIndex(1);
            });
        });

        if (center) {
            map.setCenter(center);
            map.setZoom(19);
        } else if (elements.length > 1) {
            map.fitBounds(markerBounds);
        } else if (elements.length === 1) {
            map.setCenter(createPosition(elements[0]));
            map.setZoom(7);
        }

        function createPosition(el) {
            const coords = JSON.parse(el.dataset.coords);

            if (!coords) {
                return;
            }

            return new gmaps.LatLng(...coords);
        }
    });
}
