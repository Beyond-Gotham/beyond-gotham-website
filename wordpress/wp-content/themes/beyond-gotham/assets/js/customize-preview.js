(function (wp, data) {
    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;
    var docEl = document.documentElement;
    var bodyEl = document.body;
    var fontStacks = (data && data.fontStacks) ? data.fontStacks : {};
    var footerSelector = data && data.footerTarget ? data.footerTarget : '.site-info';
    var headingSelector = data && data.headingSelector ? data.headingSelector : 'h1, h2, h3, h4, h5, h6';
    var footerSocialSelector = data && data.footerSocialSelector ? data.footerSocialSelector : '[data-bg-footer-social]';
    var ctaSelectors = (data && data.ctaSelectors) ? data.ctaSelectors : {};
    var ctaWrapperSelector = ctaSelectors.wrapper || '[data-bg-cta]';
    var ctaTextSelector = ctaSelectors.text || '[data-bg-cta-text]';
    var ctaButtonSelector = ctaSelectors.button || '[data-bg-cta-button]';

    function toArray(nodeList) {
        return Array.prototype.slice.call(nodeList || []);
    }

    function getNodes(selector) {
        if (!selector) {
            return [];
        }

        return toArray(document.querySelectorAll(selector));
    }

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

    function updateHeadingFont(fontKey) {
        var stack = fontStacks[fontKey];

        getNodes(headingSelector).forEach(function (heading) {
            if (stack) {
                heading.style.fontFamily = stack;
            } else {
                heading.style.removeProperty('font-family');
            }
        });
    }

    var bodyFontSizeValue = null;
    var bodyFontSizeUnit = 'px';

    function updateBodyFontSize() {
        var value = parseFloat(bodyFontSizeValue);
        if (isNaN(value) || value <= 0) {
            return;
        }

        if (bodyFontSizeUnit === 'rem') {
            bodyEl.style.fontSize = value + 'rem';
        } else {
            bodyEl.style.fontSize = Math.round(value) + 'px';
        }
    }

    function hexToRgba(hex, alpha) {
        if (!hex) {
            return '';
        }

        var normalized = hex.replace('#', '');

        if (normalized.length === 3) {
            normalized = normalized[0] + normalized[0] + normalized[1] + normalized[1] + normalized[2] + normalized[2];
        }

        if (normalized.length !== 6) {
            return '';
        }

        var r = parseInt(normalized.substr(0, 2), 16);
        var g = parseInt(normalized.substr(2, 2), 16);
        var b = parseInt(normalized.substr(4, 2), 16);
        var a = Math.max(0, Math.min(1, parseFloat(alpha)));

        if (isNaN(r) || isNaN(g) || isNaN(b)) {
            return '';
        }

        return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';
    }

    function updateCTAStyles(color) {
        var wrappers = getNodes(ctaWrapperSelector);
        var buttons = getNodes(ctaButtonSelector);

        if (!color) {
            wrappers.forEach(function (el) {
                el.style.removeProperty('background');
                el.style.removeProperty('border-color');
            });
            buttons.forEach(function (btn) {
                btn.style.removeProperty('background-color');
                btn.style.removeProperty('border-color');
            });
            return;
        }

        var light = hexToRgba(color, 0.15);
        var soft = hexToRgba(color, 0.1);
        var border = hexToRgba(color, 0.3);

        wrappers.forEach(function (el) {
            if (light && soft) {
                el.style.background = 'linear-gradient(135deg, ' + light + ', ' + soft + ')';
            }

            if (border) {
                el.style.borderColor = border;
            }
        });

        buttons.forEach(function (btn) {
            btn.style.backgroundColor = color;
            btn.style.borderColor = color;
        });
    }

    function updateCTAContent(value) {
        getNodes(ctaTextSelector).forEach(function (el) {
            el.innerHTML = value || '';
        });

        toggleCTAWrapperVisibility();
    }

    function updateCTALabel(value) {
        getNodes(ctaButtonSelector).forEach(function (btn) {
            btn.textContent = value || '';
        });

        toggleCTAWrapperVisibility();
    }

    function updateCTAUrl(value) {
        getNodes(ctaButtonSelector).forEach(function (btn) {
            if (value) {
                btn.setAttribute('href', value);
                btn.removeAttribute('aria-disabled');
            } else {
                btn.removeAttribute('href');
                btn.setAttribute('aria-disabled', 'true');
            }
        });

        toggleCTAWrapperVisibility();
    }

    function toggleCTAWrapperVisibility() {
        var wrappers = getNodes(ctaWrapperSelector);

        if (!wrappers.length) {
            return;
        }

        var hasText = false;
        getNodes(ctaTextSelector).forEach(function (el) {
            if ((el.innerHTML || '').trim() !== '') {
                hasText = true;
            }
        });

        var hasLabel = false;
        getNodes(ctaButtonSelector).forEach(function (btn) {
            if ((btn.textContent || '').trim() !== '') {
                hasLabel = true;
            }
        });

        var shouldShow = hasText || hasLabel;

        wrappers.forEach(function (wrapper) {
            if (shouldShow) {
                wrapper.classList.remove('newsletter--empty', 'site-footer__cta--empty', 'is-empty');
                wrapper.removeAttribute('hidden');
                wrapper.removeAttribute('aria-hidden');
            } else {
                wrapper.classList.add('is-empty');
                wrapper.setAttribute('hidden', 'hidden');
                wrapper.setAttribute('aria-hidden', 'true');
            }
        });
    }

    function toggleFooterSocial(show) {
        var container = document.querySelector(footerSocialSelector);
        if (!container) {
            return;
        }

        if (show) {
            container.classList.remove('is-hidden');
            container.removeAttribute('hidden');
            container.removeAttribute('aria-hidden');
        } else {
            container.classList.add('is-hidden');
            container.setAttribute('hidden', 'hidden');
            container.setAttribute('aria-hidden', 'true');
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

    api('beyond_gotham_background_color', function (value) {
        value.bind(function (newValue) {
            setCSSVariable('--bg', newValue);
            if (newValue) {
                bodyEl.style.backgroundColor = newValue;
            } else {
                bodyEl.style.removeProperty('background-color');
            }
        });
    });

    api('beyond_gotham_text_color', function (value) {
        value.bind(function (newValue) {
            setCSSVariable('--fg', newValue);
            if (newValue) {
                bodyEl.style.color = newValue;
            } else {
                bodyEl.style.removeProperty('color');
            }
        });
    });

    api('beyond_gotham_cta_accent_color', function (value) {
        value.bind(function (newValue) {
            setCSSVariable('--cta-accent', newValue);
            updateCTAStyles(newValue);
        });
    });

    api('beyond_gotham_body_font_family', function (value) {
        value.bind(function (newValue) {
            if (fontStacks[newValue]) {
                bodyEl.style.fontFamily = fontStacks[newValue];
            }
        });
    });

    api('beyond_gotham_heading_font_family', function (value) {
        value.bind(function (newValue) {
            updateHeadingFont(newValue);
        });
    });

    api('beyond_gotham_body_font_size', function (value) {
        bodyFontSizeValue = value.get();
        updateBodyFontSize();

        value.bind(function (newValue) {
            bodyFontSizeValue = newValue;
            updateBodyFontSize();
        });
    });

    api('beyond_gotham_body_font_size_unit', function (value) {
        bodyFontSizeUnit = value.get() || 'px';
        updateBodyFontSize();

        value.bind(function (newValue) {
            bodyFontSizeUnit = newValue || 'px';
            updateBodyFontSize();
        });
    });

    api('beyond_gotham_body_line_height', function (value) {
        value.bind(function (newValue) {
            var parsed = parseFloat(newValue);
            if (!isNaN(parsed) && parsed > 0) {
                bodyEl.style.lineHeight = parsed;
            }
        });
    });

    api('beyond_gotham_footer_text', function (value) {
        value.bind(function (newValue) {
            updateFooter(newValue);
        });
    });

    api('beyond_gotham_footer_show_social', function (value) {
        value.bind(function (newValue) {
            toggleFooterSocial(!!newValue);
        });
    });

    api('beyond_gotham_cta_text', function (value) {
        value.bind(function (newValue) {
            updateCTAContent(newValue);
        });
    });

    api('beyond_gotham_cta_button_label', function (value) {
        value.bind(function (newValue) {
            updateCTALabel(newValue);
        });
    });

    api('beyond_gotham_cta_button_url', function (value) {
        value.bind(function (newValue) {
            updateCTAUrl(newValue);
        });
    });
})(window.wp, window.BGCustomizerPreview);
