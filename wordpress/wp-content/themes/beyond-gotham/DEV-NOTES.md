# Beyond Gotham – Developer Notes

## Post Meta Single Source
- `inc/post-meta.php` is the canonical provider for post meta field definitions, post type support, and defaults.
- Customizer components and other consumers must call the helpers from this file instead of defining or requiring their own copies.

## Customizer Loader Order
- `functions.php` loads `inc/post-meta.php` before the customizer bootstrap to guarantee helpers exist exactly once per request.
- The modular customizer loader skips AJAX, REST, cron, and installation requests unless they originate from the Customizer, so admin-ajax no longer pulls in unnecessary modules.
- Customizer modules expect the shared helpers to be present; if they are missing, the module aborts early and logs `_doing_it_wrong` during development.

## Admin-AJAX Stability
- Generic calls to `admin-ajax.php` (with or without an `action`) run without loading heavy Customizer code, preventing accidental redeclarations and ensuring a clean `0` response for empty requests.
- When invoking theme-provided AJAX actions, confirm the required nonces and parameters are passed; logs should stay free of redeclaration notices under PHP 8.4.

## Footer Layout
- The footer now only renders the configured copyright text and navigation links. Legacy social icon output has been removed entirely.
- `.footer-inner` exposes `data-footer-alignment` so the center menu can switch between flex and grid layouts. When set to `center`, the grid ensures `.footer-left` and `.footer-right` share the same width, keeping the navigation geometrically centered.
- Mobile behaviour is controlled through `data-footer-mobile-layout` (`stack` or `inline`). The Customizer updates this attribute live so designers can choose between a stacked column layout or an inline row on narrow viewports.
