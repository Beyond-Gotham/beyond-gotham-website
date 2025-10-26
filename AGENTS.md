# AGENTS.md

## Zweck
Diese Datei dokumentiert die modularen Komponenten ("Agents") des WordPress-Themes **Beyond Gotham**. Sie dient als technische Übersicht für Entwickler:innen, die das Theme erweitern, warten oder refaktorisieren wollen. Jeder Agent ist für eine klar definierte Teilverantwortung zuständig, insbesondere im Bereich des Customizers, der Gutenberg-Kompatibilität, der Theme-Konfiguration und -Funktionalität.

👉 Ergänzende Übersicht: Siehe **[docs/Entwicklungsfahrplan.md](../docs/Entwicklungsfahrplan.md)** für den vollständigen technischen Entwicklungsplan des Themes.

## Architekturprinzipien
- **Modularisierung**: Alle Theme-Komponenten (Customizer, CPTs, Blöcke, etc.) sind in getrennten Dateien und Klassen gekapselt.
- **Single Responsibility**: Jede Datei / Klasse verfolgt genau einen Zweck.
- **Customizable by Design**: Alle relevanten UI-Einstellungen sollen über den Customizer konfigurierbar sein.
- **Gutenberg-kompatibel**: Eigene Blöcke, Block Styles und Block Patterns werden über `blocks/` und `inc/blocks.php` registriert.

---

## Übersicht der Agents

### Theme-Setup
| Agent | Zweck |
|-------|-------|
| `functions.php` | Globales Setup des Themes: Registrierung von Theme-Supports (z. B. Thumbnails, Custom Logos), Navigationsmenüs, WooCommerce-Kompatibilität, Lade-Logik für Scripts und Styles. Enthält auch zentrale Hilfsfunktionen. |
| `inc/post-meta.php` | Verwaltung und Ausgabe der Beitragsmetadaten im Frontend. Stellt gleichzeitig Schnittstellen für den Customizer bereit (Modul „Post Meta“). |
| `inc/custom-post-types.php` | Registriert die Custom Post Types (Kurse, Dozent:innen, Anmeldungen) inklusive zugehöriger Taxonomien. Definiert außerdem Meta-Felder für Editor und REST API. |
| `inc/enrollment-form.php` | Stellt ein AJAX-basiertes Formularsystem bereit (Shortcode-gesteuert), inklusive Validierung, Wartelistenverwaltung und E-Mail-Handling. |
| `inc/rest-api.php` | Erweiterung der WordPress REST API um Custom Fields und Zusatzendpunkte (z. B. Kurs-Metadaten). |
| `inc/blocks.php` | Bindeglied zwischen den Block-Ordnern im Theme und WordPress: registriert eigene Gutenberg-Blöcke per `block.json`. |
| `theme.json` | Zentrale Gutenberg-Konfiguration (Farben, Typografie, Layoutgrößen). Spiegelt Customizer-Defaults wider und ersetzt die Legacy-`add_theme_support`-Palette/Font-Registrierungen. |

### Template Components
| Component | Zweck |
|-----------|-------|
| `template-parts/components/cta-content.php` | Wiederverwendbares CTA-/Newsletter-Markup für Footer-, Sticky- und Inline-Boxen mit optionalen Social-Icons. |
| `template-parts/components/sticky-cta.php` | Kapselt die Sticky-CTA-Leiste inklusive Close-Button und bindet sich an Customizer/Preview-Selektoren (`data-bg-sticky-cta-*`). |

