# WordPress Theme Customizer - Modularisierung

## ✅ Abgeschlossen

Die monolithische Datei `wordpress/wp-content/themes/beyond-gotham/inc/customizer.php` wurde erfolgreich in 6 spezialisierte Module aufgeteilt:

### 📁 Erstellte Module

```
inc/customizer/
├── cta.php               # Call-to-Action & Sticky CTA
├── footer.php            # Footer-Text, Menü & Social Icons
├── social.php            # Social Media Links & Socialbar
├── social-sharing.php    # Social Sharing Buttons
├── post-meta.php         # Beitragsmetadaten (Autor, Datum, etc.)
└── styles.php            # CSS-Generierung (Farben, Typografie)
```

---

## 📋 Modul-Übersicht

### 1. **cta.php** (Call-to-Action)

**Funktionen:**
- Standard CTA-Box Konfiguration
- Sticky CTA Bar am unteren Bildschirmrand
- Trigger-Optionen (Zeitverzögerung, Scrolltiefe, Element)
- Layout-Einstellungen (Position, Ausrichtung, Größe)
- Mobile Sichtbarkeit

**Customizer Sections:**
- `beyond_gotham_cta` - Standard CTA
- `beyond_gotham_cta_sticky` - Sticky CTA Bar

**Hauptfunktionen:**
- `beyond_gotham_get_cta_defaults()`
- `beyond_gotham_get_cta_layout_settings()`
- `beyond_gotham_get_sticky_cta_settings()`
- `beyond_gotham_register_cta_customizer()`

---

### 2. **footer.php** (Footer-Einstellungen)

**Funktionen:**
- Footer-Text mit HTML-Unterstützung
- Social Icons Sichtbarkeit im Footer
- Footer-Menü Location Control

**Customizer Section:**
- `beyond_gotham_footer`

**Hauptfunktionen:**
- `beyond_gotham_get_footer_text()`
- `beyond_gotham_get_footer_social_visibility()`
- `beyond_gotham_register_footer_customizer()`

---

### 3. **social.php** (Social Media)

**Funktionen:**
- Verwaltung aller Social Media URLs
- Socialbar Display-Optionen (Header, Mobile, Footer)
- Social Icon SVGs
- Automatische Netzwerk-Erkennung

**Netzwerke:**
- GitHub, LinkedIn, Mastodon, X/Twitter
- Facebook, Instagram, TikTok, YouTube
- Telegram, E-Mail

**Customizer Section:**
- `beyond_gotham_social_media`

**Hauptfunktionen:**
- `beyond_gotham_get_social_links()`
- `beyond_gotham_get_socialbar_settings()`
- `beyond_gotham_render_socialbar()`
- `beyond_gotham_register_social_customizer()`

**Action Hooks:**
- `wp_footer` - Mobile Socialbar Output

---

### 4. **social-sharing.php** (Social Sharing)

**Funktionen:**
- Share-Buttons für Posts, Pages, Kategorien
- Netzwerk-Auswahl (LinkedIn, Twitter, Facebook, etc.)
- Context-basierte Anzeige-Kontrolle

**Customizer Section:**
- `beyond_gotham_social_sharing`

**Hauptfunktionen:**
- `beyond_gotham_get_social_share_settings()`
- `beyond_gotham_is_social_sharing_enabled_for()`
- `beyond_gotham_build_social_share_links()`
- `beyond_gotham_register_social_sharing_customizer()`

---

### 5. **post-meta.php** (Beitragsmetadaten)

**Funktionen:**
- Konfigurierbare Post-Meta für Posts, Pages, Kurse
- Desktop/Mobile Sichtbarkeit pro Feld
- Sortier-Priorität
- Unterstützte Felder: Datum, Autor, Kategorien, Tags

**Customizer Section:**
- `post_meta_settings`

**Hauptfunktionen:**
- `beyond_gotham_get_post_meta_fields()`
- `beyond_gotham_get_post_meta_settings()`
- `beyond_gotham_register_post_meta_customizer()`

