# Beyond Gotham Website

## Überblick

Die Beyond-Gotham-Plattform bündelt Landing Page, Kursverwaltung und Anmeldeprozesse in einem WordPress-Child-Theme. Das Theme liefert eine dunkle, redaktionelle Gestaltung sowie modulare PHP- und JS-Logik für Kurse, Dozenten und Anmeldungen.

## Tech-Stack

- **CMS**: WordPress 6.x + FreeNews (Parent Theme)
- **Theme**: `beyondgotham-dark-child`
- **Sprachen**: PHP 8.x, JavaScript (ES6), SCSS/CSS
- **Tooling**: WordPress Hooks, AJAX (`admin-ajax.php`), PHPCS (WordPress-Standard)

## Theme-Module

| Bereich | Datei | Inhalt |
| --- | --- | --- |
| Funktionen & Hooks | `functions.php` | Asset-Enqueueing, Dashboard-Widget, Admin-Anpassungen, Demo-Daten-Helfer |
| Custom Post Types | `inc/custom-post-types.php` | CPTs `bg_course`, `bg_instructor`, `bg_enrollment`, Taxonomien, Meta-Boxes, Admin-Spalten |
| Enrollment | `inc/enrollment-form.php` | Shortcode `[bg_course_enrollment]`, AJAX-Handler, E-Mail-Benachrichtigungen, Wartelisten-Logik |
| Templates | `page-landing.php`, `page-courses.php`, `single-bg_course.php` | Landing Page, Kursübersicht mit Filtern, Kursdetail inkl. Formular |
| Assets | `assets/css/frontend.css`, `assets/js/frontend.js` | Frontend-Komponenten, Smooth-Scroll, Formular-Handling |

## Lokale Entwicklung

1. **WordPress installieren** und Parent Theme *FreeNews* aktivieren.
2. Repo-Inhalt nach `wp-content/themes/beyondgotham-dark-child` kopieren.
3. Theme aktivieren (Design → Themes).
4. Permalinks auf `/%postname%/` stellen und speichern.
5. Testseite mit Template „Landing Page“ als Startseite setzen, Kursübersicht (Template „Kursübersicht“) anlegen.
6. Optional: In `functions.php` den auskommentierten Hook `bg_seed_demo_courses` temporär aktivieren, einmalig `wp-admin` laden, anschließend wieder deaktivieren.

## Deployment-Hinweise

- Upload der Theme-Dateien via Git/SFTP in die Zielinstanz.
- Nach Deploy: Cache leeren, Permalinks speichern, Cron für `wp_mail` testen.
- SMTP-Plugin (z. B. „WP Mail SMTP“) konfigurieren, um Formularbestätigungen zuverlässig zu versenden.
- Sicherheits-Check: `wp-config.php` auf `DISALLOW_FILE_EDIT` setzen, Admin-Rollen prüfen.

## Projektstruktur

```
beyond-gotham-website/
├── README-WEBSITE.md
├── IMPLEMENTATION.md
└── wordpress/wp-content/themes/beyondgotham-dark-child/
    ├── functions.php
    ├── style.css
    ├── assets/
    │   ├── css/frontend.css
    │   └── js/frontend.js
    ├── inc/
    │   ├── custom-post-types.php
    │   └── enrollment-form.php
    ├── page-landing.php
    ├── page-courses.php
    └── single-bg_course.php
```

## Schnellstart für Redaktionen

1. **Dozent:in anlegen** – Menü „Dozent:innen“.
2. **Kurs anlegen** – Menü „Kurse“, Meta-Felder ausfüllen (Dauer, Start, Plätze, Standort, Dozent:in).
3. **Landing Page** – Seite mit Template „Landing Page“ als Startseite festlegen.
4. **Kursübersicht** – Seite mit Template „Kursübersicht“ auf `/kurse/` veröffentlichen.
5. **Anmeldung testen** – Kursdetail öffnen, Formular mit Testdaten absenden, Eingang unter „Anmeldungen“ prüfen.

## Weiterführend

- Code-Stil: WordPress-Coding-Standards (`phpcs --standard=WordPress`).
- Tests (manuell): Kursfilter, AJAX-Formular (Warteliste + Bildungsgutschein), E-Mail-Log.
- Monitoring: Cron/SMTP-Logs beobachten, damit Anmeldebestätigungen zugestellt werden.
