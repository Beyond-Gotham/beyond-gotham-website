(function (blocks, element, blockEditor, components, i18n) {
    if (!blocks || !element || !blockEditor || !components || !i18n) {
        return;
    }

    var registerBlockType = blocks.registerBlockType;
    var createElement = element.createElement;
    var RichText = blockEditor.RichText;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var __ = i18n.__;

    registerBlockType('beyond-gotham/highlight-box', {
        title: __('Highlight-Kasten', 'beyond_gotham'),
        description: __('Zeige ein aufmerksamkeitsstarkes Info-Element mit optionalem Call-to-Action.', 'beyond_gotham'),
        icon: 'star-filled',
        category: 'design',
        supports: {
            html: false,
            align: ['wide', 'full'],
            anchor: true
        },
        attributes: {
            title: {
                type: 'string',
                source: 'html',
                selector: 'h3'
            },
            content: {
                type: 'string',
                source: 'html',
                selector: '.bg-highlight-box__content'
            },
            ctaText: {
                type: 'string',
                default: ''
            },
            ctaUrl: {
                type: 'string',
                default: ''
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return [
                createElement(
                    InspectorControls,
                    { key: 'inspector' },
                    createElement(
                        PanelBody,
                        { title: __('Call-to-Action', 'beyond_gotham'), initialOpen: true },
                        createElement(TextControl, {
                            label: __('Link-Ziel', 'beyond_gotham'),
                            value: attributes.ctaUrl,
                            placeholder: __('https://example.com', 'beyond_gotham'),
                            onChange: function (value) {
                                setAttributes({ ctaUrl: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: __('Button-Text', 'beyond_gotham'),
                            value: attributes.ctaText,
                            onChange: function (value) {
                                setAttributes({ ctaText: value });
                            }
                        })
                    )
                ),
                createElement(
                    'div',
                    { className: props.className ? props.className + ' bg-highlight-box' : 'bg-highlight-box' },
                    createElement(RichText, {
                        tagName: 'h3',
                        value: attributes.title,
                        allowedFormats: ['core/bold', 'core/italic', 'core/link'],
                        placeholder: __('Highlight-Überschrift…', 'beyond_gotham'),
                        onChange: function (value) {
                            setAttributes({ title: value });
                        }
                    }),
                    createElement(RichText, {
                        tagName: 'div',
                        multiline: 'p',
                        className: 'bg-highlight-box__content',
                        value: attributes.content,
                        allowedFormats: ['core/bold', 'core/italic', 'core/link', 'core/list', 'core/underline'],
                        placeholder: __('Beschreibe die wichtigsten Punkte…', 'beyond_gotham'),
                        onChange: function (value) {
                            setAttributes({ content: value });
                        }
                    }),
                    attributes.ctaText ? createElement(
                        'div',
                        { className: 'bg-highlight-box__actions' },
                        createElement('a', {
                            href: attributes.ctaUrl || '#',
                            className: 'bg-button bg-button--primary'
                        }, attributes.ctaText)
                    ) : null
                )
            ];
        },
        save: function (props) {
            var attributes = props.attributes;

            return createElement(
                'div',
                { className: 'bg-highlight-box' },
                attributes.title ? createElement(RichText.Content, {
                    tagName: 'h3',
                    value: attributes.title
                }) : null,
                attributes.content ? createElement(RichText.Content, {
                    tagName: 'div',
                    className: 'bg-highlight-box__content',
                    value: attributes.content
                }) : null,
                attributes.ctaText ? createElement(
                    'div',
                    { className: 'bg-highlight-box__actions' },
                    createElement('a', {
                        href: attributes.ctaUrl || '#',
                        className: 'bg-button bg-button--primary'
                    }, attributes.ctaText)
                ) : null
            );
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor || window.wp.editor, window.wp.components, window.wp.i18n);
