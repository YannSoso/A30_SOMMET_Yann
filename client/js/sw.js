// Service Worker version
const version = 'v1';

// Files to cache
const filesToCache = [
    '/',
    '/indexCtrl.js',
    '/js/loginCtrl.js',
    '/js/accueilCtrl.js',
    '/js/detailEauCtrl.js',
    '/js/vueService.js',
    '/js/httpService.js',
    '/css/style.css',
    '/index.html',
    '/views/login.html',
    '/views/accueil.html',
    '/views/detailEau.html',
    '/img/home.png',
    '/img/logo.png',
    '/img/lodibidon.jpg'
];

// Install event
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(version)
            .then((cache) => {
                return cache.addAll(filesToCache);
            })
    );
});

// Activate event
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== version) {
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
    );
});

// Fetch event
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
    );
});