# Changelog

## [Unreleased]
### Added
- Footer-Menü: neue Customizer-Option zur Ausrichtung (Links/Mitte/Rechts/Verteilt) inkl. Live-Preview.
### Removed
- Removed legacy social-icon block from footer (black field with GitHub icon). Cleaned up related CSS and Customizer references.

## [0.2.0] - 2025-10-24
### Added
- Modular Customizer loader (`inc/customizer/loader.php`) mit automatischer Registrierung aller Modulklassen.
- Erweiterte Dokumentation zu Struktur und Erweiterbarkeit des Customizers.

### Changed
- Alle Customizer-Module wurden in eigene Klassen überführt und nutzen gemeinsame Sanitizer aus `helpers.php`.
- Live-Preview-Skripte und dynamische Styles werden jetzt über das Styles-Modul initialisiert.

### Removed
- Das monolithische `inc/customizer.php` wurde entfernt zugunsten der modularen Architektur.