> **Wichtig:** Die Felddefinitionen leben zentral in `inc/post-meta.php`. Erweiterungen erfolgen über den Filter
> `beyond_gotham_post_meta_fields` – keine Helper-Funktionen im Customizer duplizieren.

---

### 6. **styles.php** (CSS-Generierung)

**Funktionen:**
- CSS-Variablen für Light/Dark Mode
- Typografie-Einstellungen
- Layout-CSS (Content Width, Spacing)
- Automatische Inline-Style-Injection

**Hauptfunktionen:**
- `beyond_gotham_get_customizer_css()`
- `beyond_gotham_build_mode_selector_list()`
- `beyond_gotham_print_customizer_styles()`

**Action Hooks:**
- `wp_enqueue_scripts` - CSS-Ausgabe

---

## 🔧 Integration

### Schritt 1: Verzeichnisstruktur erstellen

```bash
mkdir -p wordpress/wp-content/themes/beyond-gotham/inc/customizer
```

### Schritt 2: Module kopieren

Kopiere alle 6 `.php`-Dateien in das neue Verzeichnis:

```
inc/customizer/
├── cta.php
├── footer.php
├── social.php
├── social-sharing.php
├── post-meta.php
└── styles.php
```

### Schritt 3: Hauptdatei modifizieren

In `inc/customizer.php` die monolithischen Funktionen durch Module-Includes ersetzen:

```php
<?php
/**
 * Theme Customizer enhancements for Beyond Gotham.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// Core Customizer Functions (Typography, Sanitization, etc.)
// ... [Behalte nur die Core-Funktionen hier] ...

// Load Modularized Components
require get_template_directory() . '/inc/customizer/cta.php';
require get_template_directory() . '/inc/customizer/footer.php';
require get_template_directory() . '/inc/customizer/social.php';
require get_template_directory() . '/inc/customizer/social-sharing.php';
if ( ! defined( 'BEYOND_GOTHAM_POST_META_LOADED' ) ) {
    require get_template_directory() . '/inc/customizer/post-meta.php';
}
require get_template_directory() . '/inc/customizer/styles.php';
```

### Schritt 4: Sanitization-Funktionen

Diese Funktionen werden von mehreren Modulen benötigt und sollten in der Haupt-`customizer.php` verbleiben:

```php
// Required Sanitization Functions
function beyond_gotham_sanitize_checkbox( $value ) { ... }
function beyond_gotham_sanitize_optional_url( $value ) { ... }
function beyond_gotham_sanitize_optional_email( $value ) { ... }
function beyond_gotham_sanitize_css_selector( $value ) { ... }
function beyond_gotham_sanitize_css_length( $value ) { ... }
function beyond_gotham_sanitize_positive_float( $value ) { ... }
function beyond_gotham_sanitize_dimension_unit( $value ) { ... }
function beyond_gotham_format_css_size( $value, $unit = 'px' ) { ... }
function beyond_gotham_format_px_value( $value, $allow_zero = true ) { ... }
function beyond_gotham_sanitize_post_id_list( $value ) { ... }
```

---

## ⚠️ Wichtige Hinweise

### Abhängigkeiten

Alle Module benötigen diese Core-Funktionen in `customizer.php`:
- `beyond_gotham_sanitize_checkbox()`
- `beyond_gotham_sanitize_optional_url()`
- `beyond_gotham_sanitize_optional_email()`
- `beyond_gotham_sanitize_css_selector()`
- `beyond_gotham_sanitize_positive_float()`

### Custom Control Classes

Falls vorhanden, müssen diese Klassen vor den Modulen geladen werden:
- `Beyond_Gotham_Customize_Heading_Control`

### Hooks

Die Module registrieren sich automatisch über diese Hooks:
- `customize_register` - Alle Module außer styles.php
- `wp_enqueue_scripts` - styles.php für CSS-Ausgabe
- `wp_footer` - social.php für Mobile Socialbar

---

## 🎯 Vorteile der Modularisierung

### ✅ Wartbarkeit
- Jedes Modul hat eine klare Verantwortlichkeit
- Änderungen isoliert auf betroffene Bereiche
- Einfacheres Debugging

