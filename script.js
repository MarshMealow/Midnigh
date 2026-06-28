/* javascript for my website */

/* phone menu button */
function initNav() {
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');
  if (!hamburger || !mobileMenu) return;

  hamburger.addEventListener('click', function () {
    const isOpen = mobileMenu.classList.toggle('nav__mobile--open');
    // change the hamburger icon when clicked
    hamburger.classList.toggle('nav__hamburger--open', isOpen);
  });
}

/* banner slider on home */
function initHeroSlider() {
  const slides = document.querySelectorAll('.hero__slide');
  const dots   = document.querySelectorAll('.hero__dot');
  if (slides.length === 0) return;

  let current = 0;
  let timer   = null;

  function goTo(index) {
    // hide the old slide
    slides[current].classList.remove('hero__slide--active');
    dots[current].classList.remove('hero__dot--active');

    // show the new slide
    current = (index + slides.length) % slides.length;

    slides[current].classList.add('hero__slide--active');
    dots[current].classList.add('hero__dot--active');
  }

  function startAuto() {
    timer = setInterval(function () {
      goTo(current + 1);
    }, 5000);
  }

  function resetAuto() {
    clearInterval(timer);
    startAuto();
  }

  // dots at the bottom of the banner
  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
      goTo(i);
      resetAuto();
    });
  });

  // left and right banner arrows
  const arrowLeft  = document.getElementById('arrow-left');
  const arrowRight = document.getElementById('arrow-right');
  if (arrowLeft)  arrowLeft.addEventListener('click',  function () { goTo(current - 1); resetAuto(); });
  if (arrowRight) arrowRight.addEventListener('click', function () { goTo(current + 1); resetAuto(); });

  // start on the first slide
  goTo(0);
  startAuto();
}

/* input colour changes for the assignment */
/* yellow when selected and white after leaving */
function initInputEffects() {
  const inputs = document.querySelectorAll('.form__input, .form__textarea, .form__select');

  inputs.forEach(function (input) {
    input.addEventListener('focus', function () {
      this.style.borderColor = '#EAB308';
      this.style.backgroundColor = 'yellow';
      this.style.color = 'black';
    });

    input.addEventListener('blur', function () {
      this.style.borderColor = '';
      this.style.backgroundColor = 'white';
      this.style.color = 'black';
    });
  });
}

/* button hover effect */
/* css does most of this, this just adds a class */
function initButtonEffects() {
  const buttons = document.querySelectorAll('.btn');
  buttons.forEach(function (btn) {
    btn.addEventListener('mouseenter', function () {
      this.style.boxShadow = '0 0 16px rgba(59,130,246,0.3)';
    });
    btn.addEventListener('mouseleave', function () {
      this.style.boxShadow = '';
    });
  });
}

/* show messages under forms */
function showNotification(id, type, message) {
  const el = document.getElementById(id);
  if (!el) return;

  // remove old message style
  el.classList.remove('notification--error', 'notification--success', 'notification--warning');
  el.classList.add('notification--' + type, 'notification--show');
  el.innerHTML = '<span>' + getNotifIcon(type) + '</span><span>' + message + '</span>';

  // hide message after a few seconds
  setTimeout(function () {
    el.classList.remove('notification--show');
  }, 4000);
}

function getNotifIcon(type) {
  if (type === 'error')   return '&#10007;';
  if (type === 'success') return '&#10003;';
  if (type === 'warning') return '&#9888;';
  return '';
}

/* helper checks for forms */
function isAlpha(str)    { return /^[A-Za-z\s]+$/.test(str.trim()); }
function isEmail(str)    { return /^[^\s@]+@[^\s@]+\.(com|net|my)$/i.test(str.trim()); }
function isPhone(str)    { return /^(\+64|0)[2-9]\d{7,9}$/.test(str.replace(/\s/g, '')); }
function isAlphaNum(str) { return /^[A-Za-z0-9]+$/.test(str.trim()); }
function isNumber(str)   { return /^\d+$/.test(str.trim()); }
function isDecimal(str)  { return /^\d+(\.\d{1,2})?$/.test(str.trim()); }

function setError(inputId, hintId, message) {
  const input = document.getElementById(inputId);
  const hint  = document.getElementById(hintId);
  if (input) input.style.borderColor = '#EF4444';
  if (hint)  { hint.textContent = message; hint.className = 'form__hint form__hint--error'; }
}

