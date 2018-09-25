var platformCssElem; // Contains link element, change href to load platform-
                     // -specific CSS

function getPlatformCssPath() {
  var platform = window.navigator.platform;
  var ua = window.navigator.userAgent;

  if(['iPhone', 'iPad', 'iPod'].indexOf(platform) !== -1) {
    return 'css/ios.css';
  } else if (/Android/.test(ua)) {
    return 'css/android.css';
  }
  return ''; // Don't override anything if we don't know where we run
}

function loadJSON(url, callback) {
  const request = new Request(url);

  window.caches.open('workbooks-dynamic').then(function(cache) {
    cache.match(request).then(function(response) {
      response.json().then(function(data) {
        callback(data);
      });
    });
  });

  fetch(request).then(response => {
    if(response.status === 200) {
      response.json().then(function(data) {
        callback(data);
      });
    }
  });
}

function boot() {
  // Load platform-specific CSS, currently only Android
  var cssFrag = document.createElement("link");
  cssFrag.setAttribute("rel", "stylesheet");
  cssFrag.setAttribute("type", "text/css");
  cssFrag.setAttribute("href", getPlatformCssPath());
  document.getElementsByTagName("head").item(0).appendChild(cssFrag);

  // Store reference somewhere safe
  platformCssElem = cssFrag;

  loadWorkbooks();
  loadExams();
}

if ('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('./service-worker.js')
           .then(function() { console.log('Service Worker Registered'); });
}
