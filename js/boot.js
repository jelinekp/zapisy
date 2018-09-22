var platformCssElem; // Contains link element, change href to load platform-
                     // -specific CSS

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
  // Load base CSS used by all platforms
  var cssFrag = document.createElement("link");
  cssFrag.setAttribute("rel", "stylesheet");
  cssFrag.setAttribute("type", "text/css");
  cssFrag.setAttribute("href", "css/base.css");
  document.getElementsByTagName("head").item(0).appendChild(cssFrag);

  // Load platform-specific CSS, currently only Android
  cssFrag = document.createElement("link");
  cssFrag.setAttribute("rel", "stylesheet");
  cssFrag.setAttribute("type", "text/css");
  cssFrag.setAttribute("href", "css/android.css");
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
