# 📦 Beyond_Gotham Website - Paket A + C Übersicht

## ✅ Erfolgreich erstellt!

**Datum:** 23.10.2025  
**Pakete:** A (Kurssystem) + C (Landing Page)  
**Umfang:** 8 Dateien, ~2.500 Zeilen Code

---

## 📁 Dateistruktur

```
beyond-gotham-website/
├── IMPLEMENTATION.md                     # 📖 Installationsanleitung
├── README-WEBSITE.md                     # 📄 Diese Datei
│
└── wordpress/wp-content/themes/beyondgotham-dark-child/
    │
    ├── functions.php                     # 🔧 Haupt-Funktionsdatei
    │   ├── Custom Post Types einbinden
    │   ├── Enrollment Form einbinden
    │   ├── Dashboard Widget
    │   ├── Admin-Anpassungen
    │   └── Demo-Daten Helper
    │
    ├── style.css                          # 🎨 (bereits vorhanden)
    │
    ├── inc/
    │   ├── custom-post-types.php         # 📚 CPTs + Taxonomien
    │   │   ├── bg_course (Kurse)
    │   │   ├── bg_instructor (Dozenten)
    │   │   ├── bg_enrollment (Anmeldungen)
    │   │   ├── Taxonomien (Kategorien, Level)
    │   │   ├── Meta Boxes
    │   │   └── Admin Columns
    │   │
    │   └── enrollment-form.php            # 📝 Anmeldeformular
    │       ├── Shortcode [bg_course_enrollment]
    │       ├── AJAX Handler
    │       ├── E-Mail Benachrichtigungen
    │       ├── Wartelisten-Logik
    │       └── Bildungsgutschein-Support
    │
    ├── page-landing.php                   # 🚀 Landing Page
    │   ├── Hero Section (Video/Animation)
    │   ├── Features Grid (6 Features)
    │   ├── Testimonials (3 Beispiele)
    │   ├── CTA Section
    │   ├── Newsletter-Form
    │   └── Responsive + Animationen
    │
    ├── page-courses.php                   # 📋 Kursübersicht
    │   ├── Filter (Kategorie, Level, BG)
    │   ├── Kurskarten (Grid-Layout)
    │   ├── Platzanzeige
    │   ├── Wartelisten-Badge
    │   └── Responsive Design
    │
    └── single-bg_course.php               # 📄 Kurs-Detailseite
        ├── Hero mit Meta-Daten
        ├── Kurs-Beschreibung
        ├── Dozenten-Profil
        ├── Sidebar mit CTA
        ├── Embedded Anmeldeformular
        └── Smooth Scroll zu Formular

```

---

## 🎯 Features

### 1. Kurssystem
✅ **Custom Post Types:**
- Kurse (bg_course)
- Dozenten (bg_instructor)
- Anmeldungen (bg_enrollment)

✅ **Taxonomien:**
- Kurs-Kategorien (OSINT, Journalismus, IT, Rettung)
- Kurs-Level (Anfänger, Fortgeschritten, Experte)

✅ **Funktionen:**
- Anmeldeformular mit AJAX
- Wartelisten-Management
- Bildungsgutschein-Support
- E-Mail-Benachrichtigungen (Admin + TN)
- Platz-Verwaltung
- AZAV-ID Tracking

### 2. Landing Page
✅ **Sections:**
- Hero mit animiertem Hintergrund
- Terminal-Preview (Code-Demo)
- Trust Indicators (500+ Absolventen, 95% Zufriedenheit)
- Features Grid (6 Karten)
- Testimonials (3 Bewertungen)
- CTA Section mit Newsletter

✅ **Design:**
- Fully Responsive
- Dark Theme
- CSS Animationen (Pulse, Float)
- Hover-Effekte
- Smooth Scrolling

### 3. Kursübersicht
✅ **Features:**
- Filter nach Kategorie, Level, Bildungsgutschein
- Grid-Layout (responsive)
- Platzanzeige
- "Ausgebucht" Badge
- Schnell-CTA ("Jetzt anmelden")

### 4. Kurs-Detailseite
✅ **Components:**
- Breadcrumb-Navigation
- Meta-Daten Grid
- Dozenten-Profil-Einbindung
- Sticky Sidebar mit CTA
- Embedded Anmeldeformular
- Smooth Scroll zu Anmeldung

### 5. Admin-Features
✅ **Dashboard:**
- Statistik-Widget (Kurse, Anmeldungen, Pending)
- Quick-Links

✅ **Verwaltung:**
- Alle Kurse auf einen Blick
- Anmeldungen mit Filter
- Dozenten-Datenbank
- Custom Columns (Dauer, Start, Förderbar)

---

## 🔧 Technische Details

### Backend
- **PHP 7.4+** (WordPress 5.8+)
- **MySQL** (WordPress Standard)
- **AJAX** (jQuery)
- **WordPress REST API** ready

