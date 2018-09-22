var cacheName = 'workbooks-basics-2-13';
var filesToCache = [
  '/',
  '/index.html',
  '/service-worker.js',
  '/css/splash.css',
  '/css/base.css',
  '/js/boot.js',
  '/js/workbooks.js',
  '/js/exams.js',
  '/js/navigation.js',
  '/img/icon-192.png',
  '/img/icon-512.png',
  '/img/icon-512-w.png'
];


self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', function(e) {
  console.log('[ServiceWorker] Fetch');

  var requestURL = new URL(e.request.url);

  if(
      requestURL.pathname == "/" ||
      requestURL.pathname == "/index.html" ||
      /^\/pwa-beta\/css/.test(requestURL.pathname) ||
      /^\/pwa-beta\/js/.test(requestURL.pathname) ||
      /^\/pwa-beta\/img/.test(requestURL.pathname)
  ) {
    e.respondWith (
      caches.open(cacheName).then(function(cache) {
        return cache.match(e.request);
      })
    );
    return;
  }

  e.respondWith(
    caches.open('workbooks-dynamic').then(function(cache) {
      return fetch(e.request).then(function(response) {
        cache.put(e.request, response.clone());
        return response;
      });
    })
  );
});
