<?php
/**
 * Template part for rendering the theme mode toggle button.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<button
    class="theme-toggle"
    type="button"
    data-bg-theme-toggle
    aria-pressed="false"
    aria-label="<?php echo esc_attr__( 'Designmodus wechseln', 'beyond_gotham' ); ?>"
>
    <span class="theme-toggle__icon" aria-hidden="true">
        <svg class="theme-toggle__icon-sun" viewBox="0 0 24 24" role="presentation" focusable="false">
            <circle cx="12" cy="12" r="4" />
            <g stroke-linecap="round">
                <line x1="12" y1="2.5" x2="12" y2="5" />
                <line x1="12" y1="19" x2="12" y2="21.5" />
                <line x1="4.22" y1="4.22" x2="5.9" y2="5.9" />
                <line x1="18.1" y1="18.1" x2="19.78" y2="19.78" />
                <line x1="2.5" y1="12" x2="5" y2="12" />
                <line x1="19" y1="12" x2="21.5" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.9" y2="18.1" />
                <line x1="18.1" y1="5.9" x2="19.78" y2="4.22" />
            </g>
        </svg>
        <svg class="theme-toggle__icon-moon" viewBox="0 0 24 24" role="presentation" focusable="false">
            <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79z" />
        </svg>
    </span>
</button>
