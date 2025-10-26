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
