# IMPLEMENTATION – Beyond Gotham Website

Diese Anleitung beschreibt Installation, Updates und optionale Demo-Daten des Child-Themes `beyondgotham-dark-child`.

---

## 1. Voraussetzungen

- WordPress 6.x mit aktivem Parent Theme **FreeNews**
- PHP ≥ 8.0, MySQL ≥ 5.7
- SMTP-Anbindung (Plugin wie „WP Mail SMTP“) für zuverlässige Formular-Mails
- Schreibrechte auf `wp-content/uploads` für Uploads (Bildungsgutschein-Dokumente)

---

## 2. Installation / Update

1. **Dateien deployen**
   - Ordner `wordpress/wp-content/themes/beyondgotham-dark-child` auf den Server kopieren (Git/SFTP/CI).

2. **Theme aktivieren**
   - WordPress-Backend → *Design → Themes* → „BeyondGotham Dark (Child)“ aktivieren.

3. **Permalinks setzen**
   - Einstellungen → Permalinks → Struktur `/%postname%/` auswählen → Speichern.

4. **Seiten anlegen**
   - Seite „Landing“ mit Template **Landing Page** erstellen und als Startseite definieren.
   - Seite „Kurse“ mit Template **Kursübersicht** veröffentlichen.

5. **SMTP konfigurieren**
   - SMTP-Plugin installieren/konfigurieren → Testmail versenden, damit Kurs-Anmeldungen zugestellt werden.

> **Update-Hinweis:** Bei Updates alle geänderten Dateien deployen und anschließend Permalinks einmal speichern. Keine Datenbank-Migration notwendig.

---

## 3. Custom Post Types & Taxonomien

Nach Aktivierung stehen folgende Inhalte bereit:

- **Kurse (`bg_course`)** – Kursdetails, Plätze, Start/Ende, Sprache, Standort, Dozent:in.
- **Dozent:innen (`bg_instructor`)** – Bio, Erfahrung, Kontakt.
- **Anmeldungen (`bg_enrollment`)** – werden ausschließlich über das Formular erstellt (nicht öffentlich).
- **Taxonomien** – `bg_course_category` (z. B. OSINT), `bg_course_level` (Beginner/Intermediate/Advanced).

> Nach Änderungen an CPTs/Taxonomien Permalinks speichern.

---

## 4. Demo-Daten (optional, nur DEV)

1. `functions.php` öffnen und die Zeile `// add_action('admin_init', 'bg_seed_demo_courses');` entkommentieren.
2. Als Admin im Backend eine Seite laden (z. B. Dashboard). Dadurch werden:
   - 3 Demo-Kurse,
   - 2 Demo-Dozent:innen,
   - Taxonomien & Beispielwerte angelegt.
3. Hook wieder auskommentieren, damit Daten nur einmal erstellt werden.

---

## 5. Enrollment-Formular testen

1. Kurs-Detailseite aufrufen (`/kurse/...`).
2. Formular `[bg_course_enrollment]` ausfüllen:
   - Pflichtfelder: Vorname, Nachname, E-Mail, DSGVO-Checkbox.
   - Optional: Bildungsgutschein aktivieren, Nummer + Datei (PDF/JPG/PNG) hochladen.
3. Submit → AJAX-Antwort prüfen.
4. Backend → Menü **Anmeldungen**: Eintrag sollte mit Status `confirmed` (Plätze frei) oder `waitlist` (ausgebucht) erscheinen.
5. Admin- und Teilnehmer-E-Mails im Postfach bzw. im SMTP-Log kontrollieren.

**Rate-Limit:** Max. 3 Einsendungen pro IP in 15 Minuten (Transient). Meldung: „Sie haben das Limit …“

---

## 6. Wartung & Sicherheit

- **E-Mails**: SMTP-Logs regelmäßig prüfen, Spam-Ordner überwachen.
- **Uploads**: Bildungsgutschein-Dateien werden in die Mediathek gespeichert; Berechtigungen und Speicherplatz im Auge behalten.
- **Backups**: Regelmäßig Datenbank- und Dateibackups erstellen (mind. täglich in Prod).
- **Updates**: Nach WordPress- oder Plugin-Updates das Formular kurz testen.
- **Monitoring**: Dashboard-Widget „📊 Kurs-Statistiken“ liefert Überblick (Kurse, Anmeldungen, Warteliste).

---

## 7. Fehlerbehebung

| Problem | Lösung |
| --- | --- |
| 404 bei Kursseiten | Permalinks erneut speichern (`/%postname%/`). |
| Formular liefert keine E-Mails | SMTP-Konfiguration prüfen, Testmail versenden, ggf. Cron-Jobs aktivieren. |
| Upload scheitert | Dateiberechtigungen (`wp-content/uploads`) prüfen, Dateitypen (PDF/JPG/PNG) erlaubt? |
| „Sicherheitsprüfung fehlgeschlagen“ | Cache leeren, prüfen ob Nonce-Feld im Formular ausgegeben wird (Shortcode korrekt eingebunden). |
| Rate-Limit greift zu oft | Transient `bg_enrollment_rate_*` im Cache löschen oder Zeitfenster in `enrollment-form.php` anpassen. |

---

## 8. Nächste Schritte (optional)

- WooCommerce-Integration für Bezahlprozesse
- Matomo/Analytics einbinden (DSGVO-konform)
- Übersetzungen via `load_child_theme_textdomain`
- Automatisierte Tests (Playwright/PHPUnit) für Formular-Flow

Viel Erfolg mit Beyond Gotham! Bei Fragen: `kontakt@beyond-gotham.org`.
