(function (wp, data) {
    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;
    var docEl = document.documentElement;
    var bodyEl = document.body;
    var fontStacks = (data && data.fontStacks) ? data.fontStacks : {};
    var footerSelector = data && data.footerTarget ? data.footerTarget : '.footer-right .site-info';
    var headingSelector = data && data.headingSelector ? data.headingSelector : 'h1, h2, h3, h4, h5, h6';
    var ctaSelectors = (data && data.ctaSelectors) ? data.ctaSelectors : {};
    var ctaWrapperSelector = ctaSelectors.wrapper || '[data-bg-cta]';
    var ctaTextSelector = ctaSelectors.text || '[data-bg-cta-text]';
    var ctaButtonSelector = ctaSelectors.button || '[data-bg-cta-button]';
    var stickySelectors = (data && data.stickyCtaSelectors) ? data.stickyCtaSelectors : {};
    var stickyWrapperSelector = stickySelectors.wrapper || '[data-bg-sticky-cta]';
    var stickyContentSelector = stickySelectors.content || '[data-bg-sticky-cta-content]';
    var stickyButtonSelector = stickySelectors.button || '[data-bg-sticky-cta-button]';
    var rawCtaLayout = (data && (data.ctaLayout || data.cta_layout)) ? (data.ctaLayout || data.cta_layout) : {};
    var ctaLayoutState = {};
    var stickyState = Object.assign({}, (data && data.stickyCta) ? data.stickyCta : {});
    var stickyDefaults = Object.assign({}, stickyState);
    var previewUtils = {
        sanitizeHexColor: sanitizeHexColor,
        sanitizeSocialbarVariant: sanitizeSocialbarVariant,
        sanitizePosition: sanitizePosition,
        sanitizeAlignment: sanitizeAlignment,
        formatCtaDimension: formatCtaDimension,
        formatPxValue: formatPxValue,
        formatWidthValue: formatWidthValue,
        sanitizeAspectChoice: sanitizeAspectChoice,
        sanitizeThumbnailUnit: sanitizeThumbnailUnit,
        sanitizeFooterMenuAlignment: sanitizeFooterMenuAlignment,
        sanitizeFooterMobileLayout: sanitizeFooterMobileLayout
    };

    function toArray(nodeList) {
        return Array.prototype.slice.call(nodeList || []);
    }

    function getNodes(selector) {
        if (!selector) {
            return [];
        }

        return toArray(document.querySelectorAll(selector));
    }

    function getStickyWrapper() {
        if (!stickyWrapperSelector) {
            return null;
        }

        return document.querySelector(stickyWrapperSelector);
    }

    function getStickyContentNode() {
        if (!stickyContentSelector) {
            return null;
        }

        return document.querySelector(stickyContentSelector);
    }

    function getStickyButtonNode() {
        if (!stickyButtonSelector) {
            return null;
        }

        return document.querySelector(stickyButtonSelector);
    }

    function ensureDocElement() {
        if (!docEl || !docEl.style) {
            docEl = document.documentElement;
        }

        return docEl && docEl.style ? docEl : null;
    }

    function setCSSVariable(name, value) {
        if (!name) {
            return;
        }

        var element = ensureDocElement();

        if (!element) {
            return;
        }

        if (value) {
            element.style.setProperty(name, value);
        } else {
            element.style.removeProperty(name);
        }
    }

    function setBodyMobileVisibility(show) {
        if (!bodyEl) {
            bodyEl = document.body || document.querySelector('body');
        }

        if (!bodyEl) {
            return;
        }

        if (show) {
            bodyEl.classList.remove('hide-cta-mobile');
        } else {
            bodyEl.classList.add('hide-cta-mobile');
        }
    }

    var SOCIALBAR_SELECTOR = '.socialbar[data-location]';
    var SOCIALBAR_VARIANTS = ['minimal', 'boxed', 'pill', 'labelled'];
    var SOCIALBAR_ICON_STYLES = ['default', 'monochrom', 'farbig', 'invertiert'];
    var SOCIALBAR_VARIANT_CLASSES = SOCIALBAR_VARIANTS.map(function (variant) {
        return 'socialbar--' + variant;
    });

    var socialbarState = {
        variant: 'minimal',
        surface: {
            background: null,
            icon: null
        },
        variants: {},
        iconStyle: 'default'
    };

    if (data && data.socialbar) {
        if (data.socialbar.variant) {
            socialbarState.variant = sanitizeSocialbarVariant(data.socialbar.variant);
        }

        if (data.socialbar.surface) {
            if (data.socialbar.surface.background) {
                socialbarState.surface.background = data.socialbar.surface.background;
            }

            if (data.socialbar.surface.icon) {
                socialbarState.surface.icon = data.socialbar.surface.icon;
            }
        }

        if (data.socialbar.variants) {
            socialbarState.variants = data.socialbar.variants;
        }

        if (data.socialbar.iconStyle) {
            socialbarState.iconStyle = sanitizeSocialbarIconStyle(data.socialbar.iconStyle);
        }
    }

    function sanitizeHexColor(value) {
        if (typeof value !== 'string') {
            return '';
        }

        var trimmed = value.trim();

        if (!trimmed) {
            return '';
        }

        if (/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(trimmed)) {
            return trimmed;
        }

        return '';
    }

    function sanitizeSocialbarVariant(value) {
        if (typeof value !== 'string') {
            return 'minimal';
        }

        var normalized = value.trim().toLowerCase();

        if (SOCIALBAR_VARIANTS.indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'minimal';
    }

    function sanitizeSocialbarIconStyle(value) {
        if (typeof value !== 'string') {
            return 'default';
        }

        var normalized = value.trim().toLowerCase();

        if (SOCIALBAR_ICON_STYLES.indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'default';
    }

    function getSocialbarElements() {
        return getNodes(SOCIALBAR_SELECTOR);
    }

    function ensureVariantState(variant) {
        if (!socialbarState.variants[variant]) {
            socialbarState.variants[variant] = {
                background: null,
                hover: null,
                icon: null
            };
        }

        return socialbarState.variants[variant];
    }

    function applySocialbarVariantClasses(variant) {
        var nodes = getSocialbarElements();
        if (!nodes.length) {
            return;
        }

        var className = 'socialbar--' + variant;

        nodes.forEach(function (node) {
            SOCIALBAR_VARIANT_CLASSES.forEach(function (candidate) {
                node.classList.remove(candidate);
            });

            node.classList.add(className);
            node.setAttribute('data-variant', variant);
        });
    }

    function applySocialbarIconStyle(style) {
        var nodes = getSocialbarElements();

        if (!nodes.length) {
            return;
        }

        var normalized = sanitizeSocialbarIconStyle(style);

        nodes.forEach(function (node) {
            SOCIALBAR_ICON_STYLES.forEach(function (candidate) {
                if (candidate === 'default') {
                    return;
                }

                node.classList.remove('socialbar--icon-' + candidate);
            });

            if (normalized && normalized !== 'default') {
                node.classList.add('socialbar--icon-' + normalized);
            }

            node.setAttribute('data-icon-style', normalized);
        });
    }

    function applySocialbarStyles() {
        var nodes = getSocialbarElements();
        if (!nodes.length) {
            return;
        }

        var variantState = ensureVariantState(socialbarState.variant);
        var backgroundState = variantState.background;
        var hoverState = variantState.hover;
        var iconState = variantState.icon;
        var surfaceBackgroundState = socialbarState.surface.background;
        var surfaceIconState = socialbarState.surface.icon;

        nodes.forEach(function (node) {
            if (surfaceBackgroundState !== null) {
                if (surfaceBackgroundState) {
                    node.style.setProperty('--socialbar-surface', surfaceBackgroundState);
                } else {
                    node.style.removeProperty('--socialbar-surface');
                }
            }

            if (backgroundState !== null) {
                if (backgroundState) {
                    node.style.setProperty('--socialbar-bg', backgroundState);
                } else {
                    node.style.removeProperty('--socialbar-bg');
                }
            }

            if (hoverState !== null) {
                if (hoverState) {
                    node.style.setProperty('--socialbar-hover', hoverState);
                } else {
                    node.style.removeProperty('--socialbar-hover');
                }
            }

            var resolvedIconState;

            if (iconState === null) {
                resolvedIconState = surfaceIconState;
            } else if (iconState) {
                resolvedIconState = iconState;
            } else {
                resolvedIconState = '';
            }

            if (resolvedIconState !== null) {
                if (resolvedIconState) {
                    node.style.setProperty('--socialbar-icon', resolvedIconState);
                } else {
                    node.style.removeProperty('--socialbar-icon');
                }
            }
        });
    }

    function setSocialbarVariant(value) {
        socialbarState.variant = sanitizeSocialbarVariant(value);
        applySocialbarVariantClasses(socialbarState.variant);
        applySocialbarStyles();
    }

    setSocialbarVariant(socialbarState.variant);
    applySocialbarIconStyle(socialbarState.iconStyle);

    function toggleSocialbarLocation(location, isVisible) {
        var selector = '.socialbar[data-location="' + location + '"]';
        getNodes(selector).forEach(function (node) {
            if (isVisible) {
                node.removeAttribute('hidden');
                node.removeAttribute('aria-hidden');
                node.classList.remove('is-preview-hidden');
            } else {
                node.setAttribute('hidden', 'hidden');
                node.setAttribute('aria-hidden', 'true');
                node.classList.add('is-preview-hidden');
            }
        });
    }

    function toggleHeaderSocialFallback(hideFallback) {
        getNodes('.site-nav__social--theme').forEach(function (node) {
            if (hideFallback) {
                node.setAttribute('hidden', 'hidden');
                node.setAttribute('aria-hidden', 'true');
            } else {
                node.removeAttribute('hidden');
                node.removeAttribute('aria-hidden');
            }
        });
    }

    function updateSocialLink(network, rawValue) {
        if (!network) {
            return;
        }

        var value = typeof rawValue === 'string' ? rawValue.trim() : '';

        if (network === 'email' && value) {
            if (value.indexOf('mailto:') !== 0) {
                value = 'mailto:' + value;
            }
        }

        var hasUrl = value.length > 0;
        var isMail = hasUrl && value.indexOf('mailto:') === 0;
        var selectors = [
            '.socialbar__link[data-network="' + network + '"]',
            '.social-icons__link[data-network="' + network + '"]'
        ];

        selectors.forEach(function (selector) {
            getNodes(selector).forEach(function (link) {
                var container = link.closest('.socialbar__item');

                if (hasUrl) {
                    link.setAttribute('href', value);
                    if (!isMail) {
                        link.setAttribute('target', '_blank');
                        link.setAttribute('rel', 'noopener');
                    } else {
                        link.removeAttribute('target');
                        link.removeAttribute('rel');
                    }
                    link.removeAttribute('aria-hidden');
                    link.removeAttribute('tabindex');
                    link.removeAttribute('hidden');

                    if (container) {
                        container.classList.remove('socialbar__item--empty');
                        container.removeAttribute('data-empty');
                        container.removeAttribute('hidden');
                        container.removeAttribute('aria-hidden');
                    }
                } else {
                    link.removeAttribute('href');
                    link.removeAttribute('target');
                    link.removeAttribute('rel');
                    link.setAttribute('aria-hidden', 'true');
                    link.setAttribute('tabindex', '-1');
                    link.setAttribute('hidden', 'hidden');

                    if (container) {
                        container.classList.add('socialbar__item--empty');
                        container.setAttribute('data-empty', 'true');
                        container.setAttribute('hidden', 'hidden');
                        container.setAttribute('aria-hidden', 'true');
                    }
                }
            });
        });
    }

    function setSocialbarSurfaceBackground(value) {
        if (value === null || typeof value === 'undefined') {
            socialbarState.surface.background = null;
        } else {
            var sanitized = sanitizeHexColor(value);
            socialbarState.surface.background = sanitized || (value ? sanitized : '');
        }
        applySocialbarStyles();
    }

    function setSocialbarSurfaceIcon(value) {
        if (value === null || typeof value === 'undefined') {
            socialbarState.surface.icon = null;
        } else {
            var sanitized = sanitizeHexColor(value);
            socialbarState.surface.icon = sanitized || (value ? sanitized : '');
        }
        applySocialbarStyles();
    }

    function setSocialbarVariantColor(variant, key, value) {
        if (SOCIALBAR_VARIANTS.indexOf(variant) === -1) {
            return;
        }

        var variantState = ensureVariantState(variant);

        if (['background', 'hover', 'icon'].indexOf(key) === -1) {
            return;
        }

        if (value === null || typeof value === 'undefined') {
            variantState[key] = null;
        } else {
            var sanitized = sanitizeHexColor(value);
            variantState[key] = sanitized || (value ? sanitized : '');
        }

        if (variant === socialbarState.variant) {
            applySocialbarStyles();
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

    function toBoolean(value, fallback) {
        if (typeof value === 'undefined' || value === null) {
            return !!fallback;
        }

        if (typeof value === 'string') {
            var normalized = value.trim().toLowerCase();

            if (normalized === '0' || normalized === 'false' || normalized === 'off' || normalized === 'no') {
                return false;
            }

            if (normalized === '1' || normalized === 'true' || normalized === 'on' || normalized === 'yes') {
                return true;
            }
        }

        if (typeof value === 'number') {
            if (value === 0) {
                return false;
            }

            if (value === 1) {
                return true;
            }
        }

        return !!value;
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

    function formatWidthValue(value, unit) {
        var number = toPositiveFloat(value);
        var sanitizedUnit = sanitizeThumbnailUnit(unit);

        if (sanitizedUnit === '%') {
            if (number <= 0) {
                return '';
            }

            if (number > 100) {
                number = 100;
            }

            var percentPrecision = number < 10 ? 1 : 0;
            var percentFactor = Math.pow(10, percentPrecision);
            var percentRounded = Math.round(number * percentFactor) / percentFactor;

            return percentRounded + '%';
        }

        if (number <= 0) {
            return '';
        }

        var precision = number < 10 ? 1 : 0;
        var factor = Math.pow(10, precision);
        var rounded = Math.round(number * factor) / factor;

        return rounded + 'px';
    }

    function normalizeHexColor(value) {
        if (typeof value !== 'string') {
            return null;
        }

        var color = value.trim();

        if (!color) {
            return null;
        }

        if (color.charAt(0) !== '#') {
            return null;
        }

        if (color.length === 4) {
            var r = color.charAt(1);
            var g = color.charAt(2);
            var b = color.charAt(3);

            return ('#' + r + r + g + g + b + b).toLowerCase();
        }

        if (color.length === 7) {
            return color.toLowerCase();
        }

        return null;
    }

    function hexToRgb(hex) {
        var normalized = normalizeHexColor(hex);

        if (!normalized) {
            return null;
        }

        var value = parseInt(normalized.slice(1), 16);

        return {
            r: (value >> 16) & 255,
            g: (value >> 8) & 255,
            b: value & 255
        };
    }

    function linearizeColorChannel(component) {
        var ratio = component / 255;

        if (ratio <= 0.03928) {
            return ratio / 12.92;
        }

        return Math.pow((ratio + 0.055) / 1.055, 2.4);
    }

    function getRelativeLuminance(color) {
        var rgb = hexToRgb(color);

        if (!rgb) {
            return null;
        }

        var r = linearizeColorChannel(rgb.r);
        var g = linearizeColorChannel(rgb.g);
        var b = linearizeColorChannel(rgb.b);

        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    function getContrastRatio(colorA, colorB) {
        var luminanceA = getRelativeLuminance(colorA);
        var luminanceB = getRelativeLuminance(colorB);

        if (luminanceA === null || luminanceB === null) {
            return 1;
        }

        var lighter = Math.max(luminanceA, luminanceB);
        var darker = Math.min(luminanceA, luminanceB);

        return (lighter + 0.05) / (darker + 0.05);
    }

    function ensureAccessibleColor(preferred, background, fallbacks, threshold) {
        var normalizedBackground = normalizeHexColor(background);
        var candidates = [];

        if (preferred) {
            candidates.push(preferred);
        }

        if (Array.isArray(fallbacks)) {
            candidates = candidates.concat(fallbacks);
        }

        if (!normalizedBackground) {
            return normalizeHexColor(preferred) || null;
        }

        var limit = typeof threshold === 'number' ? threshold : 4.5;

        for (var i = 0; i < candidates.length; i += 1) {
            var candidate = normalizeHexColor(candidates[i]);

            if (!candidate) {
                continue;
            }

            if (getContrastRatio(candidate, normalizedBackground) >= limit) {
                return candidate;
            }
        }

        return normalizeHexColor(preferred) || normalizeHexColor((Array.isArray(fallbacks) && fallbacks.length) ? fallbacks[0] : null);
    }

    function hasStickyContent(value) {
        if (typeof value === 'undefined' || value === null) {
            return false;
        }

        var markup = String(value);

        if (!markup.trim()) {
            return false;
        }

        var temp = document.createElement('div');
        temp.innerHTML = markup;

        var text = (temp.textContent || temp.innerText || '').trim();

        if (text.length > 0) {
            return true;
        }

        return /<(img|video|audio|iframe|svg|canvas|object|embed)\b/i.test(markup);
    }

    function refreshStickyCtaState(element) {
        if (!element) {
            return;
        }

        var isActive = element.getAttribute('data-active') === 'true';
        var hasContent = element.getAttribute('data-has-content') === 'true';
        var hasLink = element.getAttribute('data-has-link') === 'true';
        var showDesktop = element.getAttribute('data-show-desktop') !== 'false';
        var showMobile = element.getAttribute('data-show-mobile') !== 'false';
        var enabled = isActive && (hasContent || hasLink) && (showDesktop || showMobile);

        element.setAttribute('data-enabled', enabled ? 'true' : 'false');
        element.setAttribute('data-empty', (hasContent || hasLink) ? 'false' : 'true');

        if (enabled) {
            element.removeAttribute('hidden');
        } else {
            element.setAttribute('hidden', 'hidden');
            element.classList.remove('visible');
            element.setAttribute('aria-hidden', 'true');
        }
    }

    function updateStickyButtonTextColor(element, buttonColor, textColor) {
        if (!element) {
            return;
        }

        var normalizedButton = normalizeHexColor(buttonColor);

        if (!normalizedButton) {
            element.style.removeProperty('--sticky-cta-button-text');
            stickyState.button_text_color = '';
            return;
        }

        var normalizedText = normalizeHexColor(textColor) || normalizeHexColor(stickyState.text_color) || '#ffffff';
        var contrastColor = ensureAccessibleColor(normalizedText, normalizedButton, ['#050608', '#ffffff', '#000000'], 4.5);

        if (contrastColor) {
            element.style.setProperty('--sticky-cta-button-text', contrastColor);
            stickyState.button_text_color = contrastColor;
        }
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

    var FOOTER_NAV_ALIGNMENTS = ['left', 'center', 'right', 'justify'];
    var FOOTER_NAV_ALIGNMENT_CLASSES = FOOTER_NAV_ALIGNMENTS.map(function (alignment) {
        return 'is-' + alignment;
    });

    function sanitizeFooterMenuAlignment(value) {
        if (typeof value !== 'string') {
            return 'center';
        }

        var normalized = value.trim().toLowerCase();

        if (FOOTER_NAV_ALIGNMENTS.indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'center';
    }

    function applyFooterMenuAlignment(value) {
        var alignment = previewUtils.sanitizeFooterMenuAlignment(value);
        var className = 'is-' + alignment;
        var nodes = getNodes('.footer-navigation');
        var containers = getNodes('.footer-inner');

        if (!nodes.length) {
            containers.forEach(function (container) {
                container.setAttribute('data-footer-alignment', alignment);
            });
            return;
        }

        nodes.forEach(function (node) {
            applyChoiceClass(node, FOOTER_NAV_ALIGNMENT_CLASSES, className);
            node.setAttribute('data-footer-alignment', alignment);
        });

        containers.forEach(function (container) {
            container.setAttribute('data-footer-alignment', alignment);
        });
    }

    var FOOTER_MOBILE_LAYOUTS = ['stack', 'inline'];

    function sanitizeFooterMobileLayout(value) {
        if (typeof value !== 'string') {
            return 'stack';
        }

        var normalized = value.trim().toLowerCase();

        if (FOOTER_MOBILE_LAYOUTS.indexOf(normalized) !== -1) {
            return normalized;
        }

        return 'stack';
    }

    function applyFooterMobileLayout(value) {
        var layout = previewUtils.sanitizeFooterMobileLayout(value);
        var containers = getNodes('.footer-inner');

        containers.forEach(function (container) {
            container.setAttribute('data-footer-mobile-layout', layout);
        });
    }

    var rawMobileWidth = typeof rawCtaLayout.mobile_width !== 'undefined' ? rawCtaLayout.mobile_width : rawCtaLayout.mobileWidth;
    var rawMobileHeight = typeof rawCtaLayout.mobile_height !== 'undefined' ? rawCtaLayout.mobile_height : rawCtaLayout.mobileHeight;
    var rawMobilePadding = typeof rawCtaLayout.mobile_padding !== 'undefined' ? rawCtaLayout.mobile_padding : rawCtaLayout.mobilePadding;
    var rawShowMobile = typeof rawCtaLayout.show_mobile !== 'undefined' ? rawCtaLayout.show_mobile : rawCtaLayout.showMobile;

    ctaLayoutState = {
        width: toPositiveFloat(rawCtaLayout.width || rawCtaLayout.maxWidthValue || rawCtaLayout.max_width_value),
        height: toPositiveFloat(rawCtaLayout.height || rawCtaLayout.minHeightValue || rawCtaLayout.min_height_value),
        position: sanitizePosition(rawCtaLayout.position),
        alignment: sanitizeAlignment(rawCtaLayout.alignment),
        mobileWidth: toPositiveFloat(rawMobileWidth),
        mobileHeight: toPositiveFloat(rawMobileHeight),
        mobilePadding: toPositiveFloat(rawMobilePadding),
        showMobile: toBoolean(rawShowMobile, true)
    };

    setBodyMobileVisibility(ctaLayoutState.showMobile);

    var rawUiLayout = (data && (data.uiLayout || data.ui_layout)) ? (data.uiLayout || data.ui_layout) : {};
    var headerData = rawUiLayout.header || {};
    var footerData = rawUiLayout.footer || {};
    var buttonData = rawUiLayout.buttons || {};
    var thumbnailData = rawUiLayout.thumbnails || {};
    var contentData = rawUiLayout.content || {};
    var containerData = rawUiLayout.containers || {};
    var spacingData = rawUiLayout.spacing_scale || rawUiLayout.spacing || {};
    var gridGapData = typeof rawUiLayout.grid_gap !== 'undefined' ? rawUiLayout.grid_gap : null;

    var headerLayoutState = {
        height: toPositiveFloat(typeof headerData.height !== 'undefined' ? headerData.height : headerData.height_value || headerData.heightValue),
        paddingTop: toPositiveFloat(typeof headerData.padding_top !== 'undefined' ? headerData.padding_top : headerData.paddingTop),
        paddingBottom: toPositiveFloat(typeof headerData.padding_bottom !== 'undefined' ? headerData.padding_bottom : headerData.paddingBottom)
    };

    var footerHeightValue = footerData.height;

    if (typeof footerHeightValue === 'undefined') {
        footerHeightValue = typeof footerData.min_height !== 'undefined' ? footerData.min_height : footerData.minHeight;
    }

    var footerLayoutState = {
        height: toPositiveFloat(footerHeightValue),
        marginTop: toPositiveFloat(typeof footerData.margin_top !== 'undefined' ? footerData.margin_top : footerData.marginTop)
    };

    var buttonLayoutState = {
        paddingVertical: toPositiveFloat(typeof buttonData.padding_vertical !== 'undefined' ? buttonData.padding_vertical : buttonData.paddingVertical),
        paddingHorizontal: toPositiveFloat(typeof buttonData.padding_horizontal !== 'undefined' ? buttonData.padding_horizontal : buttonData.paddingHorizontal),
        borderRadius: toPositiveFloat(typeof buttonData.border_radius !== 'undefined' ? buttonData.border_radius : buttonData.borderRadius)
    };

    var thumbnailLayoutState = {
        aspectRatio: previewUtils.sanitizeAspectChoice(thumbnailData.aspect_ratio || thumbnailData.aspectRatio),
        maxWidthValue: toPositiveFloat(typeof thumbnailData.max_width_value !== 'undefined' ? thumbnailData.max_width_value : thumbnailData.maxWidthValue),
        maxWidthUnit: previewUtils.sanitizeThumbnailUnit(thumbnailData.max_width_unit || thumbnailData.maxWidthUnit)
    };

    var contentLayoutState = {
        maxWidth: toPositiveFloat(typeof containerData.xl !== 'undefined' ? containerData.xl : contentData.maxWidth),
        sectionSpacing: toPositiveFloat(typeof spacingData.lg !== 'undefined' ? spacingData.lg : contentData.sectionSpacing)
    };

    ['xs', 'sm', 'md', 'lg', 'xl'].forEach(function (size) {
        if (typeof containerData[size] !== 'undefined') {
            setContainerWidthValue(size, containerData[size]);
        }

        if (typeof spacingData[size] !== 'undefined') {
            setSpacingScaleValue(size, spacingData[size]);
        }
    });

    if (gridGapData !== null) {
        setGridGapValue(gridGapData);
    }

    var navPreview = (data && data.navLayout) ? data.navLayout : {};
    if (typeof navPreview.alignment !== 'undefined') {
        setNavAlignment(navPreview.alignment);
    }
    if (typeof navPreview.itemSpacing !== 'undefined') {
        setNavItemGap(navPreview.itemSpacing);
    }
    if (typeof navPreview.paddingY !== 'undefined') {
        setNavPadding(navPreview.paddingY);
    }
    if (typeof navPreview.sticky !== 'undefined') {
        setStickyEnabled(navPreview.sticky);
    }

    var brandingPreview = (data && data.branding) ? data.branding : {};
    if (typeof brandingPreview.maxWidth !== 'undefined') {
        setBrandLogoWidth(brandingPreview.maxWidth);
    }
    if (typeof brandingPreview.maxHeight !== 'undefined') {
        setBrandLogoHeight(brandingPreview.maxHeight);
    }
    if (typeof brandingPreview.maxWidthMobile !== 'undefined') {
        setBrandLogoMobileWidth(brandingPreview.maxWidthMobile);
    }
    if (typeof brandingPreview.textOnly !== 'undefined') {
        setBrandTextOnly(brandingPreview.textOnly);
    }

    function applyHeaderLayout() {
        setCSSVariable('--site-header-height', formatPxValue(headerLayoutState.height, false));
        setCSSVariable('--site-header-padding-top', formatPxValue(headerLayoutState.paddingTop, true));
        setCSSVariable('--site-header-padding-bottom', formatPxValue(headerLayoutState.paddingBottom, true));
    }

    function applyFooterLayout() {
        var heightValue = formatPxValue(footerLayoutState.height, false);

        setCSSVariable('--site-footer-height', heightValue);
        setCSSVariable('--site-footer-min-height', heightValue);
        setCSSVariable('--site-footer-max-height', heightValue);
        setCSSVariable('--site-footer-margin-top', formatPxValue(footerLayoutState.marginTop, true));
    }

    function applyButtonLayout() {
        setCSSVariable('--ui-button-padding-y', formatPxValue(buttonLayoutState.paddingVertical, true));
        setCSSVariable('--ui-button-padding-x', formatPxValue(buttonLayoutState.paddingHorizontal, true));
        setCSSVariable('--ui-button-radius', formatPxValue(buttonLayoutState.borderRadius, true));
    }

    function applyThumbnailLayout() {
        var ratioKey = previewUtils.sanitizeAspectChoice(thumbnailLayoutState.aspectRatio);
        var ratioValue = THUMBNAIL_ASPECT_MAP[ratioKey] || THUMBNAIL_ASPECT_MAP['16-9'];
        var widthCss = previewUtils.formatWidthValue(thumbnailLayoutState.maxWidthValue, previewUtils.sanitizeThumbnailUnit(thumbnailLayoutState.maxWidthUnit));

        setCSSVariable('--post-thumbnail-aspect-ratio', ratioValue);
        setCSSVariable('--post-thumbnail-max-width', widthCss);
    }

    function applyContentLayout() {
        setCSSVariable('--content-max-width', formatPxValue(contentLayoutState.maxWidth, false));
        setCSSVariable('--content-section-gap', formatPxValue(contentLayoutState.sectionSpacing, true));
    }

    function initializePreview() {
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

    var navAlignmentClasses = ['nav-align-left', 'nav-align-center', 'nav-align-right', 'nav-align-space-between'];
    var stickyEnabledState = bodyEl ? bodyEl.classList.contains('bg-has-sticky-header') : true;

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
            setCSSVariable('--bg-sticky-offset', '0px');
        } else {
            setCSSVariable('--bg-sticky-offset', '0px');
        }
    }

    function setNavAlignment(value) {
        var normalized = (value || '').toString().toLowerCase();
        var allowed = ['left', 'center', 'right', 'space-between'];
        if (allowed.indexOf(normalized) === -1) {
            normalized = 'space-between';
        }

        replaceBodyClass(navAlignmentClasses, 'nav-align-' + normalized);
    }

    function setNavItemGap(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        setCSSVariable('--nav-item-gap', parsed + 'px');
    }

    function setNavPadding(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        setCSSVariable('--nav-padding-y', parsed + 'px');
    }

    function setContainerWidthValue(size, value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        var key = '--container-' + size;
        setCSSVariable(key, parsed > 0 ? parsed + 'px' : '');

        if (size === 'xl') {
            setCSSVariable('--content-max-width', parsed > 0 ? parsed + 'px' : '');
        }
    }

    function setSpacingScaleValue(size, value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        var key = '--spacing-' + size;
        setCSSVariable(key, parsed + 'px');

        if (size === 'lg') {
            setCSSVariable('--content-section-gap', parsed + 'px');
        }
    }

    function setGridGapValue(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed < 0) {
            parsed = 0;
        }

        setCSSVariable('--grid-gap', parsed + 'px');
    }

    function setBrandLogoWidth(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed <= 0) {
            setCSSVariable('--brand-logo-max-width', '');
            return;
        }

        setCSSVariable('--brand-logo-max-width', parsed + 'px');
    }

    function setBrandLogoHeight(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed <= 0) {
            setCSSVariable('--brand-logo-max-height', '');
            return;
        }

        setCSSVariable('--brand-logo-max-height', parsed + 'px');
    }

    function setBrandLogoMobileWidth(value) {
        var parsed = parseInt(value, 10);

        if (isNaN(parsed) || parsed <= 0) {
            setCSSVariable('--brand-logo-max-width-mobile', '');
            return;
        }

        setCSSVariable('--brand-logo-max-width-mobile', parsed + 'px');
    }

    function setBrandTextOnly(value) {
        var enabled = normalizeBoolean(value);

        if (!bodyEl) {
            return;
        }

        if (enabled) {
            bodyEl.classList.add('brand-text-only');
        } else {
            bodyEl.classList.remove('brand-text-only');
        }
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

    function updateCTALayout() {
        var wrappers = getNodes(ctaWrapperSelector);

        if (!wrappers.length) {
            return;
        }

        var widthCss = formatCtaDimension(ctaLayoutState.width);
        var heightCss = formatCtaDimension(ctaLayoutState.height);
        var mobileWidthCss = formatCtaDimension(ctaLayoutState.mobileWidth);
        var mobileHeightCss = formatCtaDimension(ctaLayoutState.mobileHeight);
        var mobilePaddingCss = formatPxValue(ctaLayoutState.mobilePadding, true);
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

            if (mobileWidthCss) {
                el.style.setProperty('--cta-width-mobile', mobileWidthCss);
            } else {
                el.style.removeProperty('--cta-width-mobile');
            }

            if (mobileHeightCss) {
                el.style.setProperty('--cta-height-mobile', mobileHeightCss);
            } else {
                el.style.removeProperty('--cta-height-mobile');
            }

            if (mobilePaddingCss !== '') {
                el.style.setProperty('--cta-padding-mobile', mobilePaddingCss);
            } else {
                el.style.removeProperty('--cta-padding-mobile');
            }

            el.style.removeProperty('--cta-max-width');
            el.style.removeProperty('--cta-min-height');

            applyChoiceClass(el, CTA_POSITION_CLASSES, positionClass);
            applyChoiceClass(el, CTA_ALIGNMENT_CLASSES, alignmentClass);
        });
    }

        api('beyond_gotham_show_socialbar_header', function (value) {
            var isVisible = !!value.get();
            toggleSocialbarLocation('header', isVisible);
            toggleHeaderSocialFallback(isVisible);

            value.bind(function (newValue) {
                var visible = !!newValue;
                toggleSocialbarLocation('header', visible);
                toggleHeaderSocialFallback(visible);
            });
        });

        api('beyond_gotham_show_socialbar_mobile', function (value) {
            toggleSocialbarLocation('mobile', !!value.get());

            value.bind(function (newValue) {
                toggleSocialbarLocation('mobile', !!newValue);
            });
        });

        var SOCIAL_NETWORK_SETTINGS = ['github', 'linkedin', 'mastodon', 'twitter', 'facebook', 'instagram', 'tiktok', 'youtube', 'telegram', 'email'];

        SOCIAL_NETWORK_SETTINGS.forEach(function (network) {
            var settingId = network === 'email' ? 'beyond_gotham_social_email' : 'beyond_gotham_social_' + network;

            api(settingId, function (setting) {
                updateSocialLink(network, setting.get());

                setting.bind(function (newValue) {
                    updateSocialLink(network, newValue);
                });
            });
        });

        api('beyond_gotham_socialbar_style_variant', function (value) {
            setSocialbarVariant(value.get());

            value.bind(function (newValue) {
                setSocialbarVariant(newValue);
            });
        });

        api('beyond_gotham_socialbar_icon_style', function (value) {
            applySocialbarIconStyle(value.get());

            value.bind(function (newValue) {
                applySocialbarIconStyle(newValue);
            });
        });

        api('beyond_gotham_socialbar_background_color', function (value) {
            setSocialbarSurfaceBackground(value.get());

            value.bind(function (newValue) {
                setSocialbarSurfaceBackground(newValue);
            });
        });

        api('beyond_gotham_socialbar_icon_color', function (value) {
            setSocialbarSurfaceIcon(value.get());

            value.bind(function (newValue) {
                setSocialbarSurfaceIcon(newValue);
            });
        });

        SOCIALBAR_VARIANTS.forEach(function (variant) {
            ['background', 'hover', 'icon'].forEach(function (type) {
                var settingId = 'beyond_gotham_socialbar_' + variant + '_' + type + '_color';

                api(settingId, function (setting) {
                    setSocialbarVariantColor(variant, type, setting.get());

                    setting.bind(function (newValue) {
                        setSocialbarVariantColor(variant, type, newValue);
                    });
                });
            });
        });

        api('beyond_gotham_nav_alignment', function (value) {
            setNavAlignment(value.get());

            value.bind(function (newValue) {
                setNavAlignment(newValue);
            });
        });

        api('beyond_gotham_nav_item_spacing', function (value) {
            setNavItemGap(value.get());

            value.bind(function (newValue) {
                setNavItemGap(newValue);
            });
        });

        api('beyond_gotham_nav_padding_y', function (value) {
            setNavPadding(value.get());

            value.bind(function (newValue) {
                setNavPadding(newValue);
            });
        });

        api('beyond_gotham_nav_sticky', function (value) {
            setStickyEnabled(value.get());

            value.bind(function (newValue) {
                setStickyEnabled(newValue);
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
            footerLayoutState.height = toPositiveFloat(value.get());
            applyFooterLayout();

            value.bind(function (newValue) {
                footerLayoutState.height = toPositiveFloat(newValue);
                applyFooterLayout();
            });
        });

        api('beyond_gotham_footer_menu_alignment', function (value) {
            applyFooterMenuAlignment(value.get());

            value.bind(function (newValue) {
                applyFooterMenuAlignment(newValue);
            });
        });

        api('beyond_gotham_footer_mobile_layout', function (value) {
            applyFooterMobileLayout(value.get());

            value.bind(function (newValue) {
                applyFooterMobileLayout(newValue);
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
            thumbnailLayoutState.aspectRatio = previewUtils.sanitizeAspectChoice(value.get());
            applyThumbnailLayout();

            value.bind(function (newValue) {
                thumbnailLayoutState.aspectRatio = previewUtils.sanitizeAspectChoice(newValue);
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
            thumbnailLayoutState.maxWidthUnit = previewUtils.sanitizeThumbnailUnit(value.get());
            applyThumbnailLayout();

            value.bind(function (newValue) {
                thumbnailLayoutState.maxWidthUnit = previewUtils.sanitizeThumbnailUnit(newValue);
                applyThumbnailLayout();
            });
        });

        ['xs', 'sm', 'md', 'lg', 'xl'].forEach(function (size) {
            var settingId = 'beyond_gotham_container_width_' + size;

            api(settingId, function (value) {
                var initial = value.get();
                setContainerWidthValue(size, initial);

                if (size === 'xl') {
                    contentLayoutState.maxWidth = toPositiveFloat(initial);
                    applyContentLayout();
                }

                value.bind(function (newValue) {
                    setContainerWidthValue(size, newValue);

                    if (size === 'xl') {
                        contentLayoutState.maxWidth = toPositiveFloat(newValue);
                        applyContentLayout();
                    }
                });
            });
        });

        ['xs', 'sm', 'md', 'lg', 'xl'].forEach(function (size) {
            var settingId = 'beyond_gotham_spacing_' + size;

            api(settingId, function (value) {
                var initial = value.get();
                setSpacingScaleValue(size, initial);

                if (size === 'lg') {
                    contentLayoutState.sectionSpacing = toPositiveFloat(initial);
                    applyContentLayout();
                }

                value.bind(function (newValue) {
                    setSpacingScaleValue(size, newValue);

                    if (size === 'lg') {
                        contentLayoutState.sectionSpacing = toPositiveFloat(newValue);
                        applyContentLayout();
                    }
                });
            });
        });

        api('beyond_gotham_grid_gap', function (value) {
            setGridGapValue(value.get());

            value.bind(function (newValue) {
                setGridGapValue(newValue);
            });
        });

        api('beyond_gotham_brand_logo_max_width', function (value) {
            setBrandLogoWidth(value.get());

            value.bind(function (newValue) {
                setBrandLogoWidth(newValue);
            });
        });

        api('beyond_gotham_brand_logo_max_height', function (value) {
            setBrandLogoHeight(value.get());

            value.bind(function (newValue) {
                setBrandLogoHeight(newValue);
            });
        });

        api('beyond_gotham_brand_logo_max_width_mobile', function (value) {
            setBrandLogoMobileWidth(value.get());

            value.bind(function (newValue) {
                setBrandLogoMobileWidth(newValue);
            });
        });

        api('beyond_gotham_brand_text_only', function (value) {
            setBrandTextOnly(value.get());

            value.bind(function (newValue) {
                setBrandTextOnly(newValue);
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

        updateCTALayout();

        api('beyond_gotham_cta_mobile_visible', function (value) {
            value.bind(function (newValue) {
                ctaLayoutState.showMobile = toBoolean(newValue, true);
                setBodyMobileVisibility(ctaLayoutState.showMobile);
            });
        });

        api('beyond_gotham_cta_mobile_width', function (value) {
            value.bind(function (newValue) {
                ctaLayoutState.mobileWidth = toPositiveFloat(newValue);
                updateCTALayout();
            });
        });

        api('beyond_gotham_cta_mobile_height', function (value) {
            value.bind(function (newValue) {
                ctaLayoutState.mobileHeight = toPositiveFloat(newValue);
                updateCTALayout();
            });
        });

        api('beyond_gotham_cta_mobile_padding', function (value) {
            value.bind(function (newValue) {
                ctaLayoutState.mobilePadding = toPositiveFloat(newValue);
                updateCTALayout();
            });
        });

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

        api('beyond_gotham_sticky_cta_active', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var isActive = toBoolean(newValue);
                wrapper.setAttribute('data-active', isActive ? 'true' : 'false');
                stickyState.active = isActive;

                if (!isActive) {
                    wrapper.classList.remove('visible');
                }

                refreshStickyCtaState(wrapper);
            });
        });

        api('beyond_gotham_sticky_cta_content', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();
                var contentNode = getStickyContentNode();

                if (!wrapper || !contentNode) {
                    return;
                }

                var markup = newValue || '';
                contentNode.innerHTML = markup;

                var hasContent = hasStickyContent(markup);
                wrapper.setAttribute('data-has-content', hasContent ? 'true' : 'false');
                stickyState.has_content = hasContent;

                refreshStickyCtaState(wrapper);
            });
        });

        api('beyond_gotham_sticky_cta_link', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();
                var button = getStickyButtonNode();

                if (!wrapper || !button) {
                    return;
                }

                var linkValue = (newValue || '').trim();
                var hasLink = linkValue.length > 0;

                stickyState.link = linkValue;
                wrapper.setAttribute('data-has-link', hasLink ? 'true' : 'false');

                if (hasLink) {
                    button.setAttribute('href', linkValue);
                    button.removeAttribute('aria-disabled');
                    button.removeAttribute('tabindex');
                    button.removeAttribute('hidden');
                } else {
                    button.removeAttribute('href');
                    button.setAttribute('aria-disabled', 'true');
                    button.setAttribute('tabindex', '-1');
                    button.setAttribute('hidden', 'hidden');
                }

                refreshStickyCtaState(wrapper);
            });
        });

        api('beyond_gotham_sticky_cta_delay', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var seconds = toPositiveFloat(newValue);
                var milliseconds = Math.max(0, Math.round(seconds * 1000));

                wrapper.setAttribute('data-delay', String(milliseconds));
                stickyState.delay_ms = milliseconds;
            });
        });

        api('beyond_gotham_sticky_cta_background_color', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                if (newValue) {
                    wrapper.style.setProperty('--sticky-cta-bg', newValue);
                    stickyState.background = newValue;
                } else {
                    wrapper.style.removeProperty('--sticky-cta-bg');
                    stickyState.background = stickyDefaults.background || '';
                }
            });
        });

        api('beyond_gotham_sticky_cta_text_color', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var resolved = newValue ? newValue : (stickyDefaults.text_color || '');
                stickyState.text_color = resolved;

                if (newValue) {
                    wrapper.style.setProperty('--sticky-cta-text', newValue);
                } else {
                    wrapper.style.removeProperty('--sticky-cta-text');
                }

                updateStickyButtonTextColor(wrapper, stickyState.button_color || stickyDefaults.button_color || '', resolved);
            });
        });

        api('beyond_gotham_sticky_cta_button_color', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var resolved = newValue ? newValue : (stickyDefaults.button_color || '');
                stickyState.button_color = resolved;

                if (newValue) {
                    wrapper.style.setProperty('--sticky-cta-button-bg', newValue);
                } else {
                    wrapper.style.removeProperty('--sticky-cta-button-bg');
                }

                updateStickyButtonTextColor(wrapper, resolved, stickyState.text_color || stickyDefaults.text_color || '');
            });
        });

        api('beyond_gotham_sticky_cta_show_desktop', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var allowed = toBoolean(newValue, true);
                wrapper.setAttribute('data-show-desktop', allowed ? 'true' : 'false');
                stickyState.show_desktop = allowed;

                refreshStickyCtaState(wrapper);
            });
        });

        api('beyond_gotham_sticky_cta_show_mobile', function (value) {
            value.bind(function (newValue) {
                var wrapper = getStickyWrapper();

                if (!wrapper) {
                    return;
                }

                var allowed = toBoolean(newValue, true);
                wrapper.setAttribute('data-show-mobile', allowed ? 'true' : 'false');
                stickyState.show_mobile = allowed;

                refreshStickyCtaState(wrapper);
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
    }

    var domReady = false;
    var customizeReady = false;
    if (typeof window !== 'undefined') {
        window.BeyondGothamPreviewUtils = previewUtils;
    }

    var initialized = false;

    function requestInitialization() {
        if (!domReady || !customizeReady || initialized) {
            return;
        }

        initialized = true;

        var run = function () {
            initializePreview();
        };

        if (typeof window !== 'undefined' && typeof window.requestAnimationFrame === 'function') {
            window.requestAnimationFrame(run);
        } else {
            setTimeout(run, 0);
        }
    }

    function markDomReady() {
        domReady = true;
        requestInitialization();
    }

    function markCustomizeReady() {
        customizeReady = true;
        requestInitialization();
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        markDomReady();
    } else {
        document.addEventListener('DOMContentLoaded', function handleDomReady() {
            document.removeEventListener('DOMContentLoaded', handleDomReady);
            markDomReady();
        }, { once: true });
    }

    if (typeof api.bind === 'function') {
        api.bind('ready', markCustomizeReady);
    } else {
        markCustomizeReady();
    }

    });
})(window.wp, window.BGCustomizerPreview);
