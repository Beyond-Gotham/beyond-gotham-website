(() => {
  const docEl = document.documentElement;
  if (docEl) {
    docEl.classList.remove('no-js');
    docEl.classList.add('js');
  }

  const bodyEl = document.body;

  const query = (selector, scope = document) => scope.querySelector(selector);
  const queryAll = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

  const escapeSelector = (value) => {
    if (typeof value !== 'string') {
      return '';
    }

    if (window.CSS && typeof window.CSS.escape === 'function') {
      return window.CSS.escape(value);
    }

    return value.replace(/"/g, '\\"');
  };

  const focusableSelector = [
    'a[href]',
    'button:not([disabled])',
    'input:not([disabled])',
    'select:not([disabled])',
    'textarea:not([disabled])',
    '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  let lastFocusedElement = null;

  const nav = query('[data-bg-nav]');
  const toggle = query('[data-bg-nav-toggle]');
  const overlay = query('[data-bg-nav-overlay]');

  const trapFocus = (event) => {
    if (!nav || event.key !== 'Tab') {
      return;
    }

    const focusable = queryAll(focusableSelector, nav);
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

  const closeNav = () => {
    if (!nav || !toggle) {
      return;
    }

    nav.classList.remove('is-open');
    nav.removeAttribute('role');
    nav.removeAttribute('aria-modal');
    nav.removeEventListener('keydown', trapFocus);

    toggle.setAttribute('aria-expanded', 'false');

    if (overlay) {
      overlay.classList.remove('is-active');
    }

    if (bodyEl) {
      bodyEl.classList.remove('is-nav-open');
    }

    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
      lastFocusedElement.focus({ preventScroll: true });
    }
  };

  const openNav = () => {
    if (!nav || !toggle) {
      return;
    }

    lastFocusedElement = document.activeElement;
    nav.classList.add('is-open');
    nav.setAttribute('role', 'dialog');
    nav.setAttribute('aria-modal', 'true');
    nav.addEventListener('keydown', trapFocus);

    toggle.setAttribute('aria-expanded', 'true');

    if (overlay) {
      overlay.classList.add('is-active');
    }

    if (bodyEl) {
      bodyEl.classList.add('is-nav-open');
    }

    const focusable = queryAll(focusableSelector, nav);
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
    queryAll('a', nav).forEach((link) => {
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

  const revealAnimated = () => {
    const animated = queryAll('[data-bg-animate]');
    if (!animated.length) {
      return;
    }

    if (!('IntersectionObserver' in window)) {
      animated.forEach((element) => element.classList.add('is-visible'));
      return;
    }

    const observer = new IntersectionObserver((entries, observerInstance) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observerInstance.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    animated.forEach((element) => observer.observe(element));
  };

  const initSmoothScroll = () => {
    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-bg-scroll]');
      if (!trigger) {
        return;
      }

      const targetSelector = trigger.getAttribute('data-bg-scroll') || trigger.getAttribute('href');
      if (!targetSelector || !targetSelector.startsWith('#')) {
        return;
      }

      const target = document.querySelector(targetSelector);
      if (!target) {
        return;
      }

      event.preventDefault();
      const top = target.getBoundingClientRect().top + window.pageYOffset - 80;
      window.scrollTo({ top, behavior: 'smooth' });
      target.setAttribute('tabindex', '-1');
      target.focus({ preventScroll: true });
    });
  };

  const toggleVoucherFields = (checkbox) => {
    if (!checkbox) {
      return;
    }

    const targetSelector = checkbox.getAttribute('data-bg-toggle');
    if (!targetSelector) {
      return;
    }

    const target = query(`[data-bg-target="${escapeSelector(targetSelector)}"]`);
    if (!target) {
      return;
    }

    if (checkbox.checked) {
      target.removeAttribute('hidden');
    } else {
      target.setAttribute('hidden', '');
      queryAll('input, select, textarea', target).forEach((field) => {
        if ('value' in field) {
          field.value = '';
        }
      });
    }
  };

  const renderNotice = (container, message, variant) => {
    if (!container) {
      return;
    }

    if (!message) {
      container.innerHTML = '';
      return;
    }

    const classes = ['bg-enrollment-notice'];
    if (variant) {
      classes.push(`bg-enrollment-notice--${variant}`);
    }

    container.innerHTML = `<div class="${classes.join(' ')}">${message}</div>`;
  };

  const initEnrollmentForms = () => {
    const wrappers = queryAll('.course-sidebar__card--form, .bg-enrollment');
    if (!wrappers.length) {
      return;
    }

    wrappers.forEach((wrapper) => {
      const form = query('.bg-enrollment__form', wrapper);
      const messages = query('.bg-enrollment__messages', wrapper);
      const submit = query('.bg-enrollment__submit', wrapper);
      const toggleField = query('[data-bg-toggle]', form);

      if (!form || !submit) {
        return;
      }

      const defaultLabel = submit.dataset.defaultLabel || submit.textContent || '';

      if (toggleField) {
        toggleVoucherFields(toggleField);
        toggleField.addEventListener('change', () => toggleVoucherFields(toggleField));
      }

      form.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        if (window.BG_AJAX && window.BG_AJAX.nonce) {
          formData.append('security', window.BG_AJAX.nonce);
        }

        const sendingLabel = (window.BG_AJAX && window.BG_AJAX.messages && window.BG_AJAX.messages.sending)
          ? window.BG_AJAX.messages.sending
          : defaultLabel || '';

        submit.disabled = true;
        if (sendingLabel) {
          submit.textContent = sendingLabel;
        }

        renderNotice(messages, '');

        const requestUrl = (window.BG_AJAX && window.BG_AJAX.ajax_url) || form.getAttribute('action');
        if (!requestUrl) {
          const fallbackMessage = (window.BG_AJAX && window.BG_AJAX.messages && window.BG_AJAX.messages.genericError) || '';
          renderNotice(messages, fallbackMessage, 'error');
          submit.disabled = false;
          submit.textContent = defaultLabel;
          return;
        }

        fetch(requestUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
          .then(async (response) => {
            const data = await response.json().catch(() => null);
            if (!response.ok) {
              throw data;
            }
            return data;
          })
          .then((data) => {
            if (data && data.success) {
              const message = data.data && data.data.message ? data.data.message : '';
              renderNotice(messages, message, 'success');
              form.reset();
              if (toggleField) {
                toggleField.checked = false;
                toggleVoucherFields(toggleField);
              }
            } else {
              const message = data && data.data && data.data.message
                ? data.data.message
                : (window.BG_AJAX && window.BG_AJAX.messages && window.BG_AJAX.messages.genericError) || '';
              renderNotice(messages, message, 'error');
            }
          })
          .catch((errorData) => {
            let message = '';
            if (errorData && errorData.data && errorData.data.message) {
              message = errorData.data.message;
            } else if (window.BG_AJAX && window.BG_AJAX.messages && window.BG_AJAX.messages.genericError) {
              message = window.BG_AJAX.messages.genericError;
            }
            renderNotice(messages, message, 'error');
          })
          .finally(() => {
            submit.disabled = false;
            submit.textContent = defaultLabel;
          });
      });
    });
  };

  const initFilterForms = () => {
    const filterForm = query('[data-bg-filter-form]');
    if (!filterForm) {
      return;
    }

    queryAll('[data-bg-filter-select]', filterForm).forEach((selectEl) => {
      selectEl.addEventListener('change', () => filterForm.submit());
    });

    queryAll('[data-bg-filter-reset]', filterForm).forEach((button) => {
      button.addEventListener('click', () => {
        queryAll('select', filterForm).forEach((selectEl) => {
          selectEl.value = '';
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
  };

  const initStickyHeader = () => {
    const header = query('.site-header');
    if (!header) {
      return;
    }

    const toggleCondensed = () => {
      if (!bodyEl || !bodyEl.classList.contains('bg-has-sticky-header')) {
        header.classList.remove('is-condensed');
        return;
      }

      const offset = window.pageYOffset || document.documentElement.scrollTop || 0;
      if (offset > 80) {
        header.classList.add('is-condensed');
      } else {
        header.classList.remove('is-condensed');
      }
    };

    toggleCondensed();
    window.addEventListener('scroll', toggleCondensed, { passive: true });
    document.addEventListener('bg:navStickyToggle', toggleCondensed);
  };

  const initCarousels = () => {
    queryAll('[data-bg-carousel]').forEach((carousel) => {
      const track = query('[data-bg-carousel-track]', carousel);
      if (!track) {
        return;
      }

      const cardWidth = () => {
        const firstCard = query('.bg-card', track);
        if (!firstCard) {
          return 320;
        }
        const rect = firstCard.getBoundingClientRect();
        return rect.width + 24;
      };

      const prev = query('[data-bg-carousel-prev]', carousel);
      const next = query('[data-bg-carousel-next]', carousel);

      if (prev) {
        prev.addEventListener('click', () => {
          track.scrollBy({ left: -cardWidth(), behavior: 'smooth' });
        });
      }

      if (next) {
        next.addEventListener('click', () => {
          track.scrollBy({ left: cardWidth(), behavior: 'smooth' });
        });
      }
    });
  };

  const init = () => {
    revealAnimated();
    initSmoothScroll();
    initEnrollmentForms();
    initFilterForms();
    initStickyHeader();
    initCarousels();

    if (bodyEl) {
      bodyEl.classList.remove('bg-ui-loading');
      bodyEl.classList.add('bg-ui-ready');
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
