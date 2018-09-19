const version = 'v2';

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(version).then(function(cache) {
            return cache.addAll([
                '/sin-conexion',
                '/img/503.jpg',
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    //Ignore piwik, admin and non-GET requests
    const url = new URL(event.request.url);

    if (event.request.method !== 'GET'
     || url.pathname.startsWith('/img.php') 
     || url.pathname.startsWith('/admin')
     || url.hostname == 'maps.googleapis.com'
     ) {
        return;
    }

    const destination = event.request.destination;

    switch (destination) {
        case 'style':
        case 'script':
        case 'image':
        case 'font':
            event.respondWith(assets(event.request));
            return;

        default:
            event.respondWith(pages(event.request));
            return;
    }
});

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function (keys) {
            return Promise.all(
                keys.filter(key => !key.startsWith(version))
                    .map(key => caches.delete(key))
            );
        })
    );
});

//Assets - cache first strategy
function assets(request) {
    return caches.match(request).then(cached => {
        if (cached !== undefined) {
            return cached;
        }

        return fetch(request)
            .catch(errorResponse)
            .then(saveCache(request, 'assets'));
    });
}

//Html pages - network first strategy
function pages(request) {
    return fetch(request)
        .then(saveCache(request, 'pages'))
        .catch(() =>
            caches.match(request).then(cached => {
                if (cached !== undefined) {
                    return cached;
                }

                return errorResponse();
            })
        );
}

function saveCache(request, type) {
    return function(response) {
        const clonedResponse = response.clone();

        caches.open(`${version}-${type}`).then(function(cache) {
            cache.put(request, clonedResponse);
        });

        return response;
    };
}

function errorResponse() {
    return caches.match('/sin-conexion').then(cached => {
        return (
            cached ||
            new Response('Parece que no tienes internet', {
                status: 503,
                statusText: 'Service Unavailable'
            })
        );
    });
}