### Customizer Modules (geladen über `inc/customizer/loader.php`)
| Agent | Zweck |
|-------|-------|
| `modules/cta.php` → `cta.php` | Verwaltung aller CTA-Boxen (z. B. über Footer oder mobil sticky). Steuerung von Text, Linkziel, Sichtbarkeit und Layout im Customizer. |
| `modules/footer.php` → `footer.php` | Steuert Footer-Inhalte wie Copyright, Sichtbarkeit des Menüs, Position der CTA-Box, sowie Social-Bar-Einstellungen. |
| `modules/social.php` → `social.php` | Verwaltung der Social-Media-Links (Header, Footer, mobil sticky). Sichtbarkeitsregeln & Icon-Auswahl. |
| `modules/social-sharing.php` → `social-sharing.php` | Konfigurierbare Share-Buttons (z. B. unter Artikeln) – soziale Netzwerke, Position, Kontextsteuerung. |
| `modules/post-meta.php` → `post-meta.php` | Steuerung der Beitrags-Metainhalte: Sichtbarkeit, Reihenfolge, Anzeige von Autor, Tags, Kategorien, Kommentare, Lesezeit etc. |
| `modules/navigation.php` → `navigation.php` | Optionen für Menüs: Ausrichtung (horizontal/vertikal), Sticky-Verhalten, Menüpositionen (Header, Mobile, Footer). |
| `modules/branding.php` → `branding.php` | Textlogo-Option, Bildlogo, responsives Verhalten, Positionierung, favicon-Erweiterung. |
| `modules/layout.php` → `layout.php` | Containerbreiten, Abstände, responsives Verhalten – steuerbar nach Breakpoint. Erweiterung für grid-basierte Layouts geplant. |
| `modules/styles.php` → `styles.php` + `utils/colors.php`, `typography.php` | Farbsteuerung über CSS-Variablen für Light/Dark Mode, inklusive Preview und Customizer Controls. Schriftauswahl & Typografie-Voreinstellungen. |
| `modules/performance.php` | Performance-Tweaks wie Heartbeat-Abschaltung, Lazyload-Optionen. Kompatibel mit externen Plugins. |

### Utility & Loader
| Agent | Zweck |
|-------|-------|
| `inc/customizer/loader.php` | Scannt automatisiert alle Module in `inc/customizer/modules/` und lädt diese bei `customize_register`. Klassenbasiert, mit Fallback-Logging. |
| `inc/customizer/utils/helpers.php` | Enthält zentrale Helferfunktionen: Sanitizer, Default-Werte, gemeinsame Methoden für Controls & Sections. |
| `inc/helpers-html.php` | Formatiert HTML-Attribute konsistent für Template-Parts und Customizer-Ausgaben. |
| `inc/helpers-navigation.php` | Liefert Standard-Argumente für `wp_nav_menu()`, inklusive Fallback-Handling und Attribute für Header-/Footer-Navigationen. |

### Gutenberg
| Agent | Zweck |
|-------|-------|
| `blocks/highlight-box/` | Custom Block: visuell hervorgehobene Box mit Titel, Text, CTA-Link. Integriert Styles und Icons. |
| `blocks/course-teaser/` | Gutenberg-Kursteaser-Block (für Weiterbildungsbereich), JSON-basiert mit dynamischen PHP-Rückgaben und Style-Vererbung. |

---

## Empfehlungen
- **Code-Duplizierung vermeiden**: Social-Bar-Icons, CTA-Markup und Navigation wurden mehrfach implementiert. Diese Elemente sollten zentralisiert werden (z. B. via `template-parts/components/`).
- **Customizer-Vereinheitlichung**: Positionierung (top, center, bottom), Sichtbarkeit, Größe, Farben, Modus (Light/Dark) sollten global steuerbar sein – inkl. Preview via `postMessage`.
- **Dark/Light Mode erweitern**: Mehr Controls, getrennte Farbpaletten für beide Modi, automatischer Modus via `prefers-color-scheme`.
- **Beitragskarten/Loops modularisieren**: Grid/List-Umschaltung via Customizer; responsives Verhalten definieren.
- **Theme.json evaluieren**: Für langfristige Gutenberg-Kompatibilität – Styles, Supports, Presets, Farbdefinitionen, Fonts, etc.
- **Typografie konsolidieren**: Definierte Font Sizes, Line Height, responsive Type Scale über CSS Variablen & Gutenberg Presets.
- **Breakpoint-Mixins verwenden**: Nutze die Helfer aus `src/scss/base/_breakpoints.scss` (`bp.up`, `bp.down`, `bp.only`, `bp.between`) statt manueller `@media`-Queries.
- **Socialbar-Varianten berücksichtigen**: Icon-Stile und Varianten arbeiten über Klassen (`socialbar--*`) und Datenattribute (`data-variant`, `data-icon-style`) für den Customizer. Styles sollten beide Selektoren bedienen.

---

## Status
**Theme-Version:** 0.1.0  
**Stand:** Oktober 2025  
**Modularisierungsgrad:** >90% (Customizer vollständig modularisiert, Blöcke modular, Helper teilweise historisch)

---

## Ziel
Diese `AGENTS.md` ermöglicht es Entwickler:innen, sich schnell in die Beyond-Gotham-Codebasis einzuarbeiten, wiederverwendbare Module gezielt zu finden und neue Features konsistent umzusetzen. Sie dient als zentrale Entwicklungsreferenz für Wartung, Erweiterung und Review-Prozesse.
