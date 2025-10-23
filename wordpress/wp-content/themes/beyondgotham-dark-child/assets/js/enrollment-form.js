(function($) {
    function renderNotice($container, message, type) {
        const classes = ['bg-enrollment-notice'];
        if (type) {
            classes.push(`bg-enrollment-notice--${type}`);
        }
        $container.html(`<div class="${classes.join(' ')}">${message}</div>`);
    }

    function toggleBildungsgutschein($fields, show) {
        if (!$fields.length) {
            return;
        }

        if (show) {
            $fields.removeAttr('hidden');
        } else {
            $fields.attr('hidden', true);
            $fields.find('input').val('');
        }
    }

    function initForm($wrapper) {
        const $form = $wrapper.find('.bg-enrollment-form');
        if (!$form.length) {
            return;
        }

        const $submit = $form.find('.bg-enrollment-submit');
        const defaultLabel = $form.data('submit-label') || $submit.text();
        const $response = $form.find('.bg-enrollment-response');
        const $toggle = $form.find('.bg-enrollment-toggle');
        const $fields = $wrapper.find('.bg-enrollment-bildungsgutschein');

        if ($toggle.length) {
            toggleBildungsgutschein($fields, $toggle.is(':checked'));
            $toggle.on('change', function() {
                toggleBildungsgutschein($fields, $(this).is(':checked'));
            });
        }

        $form.on('submit', function(event) {
            event.preventDefault();

            $submit.prop('disabled', true).addClass('is-loading');
            if (window.bgEnrollmentForm && window.bgEnrollmentForm.sendingLabel) {
                $submit.text(window.bgEnrollmentForm.sendingLabel);
            }
            $response.empty();

            $.ajax({
                url: (window.bgEnrollmentForm && window.bgEnrollmentForm.ajaxUrl) || '',
                method: 'POST',
                dataType: 'json',
                data: $form.serialize()
            })
                .done(function(result) {
                    if (result && result.success) {
                        renderNotice($response, result.data.message, 'success');
                        $form[0].reset();
                        toggleBildungsgutschein($fields, false);

                        if (result.data.redirect) {
                            setTimeout(function() {
                                window.location.href = result.data.redirect;
                            }, (window.bgEnrollmentForm && window.bgEnrollmentForm.redirectDelay) || 2000);
                        }
                    } else {
                        const message = result && result.data && result.data.message
                            ? result.data.message
                            : (window.bgEnrollmentForm && window.bgEnrollmentForm.errorMessage) || '';
                        renderNotice($response, message, 'error');
                    }
                })
                .fail(function() {
                    renderNotice(
                        $response,
                        (window.bgEnrollmentForm && window.bgEnrollmentForm.errorMessage) || '',
                        'error'
                    );
                })
                .always(function() {
                    $submit.prop('disabled', false)
                        .removeClass('is-loading')
                        .text(defaultLabel);
                });
        });
    }

    $(function() {
        $('.bg-enrollment-form-wrapper').each(function() {
            initForm($(this));
        });
    });
})(jQuery);