function clearError(inputId, hintId) {
  const input = document.getElementById(inputId);
  const hint  = document.getElementById(hintId);
  if (input) input.style.borderColor = '';
  if (hint)  { hint.textContent = hint.dataset.original || ''; hint.className = 'form__hint'; }
}

/* register page checks */
function initRegisterForm() {
  const form = document.getElementById('register-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    let valid = true;

    const fname = document.getElementById('fname');
    if (!fname.value.trim() || !isAlpha(fname.value)) {
      setError('fname', 'fname-hint', 'First name must contain letters only');
      valid = false;
    } else clearError('fname', 'fname-hint');

    const lname = document.getElementById('lname');
    if (!lname.value.trim() || !isAlpha(lname.value)) {
      setError('lname', 'lname-hint', 'Last name must contain letters only');
      valid = false;
    } else clearError('lname', 'lname-hint');

    const addr = document.getElementById('address');
    if (!addr.value.trim()) {
      setError('address', 'address-hint', 'Address is required');
      valid = false;
    } else clearError('address', 'address-hint');

    const phone = document.getElementById('phone');
    if (!phone.value.trim() || !isPhone(phone.value)) {
      setError('phone', 'phone-hint', 'Enter a valid NZ phone number');
      valid = false;
    } else clearError('phone', 'phone-hint');

    const email = document.getElementById('email');
    if (!email.value.trim() || !isEmail(email.value)) {
      setError('email', 'email-hint', 'Email must end in .com, .net, or .my');
      valid = false;
    } else clearError('email', 'email-hint');

    const uname = document.getElementById('username');
    if (!uname.value.trim() || uname.value.trim().length < 6 || !isAlphaNum(uname.value)) {
      setError('username', 'uname-hint', 'Min 6 alphanumeric characters');
      valid = false;
    } else clearError('username', 'uname-hint');

    const pass = document.getElementById('password');
    if (!pass.value.trim() || pass.value.trim().length < 6 || !isAlphaNum(pass.value)) {
      setError('password', 'pass-hint', 'Min 6 alphanumeric characters');
      valid = false;
    } else clearError('password', 'pass-hint');

    if (!valid) {
      e.preventDefault();
      showNotification('register-notif', 'error', 'Please fix the errors above before submitting.');
    }
  });

  const clearBtn = document.getElementById('register-clear');
  if (clearBtn) clearBtn.addEventListener('click', function () { form.reset(); });
}


/* home search goes to the search page */
function initHomeSearch() {
  const homeForm = document.getElementById('home-search-form');
  const homeInput = document.getElementById('home-search-input');

  if (homeForm && homeInput) {
    homeForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const query = homeInput.value.trim();
      if (!query) {
        window.location.href = 'search.php';
        return;
      }
      window.location.href = 'search.php?q=' + encodeURIComponent(query);
    });
  }

  const homeFilterButtons = document.querySelectorAll('[data-home-filter]');
  homeFilterButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      const filter = this.dataset.homeFilter;
      if (filter === 'all') {
        window.location.href = 'search.php';
      } else if (filter === 'under15000') {
        window.location.href = 'search.php?maxPrice=15000';
      } else if (filter === 'under25000') {
        window.location.href = 'search.php?maxPrice=25000';
      } else {
        window.location.href = 'search.php?type=' + encodeURIComponent(filter);
      }
    });
  });
}

