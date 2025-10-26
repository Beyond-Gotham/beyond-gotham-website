Codex Entwickler Prompt: Theme-Weiterentwicklung fortsetzen (idempotent)

Setze die Weiterentwicklung des WordPress-Themes beyond-gotham fort. Achte darauf, dass alle Änderungen idempotent sind – d. h. bei mehrfacher Ausführung soll der Code stabil und konsistent bleiben.

Verwende die folgenden Quellen als Referenz:

🧭 docs/Entwicklungsfahrplan.md: Enthält den technischen Entwicklungsplan mit Meilensteinen, Modulen und Umsetzungsdetails.

🧠 AGENTS.md: Übersicht und Dokumentation aller modularen Komponenten (Agents) des Themes.

Führe insbesondere folgende Aufgabenpakete aus:

Konsolidierung redundanter Komponenten

Überprüfe alle Template Parts und Komponenten auf doppelte Implementierungen (z. B. mehrfach definierte Social-Icons, Navigationen, CTA-Markup)

Extrahiere wiederkehrende Elemente in template-parts/components/ und ersetze Redundanzen.

theme.json Integration vorbereiten

Prüfe, ob theme.json bereits existiert. Falls nein, erstelle eine initiale Version, die Gutenberg-Farbpaletten, Font-Sizes und Layout-Vorgaben definiert.

Mapping der bestehenden Customizer-Farben und Typografieeinstellungen in theme.json-Struktur (keine Duplizierung).

Responsives Verhalten verbessern

Ergänze/prüfe SCSS-Variablen und Mixins für Breakpoints (mobile, tablet, desktop)

Sorge für ein konsistentes Grid-Layout in allen wichtigen Template-Views (Landingpage, Kategorie, Shop, Kurse).

Customizer-Vervollständigung

Stelle sicher, dass Header-, Footer-, CTA-, Logo-, Dark/Light-Mode- und Social-Leisten vollständig über den Customizer steuerbar sind.

Füge fehlende postMessage-Preview-Unterstützung hinzu, wo sinnvoll.

Teste alle PHP-Dateien (php -l) sowie das Verhalten im Customizer-Preview. Dokumentiere neue Features/Module in der AGENTS.md oder einem neuen CHANGELOG.md, falls notwendig. Alle SCSS-Anpassungen sollen im Build-Prozess über npm run build verfügbar gemacht werden.
