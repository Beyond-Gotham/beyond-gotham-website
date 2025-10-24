(function (wp, data) {
    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;
    var docEl = document.documentElement;
    var bodyEl = document.body;
    var fontStacks = (data && data.fontStacks) ? data.fontStacks : {};
    var footerSelector = data && data.footerTarget ? data.footerTarget : '.site-info';

    function setCSSVariable(name, value) {
        if (!name) {
            return;
        }

        if (value) {
            docEl.style.setProperty(name, value);
        } else {
            docEl.style.removeProperty(name);
        }
    }

    function updateFooter(newValue) {
        var footer = document.querySelector(footerSelector);
        if (footer) {
            footer.innerHTML = newValue || '';
        }
    }

    api('beyond_gotham_primary_color', function (value) {
        value.bind(function (newValue) {
            setCSSVariable('--accent', newValue);
        });
    });

    api('beyond_gotham_secondary_color', function (value) {
        value.bind(function (newValue) {
            setCSSVariable('--accent-alt', newValue);
        });
    });

    api('beyond_gotham_body_font_family', function (value) {
        value.bind(function (newValue) {
            if (fontStacks[newValue]) {
                bodyEl.style.fontFamily = fontStacks[newValue];
            }
        });
    });

    api('beyond_gotham_body_font_size', function (value) {
        value.bind(function (newValue) {
            var size = parseInt(newValue, 10);
            if (!isNaN(size) && size > 0) {
                bodyEl.style.fontSize = size + 'px';
            }
        });
    });

    api('beyond_gotham_footer_text', function (value) {
        value.bind(function (newValue) {
            updateFooter(newValue);
        });
    });
})(window.wp, window.BGCustomizerPreview);
