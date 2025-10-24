(function (blocks, element, blockEditor, components, i18n) {
    if (!blocks || !element || !blockEditor || !i18n) {
        return;
    }

    var registerBlockType = blocks.registerBlockType;
    var createElement = element.createElement;
    var Fragment = element.Fragment;
    var RichText = blockEditor.RichText;
    var useBlockProps = blockEditor.useBlockProps ? blockEditor.useBlockProps : function (props) { return props || {}; };
    var URLInputButton = blockEditor.URLInputButton;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components ? components.PanelBody : null;
    var TextControl = components ? components.TextControl : null;
    var __ = i18n.__;

    registerBlockType('beyond-gotham/course-teaser', {
        title: __('Kurs-Teaser', 'beyond_gotham'),
        description: __('Kuratiere Inhalte für Dashboards oder Info-Terminals mit Bild, Kurztext und Link.', 'beyond_gotham'),
        icon: 'excerpt-view',
        category: 'widgets',
        supports: {
            html: false,
            align: ['wide', 'full'],
            anchor: true,
            spacing: {
                margin: true,
                padding: true
            }
        },
        attributes: {
            eyebrow: {
                type: 'string',
                source: 'html',
                selector: '.bg-course-teaser__eyebrow'
            },
            title: {
                type: 'string',
                source: 'html',
                selector: '.bg-course-teaser__title'
            },
            summary: {
                type: 'string',
                source: 'html',
                selector: '.bg-course-teaser__summary'
            },
            ctaLabel: {
                type: 'string',
                default: ''
            },
            ctaUrl: {
                type: 'string',
                default: ''
            },
            meta: {
                type: 'string',
                source: 'html',
                selector: '.bg-course-teaser__meta'
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var isSelected = props.isSelected;

            var blockProps = useBlockProps({ className: 'bg-course-teaser' });

            var inspector = null;
            if (InspectorControls && PanelBody && TextControl) {
                inspector = createElement(
                    InspectorControls,
                    { key: 'inspector' },
                    createElement(
                        PanelBody,
                        { title: __('Verlinkung', 'beyond_gotham'), initialOpen: true },
                        createElement(TextControl, {
                            label: __('Ziel-URL', 'beyond_gotham'),
                            value: attributes.ctaUrl,
                            onChange: function (value) {
                                setAttributes({ ctaUrl: value || '' });
                            },
                            placeholder: __('https://example.com', 'beyond_gotham')
                        })
                    )
                );
            }

            return createElement(
                Fragment,
                {},
                inspector,
                createElement(
                    'div',
                    blockProps,
                    createElement(RichText, {
                        tagName: 'span',
                        className: 'bg-course-teaser__eyebrow',
                        value: attributes.eyebrow,
                        placeholder: __('Kategorie oder Hinweis…', 'beyond_gotham'),
                        onChange: function (value) {
                            setAttributes({ eyebrow: value });
                        },
                        allowedFormats: ['core/bold', 'core/italic']
                    }),
                    createElement(RichText, {
                        tagName: 'h3',
                        className: 'bg-course-teaser__title',
                        value: attributes.title,
                        placeholder: __('Headline zum Inhalt…', 'beyond_gotham'),
                        allowedFormats: ['core/bold', 'core/italic', 'core/strikethrough'],
                        onChange: function (value) {
                            setAttributes({ title: value });
                        }
                    }),
                    createElement(RichText, {
                        tagName: 'div',
                        className: 'bg-course-teaser__summary',
                        multiline: 'p',
                        value: attributes.summary,
                        placeholder: __('Kurze Beschreibung des Angebots…', 'beyond_gotham'),
                        allowedFormats: ['core/bold', 'core/italic', 'core/link'],
                        onChange: function (value) {
                            setAttributes({ summary: value });
                        }
                    }),
                    createElement(RichText, {
                        tagName: 'div',
                        className: 'bg-course-teaser__meta',
                        value: attributes.meta,
                        placeholder: __('Datum, Ort oder Tags…', 'beyond_gotham'),
                        allowedFormats: ['core/bold', 'core/italic', 'core/link'],
                        onChange: function (value) {
                            setAttributes({ meta: value });
                        }
                    }),
                    createElement(
                        'div',
                        { className: 'bg-course-teaser__cta' },
                        createElement(RichText, {
                            tagName: 'span',
                            className: 'bg-course-teaser__cta-label',
                            value: attributes.ctaLabel,
                            placeholder: __('Button-Text…', 'beyond_gotham'),
                            allowedFormats: ['core/bold'],
                            onChange: function (value) {
                                setAttributes({ ctaLabel: value });
                            }
                        })
                    )
                ),
                isSelected && URLInputButton
                    ? createElement(
                        'div',
                        { className: 'bg-course-teaser__url-picker' },
                        createElement(URLInputButton, {
                            url: attributes.ctaUrl,
                            onChange: function (value) {
                                setAttributes({ ctaUrl: value || '' });
                            },
                            label: __('Link auswählen', 'beyond_gotham')
                        })
                    )
                    : null
            );
        },
        save: function (props) {
            var attributes = props.attributes;
            var blockProps = useBlockProps.save ? useBlockProps.save({ className: 'bg-course-teaser' }) : { className: 'bg-course-teaser' };

            return createElement(
                'div',
                blockProps,
                attributes.eyebrow
                    ? createElement(RichText.Content, {
                        tagName: 'span',
                        className: 'bg-course-teaser__eyebrow',
                        value: attributes.eyebrow
                    })
                    : null,
                attributes.title
                    ? createElement(RichText.Content, {
                        tagName: 'h3',
                        className: 'bg-course-teaser__title',
                        value: attributes.title
                    })
                    : null,
                attributes.summary
                    ? createElement(RichText.Content, {
                        tagName: 'div',
                        className: 'bg-course-teaser__summary',
                        value: attributes.summary
                    })
                    : null,
                attributes.meta
                    ? createElement(RichText.Content, {
                        tagName: 'div',
                        className: 'bg-course-teaser__meta',
                        value: attributes.meta
                    })
                    : null,
                attributes.ctaLabel
                    ? createElement(
                        'div',
                        { className: 'bg-course-teaser__cta' },
                        createElement(
                            'a',
                            {
                                className: 'bg-button bg-button--primary',
                                href: attributes.ctaUrl ? attributes.ctaUrl : '#'
                            },
                            createElement(RichText.Content, {
                                tagName: 'span',
                                className: 'bg-course-teaser__cta-label',
                                value: attributes.ctaLabel
                            })
                        )
                    )
                    : null
            );
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor || window.wp.editor, window.wp.components, window.wp.i18n);
