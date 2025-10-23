(() => {
  const docEl = document.documentElement;
  docEl.classList.remove('no-js');
  docEl.classList.add('js');

  const nav = document.querySelector('[data-bg-nav]');
  const toggle = document.querySelector('[data-bg-nav-toggle]');
  const overlay = document.querySelector('[data-bg-nav-overlay]');
  let lastFocusedElement = null;

  const getFocusable = (container) => {
    if (!container) {
      return [];
    }
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    );
  };

  const closeNav = () => {
    if (!nav || !toggle) {
      return;
    }
    nav.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
    if (overlay) {
      overlay.classList.remove('is-active');
    }
    if (document.body) {
      document.body.classList.remove('is-nav-open');
    }
    nav.removeAttribute('aria-modal');
    nav.removeAttribute('role');
    nav.removeEventListener('keydown', trapFocus);
    if (lastFocusedElement) {
      lastFocusedElement.focus({ preventScroll: true });
    }
  };

  const trapFocus = (event) => {
    if (event.key !== 'Tab') {
      return;
    }

    const focusable = getFocusable(nav);
    if (!focusable.length) {
      return;
    }

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  };

  const openNav = () => {
    if (!nav || !toggle) {
      return;
    }
    lastFocusedElement = document.activeElement;
    nav.classList.add('is-open');
    toggle.setAttribute('aria-expanded', 'true');
    if (overlay) {
      overlay.classList.add('is-active');
    }
    if (document.body) {
      document.body.classList.add('is-nav-open');
    }
    nav.setAttribute('role', 'dialog');
    nav.setAttribute('aria-modal', 'true');
    nav.addEventListener('keydown', trapFocus);

    const focusable = getFocusable(nav);
    if (focusable.length) {
      focusable[0].focus();
    }
  };

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      if (nav.classList.contains('is-open')) {
        closeNav();
      } else {
        openNav();
      }
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeNav);
  }

  if (nav) {
    nav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        if (nav.classList.contains('is-open')) {
          closeNav();
        }
      });
    });
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && nav && nav.classList.contains('is-open')) {
      closeNav();
    }
  });

  const filterForm = document.querySelector('[data-bg-filter-form]');
  if (filterForm) {
    filterForm.querySelectorAll('[data-bg-filter-select]').forEach((select) => {
      select.addEventListener('change', () => {
        filterForm.submit();
      });
    });

    const resetButtons = filterForm.querySelectorAll('[data-bg-filter-reset]');
    resetButtons.forEach((button) => {
      button.addEventListener('click', () => {
        filterForm.querySelectorAll('select').forEach((select) => {
          select.value = '';
        });
        const action = filterForm.getAttribute('action');
        if (action) {
          window.location.href = action;
        } else {
          const url = new URL(window.location.href);
          url.search = '';
          window.location.replace(url.toString());
        }
      });
    });
  }

  document.querySelectorAll('[data-bg-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-bg-carousel-track]');
    if (!track) {
      return;
    }

    const scrollByCard = () => {
      const firstCard = track.querySelector('.bg-card');
      return firstCard ? firstCard.getBoundingClientRect().width + 24 : 320;
    };

    const prev = carousel.querySelector('[data-bg-carousel-prev]');
    const next = carousel.querySelector('[data-bg-carousel-next]');

    if (prev) {
      prev.addEventListener('click', () => {
        track.scrollBy({ left: -scrollByCard(), behavior: 'smooth' });
      });
    }

    if (next) {
      next.addEventListener('click', () => {
        track.scrollBy({ left: scrollByCard(), behavior: 'smooth' });
      });
    }
  });

  if (document.body) {
    document.body.classList.remove('bg-ui-loading');
    document.body.classList.add('bg-ui-ready');
  }
})();