/* search page filtering */
function initSearchForm() {
  const form = document.getElementById('search-form');
  if (!form) return;

  const resultCards = Array.from(document.querySelectorAll('.search-result'));
  const resultsCount = document.getElementById('results-count');
  const clearBtn = document.getElementById('search-clear');
  let currentSearchSort = 'newest';

  function updateCount(count) {
    if (resultsCount) {
      resultsCount.textContent = count + (count === 1 ? ' result found' : ' results found');
    }
  }

  function showAllResults() {
    resultCards.forEach(function (card) {
      card.style.display = '';
    });
    updateCount(resultCards.length);
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const make = document.getElementById('s-make').value.trim().toLowerCase();
    const year = document.getElementById('s-year').value;
    const min = document.getElementById('s-min').value.trim();
    const max = document.getElementById('s-max').value.trim();
    const type = document.getElementById('s-type').value.toLowerCase();
    const km = document.getElementById('s-km').value.trim();

    if (!make && !year && !min && !max && !type && !km) {
      showAllResults();
      showNotification('search-notif', 'warning', 'Please fill in at least one search field.');
      return;
    }

    if ((min && !isNumber(min)) || (max && !isNumber(max)) || (km && !isNumber(km))) {
      showNotification('search-notif', 'error', 'Price and mileage fields must contain numbers only.');
      return;
    }

    const minPrice = min ? Number(min) : 0;
    const maxPrice = max ? Number(max) : Infinity;
    const maxKm = km ? Number(km) : Infinity;

    if (min && max && minPrice > maxPrice) {
      showNotification('search-notif', 'error', 'Minimum price cannot be higher than maximum price.');
      return;
    }

    let matches = 0;

    resultCards.forEach(function (card) {
      const cardMake = card.dataset.make || '';
      const cardYear = card.dataset.year || '';
      const cardPrice = Number(card.dataset.price || 0);
      const cardType = card.dataset.type || '';
      const cardKm = Number(card.dataset.km || 0);

      const makeMatch = !make || cardMake.includes(make);
      const yearMatch = !year || cardYear === year;
      const priceMatch = cardPrice >= minPrice && cardPrice <= maxPrice;
      const typeMatch = !type || cardType === type;
      const kmMatch = cardKm <= maxKm;

      if (makeMatch && yearMatch && priceMatch && typeMatch && kmMatch) {
        card.style.display = '';
        matches += 1;
      } else {
        card.style.display = 'none';
      }
    });

    updateCount(matches);
    applyCurrentSearchSort();
    if (matches === 0) {
      showNotification('search-notif', 'warning', 'No cars matched your search. Try changing the filters.');
    } else {
      showNotification('search-notif', 'success', matches + (matches === 1 ? ' car matched your search.' : ' cars matched your search.'));
    }
  });

  function getSortValue(card, mode) {
    if (mode === 'price-asc' || mode === 'price-desc') return Number(card.dataset.price || 0);
    if (mode === 'km-asc') return Number(card.dataset.km || 0);
    return Number(card.dataset.order || 0);
  }

  function applyCurrentSearchSort() {
    const container = document.querySelector('.results-grid');
    if (!container) return;
    const sorted = resultCards.slice().sort(function (a, b) {
      if (currentSearchSort === 'price-desc') return getSortValue(b, currentSearchSort) - getSortValue(a, currentSearchSort);
      return getSortValue(a, currentSearchSort) - getSortValue(b, currentSearchSort);
    });
    sorted.forEach(function (card) { container.appendChild(card); });
  }

  const searchSortButtons = document.querySelectorAll('[data-search-sort]');
  searchSortButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      currentSearchSort = this.dataset.searchSort;
      applyCurrentSearchSort();
    });
  });

  if (clearBtn) {
    clearBtn.addEventListener('click', function () {
      form.reset();
      showAllResults();
      currentSearchSort = 'newest';
      applyCurrentSearchSort();
      showNotification('search-notif', 'success', 'Search filters have been cleared.');
    });
  }

  function applySearchFromHome() {
    const params = new URLSearchParams(window.location.search);
    const query = params.get('q');
    const type = params.get('type');
    const maxPrice = params.get('maxPrice');

    if (query) {
      const makeInput = document.getElementById('s-make');
      if (makeInput) makeInput.value = query;
    }

    if (type) {
      const typeInput = document.getElementById('s-type');
      if (typeInput) typeInput.value = type;
    }

    if (maxPrice) {
      const maxInput = document.getElementById('s-max');
      if (maxInput) maxInput.value = maxPrice;
    }

    if (query || type || maxPrice) {
      form.dispatchEvent(new Event('submit', { cancelable: true }));
    } else {
      showAllResults();
    }
  }

  applySearchFromHome();
}


