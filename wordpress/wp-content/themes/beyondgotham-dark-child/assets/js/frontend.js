(function ($) {
  function initAnimations() {
    if (!('IntersectionObserver' in window)) {
      $('[data-bg-animate]').addClass('is-visible');
      return;
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('[data-bg-animate]').forEach((element) => observer.observe(element));
  }

  function initSmoothScroll() {
    $(document).on('click', '[data-bg-scroll]', function (event) {
      const targetSelector = $(this).data('bg-scroll') || $(this).attr('href');
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
  }

  function toggleVoucherFields($toggle) {
    const targetSelector = $toggle.data('bg-toggle');
    if (!targetSelector) {
      return;
    }

    const $target = $(`[data-bg-target="${targetSelector}"]`);
    if (!$target.length) {
      return;
    }

    const isChecked = $toggle.is(':checked');
    if (isChecked) {
      $target.removeAttr('hidden');
    } else {
      $target.attr('hidden', true);
      $target.find('input').val('');
    }
  }

  function renderNotice($container, message, variant) {
    if (!message) {
      $container.empty();
      return;
    }

    const classes = ['bg-enrollment-notice'];
    if (variant) {
      classes.push(`bg-enrollment-notice--${variant}`);
    }

    $container.html(`<div class="${classes.join(' ')}">${message}</div>`);
  }

  function initEnrollmentForms() {
    $('.course-sidebar__card--form, .bg-enrollment').each(function () {
      const $wrapper = $(this);
      const $form = $wrapper.find('.bg-enrollment__form');
      if (!$form.length) {
        return;
      }

      const $messages = $wrapper.find('.bg-enrollment__messages');
      const $submit = $wrapper.find('.bg-enrollment__submit');
      const defaultLabel = $submit.data('default-label') || $submit.text();

      const $toggle = $form.find('[data-bg-toggle]');
      if ($toggle.length) {
        toggleVoucherFields($toggle);
        $toggle.on('change', function () {
          toggleVoucherFields($(this));
        });
      }

      $form.on('submit', function (event) {
        event.preventDefault();

        const formData = new FormData($form[0]);
        if (window.BG_AJAX && BG_AJAX.nonce) {
          formData.append('security', BG_AJAX.nonce);
        }

        var sendingLabel = defaultLabel;
        if (window.BG_AJAX && BG_AJAX.messages && BG_AJAX.messages.sending) {
          sendingLabel = BG_AJAX.messages.sending;
        }

        $submit.prop('disabled', true).text(sendingLabel);
        renderNotice($messages, '');

        $.ajax({
          url: window.BG_AJAX ? BG_AJAX.ajax_url : '',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json'
        })
          .done(function (response) {
            if (response && response.success) {
              renderNotice($messages, response.data.message, 'success');
              $form[0].reset();
              if ($toggle.length) {
                $toggle.prop('checked', false);
                toggleVoucherFields($toggle);
              }
            } else {
              const message = response && response.data && response.data.message
                ? response.data.message
                : (window.BG_AJAX && BG_AJAX.messages ? BG_AJAX.messages.genericError : '');
              renderNotice($messages, message, 'error');
            }
          })
          .fail(function (xhr) {
            const message = (xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message)
              ? xhr.responseJSON.data.message
              : (window.BG_AJAX && BG_AJAX.messages ? BG_AJAX.messages.genericError : '');
            renderNotice($messages, message, 'error');
          })
          .always(function () {
            $submit.prop('disabled', false).text(defaultLabel);
          });
      });
    });
  }

  $(function () {
    initAnimations();
    initSmoothScroll();
    initEnrollmentForms();
  });
})(jQuery);
