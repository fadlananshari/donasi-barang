const CACHE_NAME = 'offline-cache-v1';

const FILES_TO_CACHE = [
  '/offline.html',
  '/manifest.json',
  '/icon512_maskable.png',
  '/icon512_rounded.png'
];

// Saat install: cache file offline dasar
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(FILES_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Saat activate: hapus cache lama
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keyList) =>
      Promise.all(
        keyList.map((key) => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      )
    )
  );
  self.clients.claim();
});

// Strategi Cache-First untuk gambar dan media
self.addEventListener('fetch', (event) => {
  const { request } = event;

  // Skip non-GET requests
  if (request.method !== 'GET') return;

  // Untuk request ke storage (seperti gambar proposal)
  if (request.url.includes('/storage/')) {
    event.respondWith(
      caches.match(request).then((response) => {
        return (
          response ||
          fetch(request)
            .then((networkResponse) => {
              return caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, networkResponse.clone());
                return networkResponse;
              });
            })
            .catch(() => {
              // Fallback jika gambar gagal dimuat
              return new Response('', {
                status: 404,
                statusText: 'Not Found',
              });
            })
        );
      })
    );
    return;
  }

  // Untuk permintaan umum
  event.respondWith(
    fetch(request)
      .then((response) => {
        // Simpan ke cache untuk permintaan GET yang berhasil
        if (
          request.url.startsWith('http') &&
          response &&
          response.status === 200
        ) {
          const clonedResponse = response.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(request, clonedResponse);
          });
        }
        return response;
      })
      .catch(() => {
        return caches.match(request).then((cachedResponse) => {
          return cachedResponse || caches.match(OFFLINE_URL);
        });
      })
  );
});
