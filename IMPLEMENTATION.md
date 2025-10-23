# 🚀 Beyond_Gotham Website - Implementierungsanleitung

**Paket A (Kurssystem) + Paket C (Landing Page)** erfolgreich erstellt!

---

## 📦 Was wurde erstellt?

### 1. **Kurssystem (Custom Post Types)**
```
wordpress/wp-content/themes/beyondgotham-dark-child/
├── inc/
│   ├── custom-post-types.php      # CPTs: Kurse, Dozenten, Anmeldungen
│   └── enrollment-form.php         # Anmeldeformular + AJAX Handler
├── page-courses.php                # Kursübersichtsseite
├── single-bg_course.php            # Einzelkurs-Detailseite
└── functions.php                   # Hauptfunktionen + Dashboard Widget
```

### 2. **Landing Page**
```
wordpress/wp-content/themes/beyondgotham-dark-child/
└── page-landing.php                # Hero + Features + Testimonials + CTA
```

---

## 🔧 Installation

### Schritt 1: Dateien hochladen
1. Alle Dateien via SFTP nach `/wordpress/wp-content/themes/beyondgotham-dark-child/` hochladen
2. Ordnerstruktur muss so aussehen:
   ```
   beyondgotham-dark-child/
   ├── inc/
   │   ├── custom-post-types.php
   │   └── enrollment-form.php
   ├── functions.php
   ├── style.css
   ├── page-landing.php
   ├── page-courses.php
   └── single-bg_course.php
   ```

### Schritt 2: WordPress aktivieren
1. Im WordPress Admin: **Design → Themes**
2. **"BeyondGotham Dark (Child)"** aktivieren
3. Seite neu laden

### Schritt 3: Kategorien erstellen (einmalig)
1. **functions.php** öffnen
2. Kommentar-Zeichen `//` entfernen vor `add_action('init', function(){...` (Zeile 76-95)
3. WordPress-Frontend einmal aufrufen (irgendeine Seite)
4. Kommentar-Zeichen `//` wieder hinzufügen
5. Fertig! Kategorien sind jetzt angelegt:
   - **Kurs-Kategorien:** OSINT & Forensik, Investigativer Journalismus, IT & Linux, Rettungsdienst
   - **Kurs-Level:** Anfänger, Fortgeschritten, Experte

### Schritt 4: Seiten erstellen

#### A) Landing Page
1. **Seiten → Neu hinzufügen**
2. Titel: "Home" oder "Start"
3. **Rechts im Panel:** Template → "Landing Page (Hero)"
4. Veröffentlichen
5. **Einstellungen → Lesen:** Als Startseite festlegen

#### B) Kursübersicht
1. **Seiten → Neu hinzufügen**
2. Titel: "Kurse"
3. **Template:** "Kursübersicht"
4. Veröffentlichen
5. URL wird: `https://beyond-gotham.com/kurse/`

---

## 📚 Nutzung

### Kurs erstellen
1. **Dashboard → Kurse → Neuer Kurs**
2. Titel + Beschreibung eingeben
3. **Rechts im Panel:**
   - Kategorie wählen (z.B. "OSINT & Forensik")
   - Level wählen (z.B. "Fortgeschritten")
   - Beitragsbild hochladen
4. **Kurs-Details Meta Box** ausfüllen:
   - Dauer: 8 (Wochen)
   - Preis: 4500.00
   - Startdatum: 2025-06-01
   - Max. Teilnehmer: 12
   - ✅ Bildungsgutschein aktivieren
   - AZAV-ID: BG-OSINT-01
   - Dozent:in auswählen
5. **Veröffentlichen**

### Dozent:in erstellen
1. **Dashboard → Dozenten → Neue:r Dozent:in**
2. Name als Titel
3. Biografie im Hauptfeld
4. Profilbild hochladen
5. **Dozenten-Details:**
   - Qualifikation: "LPIC-2, OSINT-Zertifikat"
   - Erfahrung: 10 (Jahre)
   - E-Mail
   - LinkedIn-URL
6. **Veröffentlichen**

### Anmeldungen verwalten
1. **Dashboard → Anmeldungen**
2. Liste aller Kursanmeldungen
3. Klick auf Anmeldung → Details ansehen
4. Status ändern:
   - `pending` → Prüfung läuft
   - `confirmed` → Bestätigt
   - `waitlist` → Warteliste
   - `cancelled` → Storniert

### Dashboard Widget
Im WordPress-Dashboard erscheint automatisch ein Widget:
- **Aktive Kurse** (Anzahl)
- **Anmeldungen** (Gesamt)
- **Offene Anmeldungen** (Status: pending)
- **Dozenten** (Anzahl)

---

## 🎨 Customizing

### Farben anpassen
In `style.css` (Zeile 11-20):
```css
:root{
  --bg:#0f1115;       /* Haupt-Hintergrund */
  --bg-2:#141924;     /* Panels / Header */
  --bg-3:#0b0e14;     /* Tiefer Hintergrund */
  --fg:#e7eaee;       /* Text hell */
  --muted:#a9b0bb;    /* Sekundärtext */
  --line:#1c212b;     /* Linien/Border */
  --accent:#33d1ff;   /* Beyond_Gotham Akzent */
  --accent-2:#1aa5d1; /* Hover */
}
```

### Testimonials ändern
In `page-landing.php` (Zeile 248-268):
```php
$testimonials = [
    [
        'name' => 'Dein Name',
        'role' => 'Position',
        'text' => 'Zitat...',
        'rating' => 5,
    ],
    // Weitere hinzufügen...
];
```

