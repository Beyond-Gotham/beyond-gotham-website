# Beyond Gotham – Repository Hinweis

Die vollständige Projektbeschreibung befindet sich in **README-WEBSITE.md**. Für Installations- und Betriebsdetails siehe **IMPLEMENTATION.md**.

Kurzübersicht:

- Child Theme: `wordpress/wp-content/themes/beyondgotham-dark-child`
- Dokumentation: `README-WEBSITE.md`
- Setup/Deploy: `IMPLEMENTATION.md`
- Customizer: Footer-Menü-Ausrichtung (Links/Mitte/Rechts/Verteilt) mit Live-Preview

Bitte dort nachlesen, bevor Änderungen eingespielt werden.

## Modularer Customizer

Der WordPress-Customizer des Beyond-Gotham-Themes ist vollständig modularisiert.

- Einstiegspunkt: `wordpress/wp-content/themes/beyond-gotham/inc/customizer/loader.php`
- Module liegen unter `inc/customizer/modules/` und registrieren sich automatisch über den Loader.
- Jedes Modul implementiert `Beyond_Gotham_Customizer_Module_Interface` und kann eigene Hooks (z. B. `customize_register`, `customize_preview_init`) binden.
- Gemeinsame Sanitizer- und Helper-Funktionen befinden sich in `inc/customizer/helpers.php`.
- Neue Module werden einfach als Datei im Modul-Ordner abgelegt; der Loader lädt Klassen automatisch anhand der Implementierung.
- Erweiterung 2025: Navigation-, Branding-, Layout-, Performance- und SEO-Module bringen neue Einstellungen inkl. Live-Preview, sanitisierten Eingaben und Plugin-Erkennung.
