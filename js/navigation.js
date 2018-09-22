const pages = {
  workbooks: {
    tab: null,
    page: null,
    position: 1
  },
  exams: {
    tab: null,
    page: null,
    position: 2
  },
  dev: {
    tab: null,
    page: null,
    position: 3
  }
};

const valid_pages = [
  "workbooks",
  "exams"
];

var currentPage = pages.workbooks;
var initialX = 0;
var initialY = 0;

function nav_load() {
  pages.workbooks.tab = document.getElementById('tab-workbooks');
  pages.workbooks.page = document.getElementById('page-workbooks');

  pages.exams.tab = document.getElementById('tab-exams');
  pages.exams.page = document.getElementById('page-exams');

  var body = document.getElementsByTagName('body')[0];
  body.addEventListener('touchstart', nav_touchstart, false);
  body.addEventListener('touchmove', nav_touchmove, false);

  nav_update();
}

function nav_update() {
  valid_pages.forEach((k) => {
    if(pages[k] == currentPage) {
      pages[k].tab.classList.add('active');
      pages[k].page.classList.remove('hidden');
    } else {
      pages[k].tab.classList.remove('active');
      pages[k].page.classList.add('hidden');
    }
  });
};

function nav_move(target) {
  currentPage = pages[target];
  nav_update();
}

function nav_touchstart(e) {
  initialX = e.touches[0].clientX;
  initialY = e.touches[0].clientY;
}

function nav_move_right() {
  var i = 0;
  for(i = 0; i < valid_pages.length; i++) {
    if (currentPage == pages[valid_pages[i]]) {
      break;
    }
  }

  if (i < valid_pages.length - 1) {
    currentPage = pages[valid_pages[i + 1]];
  }

  nav_update();
}

function nav_move_left() {
  var i = 0;
  for(i = 0; i < valid_pages.length; i++) {
    if (currentPage == pages[valid_pages[i]]) {
      break;
    }
  }

  if (i > 0) {
    currentPage = pages[valid_pages[i - 1]];
  }

  nav_update();
}

function nav_touchmove(e) {
  var cx = e.touches[0].clientX;
  var cy = e.touches[0].clientY;

  var diffX = initialX - cx;
  var diffY = initialY - cy;

  if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 200) {
    if(diffX > 0) {
      nav_move_right();
    } else {
      nav_move_left();
    }
    e.preventDefault();
  }
}
