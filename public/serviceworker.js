var staticCacheName = "pwa-laravel" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/vendor/fontawesome-free/css/all.min.css",
    "/vendor/overlayScrollbars/css/OverlayScrollbars.min.css",
    "/vendor/adminlte/dist/css/adminlte.min.css",
    "/vendor/jquery/jquery.min.js",
    "/vendor/bootstrap/js/bootstrap.bundle.min.js",
    "/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
    "/vendor/adminlte/dist/js/adminlte.min.js",
    "/images/Default_pfp.svg.png",
    "/images/jm-logo-ai.png",
    "/images/mom-logo.png",
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});
