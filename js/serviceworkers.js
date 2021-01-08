// https://www.youtube.com/watch?v=YFrCEbx1oW0  by Sophia Shoemaker
// REGISTER


if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('js/serviceworkers.js',{scope: '/js/'}).then(function(registration) {
        // registration worked
        console.log('Registration succeeded. ', registration.scope);
    }, function(error) {
        // registration failed
        console.log('Registration failed with: ' + error );
       });
    });
}
    
// INSTALL
var CACHE_NAME = 'ncm-site-cache-v1';
var urlsToCache = [
            'indexSW.php',
            '/css/NetManager.css',
            '/css/NetManager-media.css',
            '/js/NetManager.js',
            '/js/NetManager-p2.js',
            '/js/sortTable.js',
            '/js/CellEditFunction.js'
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

// FETCH EVENTS
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }

        return fetch(event.request).then(
          function(response) {
            // Check if we received a valid response
            if(!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // IMPORTANT: Clone the response. A response is a stream
            // and because we want the browser to consume the response
            // as well as the cache consuming the response, we need
            // to clone it so we have two streams.
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function(cache) {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        );
      })
    );
});

self.addEventListener('activate', function(event) {

  var cacheAllowlist = ['pages-cache-v1', 'blog-posts-cache-v1'];

  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheAllowlist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});




// STORING DATa
// localStorage
function updateLocalStorage(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}
function getLocalStorage(key) {
    return JSON.parse(localStorage.getItem(key));
}

// SAVE DATA
function putNCMData(data) {
    return onlineOffline(
        () => {
            data.update = "remote";
            updateLocalStorageNCMData(data);
            return putNCMDataRemote(data);
        },
        () => {
            data.update = "optimistic";
            return putNCMDataOffline(data);
        }
    )
}