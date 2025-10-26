# AGENTS.md

## Zweck
Diese Datei dokumentiert die modularen Komponenten ("Agents") des WordPress-Themes **Beyond Gotham**. Sie dient als technische Übersicht für Entwickler:innen, die das Theme erweitern, warten oder refaktorisieren wollen. Jeder Agent ist für eine klar definierte Teilverantwortung zuständig, insbesondere im Bereich des Customizers, der Gutenberg-Kompatibilität, der Theme-Konfiguration und -Funktionalität.

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
| `functions.php` | Globales Setup: Theme-Supports, Menü-Registrierung, Hooks, globale Hilfsfunktionen, WooCommerce-Kompatibilität, Asset-Loading |
| `inc/post-meta.php` | Zentrale Verwaltung und Ausgabe von Beitragsmetadaten; liefert Struktur für Customizer-Modul „Post Meta“ |
| `inc/custom-post-types.php` | Registrierung von CPTs (Kurse, Dozent:innen, Anmeldungen) und Taxonomien; Definition von Meta-Feldern |
| `inc/enrollment-form.php` | AJAX-Anmeldeformular + Validierung + E-Mail-Versand (Shortcode-basiert) |
| `inc/rest-api.php` | Erweiterung der WP REST API (z.B. mit Custom Feldern) |
| `inc/blocks.php` | Registrierung eigener Gutenberg-Blöcke (block.json basiert)

### Customizer Modules (geladen über `inc/customizer/loader.php`)
| Agent | Zweck |
|-------|-------|
| `modules/cta.php` → `cta.php` | CTA-Boxen (Standard + Sticky); Text, Link, Sichtbarkeit, Layout |
| `modules/footer.php` → `footer.php` | Footer-Claim, Social-Icons im Footer |
| `modules/social.php` → `social.php` | Social-Profile-URLs + Sichtbarkeiten (Header, Footer, mobil) |
| `modules/social-sharing.php` → `social-sharing.php` | Teilen-Buttons unter Inhalten: Netzwerke + Kontextsteuerung |
| `modules/post-meta.php` → `post-meta.php` | Sichtbarkeit / Reihenfolge / Inhalt von Beitragsmetadaten (Autor, Tags etc.) |
| `modules/navigation.php` → `navigation.php` | Sichtbarkeit von Menüs, Sticky Header, Ausrichtung & Abstand der Navigation |
| `modules/branding.php` → `branding.php` | Textlogo statt Grafik, Zusatzfavicon-Einstellungen |
| `modules/layout.php` → `layout.php` | Max. Seitenbreite, Container-Abstände (in Arbeit/erweiterbar) |
| `modules/styles.php` → `styles.php` + `utils/colors.php`, `typography.php` | Farbschema & Typografie via CSS-Variablen; Light/Dark-Mode-basierte Präfixe |
| `modules/performance.php` | Heartbeat, Lazyload etc. – Performance-Optimierung mit Plugin-Kompatibilität |

### Utility & Loader
| Agent | Zweck |
|-------|-------|
| `inc/customizer/loader.php` | Klassenbasierter Customizer-Loader: Scannt `modules/`, lädt sie und ruft deren `register()`-Methode beim Hook `customize_register` auf |
| `inc/customizer/utils/helpers.php` | Sanitizer, Defaults, Helper für alle Module |

### Gutenberg
| Agent | Zweck |
|-------|-------|
| `blocks/highlight-box/` | Eigenes Gutenberg-Blockmodul (Teaser-Box mit CTA); definiert in `block.json` |
| `blocks/course-teaser/` | Gutenberg-Block für Kursteaser; JSON-basiert + eigene Assets |

---

## Empfehlungen
- **Keine parallele Einbindung**: Nur noch Loader-basiertes Laden der Customizer-Module verwenden, `customizer.php` ist veraltet.
- **Präfixe vereinheitlichen**: Alle Funktionen sollten mit `beyond_gotham_` beginnen.
- **Customizer erweitern**: Module für SEO, Block-Styling, Kommentar-Steuerung könnten folgen.
- **Redundanzen prüfen**: Social-Menü vs. Customizer-Links; CTA-HTML mehrfach vorhanden – vereinheitlichen.
- **Theme.json perspektivisch prüfen**: Für volle Block-Editor-Kompatibilität langfristig sinnvoll.

---

## Status
**Theme-Version:** 0.1.0  
**Stand:** Oktober 2025  
**Modularisierungsgrad:** >90% (Customizer vollständig modularisiert, Blöcke modular, einige Helper historisch gewachsen)

---

## Ziel
Diese AGENTS.md ermöglicht es Entwickler:innen, sich schnell in die Beyond-Gotham-Codebasis einzuarbeiten und gezielt bestehende Module zu erweitern oder neue hinzuzufügen – immer im Sinne eines modularen, gut konfigurierbaren und wartbaren WordPress-Themes.
