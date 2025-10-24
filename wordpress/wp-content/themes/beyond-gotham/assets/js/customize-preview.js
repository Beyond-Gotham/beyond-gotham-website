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
    var rawCtaLayout = (data && (data.ctaLayout || data.cta_layout)) ? (data.ctaLayout || data.cta_layout) : {};
    var ctaLayoutState = {};

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

    var CTA_POSITION_CLASSES = ['cta-top', 'cta-bottom', 'cta-fixed'];
    var CTA_ALIGNMENT_CLASSES = ['cta-align-left', 'cta-align-center', 'cta-align-right'];
    function sanitizePosition(value) {
        if (typeof value !== 'string') {
            return 'bottom';
        }

        var normalized = value.trim().toLowerCase();

        if (['top', 'bottom', 'fixed'].indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'bottom';
    }

    function sanitizeAlignment(value) {
        if (typeof value !== 'string') {
            return 'center';
        }

        var normalized = value.trim().toLowerCase();

        if (['left', 'center', 'right'].indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'center';
    }

    function toPositiveFloat(value) {
        var number = parseFloat(value);

        if (isNaN(number) || number < 0) {
            return 0;
        }

        return number;
    }

    function formatCtaDimension(value) {
        var sanitizedValue = Math.round(toPositiveFloat(value));

        if (!sanitizedValue) {
            return '';
        }

        return sanitizedValue + 'px';
    }

    function formatPxValue(value, allowZero) {
        var number = toPositiveFloat(value);

        if (!allowZero && number <= 0) {
            return '';
        }

        if (allowZero && number < 0) {
            number = 0;
        }

        if (!allowZero && number <= 0) {
            return '';
        }

        var precision = number < 10 ? 1 : 0;
        var factor = Math.pow(10, precision);
        var rounded = Math.round(number * factor) / factor;

        if (!allowZero && rounded <= 0) {
            return '';
        }

        return rounded + 'px';
    }

    var THUMBNAIL_ASPECT_MAP = {
        '16-9': '16 / 9',
        '4-3': '4 / 3',
        '1-1': '1 / 1'
    };

    function sanitizeAspectChoice(value) {
        if (typeof value !== 'string') {
            return '16-9';
        }

        var normalized = value.trim().toLowerCase();

        if (THUMBNAIL_ASPECT_MAP[normalized]) {
            return normalized;
        }

        return '16-9';
    }

    function sanitizeThumbnailUnit(value) {
        if (typeof value !== 'string') {
            return 'px';
        }

        var normalized = value.trim().toLowerCase();

        if (normalized === '%') {
            return '%';
        }

        return 'px';
    }

    function applyChoiceClass(element, choices, activeClass) {
        if (!element || !element.classList || !Array.isArray(choices)) {
            return;
        }

        choices.forEach(function (choice) {
            element.classList.remove(choice);
        });

        if (activeClass && choices.indexOf(activeClass) !== -1) {
            element.classList.add(activeClass);
        }
    }

    ctaLayoutState = {
        width: toPositiveFloat(rawCtaLayout.width || rawCtaLayout.maxWidthValue || rawCtaLayout.max_width_value),
        height: toPositiveFloat(rawCtaLayout.height || rawCtaLayout.minHeightValue || rawCtaLayout.min_height_value),
        position: sanitizePosition(rawCtaLayout.position),
        alignment: sanitizeAlignment(rawCtaLayout.alignment)
    };

    var rawUiLayout = (data && (data.uiLayout || data.ui_layout)) ? (data.uiLayout || data.ui_layout) : {};
    var headerData = rawUiLayout.header || {};
    var footerData = rawUiLayout.footer || {};
    var buttonData = rawUiLayout.buttons || {};
    var thumbnailData = rawUiLayout.thumbnails || {};
    var contentData = rawUiLayout.content || {};

    var headerLayoutState = {
        height: toPositiveFloat(typeof headerData.height !== 'undefined' ? headerData.height : headerData.height_value || headerData.heightValue),
        paddingTop: toPositiveFloat(typeof headerData.padding_top !== 'undefined' ? headerData.padding_top : headerData.paddingTop),
        paddingBottom: toPositiveFloat(typeof headerData.padding_bottom !== 'undefined' ? headerData.padding_bottom : headerData.paddingBottom)
    };

    var footerLayoutState = {
        minHeight: toPositiveFloat(typeof footerData.min_height !== 'undefined' ? footerData.min_height : footerData.minHeight),
        marginTop: toPositiveFloat(typeof footerData.margin_top !== 'undefined' ? footerData.margin_top : footerData.marginTop)
    };

    var buttonLayoutState = {
        paddingVertical: toPositiveFloat(typeof buttonData.padding_vertical !== 'undefined' ? buttonData.padding_vertical : buttonData.paddingVertical),
        paddingHorizontal: toPositiveFloat(typeof buttonData.padding_horizontal !== 'undefined' ? buttonData.padding_horizontal : buttonData.paddingHorizontal),
        borderRadius: toPositiveFloat(typeof buttonData.border_radius !== 'undefined' ? buttonData.border_radius : buttonData.borderRadius)
    };

    var thumbnailLayoutState = {
        aspectRatio: sanitizeAspectChoice(thumbnailData.aspect_ratio || thumbnailData.aspectRatio),
        maxWidthValue: toPositiveFloat(typeof thumbnailData.max_width_value !== 'undefined' ? thumbnailData.max_width_value : thumbnailData.maxWidthValue),
        maxWidthUnit: sanitizeThumbnailUnit(thumbnailData.max_width_unit || thumbnailData.maxWidthUnit)
    };

    var contentLayoutState = {
        maxWidth: toPositiveFloat(typeof contentData.max_width !== 'undefined' ? contentData.max_width : contentData.maxWidth),
        sectionSpacing: toPositiveFloat(typeof contentData.section_spacing !== 'undefined' ? contentData.section_spacing : contentData.sectionSpacing)
    };

    function applyHeaderLayout() {
        setCSSVariable('--site-header-height', formatPxValue(headerLayoutState.height, false));
        setCSSVariable('--site-header-padding-top', formatPxValue(headerLayoutState.paddingTop, true));
        setCSSVariable('--site-header-padding-bottom', formatPxValue(headerLayoutState.paddingBottom, true));
    }

    function applyFooterLayout() {
        setCSSVariable('--site-footer-min-height', formatPxValue(footerLayoutState.minHeight, false));
        setCSSVariable('--site-footer-margin-top', formatPxValue(footerLayoutState.marginTop, true));
    }

    function applyButtonLayout() {
        setCSSVariable('--ui-button-padding-y', formatPxValue(buttonLayoutState.paddingVertical, true));
        setCSSVariable('--ui-button-padding-x', formatPxValue(buttonLayoutState.paddingHorizontal, true));
        setCSSVariable('--ui-button-radius', formatPxValue(buttonLayoutState.borderRadius, true));
    }

    function applyThumbnailLayout() {
        var ratioKey = sanitizeAspectChoice(thumbnailLayoutState.aspectRatio);
        var ratioValue = THUMBNAIL_ASPECT_MAP[ratioKey] || THUMBNAIL_ASPECT_MAP['16-9'];
        var widthCss = formatWidthValue(thumbnailLayoutState.maxWidthValue, sanitizeThumbnailUnit(thumbnailLayoutState.maxWidthUnit));

        setCSSVariable('--post-thumbnail-aspect-ratio', ratioValue);
        setCSSVariable('--post-thumbnail-max-width', widthCss);
    }

    function applyContentLayout() {
        setCSSVariable('--content-max-width', formatPxValue(contentLayoutState.maxWidth, false));
        setCSSVariable('--content-section-gap', formatPxValue(contentLayoutState.sectionSpacing, true));
    }

    applyHeaderLayout();
    applyFooterLayout();
    applyButtonLayout();
    applyThumbnailLayout();
    applyContentLayout();

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


var MODE_LIGHT = 'light';
var MODE_DARK = 'dark';
var COLOR_MODES = [MODE_LIGHT, MODE_DARK];

function normalizeMode(mode) {
    return mode === MODE_DARK ? MODE_DARK : MODE_LIGHT;
}

    var colorDefaults = (data && data.colorDefaults) ? data.colorDefaults : ((data && data.defaults) ? data.defaults : {});
var paletteDefaults = {};
var chosenColors = {};
var activeColors = {};
var themeColorStyleEl = null;

function getModeDefaults(mode) {
    var normalized = normalizeMode(mode);

    if (!paletteDefaults[normalized]) {
        var defaultsForMode = colorDefaults && colorDefaults[normalized] ? colorDefaults[normalized] : {};
        var isDark = normalized === MODE_DARK;

        paletteDefaults[normalized] = {
            primary: sanitizeHex(defaultsForMode.primary) || '#33d1ff',
            secondary: sanitizeHex(defaultsForMode.secondary) || '#1aa5d1',
            background: sanitizeHex(defaultsForMode.background) || (isDark ? '#0f1115' : '#f4f6fb'),
            text: sanitizeHex(defaultsForMode.text) || (isDark ? '#e7eaee' : '#0f172a'),
            darkText: sanitizeHex(defaultsForMode.darkText) || '#050608',
            ctaAccent: sanitizeHex(defaultsForMode.ctaAccent) || '#33d1ff',
            headerBackground: sanitizeHex(defaultsForMode.headerBackground) || (isDark ? '#0b0d12' : '#ffffff'),
            footerBackground: sanitizeHex(defaultsForMode.footerBackground) || (isDark ? '#050608' : '#f4f6fb'),
            link: sanitizeHex(defaultsForMode.link) || (isDark ? '#33d1ff' : '#0f172a'),
            linkHover: sanitizeHex(defaultsForMode.linkHover) || '#1aa5d1',
            buttonBackground: sanitizeHex(defaultsForMode.buttonBackground) || '#33d1ff',
            buttonText: sanitizeHex(defaultsForMode.buttonText) || '#050608',
            quoteBackground: sanitizeHex(defaultsForMode.quoteBackground) || (isDark ? '#161b2a' : '#e6edf7')
        };
    }

    return paletteDefaults[normalized];
}

function ensureModeState(mode) {
    var normalized = normalizeMode(mode);
    var defaultsForMode = getModeDefaults(normalized);

    if (!chosenColors[normalized]) {
        chosenColors[normalized] = Object.assign({}, defaultsForMode);
    }

    if (!activeColors[normalized]) {
        activeColors[normalized] = Object.assign({}, defaultsForMode);
    }
}

function recalcMode(mode) {
    var normalized = normalizeMode(mode);
    ensureModeState(normalized);

    var defaultsForMode = getModeDefaults(normalized);
    var chosen = chosenColors[normalized];
    var active = activeColors[normalized];

    var background = sanitizeHex(chosen.background) || defaultsForMode.background;
    var primary = sanitizeHex(chosen.primary) || defaultsForMode.primary;
    var secondary = sanitizeHex(chosen.secondary) || defaultsForMode.secondary;
    var ctaAccent = sanitizeHex(chosen.ctaAccent) || defaultsForMode.ctaAccent;

    active.background = background;
    active.primary = primary;
    active.secondary = secondary;
    active.ctaAccent = ctaAccent;

    var textPreferred = sanitizeHex(chosen.text) || defaultsForMode.text;
    var text = ensureContrast(textPreferred, background, [defaultsForMode.text, defaultsForMode.darkText]) || defaultsForMode.text;
    active.text = text;

    var headerBackground = sanitizeHex(chosen.headerBackground) || defaultsForMode.headerBackground;
    headerBackground = ensureContrast(headerBackground, text, [defaultsForMode.headerBackground, background]) || defaultsForMode.headerBackground;
    active.headerBackground = headerBackground;

    var footerBackground = sanitizeHex(chosen.footerBackground) || defaultsForMode.footerBackground;
    footerBackground = ensureContrast(footerBackground, text, [defaultsForMode.footerBackground, background]) || defaultsForMode.footerBackground;
    active.footerBackground = footerBackground;

    var linkPreferred = sanitizeHex(chosen.link) || defaultsForMode.link;
    var link = ensureContrast(linkPreferred, background, [defaultsForMode.link, primary, secondary, defaultsForMode.darkText, text]) || defaultsForMode.link;
    active.link = link;

    var linkHoverPreferred = sanitizeHex(chosen.linkHover) || defaultsForMode.linkHover;
    var linkHover = ensureContrast(linkHoverPreferred, background, [link, defaultsForMode.linkHover, secondary, primary, defaultsForMode.darkText, text]) || defaultsForMode.linkHover;
    active.linkHover = linkHover;

    var buttonBackground = sanitizeHex(chosen.buttonBackground) || defaultsForMode.buttonBackground;
    active.buttonBackground = buttonBackground;

    var buttonTextPreferred = sanitizeHex(chosen.buttonText) || defaultsForMode.buttonText;
    var buttonText = ensureContrast(buttonTextPreferred, buttonBackground, [defaultsForMode.buttonText, text, defaultsForMode.darkText, '#ffffff']) || defaultsForMode.buttonText;
    active.buttonText = buttonText;

    var quoteBackgroundPreferred = sanitizeHex(chosen.quoteBackground) || defaultsForMode.quoteBackground;
    var quoteBackground = ensureContrast(quoteBackgroundPreferred, text, [defaultsForMode.quoteBackground, background]) || defaultsForMode.quoteBackground;
    active.quoteBackground = quoteBackground;
    active.quoteBorder = hexToRgba(quoteBackground, 0.35) || '';

    return active;
}

function getModePrefixes(mode) {
    var normalized = normalizeMode(mode);
    return [
        'html.theme-' + normalized,
        'html[data-theme="' + normalized + '"]',
        'body.theme-' + normalized
    ];
}

function buildModeSelectorList(mode, selectors) {
    var prefixes = getModePrefixes(mode);
    var scoped = [];

    prefixes.forEach(function (prefix) {
        selectors.forEach(function (selector) {
            var target = (selector || '').trim();

            if (!target) {
                scoped.push(prefix);
                return;
            }

            if (target === 'body' && prefix.indexOf('body.') === 0) {
                scoped.push(prefix);
                return;
            }

            scoped.push(prefix + ' ' + target);
        });
    });

    return Array.from(new Set(scoped)).join(', ');
}

function ensureThemeStyleElement() {
    if (themeColorStyleEl && themeColorStyleEl.parentNode) {
        return themeColorStyleEl;
    }

    var existing = document.getElementById('bg-theme-mode-preview');

    if (existing) {
        themeColorStyleEl = existing;
        return themeColorStyleEl;
    }

    themeColorStyleEl = document.createElement('style');
    themeColorStyleEl.id = 'bg-theme-mode-preview';
    document.head.appendChild(themeColorStyleEl);

    return themeColorStyleEl;
}

function renderThemeStyles() {
    var styleEl = ensureThemeStyleElement();
    var css = '';

    COLOR_MODES.forEach(function (mode) {
        var normalized = normalizeMode(mode);
        var palette = activeColors[normalized];

        if (!palette) {
            return;
        }

        var prefixes = getModePrefixes(normalized);
        var rootSelector = prefixes.join(', ');
        var rootRules = [];

        if (palette.primary) {
            rootRules.push('--accent: ' + palette.primary + ';');
        }

        if (palette.secondary) {
            rootRules.push('--accent-alt: ' + palette.secondary + ';');
        }

        if (palette.background) {
            rootRules.push('--bg: ' + palette.background + ';');
        }

        if (palette.text) {
            rootRules.push('--fg: ' + palette.text + ';');
        }

        if (palette.ctaAccent) {
            rootRules.push('--cta-accent: ' + palette.ctaAccent + ';');
        }

        if (palette.headerBackground) {
            rootRules.push('--bg-header: ' + palette.headerBackground + ';');
        }

        if (palette.footerBackground) {
            rootRules.push('--bg-footer: ' + palette.footerBackground + ';');
        }

        if (palette.link) {
            rootRules.push('--link-color: ' + palette.link + ';');
        }

        if (palette.linkHover) {
            rootRules.push('--link-hover-color: ' + palette.linkHover + ';');
        }

        if (palette.buttonBackground) {
            rootRules.push('--button-bg: ' + palette.buttonBackground + ';');
        }

        if (palette.buttonText) {
            rootRules.push('--button-fg: ' + palette.buttonText + ';');
        }

        if (palette.quoteBackground) {
            rootRules.push('--callout-bg: ' + palette.quoteBackground + ';');
        }

        if (palette.quoteBorder) {
            rootRules.push('--callout-border: ' + palette.quoteBorder + ';');
        }

        if (rootRules.length) {
            css += rootSelector + ' {' + rootRules.join(' ') + '}';
        }

        var bodySelectors = [
            'body.theme-' + normalized,
            'html.theme-' + normalized + ' body',
            'html[data-theme="' + normalized + '"] body'
        ];
        var bodyRules = [];

        if (palette.background) {
            bodyRules.push('background-color: ' + palette.background + ';');
        }

        if (palette.text) {
            bodyRules.push('color: ' + palette.text + ';');
        }

        if (bodyRules.length) {
            css += Array.from(new Set(bodySelectors)).join(', ') + ' {' + bodyRules.join(' ') + '}';
        }

        if (palette.headerBackground) {
            css += buildModeSelectorList(normalized, ['.site-header']) + '{background-color: var(--bg-header, ' + palette.headerBackground + ');}';
        }

        if (palette.footerBackground) {
            css += buildModeSelectorList(normalized, ['.site-footer']) + '{background-color: var(--bg-footer, ' + palette.footerBackground + ');}';
        }

        if (palette.link) {
            css += buildModeSelectorList(normalized, ['a', 'a:visited', '.entry-content a', '.widget a', '.site-footer a', '.site-header a']) + '{color: var(--link-color, ' + palette.link + ');}';
        }

        if (palette.linkHover) {
            css += buildModeSelectorList(normalized, [
                'a:hover',
                'a:focus',
                'a:active',
                '.entry-content a:hover',
                '.entry-content a:focus',
                '.widget a:hover',
                '.widget a:focus',
                '.site-footer a:hover',
                '.site-footer a:focus',
                '.site-header a:hover',
                '.site-header a:focus'
            ]) + '{color: var(--link-hover-color, ' + palette.linkHover + ');}';
        }

        var buttonSelectors = [
            '.bg-button',
            '.wp-block-button__link',
            '.wp-element-button',
            'button',
            'input[type="submit"]',
            'input[type="button"]',
            'input[type="reset"]',
            '.button'
        ];
        var buttonHoverSelectors = [
            '.bg-button:hover',
            '.bg-button:focus',
            '.wp-block-button__link:hover',
            '.wp-block-button__link:focus',
            '.wp-element-button:hover',
            '.wp-element-button:focus',
            'button:hover',
            'button:focus',
            'input[type="submit"]:hover',
            'input[type="submit"]:focus',
            'input[type="button"]:hover',
            'input[type="button"]:focus',
            'input[type="reset"]:hover',
            'input[type="reset"]:focus',
            '.button:hover',
            '.button:focus'
        ];

        var buttonRuleParts = [];

        if (palette.buttonBackground) {
            buttonRuleParts.push('background-color: var(--button-bg, ' + palette.buttonBackground + ');');
            buttonRuleParts.push('border-color: var(--button-bg, ' + palette.buttonBackground + ');');
        }

        if (palette.buttonText) {
            buttonRuleParts.push('color: var(--button-fg, ' + palette.buttonText + ');');
        }

        if (buttonRuleParts.length) {
            css += buildModeSelectorList(normalized, buttonSelectors) + ' {' + buttonRuleParts.join(' ') + '}';
            css += buildModeSelectorList(normalized, buttonHoverSelectors) + ' {' + buttonRuleParts.join(' ') + '}';
        }

        if (palette.quoteBackground) {
            css += buildModeSelectorList(normalized, ['.wp-block-beyond-gotham-highlight-box', '.bg-highlight-box']) + '{background: var(--callout-bg, ' + palette.quoteBackground + ');';

            if (palette.quoteBorder) {
                css += 'border-color: var(--callout-border, ' + palette.quoteBorder + ');';
            }

            css += '}';

            css += buildModeSelectorList(normalized, ['blockquote', '.wp-block-quote', '.wp-block-quote.is-style-large', '.wp-block-pullquote']) + '{background-color: var(--callout-bg, ' + palette.quoteBackground + ');';

            if (palette.quoteBorder) {
                css += 'border-color: var(--callout-border, ' + palette.quoteBorder + '); border-left-color: var(--callout-border, ' + palette.quoteBorder + ');';
            }

            css += '}';
        }

        if (palette.ctaAccent) {
            var ctaLight = hexToRgba(palette.ctaAccent, 0.15);
            var ctaSoft = hexToRgba(palette.ctaAccent, 0.1);
            var ctaLine = hexToRgba(palette.ctaAccent, 0.3);

            if (ctaLight && ctaSoft) {
                css += buildModeSelectorList(normalized, ['[data-bg-cta]']) + '{background: linear-gradient(135deg, ' + ctaLight + ', ' + ctaSoft + ');';

                if (ctaLine) {
                    css += 'border-color: ' + ctaLine + ';';
                }

                css += '}';
            }

            css += buildModeSelectorList(normalized, ['[data-bg-cta] .bg-button--primary']) + '{background-color: ' + palette.ctaAccent + '; border-color: ' + palette.ctaAccent + ';}';
        }
    });

    styleEl.textContent = css;
}

function updateModeColor(mode, key, rawValue) {
    var normalized = normalizeMode(mode);
    ensureModeState(normalized);

    var sanitized = sanitizeHex(rawValue);
    chosenColors[normalized][key] = sanitized || '';

    recalcMode(normalized);
    renderThemeStyles();
}

function bindColorSetting(mode, key, settingId) {
    if (!settingId) {
        return;
    }

    api(settingId, function (value) {
        updateModeColor(mode, key, value.get());

        value.bind(function (newValue) {
            updateModeColor(mode, key, newValue);
        });
    });
}

COLOR_MODES.forEach(function (mode) {
    ensureModeState(mode);
    recalcMode(mode);
});
renderThemeStyles();

var COLOR_SETTING_IDS = {
    primary: { light: 'beyond_gotham_primary_color_light', dark: 'beyond_gotham_primary_color_dark' },
    secondary: { light: 'beyond_gotham_secondary_color_light', dark: 'beyond_gotham_secondary_color_dark' },
    background: { light: 'beyond_gotham_background_color_light', dark: 'beyond_gotham_background_color_dark' },
    text: { light: 'beyond_gotham_text_color_light', dark: 'beyond_gotham_text_color_dark' },
    ctaAccent: { light: 'beyond_gotham_cta_accent_color_light', dark: 'beyond_gotham_cta_accent_color_dark' },
    headerBackground: { light: 'beyond_gotham_header_background_color_light', dark: 'beyond_gotham_header_background_color_dark' },
    footerBackground: { light: 'beyond_gotham_footer_background_color_light', dark: 'beyond_gotham_footer_background_color_dark' },
    link: { light: 'beyond_gotham_link_color_light', dark: 'beyond_gotham_link_color_dark' },
    linkHover: { light: 'beyond_gotham_link_hover_color_light', dark: 'beyond_gotham_link_hover_color_dark' },
    buttonBackground: { light: 'beyond_gotham_button_background_color_light', dark: 'beyond_gotham_button_background_color_dark' },
    buttonText: { light: 'beyond_gotham_button_text_color_light', dark: 'beyond_gotham_button_text_color_dark' },
    quoteBackground: { light: 'beyond_gotham_quote_background_color_light', dark: 'beyond_gotham_quote_background_color_dark' }
};

Object.keys(COLOR_SETTING_IDS).forEach(function (key) {
    var ids = COLOR_SETTING_IDS[key] || {};
    if (ids.light) {
        bindColorSetting(MODE_LIGHT, key, ids.light);
    }
    if (ids.dark) {
        bindColorSetting(MODE_DARK, key, ids.dark);
    }
});

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

function updateCTALayout() {
    var wrappers = getNodes(ctaWrapperSelector);

    if (!wrappers.length) {
        return;
    }

    var widthCss = formatCtaDimension(ctaLayoutState.width);
    var heightCss = formatCtaDimension(ctaLayoutState.height);
    var positionClass = 'cta-' + sanitizePosition(ctaLayoutState.position);
    var alignmentClass = 'cta-align-' + sanitizeAlignment(ctaLayoutState.alignment);

    wrappers.forEach(function (el) {
        if (widthCss) {
            el.style.setProperty('--cta-width', widthCss);
        } else {
            el.style.removeProperty('--cta-width');
        }

        if (heightCss) {
            el.style.setProperty('--cta-height', heightCss);
        } else {
            el.style.removeProperty('--cta-height');
        }

        el.style.removeProperty('--cta-max-width');
        el.style.removeProperty('--cta-min-height');

        applyChoiceClass(el, CTA_POSITION_CLASSES, positionClass);
        applyChoiceClass(el, CTA_ALIGNMENT_CLASSES, alignmentClass);
    });
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

    api('beyond_gotham_header_height', function (value) {
        headerLayoutState.height = toPositiveFloat(value.get());
        applyHeaderLayout();

        value.bind(function (newValue) {
            headerLayoutState.height = toPositiveFloat(newValue);
            applyHeaderLayout();
        });
    });

    api('beyond_gotham_header_padding_top', function (value) {
        headerLayoutState.paddingTop = toPositiveFloat(value.get());
        applyHeaderLayout();

        value.bind(function (newValue) {
            headerLayoutState.paddingTop = toPositiveFloat(newValue);
            applyHeaderLayout();
        });
    });

    api('beyond_gotham_header_padding_bottom', function (value) {
        headerLayoutState.paddingBottom = toPositiveFloat(value.get());
        applyHeaderLayout();

        value.bind(function (newValue) {
            headerLayoutState.paddingBottom = toPositiveFloat(newValue);
            applyHeaderLayout();
        });
    });

    api('beyond_gotham_footer_min_height', function (value) {
        footerLayoutState.minHeight = toPositiveFloat(value.get());
        applyFooterLayout();

        value.bind(function (newValue) {
            footerLayoutState.minHeight = toPositiveFloat(newValue);
            applyFooterLayout();
        });
    });

    api('beyond_gotham_footer_margin_top', function (value) {
        footerLayoutState.marginTop = toPositiveFloat(value.get());
        applyFooterLayout();

        value.bind(function (newValue) {
            footerLayoutState.marginTop = toPositiveFloat(newValue);
            applyFooterLayout();
        });
    });

    api('beyond_gotham_button_padding_vertical', function (value) {
        buttonLayoutState.paddingVertical = toPositiveFloat(value.get());
        applyButtonLayout();

        value.bind(function (newValue) {
            buttonLayoutState.paddingVertical = toPositiveFloat(newValue);
            applyButtonLayout();
        });
    });

    api('beyond_gotham_button_padding_horizontal', function (value) {
        buttonLayoutState.paddingHorizontal = toPositiveFloat(value.get());
        applyButtonLayout();

        value.bind(function (newValue) {
            buttonLayoutState.paddingHorizontal = toPositiveFloat(newValue);
            applyButtonLayout();
        });
    });

    api('beyond_gotham_button_border_radius', function (value) {
        buttonLayoutState.borderRadius = toPositiveFloat(value.get());
        applyButtonLayout();

        value.bind(function (newValue) {
            buttonLayoutState.borderRadius = toPositiveFloat(newValue);
            applyButtonLayout();
        });
    });

    api('beyond_gotham_thumbnail_aspect_ratio', function (value) {
        thumbnailLayoutState.aspectRatio = sanitizeAspectChoice(value.get());
        applyThumbnailLayout();

        value.bind(function (newValue) {
            thumbnailLayoutState.aspectRatio = sanitizeAspectChoice(newValue);
            applyThumbnailLayout();
        });
    });

    api('beyond_gotham_thumbnail_max_width_value', function (value) {
        thumbnailLayoutState.maxWidthValue = toPositiveFloat(value.get());
        applyThumbnailLayout();

        value.bind(function (newValue) {
            thumbnailLayoutState.maxWidthValue = toPositiveFloat(newValue);
            applyThumbnailLayout();
        });
    });

    api('beyond_gotham_thumbnail_max_width_unit', function (value) {
        thumbnailLayoutState.maxWidthUnit = sanitizeThumbnailUnit(value.get());
        applyThumbnailLayout();

        value.bind(function (newValue) {
            thumbnailLayoutState.maxWidthUnit = sanitizeThumbnailUnit(newValue);
            applyThumbnailLayout();
        });
    });

    api('beyond_gotham_content_max_width', function (value) {
        contentLayoutState.maxWidth = toPositiveFloat(value.get());
        applyContentLayout();

        value.bind(function (newValue) {
            contentLayoutState.maxWidth = toPositiveFloat(newValue);
            applyContentLayout();
        });
    });

    api('beyond_gotham_content_section_spacing', function (value) {
        contentLayoutState.sectionSpacing = toPositiveFloat(value.get());
        applyContentLayout();

        value.bind(function (newValue) {
            contentLayoutState.sectionSpacing = toPositiveFloat(newValue);
            applyContentLayout();
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

    updateCTALayout();

    api('beyond_gotham_cta_width', function (value) {
        value.bind(function (newValue) {
            ctaLayoutState.width = toPositiveFloat(newValue);
            updateCTALayout();
        });
    });

    api('beyond_gotham_cta_height', function (value) {
        value.bind(function (newValue) {
            ctaLayoutState.height = toPositiveFloat(newValue);
            updateCTALayout();
        });
    });

    api('beyond_gotham_cta_position', function (value) {
        value.bind(function (newValue) {
            ctaLayoutState.position = sanitizePosition(newValue);
            updateCTALayout();
        });
    });

    api('beyond_gotham_cta_alignment', function (value) {
        value.bind(function (newValue) {
            ctaLayoutState.alignment = sanitizeAlignment(newValue);
            updateCTALayout();
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
