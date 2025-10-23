(function($) {
    function renderMessage($container, message, type) {
        const classes = ['contact-alert'];
        if (type) {
            classes.push(`contact-alert--${type}`);
        }
        $container.html(`<div class="${classes.join(' ')}">${message}</div>`);
    }

    $(function() {
        const $form = $('#contact-form');
        if (!$form.length) {
            return;
        }

        const $submit = $form.find('button[type="submit"]');
        const $response = $('#contact-response');
        const defaultLabel = $submit.text();

        $form.on('submit', function(event) {
            event.preventDefault();

            $submit.prop('disabled', true).addClass('is-loading');
            if (window.bgContactForm && window.bgContactForm.sendingLabel) {
                $submit.text(window.bgContactForm.sendingLabel);
            }
            $response.empty();

            $.ajax({
                url: (window.bgContactForm && window.bgContactForm.ajaxUrl) || '',
                method: 'POST',
                dataType: 'json',
                data: $form.serialize() + '&action=bg_contact_form_submit'
            })
                .done(function(result) {
                    if (result && result.success) {
                        renderMessage($response, result.data.message, 'success');
                        $form[0].reset();
                    } else {
                        const message = result && result.data && result.data.message
                            ? result.data.message
                            : (window.bgContactForm && window.bgContactForm.errorMessage) || '';
                        renderMessage($response, message, 'error');
                    }
                })
                .fail(function() {
                    renderMessage(
                        $response,
                        (window.bgContactForm && window.bgContactForm.errorMessage) || '',
                        'error'
                    );
                })
                .always(function() {
                    $submit.prop('disabled', false).removeClass('is-loading').text(defaultLabel);
                });
        });
    });
})(jQuery);
