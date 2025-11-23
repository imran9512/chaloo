const CACHE_NAME = 'chaloo-v1';
const urlsToCache = [
    '/',
    '/public/',
    '/public/manifest.json',
    '/public/css/app.css',
    '/public/js/app.js'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});