### Features ändern
In `page-landing.php` (Zeile 200-227):
```php
$features = [
    [
        'icon' => '🔍',
        'title' => 'Dein Feature',
        'desc' => 'Beschreibung...',
    ],
    // Weitere hinzufügen...
];
```

---

## 🔌 Shortcodes

### Anmeldeformular einbinden
In jeden Beitrag/Seite:
```
[bg_course_enrollment course_id="123"]
```
→ Zeigt Anmeldeformular für Kurs-ID 123

**Automatisch eingebunden:**
- Auf Kurs-Detailseiten (single-bg_course.php)
- Scrollt automatisch zum Formular bei Klick auf "Jetzt anmelden"

---

## 📧 E-Mail Benachrichtigungen

### Bei Anmeldung werden automatisch verschickt:
1. **An Teilnehmer:**
   - Bestätigung mit Kursdaten
   - Wartelisten-Info (falls voll)
   - Kontaktdaten für Rückfragen

2. **An Admin:**
   - Neue Anmeldung mit Details
   - Link zur Bearbeitung
   - Status-Info (pending/waitlist)

### E-Mail-Absender ändern
In `inc/enrollment-form.php` (Zeile 242 + 260):
```php
wp_mail($email, $subject, $message, [
    'From: Beyond_Gotham <noreply@beyond-gotham.org>'
]);
```

---

## 🔍 Testing

### Testdaten erstellen
1. Einen Kurs anlegen (siehe oben)
2. Einen Dozenten anlegen
3. Dozent dem Kurs zuweisen
4. Frontend aufrufen: `/kurse/`
5. Kurs anklicken
6. Testanmeldung ausfüllen
7. Im Admin prüfen: **Anmeldungen**

### AJAX-Test
1. Formular ausfüllen
2. "Jetzt anmelden" klicken
3. **Erwartet:**
   - Ladeanimation ("Wird gesendet...")
   - Erfolgsmeldung (grün)
   - E-Mail an Admin + Teilnehmer
   - Formular wird geleert

---

## ⚙️ Technische Details

### AJAX-Handler
- **Endpoint:** `wp-admin/admin-ajax.php`
- **Action:** `bg_submit_enrollment`
- **Nonce:** `bg_enrollment_nonce`
- **Response:** JSON

### Custom Post Type Slugs
- Kurse: `/kurse/kursname/`
- Dozenten: `/dozenten/name/`
- Anmeldungen: **intern** (nicht öffentlich)

### Taxonomien
- `course_category` → Kurs-Kategorien
- `course_level` → Schwierigkeitsgrad

### Meta Fields (Kurse)
- `_bg_duration` → Dauer in Wochen
- `_bg_price` → Preis in Euro
- `_bg_start_date` → Startdatum (YYYY-MM-DD)
- `_bg_end_date` → Enddatum
- `_bg_max_participants` → Max. Teilnehmer
- `_bg_bildungsgutschein` → Förderfähig (1/0)
- `_bg_azav_id` → AZAV-Kennung
- `_bg_instructor_id` → Dozent:in (Post-ID)

### Meta Fields (Anmeldungen)
- `_bg_course_id` → Kurs-ID
- `_bg_first_name` → Vorname
- `_bg_last_name` → Nachname
- `_bg_email` → E-Mail
- `_bg_phone` → Telefon
- `_bg_motivation` → Motivation
- `_bg_has_bildungsgutschein` → Hat BG (1/0)
- `_bg_gutschein_number` → Gutschein-Nr.
- `_bg_gutschein_agency` → Ausstellende Agentur
- `_bg_status` → Status (pending/confirmed/waitlist/cancelled)
- `_bg_submission_date` → Anmeldedatum

---

## 🐛 Troubleshooting

### Problem: "Fatal error: require_once()"
**Lösung:** Prüfe, ob `inc/` Ordner existiert und beide Dateien darin liegen

### Problem: Kursseite zeigt 404
**Lösung:**
1. **Einstellungen → Permalinks**
2. Einfach speichern (ohne Änderung)
3. Seite neu laden

### Problem: AJAX-Formular funktioniert nicht
**Lösung:**
1. Browser-Konsole öffnen (F12)
2. Fehlermeldungen prüfen
3. jQuery aktiviert? (sollte automatisch sein)

### Problem: E-Mails kommen nicht an
**Lösung:**
1. WordPress-SMTP Plugin installieren (z.B. "WP Mail SMTP")
2. SMTP-Server konfigurieren
3. Test-Mail senden

### Problem: Dashboard-Widget fehlt
**Lösung:**
1. Seite neu laden
2. **Ansicht anpassen** (oben rechts)
3. Widget aktivieren

---

## 🚀 Nächste Schritte

### Empfohlene Erweiterungen:
1. **Warenkorbsystem** → WooCommerce Integration
2. **Zahlungen** → Stripe/PayPal
3. **Kalender** → Events Manager Plugin
4. **Newsletter** → Mailchimp Integration
5. **Analytics** → Matomo/GA4
6. **SEO** → Yoast SEO Plugin

### Optional:
- Mitgliederbereich (Kursfortschritt)
- Online-Prüfungen (Quiz-Plugin)
- Zertifikats-Generator
- Alumni-Netzwerk

---

## 📞 Support

Bei Fragen oder Problemen:
- **E-Mail:** kontakt@beyond-gotham.org
- **Dokumentation:** Diese Datei
- **Code-Review:** Alle Dateien sind kommentiert

---

**🎉 Viel Erfolg mit der neuen Website!**