### ✅ Übersichtlichkeit
- Reduzierte Dateigröße pro Modul (ca. 200-400 Zeilen)
- Logische Gruppierung verwandter Funktionen
- Bessere Code-Navigation

### ✅ Erweiterbarkeit
- Neue Features können als separate Module hinzugefügt werden
- Keine Konflikte mit bestehenden Modulen
- Einfaches Aktivieren/Deaktivieren von Features

### ✅ Performance
- Keine Änderung der Laufzeit-Performance
- Gleiche Funktionalität wie zuvor
- Lazy Loading möglich (falls gewünscht)

---

## 📊 Code-Statistik

| Datei | Zeilen | Funktionen | Hooks |
|-------|--------|------------|-------|
| **cta.php** | ~420 | 12 | 1 |
| **footer.php** | ~120 | 3 | 1 |
| **social.php** | ~380 | 7 | 2 |
| **social-sharing.php** | ~280 | 5 | 1 |
| **post-meta.php** | ~260 | 6 | 1 |
| **styles.php** | ~240 | 4 | 1 |
| **Gesamt** | ~1700 | 37 | 7 |

---

## 🧪 Testing-Checkliste

Nach der Integration sollten folgende Bereiche getestet werden:

### Customizer
- [ ] Alle Sections sind sichtbar
- [ ] Controls funktionieren korrekt
- [ ] Live Preview (postMessage) funktioniert
- [ ] Einstellungen werden gespeichert

### CTA
- [ ] Standard CTA wird angezeigt
- [ ] Sticky CTA erscheint nach Trigger
- [ ] Mobile Sichtbarkeit funktioniert
- [ ] Layout-Optionen wirken sich aus

### Footer
- [ ] Footer-Text wird ausgegeben
- [ ] Footer-Menü funktioniert
- [ ] Social Icons werden angezeigt

### Social Media
- [ ] Socialbar im Header (wenn aktiviert)
- [ ] Mobile Socialbar am unteren Rand
- [ ] Alle Icons werden korrekt dargestellt
- [ ] Links öffnen in neuem Tab

### Social Sharing
- [ ] Share-Buttons auf Posts
- [ ] Context-basierte Anzeige
- [ ] Share-URLs korrekt generiert

### Post Meta
- [ ] Metadaten auf Posts sichtbar
- [ ] Desktop/Mobile Visibility funktioniert
- [ ] Sortierung entsprechend Priorität

### Styles
- [ ] Light Mode Farben
- [ ] Dark Mode Farben
- [ ] Typografie wird angewendet
- [ ] Layout-CSS funktioniert

---

## 🔄 Migration von der monolithischen Datei

### Backup erstellen
```bash
cp inc/customizer.php inc/customizer.php.backup
```

### Schritt-für-Schritt

1. **Core-Funktionen identifizieren** (Typography, Sanitization)
2. **Module-Includes hinzufügen** am Ende der Datei
3. **Redundanten Code entfernen** aus customizer.php
4. **Testing durchführen** (siehe Checkliste oben)
5. **Backup löschen** wenn alles funktioniert

---

## 📚 Weitere Dokumentation

### Namenskonventionen
- Funktionspräfix: `beyond_gotham_`
- Setting-IDs: `beyond_gotham_{component}_{setting}`
- Section-IDs: `beyond_gotham_{component}`

### Filter & Hooks
Jedes Modul bietet Filter für Erweiterungen:
- `beyond_gotham_cta_defaults`
- `beyond_gotham_social_links`
- `beyond_gotham_social_share_settings`
- `beyond_gotham_post_meta_fields`
- `beyond_gotham_customizer_css`

---

## 👥 Support & Weiterentwicklung

Bei Fragen oder Problemen:
1. Prüfe die Fehlermeldungen im Debug-Log
2. Überprüfe ob alle Abhängigkeiten vorhanden sind
3. Teste mit deaktiverten Plugins (falls Theme-Issue)

**Letzte Aktualisierung:** 2025-10-24
**Theme-Version:** Beyond Gotham 1.0
**WordPress-Version:** 6.4+