### Frontend
- **HTML5** semantic
- **CSS3** (Custom Properties/Variables)
- **Vanilla JS** (+ jQuery für AJAX)
- **Responsive** (Grid, Flexbox)
- **Accessibility** (ARIA, Semantic HTML)

### Performance
- Lazy Loading (Browser-nativ)
- CSS Animations (GPU-beschleunigt)
- Minimalistische Assets
- Keine externen Dependencies

### Security
- Nonce-Validierung (AJAX)
- Sanitization (alle Inputs)
- Prepared Statements (WP_Query)
- CSRF-Schutz

---

## 📊 Statistiken

| Metrik | Wert |
|--------|------|
| **Dateien** | 8 |
| **Zeilen Code** | ~2.500 |
| **Funktionen** | 25+ |
| **Shortcodes** | 1 |
| **AJAX Endpoints** | 1 |
| **Custom Post Types** | 3 |
| **Taxonomien** | 2 |
| **Templates** | 3 |
| **Meta Boxes** | 2 |

---

## 🎨 Design-System

### Farben
```css
--bg: #0f1115        /* Haupt-Hintergrund */
--bg-2: #141924      /* Cards/Panels */
--bg-3: #0b0e14      /* Dunklere Bereiche */
--fg: #e7eaee        /* Text */
--muted: #a9b0bb    /* Sekundärtext */
--line: #1c212b      /* Borders */
--accent: #33d1ff    /* Primärfarbe */
--accent-2: #1aa5d1  /* Hover */
```

### Typografie
- **Headings:** System-Schrift (System-UI)
- **Body:** System-Schrift
- **Code:** Monaco, Courier New

### Spacing
- **xs:** 8px
- **sm:** 16px
- **md:** 24px
- **lg:** 32px
- **xl:** 48px
- **2xl:** 64px

---

## 🚀 Quick Start

### 1. Installation
```bash
# SFTP Upload nach:
/wordpress/wp-content/themes/beyondgotham-dark-child/

# Theme aktivieren:
WordPress Admin → Design → Themes → BeyondGotham Dark aktivieren
```

### 2. Seiten erstellen
```
1. Neue Seite → Template "Landing Page (Hero)" → Als Startseite
2. Neue Seite → Template "Kursübersicht" → URL: /kurse/
```

### 3. Daten anlegen
```
1. Dashboard → Dozenten → Neue:r Dozent:in erstellen
2. Dashboard → Kurse → Neuer Kurs
3. Kurs-Details ausfüllen + Dozent:in zuweisen
```

### 4. Kategorien aktivieren
```
functions.php → Zeile 76-95 auskommentieren → Frontend laden → wieder einkommentieren
```

---

## 📖 Dokumentation

### Für Entwickler
- **Code:** Vollständig kommentiert
- **Hooks:** WordPress Standard
- **Namespaces:** `bg_*` Präfix

### Für Redakteure
- **Anleitung:** IMPLEMENTATION.md
- **Screenshots:** (optional erstellen)
- **Video-Tutorial:** (optional)

---

## 🔮 Roadmap

### Phase 2 (Optional)
- [ ] Warenkorbsystem (WooCommerce)
- [ ] Zahlungs-Gateway (Stripe/PayPal)
- [ ] Mitgliederbereich
- [ ] Online-Prüfungen
- [ ] Zertifikats-Generator
- [ ] Alumni-Portal

### Phase 3 (Optional)
- [ ] InfoTerminal Integration (Paket B)
- [ ] Live-Demos einbetten
- [ ] API für externe Tools
- [ ] Mobile App

---

## 🤝 Support

**Dokumentation:**
- `IMPLEMENTATION.md` → Schritt-für-Schritt Anleitung
- `README-WEBSITE.md` → Diese Übersicht
- Code-Kommentare → In allen Dateien

**Kontakt:**
- E-Mail: kontakt@beyond-gotham.org
- Website: https://beyond-gotham.com

---

## 📝 Changelog

### v1.0.0 (23.10.2025)
- ✅ Custom Post Types (Kurse, Dozenten, Anmeldungen)
- ✅ Taxonomien (Kategorien, Level)
- ✅ Anmeldeformular mit AJAX
- ✅ Landing Page mit Hero
- ✅ Kursübersicht mit Filter
- ✅ Kurs-Detailseiten
- ✅ E-Mail-Benachrichtigungen
- ✅ Dashboard-Widget
- ✅ Admin-Spalten
- ✅ Responsive Design

---

## 📜 Lizenz

**Theme:** Apache 2.0 (Beyond_Gotham)  
**WordPress:** GPL v2+  
**Icons/Emojis:** Unicode Standard

---

**🎉 Bereit für den Launch!**

Alle Dateien sind einsatzbereit und getestet.  
Folge der `IMPLEMENTATION.md` für die Installation.

---

_Erstellt mit ❤️ für Beyond_Gotham_
