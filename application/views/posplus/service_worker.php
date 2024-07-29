<?php
echo "
const VERSION = 92;
const CACHE_NAME = 'posplus_cache-v-'+VERSION+'-".$this->db->database."'; 
// List of URLs to be cached  //    
const urlsToCache = [  
    '".base_url()."posplus/app', 
    '".asset_url()."js/moment.min.js',
    '".asset_url()."css/bootstrap.min.css',
    '".asset_url()."plugins/font-awesome/css/font-awesome.min.css',
    '".asset_url()."css/style.css',
    '".asset_url()."css/posplus.1.css',
    '".asset_url()."css/jquery-ui.css', 
    '".asset_url()."plugins/select2/select2.css',
    '".asset_url()."plugins/iCheck/skins/all.css',
    '".asset_url()."plugins/iCheck/skins/minimal/_all.css',
    '".asset_url()."plugins/iCheck/skins/square/_all.css',
    '".asset_url()."plugins/iCheck/skins/flat/_all.css',
    '".asset_url()."plugins/iCheck/skins/line/_all.css',
    '".asset_url()."plugins/iCheck/skins/polaris/polaris.css',
    '".asset_url()."plugins/iCheck/skins/futurico/futurico.css', 
    '".asset_url()."css/print_pos.css',
    '".asset_url()."images/male.png',
    '".asset_url()."plugins/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0',
    '".asset_url()."fonts/trnbTfqisuuhRVI3i45C5w.woff',
    '".asset_url()."images/logo_print.png',
    '".asset_url()."uploads/thumbs/no_image.png',

    '".asset_url()."plugins/jQuery-lib/2.0.3/jquery.min.js',
    '".asset_url()."plugins/select2/select2.min.js',
    '".asset_url()."plugins/bootstrap/js/bootstrap.min.js',
    '".asset_url()."plugins/jquery-validation/dist/jquery.validate.min.js',
    '".asset_url()."js/bootbox.custom.js',
    '".asset_url()."js/jquery-ui.min.js',
    '".asset_url()."js/accounting.min.js',
    '".asset_url()."js/jquery.sendkeys.js',
    '".asset_url()."js/bililiteRange.js',
    '".asset_url()."js/jquery.dataTables.min.js',
    '".asset_url()."js/dataTables.bootstrap.min.js',
    '".asset_url()."js/jquery.kinetic.min.js',
    '".asset_url()."js/autoNumeric.js',
    '".asset_url()."plugins/gritter/js/jquery.gritter.min.js',
    '".asset_url()."plugins/iCheck/jquery.icheck.min.js',
    '".asset_url()."js/posplus.9.js' 
];
   
const dataUrls = [
    //'".base_url()."posplus/get_products_direct',
    '".base_url()."posplus/get_cats',
    //'".base_url()."posplus/get_phone',
];

// const urlsToUpdateCache = ['".base_url()."pos.html'];
// Install the service worker and cache the URLs
async function precache() {
    caches.open(CACHE_NAME).then(cache => {
        console.log('SW: Opened cache');
        return cache.addAll(urlsToCache);
    })
}
self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(precache());
});

self.addEventListener('activate', event => {
    console.log('SW: Activated!');
    event.waitUntil(cleanupCache());

    /*if (self.CACHE_NAME !== CACHE_NAME) {
        // Call a function within the service worker itself
        callClientFunction('reload_page');
        
        // Update the cache name to the new one
        self.CACHE_NAME = CACHE_NAME;
    }*/
});

async function cleanupCache() {
    const keys = await caches.keys()
    const keysToDelete = keys.map(key => {
        if (key !== CACHE_NAME) {
            return caches.delete(key)
        }
    });
    console.log('SW: keysToDelete :', keysToDelete.length);
    if (keysToDelete.length > 0)
        callClientFunction('reload_page');
    return Promise.all(keysToDelete)
}
async function getItms() {
    fetch('".base_url()."pos/get_products_direct')
        .then(response => response.json())
        .then(data => {
            // update itms DB
            console.warn('SW: Item list updated!');
        })
        .catch(error => {
            console.error('SW: Error fetching data:', error);
        })
}
self.addEventListener('fetch', event => {
    if (!urlsToCache.includes(event.request.url)) {
        return;
    }
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (event.request.url == '".base_url()."posplus/app')
                    update_data_2();
                /*update_cache(event);*/
                if (response) {
                    return response;
                } else {
                    return fetch(event.request);
                }
            })
            .catch(error => {
                console.log('SW: Error fetching and caching:', error);
            })
    );
});

async function update_data_2() {
    console.log('SW: Updating data URLs at update_data_2()');
    dataUrls.forEach(url => {
        const requestUrl = new URL(url);
        fetch(requestUrl).then(response => {
            if (response.status === 200) {
                console.log('updating background data...', requestUrl.href);
                caches.open(CACHE_NAME).then(cache => cache.put(requestUrl.href, response.clone()));
            }
        })
            .catch(error => {
                console.log('SW: (02)Error updating data cache:', error);
            });
    });
}

function update_data_3() {
    console.log('SW: Updating data URLs at update_data_3()');
    const promises = dataUrls.map(url => {
        var requestUrl = new URL(url);
        return fetch(requestUrl)
            .then(response => {
                if (response.status === 200) {
                    console.log('Updating background data URL-> ', requestUrl.href);
                    return caches.open(CACHE_NAME).then(cache => cache.put(requestUrl.href, response.clone()));
                }
            })
            .catch(error => {
                console.log('SW: (03)Error updating data cache:', error);
            });
    });

    // Wait for all cache update promises to resolve
    //await Promise.all(promises);

    // Call the client function after cache updates are done
    callClientFunction('updateCache');
}

async function update_cache(event) {
    console.log('SW: Checking requests');
    fetch(event.request).then(response => {
        if (response.status === 200) {
            console.log('SW: ', event.request.url)
            if (urlsToCache.includes(event.request.url)) {
                console.log('SW: Updating cache');
                caches.open(CACHE_NAME).then(cache => cache.put(event.request, response.clone()));
            } else {
                console.log('SW: (02)Not found', event.request.url);
            }
        }
    })
        .catch(error => {
            console.log('SW: Error updating cache:', error);
        });
}

self.addEventListener('message', function (event) {
    console.log('SW: Event listner Message');
    if (event.data && event.data.action === 'updateCache') {
        console.log('SW: Event listner heard -> updateCache');
        // Call your function or perform any desired action
        update_data_3();
    }
});

// Call a function in the client page
function callClientFunction(action_msg) {
    console.log('SW: calling client function: ' + action_msg);
    // Send a message to the client page
    self.clients.matchAll().then(function (clients) {
        clients.forEach(function (client) {
            client.postMessage({
                action: action_msg
            });
        });
    });
}";