/* filters on cars page */
function initCarsListingControls() {
  const listings = Array.from(document.querySelectorAll('.cars-listing'));
  if (!listings.length) return;

  const countLabel = document.getElementById('cars-listings-count');
  const filterButtons = document.querySelectorAll('[data-cars-filter]');
  const sortButtons = document.querySelectorAll('[data-cars-sort]');
  const container = listings[0].parentElement;
  let currentFilter = 'all';
  let currentSort = 'newest';

  function updateListingCount(count) {
    if (countLabel) {
      countLabel.textContent = count + (count === 1 ? ' car listed' : ' cars listed');
    }
  }

  function listingMatchesFilter(listing) {
    const price = Number(listing.dataset.price || 0);
    const type = listing.dataset.type || '';

    if (currentFilter === 'all') return true;
    if (currentFilter === 'under15000') return price <= 15000;
    if (currentFilter === 'under25000') return price <= 25000;
    return type === currentFilter;
  }

  function getSortValue(listing) {
    if (currentSort === 'price-asc' || currentSort === 'price-desc') return Number(listing.dataset.price || 0);
    if (currentSort === 'km-asc') return Number(listing.dataset.km || 0);
    return Number(listing.dataset.order || 0);
  }

  function sortListings() {
    const sorted = listings.slice().sort(function (a, b) {
      if (currentSort === 'price-desc') return getSortValue(b) - getSortValue(a);
      return getSortValue(a) - getSortValue(b);
    });
    sorted.forEach(function (listing) { container.appendChild(listing); });
  }

  function applyListingsFilter() {
    let matches = 0;
    listings.forEach(function (listing) {
      if (listingMatchesFilter(listing)) {
        listing.style.display = '';
        matches += 1;
      } else {
        listing.style.display = 'none';
      }
    });
    updateListingCount(matches);
    sortListings();
  }

  filterButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      currentFilter = this.dataset.carsFilter;
      applyListingsFilter();
    });
  });

  sortButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      currentSort = this.dataset.carsSort;
      applyListingsFilter();
    });
  });

  applyListingsFilter();
}

/* feedback form checks */
function initFeedbackForm() {
  const form = document.getElementById('feedback-form');
  if (!form) return;

  // put in todays date
  const dateInput = document.getElementById('fb-date');
  if (dateInput) {
    const today = new Date();
    const formatted = today.toISOString().split('T')[0];
    dateInput.value = formatted;
  }

  // star rating buttons
  let selectedRating = 0;
  const starBtns = document.querySelectorAll('.stars__btn');
  starBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      selectedRating = parseInt(this.dataset.value);
      starBtns.forEach(function (b, i) {
        b.classList.toggle('stars__btn--active', i < selectedRating);
      });
    });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    let valid = true;

    const car = document.getElementById('fb-car');
    if (!car.value.trim()) {
      setError('fb-car', 'fbcar-hint', 'Please enter the car being reviewed');
      valid = false;
    } else clearError('fb-car', 'fbcar-hint');

    const name = document.getElementById('fb-name');
    if (!name.value.trim() || !isAlpha(name.value)) {
      setError('fb-name', 'fbname-hint', 'Name must contain letters only');
      valid = false;
    } else clearError('fb-name', 'fbname-hint');

    const email = document.getElementById('fb-email');
    if (!email.value.trim() || !isEmail(email.value)) {
      setError('fb-email', 'fbemail-hint', 'Email must end in .com, .net, or .my');
      valid = false;
    } else clearError('fb-email', 'fbemail-hint');

    if (selectedRating === 0) {
      showNotification('feedback-notif', 'error', 'Please select a star rating.');
      return;
    }

    const comments = document.getElementById('fb-comments');
    if (!comments.value.trim() || comments.value.trim().length < 10) {
      setError('fb-comments', 'comments-hint', 'Comments must be at least 10 characters');
      valid = false;
    } else clearError('fb-comments', 'comments-hint');

    if (!valid) {
      showNotification('feedback-notif', 'error', 'Please fix the errors above before submitting.');
    } else {
      showNotification('feedback-notif', 'success', 'Thank you! Your feedback has been submitted.');
      form.reset();
      selectedRating = 0;
      starBtns.forEach(function (b) { b.classList.remove('stars__btn--active'); });
    }
  });

  const clearBtn = document.getElementById('feedback-clear');
  if (clearBtn) clearBtn.addEventListener('click', function () {
    form.reset();
    selectedRating = 0;
    starBtns.forEach(function (b) { b.classList.remove('stars__btn--active'); });
  });
}

/* filter chip active effect */
function initFilterChips() {
  const chips = document.querySelectorAll('.filters__chip, .sort__chip');
  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      // only change chips in the same row
      const siblings = this.parentElement.querySelectorAll('.filters__chip, .sort__chip');
      siblings.forEach(function (s) { s.classList.remove('filters__chip--active', 'sort__chip--active'); });
      this.classList.add('filters__chip--active', 'sort__chip--active');
    });
  });
}

/* init on dom ready */
document.addEventListener('DOMContentLoaded', function () {
  initNav();
  initHeroSlider();
  // initHomeSearch();
  initInputEffects();
  initButtonEffects();

  // These are now handled by PHP, so don't block form submission
  // initRegisterForm();
  // initCarsForm();
  // initSearchForm();
  // initFeedbackForm();

  initCarsListingControls();
  initFilterChips();
});
