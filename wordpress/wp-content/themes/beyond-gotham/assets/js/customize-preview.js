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

    var defaults = (data && data.defaults) ? data.defaults : {};
    var contrastThresholdRaw = (data && typeof data.contrastThreshold !== 'undefined') ? parseFloat(data.contrastThreshold) : 4.5;
    var contrastThreshold = (!isNaN(contrastThresholdRaw) && contrastThresholdRaw > 0) ? contrastThresholdRaw : 4.5;

    function sanitizeHex(value) {
        if (typeof value !== 'string') {
            return '';
        }

        var normalized = value.trim();

        if (!normalized) {
            return '';
        }

        if (normalized.charAt(0) !== '#') {
            normalized = '#' + normalized;
        }

        var match = normalized.match(/^#([0-9a-f]{3}|[0-9a-f]{6})$/i);

        if (!match) {
            return '';
        }

        return '#' + match[1].toLowerCase();
    }

    function defaultColor(key, fallback) {
        var raw = (defaults && typeof defaults[key] === 'string') ? defaults[key] : '';
        var sanitized = sanitizeHex(raw);

        if (sanitized) {
            return sanitized;
        }

        return sanitizeHex(fallback) || '';
    }

    function hexToRgb(hex) {
        var sanitized = sanitizeHex(hex);

        if (!sanitized) {
            return null;
        }

        var normalized = sanitized.slice(1);

        if (normalized.length === 3) {
            normalized = normalized[0] + normalized[0] + normalized[1] + normalized[1] + normalized[2] + normalized[2];
        }

        if (normalized.length !== 6) {
            return null;
        }

        var r = parseInt(normalized.substr(0, 2), 16);
        var g = parseInt(normalized.substr(2, 2), 16);
        var b = parseInt(normalized.substr(4, 2), 16);

        if (isNaN(r) || isNaN(g) || isNaN(b)) {
            return null;
        }

        return [r, g, b];
    }

    function relativeLuminance(hex) {
        var rgb = hexToRgb(hex);

        if (!rgb) {
            return null;
        }

        var channels = rgb.map(function (channel) {
            var value = channel / 255;

            if (value <= 0.03928) {
                return value / 12.92;
            }

            return Math.pow((value + 0.055) / 1.055, 2.4);
        });

        return (0.2126 * channels[0]) + (0.7152 * channels[1]) + (0.0722 * channels[2]);
    }

    function contrastRatio(colorA, colorB) {
        var lumA = relativeLuminance(colorA);
        var lumB = relativeLuminance(colorB);

        if (lumA === null || lumB === null) {
            return 0;
        }

        var lighter = Math.max(lumA, lumB);
        var darker = Math.min(lumA, lumB);

        return (lighter + 0.05) / (darker + 0.05);
    }

    function ensureContrast(preferred, background, fallbacks) {
        var candidates = [];
        var preferredSanitized = sanitizeHex(preferred);
        var backgroundSanitized = sanitizeHex(background);

        if (preferredSanitized) {
            candidates.push(preferredSanitized);
        }

        if (Array.isArray(fallbacks)) {
            fallbacks.forEach(function (color) {
                var sanitized = sanitizeHex(color);

                if (!sanitized) {
                    return;
                }

                if (candidates.indexOf(sanitized) === -1) {
                    candidates.push(sanitized);
                }
            });
        }

        ['#000000', '#ffffff'].forEach(function (color) {
            if (candidates.indexOf(color) === -1) {
                candidates.push(color);
            }
        });

        if (!backgroundSanitized) {
            return candidates.length ? candidates[0] : preferredSanitized || '';
        }

        for (var i = 0; i < candidates.length; i++) {
            if (contrastRatio(candidates[i], backgroundSanitized) >= contrastThreshold) {
                return candidates[i];
            }
        }

        return preferredSanitized || '';
    }

    var paletteDefaults = {
        background: defaultColor('backgroundColor', '#0f1115'),
        text: defaultColor('textColor', '#e7eaee'),
        darkText: defaultColor('darkTextColor', '#050608'),
        primary: defaultColor('primaryColor', '#33d1ff'),
        secondary: defaultColor('secondaryColor', '#1aa5d1'),
        headerBackground: defaultColor('headerBackgroundColor', '#0b0d12'),
        footerBackground: defaultColor('footerBackgroundColor', '#050608'),
        link: defaultColor('linkColor', '#33d1ff'),
        linkHover: defaultColor('linkHoverColor', '#1aa5d1'),
        buttonBackground: defaultColor('buttonBackgroundColor', '#33d1ff'),
        buttonText: defaultColor('buttonTextColor', '#050608'),
        quoteBackground: defaultColor('quoteBackgroundColor', '#161b2a')
    };

    var chosenColors = {
        background: paletteDefaults.background,
        text: paletteDefaults.text,
        headerBackground: paletteDefaults.headerBackground,
        footerBackground: paletteDefaults.footerBackground,
        link: paletteDefaults.link,
        linkHover: paletteDefaults.linkHover,
        buttonBackground: paletteDefaults.buttonBackground,
        buttonText: paletteDefaults.buttonText,
        quoteBackground: paletteDefaults.quoteBackground,
        primary: paletteDefaults.primary,
        secondary: paletteDefaults.secondary
    };

    var activeColors = {
        background: paletteDefaults.background,
        text: paletteDefaults.text,
        headerBackground: paletteDefaults.headerBackground,
        footerBackground: paletteDefaults.footerBackground,
        link: paletteDefaults.link,
        linkHover: paletteDefaults.linkHover,
        buttonBackground: paletteDefaults.buttonBackground,
        buttonText: paletteDefaults.buttonText,
        quoteBackground: paletteDefaults.quoteBackground,
        primary: paletteDefaults.primary,
        secondary: paletteDefaults.secondary
    };

    var orientationClasses = ['nav-horizontal', 'nav-vertical'];
    var positionClasses = ['nav-position-left', 'nav-position-center', 'nav-position-right', 'nav-position-below'];
    var dropdownClasses = ['nav-dropdown-down', 'nav-dropdown-right'];
    var stickyEnabledState = bodyEl ? bodyEl.classList.contains('bg-has-sticky-header') : true;
    var stickyOffsetValue = 0;

    function replaceBodyClass(classNames, activeClass) {
        if (!bodyEl || !Array.isArray(classNames)) {
            return;
        }

        classNames.forEach(function (className) {
            bodyEl.classList.remove(className);
        });

        if (activeClass) {
            bodyEl.classList.add(activeClass);
        }
    }

    function normalizeBoolean(value) {
        if (typeof value === 'string') {
            return value === '1' || value.toLowerCase() === 'true';
        }

        return !!value;
    }

    function dispatchStickyEvent() {
        var eventName = 'bg:navStickyToggle';

        if (typeof window.CustomEvent === 'function') {
            document.dispatchEvent(new CustomEvent(eventName));
            return;
        }

        var event = document.createEvent('CustomEvent');
        event.initCustomEvent(eventName, false, false, null);
        document.dispatchEvent(event);
    }

    function refreshStickyOffset() {
        if (!docEl) {
            return;
        }

        if (stickyEnabledState) {
            setCSSVariable('--bg-sticky-offset', stickyOffsetValue + 'px');
        } else {
            setCSSVariable('--bg-sticky-offset', '0px');
        }
    }

    function setOrientation(value) {
        var normalized = (value || '').toString().toLowerCase();
        var active = normalized === 'vertical' ? 'nav-vertical' : 'nav-horizontal';
        replaceBodyClass(orientationClasses, active);
    }

    function setPosition(value) {
        var normalized = (value || '').toString().toLowerCase();
        var map = {
            left: 'nav-position-left',
            center: 'nav-position-center',
            right: 'nav-position-right',
            below: 'nav-position-below'
        };

        var active = map[normalized] || map.right;
        replaceBodyClass(positionClasses, active);
    }

    function setDropdown(value) {
        var normalized = (value || '').toString().toLowerCase();
        var active = normalized === 'right' ? 'nav-dropdown-right' : 'nav-dropdown-down';
        replaceBodyClass(dropdownClasses, active);
    }

    function setStickyEnabled(value) {
        stickyEnabledState = normalizeBoolean(value);

        if (bodyEl) {
            if (stickyEnabledState) {
                bodyEl.classList.add('bg-has-sticky-header');
            } else {
                bodyEl.classList.remove('bg-has-sticky-header');
            }
        }

        refreshStickyOffset();
        dispatchStickyEvent();
    }

    function updateStickyOffset(newValue, shouldNotify) {
        var parsed = parseInt(newValue, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        stickyOffsetValue = parsed;
        refreshStickyOffset();

        if (shouldNotify) {
            dispatchStickyEvent();
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
        var sanitized = sanitizeHex(hex);

        if (!sanitized) {
            return '';
        }

        var normalized = sanitized.slice(1);

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
        var sanitized = sanitizeHex(color);

        if (!sanitized) {
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

        var light = hexToRgba(sanitized, 0.15);
        var soft = hexToRgba(sanitized, 0.1);
        var border = hexToRgba(sanitized, 0.3);

        wrappers.forEach(function (el) {
            if (light && soft) {
                el.style.background = 'linear-gradient(135deg, ' + light + ', ' + soft + ')';
            }

            if (border) {
                el.style.borderColor = border;
            }
        });

        buttons.forEach(function (btn) {
            btn.style.backgroundColor = sanitized;
            btn.style.borderColor = sanitized;
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

    function applyBackgroundColor(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.background;

        chosenColors.background = sanitized;
        activeColors.background = sanitized;

        setCSSVariable('--bg', sanitized);

        if (bodyEl) {
            bodyEl.style.backgroundColor = sanitized;
        }

        applyTextColor(chosenColors.text);
        applyLinkColor(chosenColors.link);
        applyLinkHoverColor(chosenColors.linkHover);
        applyQuoteBackground(chosenColors.quoteBackground);
    }

    function applyTextColor(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.text;
        var ensured = ensureContrast(sanitized, activeColors.background, [paletteDefaults.text, paletteDefaults.darkText]);

        chosenColors.text = sanitized;
        activeColors.text = ensured || paletteDefaults.text;

        setCSSVariable('--fg', activeColors.text);

        if (bodyEl) {
            bodyEl.style.color = activeColors.text;
        }

        applyHeaderBackground(chosenColors.headerBackground);
        applyFooterBackground(chosenColors.footerBackground);
        applyQuoteBackground(chosenColors.quoteBackground);
        applyButtonTextColor(chosenColors.buttonText);
    }

    function applyHeaderBackground(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.headerBackground;
        var ensured = ensureContrast(sanitized, activeColors.text, [paletteDefaults.headerBackground, activeColors.background]);

        chosenColors.headerBackground = sanitized;
        activeColors.headerBackground = ensured || paletteDefaults.headerBackground;

        setCSSVariable('--bg-header', activeColors.headerBackground);
    }

    function applyFooterBackground(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.footerBackground;
        var ensured = ensureContrast(sanitized, activeColors.text, [paletteDefaults.footerBackground, activeColors.background]);

        chosenColors.footerBackground = sanitized;
        activeColors.footerBackground = ensured || paletteDefaults.footerBackground;

        setCSSVariable('--bg-footer', activeColors.footerBackground);
    }

    function applyLinkColor(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.link;
        var ensured = ensureContrast(sanitized, activeColors.background, [paletteDefaults.link, activeColors.primary, activeColors.secondary, paletteDefaults.darkText, activeColors.text]);

        chosenColors.link = sanitized;
        activeColors.link = ensured || paletteDefaults.link;

        setCSSVariable('--link-color', activeColors.link);
    }

    function applyLinkHoverColor(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.linkHover;
        var ensured = ensureContrast(sanitized, activeColors.background, [activeColors.link, paletteDefaults.linkHover, activeColors.secondary, activeColors.primary, paletteDefaults.darkText, activeColors.text]);

        chosenColors.linkHover = sanitized;
        activeColors.linkHover = ensured || paletteDefaults.linkHover;

        setCSSVariable('--link-hover-color', activeColors.linkHover);
    }

    function applyButtonBackground(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.buttonBackground;

        chosenColors.buttonBackground = sanitized;
        activeColors.buttonBackground = sanitized;

        setCSSVariable('--button-bg', activeColors.buttonBackground);

        applyButtonTextColor(chosenColors.buttonText);
    }

    function applyButtonTextColor(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.buttonText;
        var ensured = ensureContrast(sanitized, activeColors.buttonBackground || paletteDefaults.buttonBackground, [paletteDefaults.buttonText, activeColors.text, paletteDefaults.darkText, '#ffffff']);

        chosenColors.buttonText = sanitized;
        activeColors.buttonText = ensured || paletteDefaults.buttonText;

        setCSSVariable('--button-fg', activeColors.buttonText);
    }

    function applyQuoteBackground(raw) {
        var sanitized = sanitizeHex(raw) || paletteDefaults.quoteBackground;
        var ensured = ensureContrast(sanitized, activeColors.text, [paletteDefaults.quoteBackground, activeColors.background]);

        chosenColors.quoteBackground = sanitized;
        activeColors.quoteBackground = ensured || paletteDefaults.quoteBackground;

        setCSSVariable('--callout-bg', activeColors.quoteBackground);

        var border = hexToRgba(activeColors.quoteBackground, 0.35);

        if (border) {
            setCSSVariable('--callout-border', border);
        } else {
            setCSSVariable('--callout-border', '');
        }
    }

    api('beyond_gotham_nav_orientation', function (value) {
        setOrientation(value.get());

        value.bind(function (newValue) {
            setOrientation(newValue);
        });
    });

    api('beyond_gotham_nav_position', function (value) {
        setPosition(value.get());

        value.bind(function (newValue) {
            setPosition(newValue);
        });
    });

    api('beyond_gotham_nav_dropdown_direction', function (value) {
        setDropdown(value.get());

        value.bind(function (newValue) {
            setDropdown(newValue);
        });
    });

    api('beyond_gotham_nav_sticky', function (value) {
        setStickyEnabled(value.get());

        value.bind(function (newValue) {
            setStickyEnabled(newValue);
        });
    });

    api('beyond_gotham_nav_sticky_offset', function (value) {
        updateStickyOffset(value.get(), false);

        value.bind(function (newValue) {
            updateStickyOffset(newValue, true);
        });
    });

    api('beyond_gotham_primary_color', function (value) {
        var currentValue = value.get();
        var currentSanitized = sanitizeHex(currentValue);

        if (currentSanitized) {
            activeColors.primary = currentSanitized;
            chosenColors.primary = currentSanitized;
        } else {
            activeColors.primary = paletteDefaults.primary;
            chosenColors.primary = paletteDefaults.primary;
        }

        setCSSVariable('--accent', currentSanitized || currentValue || '');
        applyLinkColor(chosenColors.link);
        applyLinkHoverColor(chosenColors.linkHover);

        value.bind(function (newValue) {
            var sanitized = sanitizeHex(newValue);

            if (sanitized) {
                activeColors.primary = sanitized;
                chosenColors.primary = sanitized;
            } else {
                activeColors.primary = paletteDefaults.primary;
                chosenColors.primary = paletteDefaults.primary;
            }

            setCSSVariable('--accent', sanitized || newValue || '');
            applyLinkColor(chosenColors.link);
            applyLinkHoverColor(chosenColors.linkHover);
        });
    });

    api('beyond_gotham_secondary_color', function (value) {
        var currentValue = value.get();
        var currentSanitized = sanitizeHex(currentValue);

        if (currentSanitized) {
            activeColors.secondary = currentSanitized;
            chosenColors.secondary = currentSanitized;
        } else {
            activeColors.secondary = paletteDefaults.secondary;
            chosenColors.secondary = paletteDefaults.secondary;
        }

        setCSSVariable('--accent-alt', currentSanitized || currentValue || '');
        applyLinkColor(chosenColors.link);
        applyLinkHoverColor(chosenColors.linkHover);

        value.bind(function (newValue) {
            var sanitized = sanitizeHex(newValue);

            if (sanitized) {
                activeColors.secondary = sanitized;
                chosenColors.secondary = sanitized;
            } else {
                activeColors.secondary = paletteDefaults.secondary;
                chosenColors.secondary = paletteDefaults.secondary;
            }

            setCSSVariable('--accent-alt', sanitized || newValue || '');
            applyLinkColor(chosenColors.link);
            applyLinkHoverColor(chosenColors.linkHover);
        });
    });

    api('beyond_gotham_background_color', function (value) {
        applyBackgroundColor(value.get());

        value.bind(function (newValue) {
            applyBackgroundColor(newValue);
        });
    });

    api('beyond_gotham_text_color', function (value) {
        applyTextColor(value.get());

        value.bind(function (newValue) {
            applyTextColor(newValue);
        });
    });

    api('beyond_gotham_header_background_color', function (value) {
        applyHeaderBackground(value.get());

        value.bind(function (newValue) {
            applyHeaderBackground(newValue);
        });
    });

    api('beyond_gotham_footer_background_color', function (value) {
        applyFooterBackground(value.get());

        value.bind(function (newValue) {
            applyFooterBackground(newValue);
        });
    });

    api('beyond_gotham_link_color', function (value) {
        applyLinkColor(value.get());

        value.bind(function (newValue) {
            applyLinkColor(newValue);
        });
    });

    api('beyond_gotham_link_hover_color', function (value) {
        applyLinkHoverColor(value.get());

        value.bind(function (newValue) {
            applyLinkHoverColor(newValue);
        });
    });

    api('beyond_gotham_button_background_color', function (value) {
        applyButtonBackground(value.get());

        value.bind(function (newValue) {
            applyButtonBackground(newValue);
        });
    });

    api('beyond_gotham_button_text_color', function (value) {
        applyButtonTextColor(value.get());

        value.bind(function (newValue) {
            applyButtonTextColor(newValue);
        });
    });

    api('beyond_gotham_quote_background_color', function (value) {
        applyQuoteBackground(value.get());

        value.bind(function (newValue) {
            applyQuoteBackground(newValue);
        });
    });

    api('beyond_gotham_cta_accent_color', function (value) {
        var current = value.get();
        setCSSVariable('--cta-accent', current);
        updateCTAStyles(current);

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
