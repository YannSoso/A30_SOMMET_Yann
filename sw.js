// Service Worker version
const version = 'v1';

// Files to cache
const filesToCache = [
    'client/js/indexCtrl.js',
    'client/js/loginCtrl.js',
    'client/js/accueilCtrl.js',
    'client/js/detailEauCtrl.js',
    'client/js/vueService.js',
    'client/js/httpService.js',
    'client/index.html',
    'client/views/login.html',
    'client/views/accueil.html',
    'client/views/detailEau.html',
    'client/css/styles.css',
    'client/img/logo.png',
    'client/img/lodibidon.png',
    'client/img/home.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(version)
            .then((cache) => {
                return cache.addAll(filesToCache);
            })
    );
});

self.addEventListener('fetch', (event) => {
    // Open the cache
    event.respondWith(caches.open(version).then((cache) => {
        // Go to the network first
        return fetch(event.request.url).then((fetchedResponse) => {
            cache.put(event.request, fetchedResponse.clone());
            return fetchedResponse;
        }).catch(() => {
            // If the network is unavailable, get

            return cache.match(event.request.url);
        });
    }));
});