# Changelog

## [Unreleased]
### Added
- Konsolidierte CTA-Komponente (`template-parts/components/cta-content.php`) inkl. Helper für Wrapper-Attribute (`inc/customizer/cta.php`).
- Initiale `theme.json` mit Farbpaletten, Typografie- und Layout-Vorgaben, abgestimmt auf Customizer-Variablen.
- Breakpoint-/Grid-Mixins (`src/scss/base/_breakpoints.scss`) und neues Shop-Stylesheet (`src/scss/pages/_shop.scss`).
- Footer-Menü: neue Customizer-Option zur Ausrichtung (Links/Mitte/Rechts/Verteilt) inkl. Live-Preview.
- Erweiterte Customizer-Module für Navigation, Branding und Layout (Menü-Toggles, Logo-Varianten, Container-/Spacing-Skala).
- Neues Performance-Modul mit Lazy Loading (Bilder/iFrames), LQIP-Blur, Script-Strategien und Heartbeat-Tuning.
- Neues SEO-Modul mit Titel-Formaten, Meta-Description-Fallbacks, Open-Graph-Basis und Schema.org JSON-LD inkl. Breadcrumbs.
- Sticky-CTA-Partial (`template-parts/components/sticky-cta.php`) mit zentralisiertem Markup und Customizer-Hooks.
- HTML-Attribut-Helper (`inc/helpers-html.php`) für konsistente Template- und Preview-Ausgaben.
- Navigations-Helper (`inc/helpers-navigation.php`) für konsistente `wp_nav_menu()`-Aufrufe samt Fallback-Markup und Customizer-Datenattributen.

### Changed
- Header-, Struktur- und Landing-Styles verwenden die Breakpoint-Mixins (`bp.up`, `bp.down`, …) für konsistente Grids.
- Socialbar-SCSS deckt Varianten/Icon-Stile via Klassen & `data-*`-Attribute ab; Sticky-CTA-Attribute harmonisieren mit der Customizer-Vorschau.
- Socialbar-Renderer nutzt den zentralen Icon-Helper und erweitert Wrapper-/Link-Attribute um Filter für Preview-Hooks.
- InfoTerminal-CTA setzt auf das `cta-content`-Partial und konsolidiert damit Button- und Link-Markup.
- Farben-Modul übernimmt theme.json-Presets (Primary/Secondary, Header/Footer, CTA) und mappt Legacy-Werte automatisch.
- Globale `.bg-grid`-Klasse nutzt Auto-Layout & WooCommerce-Schleifen erhalten dieselben Grid-Styles.
- Header- und Footer-Menüs verwenden den Navigations-Helper, liefern konsistente Wrapper-Attribute und unterstützen `postMessage`-Toggles im Customizer.
- Navigationstoggle, Overlay und Footer-Menü spiegeln `nav_show_*`-Einstellungen ohne Reload; Social-Icon-Template setzt vollständig auf den HTML-Attribut-Helper.
- Archiv-, Kurs- und Komponenten-SCSS greifen auf die Breakpoint-Mixins zurück (statt manueller `@media`-Queries) und decken zusätzliche Rastersprünge über numerische Breakpoint-Werte ab.

### Removed
- Removed legacy social-icon block from footer (black field with GitHub icon). Cleaned up related CSS and Customizer references.

### Fixed
- Sass-Build mit einheitlicher `@use`-Reihenfolge und modernen `map.get`-Aufrufen für Breakpoint-Mixins.
- fix(footer): symmetrische Spaltenbreite für exakte Zentrierung des Footer-Menüs; Customizer-Option erweitert.

## [0.2.0] - 2025-10-24
### Added
- Modular Customizer loader (`inc/customizer/loader.php`) mit automatischer Registrierung aller Modulklassen.
- Erweiterte Dokumentation zu Struktur und Erweiterbarkeit des Customizers.

### Changed
- Alle Customizer-Module wurden in eigene Klassen überführt und nutzen gemeinsame Sanitizer aus `helpers.php`.
- Live-Preview-Skripte und dynamische Styles werden jetzt über das Styles-Modul initialisiert.

### Removed
- Das monolithische `inc/customizer.php` wurde entfernt zugunsten der modularen Architektur.
