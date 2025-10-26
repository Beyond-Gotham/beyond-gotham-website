Ausgangslage (Ist-Zustand)

Beyond Gotham Website nutzt aktuell WordPress 6.x mit dem kommerziellen Theme FreeNews als Parent und einem eigenen Child-Theme beyondgotham-dark-child
GitHub
. Das Child-Theme (entwickelt für PHP 8 mit modernem JS/SCSS) erweitert WordPress um zahlreiche projekt-spezifische Funktionen. Es definiert z. B. eigene Custom Post Types – bg_course (Kurse), bg_instructor (Dozent:innen) und bg_enrollment (Kurs-Anmeldungen) – einschließlich zugehöriger Taxonomien (bg_course_category für Kurskategorien wie OSINT, und bg_course_level für Schwierigkeitsgrade)
GitHub
. Spezial-Templates existieren für die Landingpage (mit Kurs-Programm und Teaser-Sektionen für Nachrichten-Kategorien), eine Kursübersicht (Filter nach Kategorie, Level, Förderung) sowie Kurs-Detailseiten mit Anmeldeformular
GitHub
GitHub
. Weitere Features des Child-Themes sind u. a. Breadcrumb-Navigation, Lazy-Loading von Bildern, Open-Graph Meta-Tags, ein AJAX-gestütztes Kurs-Anmeldeformular ([bg_course_enrollment] Shortcode) zur Erfassung von Anmeldungen inkl. Bestätigungs-Mail und Wartelistenlogik
GitHub
. Insgesamt bildet diese Codebasis ein solides Fundament für Weiterbildungsangebote
GitHub
.

Für den geplanten Relaunch soll Beyond Gotham jedoch zu einer vollwertigen Nachrichten- und Magazin-Website ausgebaut werden – mit investigativen Inhalten (Dossiers, Interviews, OSINT-Reportagen), einer Produktseite zum hauseigenen OSINT-Tool InfoTerminal und einem eigenen Shop. Dazu wird das Theme technisch und visuell neu aufgestellt: Weg vom Child-Theme hin zu einem eigenständigen Theme mit komplett überarbeitetem Design. Bestehende Funktionen (Kurse, Formular etc.) werden übernommen und nahtlos integriert, während neue Bereiche hinzukommen
GitHub
.

Meilenstein 1: Design-Neukonzeption und UX

Designkonzept festlegen: Ein neues visuelles Konzept für Beyond Gotham entwickeln, das modern, übersichtlich und dem Charakter einer hochwertigen investigativen Nachrichtenplattform entspricht. Entscheidung über das generelle Farbschema: das bisherige dunkle Theme vs. ein helles, klassisches News-Design (schwarzer Text auf weißem Hintergrund)
GitHub
. Wichtig ist ein aufgeräumter, moderner Eindruck, der zur Marke Beyond Gotham passt.

Moodboard & Benchmarking: Beispiele anderer News-Seiten und Magazine sammeln (z. B. Zeit Online, Guardian, NY Times)
GitHub
. Analyse, welche Elemente (Typografie, Layout-Raster, Farbgebung) davon für Beyond Gotham relevant sind. Besonderes Augenmerk auf seriöse, gut lesbare Typografie (Kombination aus Serif- und Sans-Serif-Schriften) und strukturierte Layouts mit klar erkennbaren Kategorien/Ressorts.

Styleguide & CI: Basierend auf dem bestehenden Logo/Farbschema einen Styleguide erstellen
GitHub
. Definition der Primär- und Sekundärfarben (z.B. das bisherige Cyan/Türkis als Akzentfarbe beibehalten)
GitHub
, der Schriftfamilien und -größen (Serif für Fließtext, Sans-Serif für UI-Elemente)
GitHub
, Abstände, Button-Styles, Link-Hover-Effekte etc. Hoher Kontrast und gute Lesbarkeit (WCAG-Konformität) müssen gewährleistet sein.

Layout-Entwürfe: Wireframes und danach visuelle Mockups für die wichtigsten Seitentypen erstellen
GitHub
:

Landing Page (Homepage): Überblick über Top-Storys und aktuelle Artikel aus allen Hauptkategorien (Dossiers, Interviews, OSINT, Reportagen), mit einem großen Aufmacher-Beitrag (Hero-Bild + Headline) und darunter Teaser-Blöcken für die Ressorts. Falls das Kursangebot weiterhin beworben wird, kann es als eigene Sektion weiter unten erscheinen
GitHub
 (die bisherige Kurs-Hero-Sektion wird zugunsten eines News-Aufmachers umgebaut).

Kategorie/Ressort-Seiten: Für Bereiche wie Dossiers, Interviews usw. jeweils eine Archiv-Seite, die analog zu Ressort-Seiten einer Zeitung gestaltet ist. Oben der Titel der Kategorie (mit evtl. Beschreibung), darunter eine Liste oder ein Grid von Artikeln dieser Kategorie (mit Vorschaubild, Titel, Auszug)
GitHub
. Wichtige Artikel können hervorgehoben dargestellt werden (z.B. der neueste Dossier-Artikel groß, die restlichen als kleinere Karten).

Artikel-Detailseite: Klassisches Nachrichtenartikel-Layout mit Titel, Untertitel, Autor, Datum, dem Fließtext, eingebetteten Medien (Bilder, Videos) und ggf. Info-Boxen oder weiterführenden Links. Fokus auf sehr gute Lesbarkeit für lange Texte (angenehme Schrift, ausreichender Zeilenabstand, ggf. eine Sidebar für Zusatzinfos)
GitHub
.

InfoTerminal-Produktseite: Seite zur Vorstellung des OSINT-Tools InfoTerminal (siehe Meilenstein 5). Enthält voraussichtlich einen Hero-Bereich, erklärenden Text, Screenshots oder ein eingebettetes Live-Demo-Element, eine Liste der wichtigsten Features und Handlungsaufrufe (CTA) für Demo oder Kauf
GitHub
.

Shop-Seiten: Produktübersichtsseite (Shop-Start) mit Produktlistings sowie Templates für Produkt-Detailseiten, den Warenkorb und den Checkout. Diese sollen optisch zum Rest der Seite passen, obwohl sie von WooCommerce generiert werden (durch Template-Overrides und CSS-Styling)
GitHub
.

Responsives Design: Alle Layouts von Beginn an für verschiedene Bildschirmgrößen konzipieren (Mobile-First)
GitHub
. Auf Smartphones sollten z.B. mehrspaltige Grids in eine einspaltige Liste umschalten, Menüs als Hamburger-Menü dargestellt werden etc. Auch eingebettete Inhalte (wie das InfoTerminal-Dashboard) müssen auf kleinen Screens handhabbar sein – ggf. Umschalten auf einen statischen Hinweis oder Scroll-Möglichkeiten innerhalb des Embeds.

UX-Details & Interaktionen: Geplante interaktive Elemente definieren
GitHub
:

Einen Sticky-Header, der beim Scrollen am Seitenoberrand fixiert bleibt (wurde im alten Theme schon als Option berücksichtigt)
GitHub
.

Sanfte Hover- und Fokus-Effekte für Links und Buttons; ggf. dezente Animationen beim Laden neuer Inhalte (ohne die Nutzer abzulenken).

Komfortfunktionen wie ein Scroll-to-top-Button, Lazy-Loading-Indikatoren, und eine gut auffindbare Suchfunktion.

Abstimmung & Freigabe: Das Designkonzept iterativ mit Stakeholdern abstimmen. Feedback einholen und einarbeiten, bis ein finales Design- und UX-Konzept vorliegt. Dieses dient als Grundlage für die Theme-Implementierung.

Meilenstein 2: Eigenständiges Theme aufsetzen

Neues Theme initiieren: Im Verzeichnis wp-content/themes einen neuen Ordner (z.B. beyond-gotham) anlegen und Basis-Dateien erstellen: eine style.css mit Theme-Header (als Template wird kein Parent mehr angegeben)
GitHub
, eine leere functions.php und ein minimaler index.php als Fallback-Template. Anschließend im WP-Backend das neue Theme aktivieren.

Theme-Supports registrieren: In functions.php die gewünschten Theme-Unterstützungen hinzufügen
GitHub
: z.B. add_theme_support('title-tag'), post-thumbnails (Beitragsbilder), html5 (für Formulare, Kommentare etc.), custom-logo usw., analog zum bisherigen Child-Theme. Menü-Locations definieren (Hauptmenü, Footer-Menü, evtl. Social-Links-Menü)
GitHub
. Eigene Bildgrößen mit add_image_size registrieren (z.B. bg-card, bg-thumb, bg-hero – entsprechend den im alten Theme genutzten Formaten)
GitHub
.

Textdomain & Übersetzungen: Die Textdomain des Themes auf beyond_gotham setzen (vorher: beyondgotham-dark-child) und sicherstellen, dass Sprachdateien (.po/.mo) entsprechend umbenannt/bereitgestellt sind
GitHub
. Dadurch funktionieren Übersetzungsfunktionen (__(), _e() etc.) weiterhin, und vorhandene deutsche Strings können wieder übersetzt geladen werden
GitHub
.

Assets einbinden (CSS/JS): Da kein Parent-Theme mehr existiert, lädt das neue Theme seine eigenen Assets:

Das Styling aus dem Child-Theme (SCSS/CSS) ins neue Theme übernehmen und an das Redesign anpassen. Per wp_enqueue_style('beyondgotham-style', get_stylesheet_directory_uri().'/assets/css/frontend.css', ...) einbinden
GitHub
. Wichtig: Das FreeNews-Parent-CSS wird nicht mehr geladen
GitHub
, daher müssen alle notwendigen Grundstil-Regeln (Typografie, Layout) im neuen CSS enthalten sein (ggf. aus dem Parent-Theme extrahieren und ins eigene Stylesheet übernehmen)
GitHub
.

JavaScript: Die bisherigen Dateien (z.B. frontend.js, ui.js) ins neue Theme kopieren und einbinden
GitHub
. Mit wp_enqueue_script registrieren, inklusive Abhängigkeiten (jQuery falls nötig). Sicherstellen, dass bestehende Funktionen wie das Filter-Formular, Smooth Scrolling etc. weiterhin laufen. Die im Child-Theme genutzte Lokalisierung von Scripts (wp_localize_script für AJAX-URLs, Texte) übernehmen
GitHub
, damit z.B. der AJAX-URL (admin-ajax.php) im JS verfügbar ist.

Templates portieren: Alle relevanten Template-Dateien aus dem Child-Theme ins neue Theme migrieren und anpassen:

Header und Footer: Falls das Child-Theme ein eigenes header.php hatte, dieses als Grundlage nehmen
GitHub
. Im neuen header.php das Markup für den Kopfbereich neu strukturieren: Logo/Sitetitle, Haupt-Navigation, Suchfeld, evtl. Social-Icons, und den Sticky-Header-Wrapper falls benötigt. Ein neues footer.php erstellen: Footer-Inhalte wie Copyright-Hinweis, Footer-Menü (Impressum, Datenschutz) und Social-Links integrieren. Elemente aus dem Parent-Theme, die im Child nicht überschrieben wurden (z.B. Footer-Text), müssen neu definiert werden.

Index- und Archive-Templates: Eine index.php als generisches Backup-Template anlegen – diese kann ähnlich wie das bisherige archive.php aus dem Child-Theme Beiträge in einem Standardlayout anzeigen
GitHub
. Zusätzlich ein spezifisches home.php (für Blogübersichtsseite, falls genutzt) und ein category.php für Kategorie-Archive erstellen, um dort gezielt das Layout der Kategorie-Listingseiten zu steuern
GitHub
. Im alten Theme wurde ein allgemeines archive.php für alle Archive verwendet
GitHub
; im neuen Theme kann man für bestimmte Kategorien (z.B. Dossiers) separate Templates (category-dossiers.php) nutzen oder innerhalb von category.php über Conditional Tags unterschiedliche Darstellungen je Kategorie umsetzen
GitHub
.

Seiten-Templates: Die speziellen Page-Templates des Child-Themes ins neue Theme übernehmen und aktualisieren:

Landing Page (page-landing.php): Enthält die Logik für die Startseitensektionen. Diese weitgehend beibehalten
GitHub
 – d.h. die Seite zeigt weiterhin pro definierter Kategorie die neuesten Beiträge an. Platzhaltertexte (im alten Code z.B. "Latest Sports News") an das neue Konzept anpassen (z.B. "Neueste Reportagen")
GitHub
. Evtl. die Kategorien/Sektionen anpassen oder konfigurierbar machen (z.B. via Customizer), aber zunächst reicht Hardcoding laut Konzept. Die Landing-Page im WP-Backend als statische Startseite einstellen (wie bisher).

Kursübersicht (page-courses.php): Template für die Liste der Kurse mit Filtern (Kategorie, Level, Förderung)
GitHub
. Dieses eins-zu-eins übernehmen, nur das Markup/designtechnisch modernisieren (z.B. Filter als Dropdown-Menüs oder besseres Grid für Kurse). Funktional bleibt die PHP-Logik unverändert, sodass weiterhin Kurse anhand von URL-Parametern gefiltert werden können.

Kurs-Detail (single-bg_course.php): Template für einzelne Kursangebote
GitHub
 mit Kursinformationen und dem Anmeldeformular-Shortcode. Ebenfalls übernehmen und optisch ans neue Theme anpassen (ggf. Blöcke im Kursinhalt ermöglichen, da CPT Gutenberg-kompatibel ist). Prüfen, ob das Template Markup aus dem Parent geerbt hatte (z.B. Kommentare, Autorbio – falls ja, neu gestalten oder weglassen).

Weitere Seiten: In einem Legacy-Ordner gab es Templates für Impressum, Kontakt, Team, About, Infoterminal, Datenschutz etc.
GitHub
. Diese dürften für das neue Theme nicht 1:1 übernommen werden, sondern werden als normale Seiten im Block-Editor umgesetzt. Impressum und Datenschutz kommen als statische Seiten (kein eigenes Template nötig). Team/Über uns: kann evtl. direkt im Editor gestaltet werden (oder zukünftig mit Custom Post Type "Team Member"). Die Inhalte aus den alten Templates sollten extrahiert und in neue Seiten eingefügt werden, damit keine wichtigen Infos verloren gehen – das Layout dieser Seiten passt sich dem allgemeinen Page-Template an.

Abhängigkeiten vom Parent lösen: Sicherstellen, dass das neue Theme autark funktioniert:

Allgemeine Styles: Alle grundlegenden Stildefinitionen (für Body, Überschriften, Paragraphen, Listen, Formulare, Buttons etc.), die zuvor vom FreeNews-Theme kamen, müssen im neuen Stylesheet vorhanden sein. Evtl. das FreeNews-CSS durchgehen und relevante Teile übernehmen
GitHub
. Auch Standard-Klassen von WP (z.B. .alignwide oder Editor-Klassen) im CSS berücksichtigen.

Formulare & Suchleiste: Das Suchformular mit eigenem searchform.php implementieren, da get_search_form() sonst das (nicht mehr existierende) Parent-Formular laden würde
GitHub
. Unser Searchform-Markup möglichst simpel und semantisch gestalten (Label, Input, Submit-Button). Für Kommentare falls nötig ein comments.php Template erstellen, um Kommentarlisten und -formular im eigenen Design zu haben (sofern Kommentare in Beiträgen genutzt werden sollen).

Sidebars/Widgets: Im alten Layout gab es rechts eine statische Sidebar mit Kategorie-Übersicht und neuesten Beiträgen auf Archivseiten
GitHub
. Entscheiden, ob diese im neuen Design erhalten bleiben soll. Falls ja, kann man in functions.php einen Widget-Bereich registrieren und im Template mit dynamic_sidebar einfügen – Redakteure könnten dann via WP-Widgets oder Custom HTML den Inhalt pflegen. Alternativ die Sidebar so belassen (Kategorie-Liste + Latest Posts via Code), bis entschieden ist, ob ein echtes Widget gebraucht wird.

Customizer modularisieren: Der Theme Customizer Code (vormals ~3000 Zeilen in einer Datei) wurde bereits in Module aufgeteilt
GitHub
. Diese Modularisierung ins neue Theme einbringen: In der functions.php oder inc/customizer.php die neuen Module cta.php, footer.php, social.php, social-sharing.php, post-meta.php und styles.php einbinden
GitHub
. Dadurch sind alle bisherigen Customizer-Einstellungen wieder verfügbar, aber der Code ist deutlich aufgeräumter. Im Customizer sollten nun Sektionen für Call-to-Action (CTA), Footer-Text, Social-Media-Links, Social-Sharing-Buttons, Post-Metadaten und ggf. Theme-Stile erscheinen – diese funktionieren wie zuvor, nur modulübergreifend. (Wichtig: Falls in der DB die Optionen unter der alten Theme-Option gespeichert waren, beim Theme-Wechsel neu setzen. Da aber gleiche Option-Namen verwendet werden dürften, bleiben Einstellungen erhalten.)

Grundgerüst abschließen: Am Ende dieses Schritts steht ein eigenständiges Theme, das optisch noch dem alten Layout ähneln mag, aber bereits alle Funktionen enthält und keinerlei Parent-Theme-Abhängigkeit mehr hat
GitHub
. Dieses Grundgerüst dient als Ausgangspunkt, um im nächsten Schritt die inhaltlichen und gestalterischen Neuerungen umzusetzen.

Meilenstein 3: Inhaltsstruktur & Kategorien aufbauen

Haupt-Ressorts als Kategorien: Die neuen inhaltlichen Bereiche Dossiers, Interviews, OSINT und Reportagen werden als WordPress-Kategorien angelegt
GitHub
. Damit werden alle redaktionellen Beiträge über den normalen Beitrags-Typ (Posts) verwaltet und nach diesen Kategorien gegliedert. Das nutzt die WP-Standards optimal und erfordert keine neuen Content-Typen
GitHub
.

Kategorie-Seiten gestalten: Für jede Hauptkategorie soll eine ansprechende Übersichtsseite existieren:

Verwendung der WP-Archivseiten für Kategorien (URL-Struktur /category/<name>). Diese greifen standardmäßig auf category.php zurück. Wir gestalten category.php so, dass der Kategorietitel (z.B. "Kategorie: Dossiers") als Überschrift erscheint und optional die Kategorie-Beschreibung als Einleitungstext (falls gepflegt)
GitHub
.

Darunter die Liste der Beiträge dieser Kategorie. Das Card-Layout aus dem alten Theme (Thumbnail-Bild, Kategorie-Badge, Titel, Auszug, Meta-Infos) kann hier wiederverwendet werden
GitHub
. Wahrscheinlich lässt sich vieles aus dem bisherigen archive.php übernehmen.

Falls designseitig gewünscht, können unterschiedliche Kategorien leicht unterschiedliche Layouts bekommen – z.B. könnte man in category.php per is_category('dossiers') einen anderen Ausgabe-Block für den ersten Beitrag einschieben (um ihn größer zu zeigen)
GitHub
. Solche Sonderfälle werden mit dem Designer abgestimmt; generell sollte das Layout aber einheitlich genug bleiben.

Landingpage-Sektionen aktualisieren: Die Startseite zeigt Teaser der Kategorien:

Die Logik in page-landing.php, die bestimmte Kategorien zieht, beibehalten
GitHub
. Allerdings die Sektionstitel und Kategorien-Slugs an die finalen Ressortnamen anpassen. Z.B. anstatt "Latest Sports News" (Platzhalter) nun "OSINT & Forensik" oder "Investigative Dossiers" je nach Absprache
GitHub
.

Reihenfolge der Sektionen festlegen (vermutlich entsprechend der Menü-Reihenfolge: Dossiers, Interviews, OSINT, Reportagen). Wenn eine Kategorie noch leer ist, springt die Code-Logik im alten Theme auf eine Fallback-Kategorie (z.B. Dossiers) um
GitHub
. Trotzdem sollte zum Launch jede Kategorie wenigstens einen Beitrag enthalten (siehe unten "Content einpflegen").

Eventuell könnte man die Anzahl der angezeigten Beiträge pro Kategorie-Sektion anpassen (aktuell evtl. 3-4). Hier entscheidet das Design: bei großen Teaser-Kacheln evtl. 3 pro Sektion, bei kleineren Thumbnails könnten es 4-5 sein.

Beiträge zuordnen & anlegen: Sollten bereits Artikel existieren (z.B. aus einem Blog), diese den neuen Kategorien zuweisen
GitHub
. Möglicherweise gab es bereits Inhalte, die begrifflich passen (das Legacy-InfoTerminal-Template deutet an, dass "Dossiers" und "Reportagen" als Kategorie genutzt wurden)
GitHub
. Sicherstellen, dass diese in die neue Struktur übernommen werden. Ggf. Dummy-Artikel für jede Kategorie erstellen, um Layout und Funktionen zu testen.

Verwechslungen vermeiden: Die Taxonomie bg_course_category (für Kurs-Themen wie "OSINT-Weiterbildung") ist separat und bleibt für Kurse bestehen
GitHub
. Die neuen WP-Kategorien für Artikel heißen ähnlich ("OSINT" etc.), überschneiden sich inhaltlich aber nicht mit Kurskategorien. Hier muss das Team künftig darauf achten, Artikel vs. Kurs zu unterscheiden – in der Admin-Oberfläche sind das klar getrennte Bereiche (Beiträge vs. Kurse).

Menüstruktur anpassen: Das Hauptmenü wird entsprechend der neuen Bereiche gestaltet
GitHub
:

Einträge für die Ressorts: "Dossiers", "Interviews", "OSINT", "Reportagen" verlinken direkt auf die jeweiligen Kategorie-Seiten
GitHub
.

Weitere Hauptpunkte: "InfoTerminal" (zur Produktseite), "Shop" (zur Shop-Startseite), ggf. "Kurse" (zur Kursübersicht) falls das Weiterbildungsangebot prominent bleiben soll
GitHub
.

"Home" bzw. "Startseite" kann als Link zur Landingpage eingefügt werden (oder man nutzt das Logo als Home-Link, was oft üblich ist).

Impressum/Datenschutz ins Footer-Menü auslagern, um das Hauptmenü schlank zu halten.

Das Menü im WP-Admin neu zusammenstellen und den Theme-Locations (Primary, Footer) zuweisen. Dabei kann man die Gelegenheit nutzen, Link-Titel und Reihenfolge neu zu ordnen. (Beispiel: Startseite, Dossiers, Interviews, OSINT, Reportagen, InfoTerminal, Shop, Kontakt).

Hinweis: Die bisherige Automatik für Menüeinträge (wie die erwähnte Funktion bg_sync_course_navigation im Child für Kurs-Untermenüpunkte) wird nicht mehr benötigt
GitHub
 – Menüpflege erfolgt manuell, was dem Redaktionsteam mehr Kontrolle gibt.

Beitrags-Listing & Metadaten: Einheitliche Darstellungsregeln festlegen:

Auszugslänge anpassen: Der alte Code setzte excerpt_length auf 28 Wörter
GitHub
. Im neuen Design je nach Layout entscheiden, ob diese Länge passt (für Kurztexte unter Teaser-Bildern) oder z.B. etwas verlängert werden soll.

Lesezeit-Anzeige: Die Funktion zur Lesezeitberechnung (bg_get_reading_time) aus dem Child-Theme übernehmen und weiterhin in Artikel-Meta anzeigen
GitHub
. So sehen Leser schon auf der Übersichtsseite, wie lange ein Artikel ca. dauert – das erhöht die Usability.

Meta-Infos: Autorname und Datum in Artikellisten und Einzelansicht anzeigen (im alten Theme vorhanden). Falls Kategorienamen als Badges bei Artikeln gezeigt werden (etwa auf der Startseite oder in Dossiers-Übersicht), bei einem Beitrag, der in einer Kategorie-Ansicht erscheint, vielleicht nur die Kategorie dieser Ansicht anzeigen um Redundanz zu vermeiden.

Breadcrumbs: Die Breadcrumbnavigation (z.B. "Home > Dossiers > Artikelname") weiter nutzen und optisch ins neue Design integrieren (kleinere Schrift, unaufdringlich) – das Markup dafür war bereits implementiert und suchmaschinenfreundlich
GitHub
.

Inhaltsstruktur-Fazit: Nach diesem Schritt ist die inhaltliche Basis der Seite gelegt
GitHub
. Alle redaktionellen Inhalte werden konsistent in den vier Hauptkategorien organisiert. Das System ist für die Redakteure vertraut (normale WP-Beiträge) und die Nutzer finden sich in klar definierten Ressorts zurecht. Die Homepage fungiert als Portal, das auf die Ressorts verweist, und das Menü bietet direkten Zugang zu allen Bereichen einschließlich Shop und InfoTerminal.

Meilenstein 4: WordPress-Funktionen optimal nutzen

Custom Post Types & Admin-Funktionen: Die projekt-spezifischen Inhaltstypen bleiben erhalten:

Den Registrierungscode für die CPTs bg_course, bg_instructor und bg_enrollment in das neue Theme übernehmen (aus dem alten functions.php oder einer included Datei)
GitHub
. Ebenso die Registrierung der Custom Taxonomies bg_course_category und bg_course_level beibehalten
GitHub
. Damit bleiben alle Kurs-Daten (Kursangebote, Dozenten, Anmeldungen) nahtlos verfügbar. Darauf basierende Features wie das Dashboard-Widget mit Kursstatistik oder spezielle Admin-Filter weiterhin einbinden
GitHub
.

Menü-Icons und Beschriftungen der CPTs unverändert lassen, sofern sie sinnvoll sind (z.B. Dashicon "welcome-learn-more" für Kurse passt gut)
GitHub
.

Prüfung: die CPTs waren mit show_in_rest => true registriert, was gut ist (für Gutenberg & REST-API) – sicherstellen, dass das so bleibt
GitHub
.

Gutenberg-Editor & Blöcke:

Theme-Unterstützung für den Block-Editor sicherstellen: add_theme_support('align-wide') aktivieren, evtl. add_theme_support('editor-styles') und eine editor-style.css einbinden, damit die Backend-Vorschau die Frontend-Styles widerspiegelt
GitHub
.

Eigene Block-Stile: Falls das Design es vorsieht, eigene CSS-Klassen für Standardblöcke definieren (z.B. Aussehen von Zitaten, Pullquotes, Tabellen). Diese in die Editor-Styles und Frontend-Styles aufnehmen.

Custom Blocks (optional): Identifizieren, ob bestimmte Inhalts-Elemente als wiederverwendbare Blöcke sinnvoll sind. Beispielsweise:

Ein Block für Testimonials (z.B. Aussagen von Kurs-Absolventen), der mit Quote-Style und Name angezeigt wird – bisher im Landing-Template vielleicht nur hart codiert.

Ein Feature-Highlight Block, um einen Artikel manuell mit Bild und Teaser irgendwo einzubinden (als Alternative zu starren Sektionen).

Umsetzung pragmatisch: ggf. mit ACF Blocks (sofern ACF genutzt werden darf), da dies schnelles Bauen per PHP erlaubt, oder mit der Core-API, falls mehr Zeit.

Block Patterns: Vordefinierte Muster anbieten (im Code via register_block_pattern), z.B. für eine zweispaltige Artikelreihe, oder eine schön formatierte Infobox, etc. So können Redakteure diese mit einem Klick einfügen, ohne eigene Blöcke programmieren zu müssen
GitHub
.

Fokus bleibt auf Kernblöcken: Überschrift, Absatz, Bild, List etc. – diese müssen im Theme gut aussehen. Erweiterungen mit eigenen Blöcken sind "nice to have", falls Zeit und Ressourcen übrig sind.

Shortcodes & Legacy-Funktionen:

Der Shortcode [bg_course_enrollment] für das Kurs-Anmeldeformular wird weiter verwendet
GitHub
. Die zugehörige PHP-Logik (vermutlich in inc/enrollment-form.php) ins neue Theme einbinden, falls nicht schon durch include abgedeckt. Dadurch bleibt die Funktionalität erhalten (Teilnehmer können sich via Formular zu Kursen anmelden, es wird ein CPT-Eintrag erzeugt und E-Mails versendet).

JavaScript für das Anmeldeformular: Prüfen, ob es noch mit jQuery arbeitet. Könnte modernisiert werden (z.B. Fetch API, asynchrone Validierung)
GitHub
, aber nur durchführen, wenn ausreichend getestet werden kann. Andernfalls belassen wir die bewährte Implementierung, um keine neuen Bugs einzuführen.

Andere Shortcodes oder Widgets aus dem alten Theme übernehmen, falls vorhanden (z.B. gab es vielleicht einen [bg_breadcrumb] Shortcode – aber Breadcrumbs sind wohl direkt im Template gelöst).

REST-API & externe Anbindungen:

Da Beiträge und CPTs via WP REST-API abrufbar sind (Kurse etc. haben show_in_rest = true)
GitHub
, kann das InfoTerminal-Tool oder andere Anwendungen Daten ziehen. Sicherstellen, dass diese API-Endpunkte erreichbar bleiben (z.B. kein Auth-Zwang für public Daten).

Falls InfoTerminal spezielle Datenfilter braucht, kann man hier oder in Zukunft eigene Endpunkte definieren. Beispielsweise ein Endpoint, der die neuesten Dossier-Artikel mit bestimmten Metadaten liefert, falls nötig – aber nur, wenn sich ein konkreter Bedarf zeigt.

(Wenn ein Security-Plugin REST deaktiviert hat, entsprechend konfigurieren, dass es offen bleibt – im Zweifel in Dokumentation vermerken.)

Performance & Caching:

Nutzen der WP-internen Caching-APIs: Das Kurs-Statistik-Widget speichert seine Werte bereits in einem Transient
GitHub
, das ist gut. Prüfen, ob ähnliche Caching-Mechanismen für andere häufige Queries sinnvoll sind (z.B. Startseiten-Teasersektionen). Man könnte z.B. das Ergebnis der Startseitenabfragen alle 10 Minuten cachen, um Datenbanklast zu reduzieren, falls nötig
GitHub
.

Objekt-Cache / Page-Cache: Gehört mehr zur Server/Plugin-Ebene (z.B. WP Super Cache). In der Entwicklungsphase erstmal ignorieren, aber für Produktion einplanen, ein Caching-Plugin zu konfigurieren, sobald alles läuft
GitHub
.

Bilder: Die neuen Bildgrößen (Thumbnails) werden von WP generiert. Darauf achten, überall the_post_thumbnail('size-name') zu verwenden, um unnötig große Bilder nicht einzubinden. WP 5.5+ lazy-loadet Bilder automatisch (bei img mit width/height), was wir nutzen
GitHub
. Zusätzliche Optimierung: Critical-Image als LQIP? Vermutlich Overkill, erstmal Standard lassen.

Skripte und CSS minimieren: Falls der Build-Prozess SCSS->CSS etc. vorhanden ist, darauf achten, minifizierte Assets auszuliefern und keine sourcemaps in Produktion. Kombinieren von CSS/JS überlassen wir ggf. einem Optimierungs-Plugin in Prod (oder nutzen moderne HTTP/2 – aber egal, das ist Deploy-Thema).

SEO & Social Features:

Meta-Tags: Das Theme soll, wenn kein SEO-Plugin wie Yoast aktiv ist, von sich aus grundlegende Meta-Tags ausgeben (OG:Title, OG:Description, OG:Image, Twitter-Card)
GitHub
. Den Code aus dem alten Theme (wahrscheinlich in functions.php oder header.php integriert) übernehmen. Er prüft vermutlich, ob z.B. WPSEO_Meta existiert, und wenn nein, generiert eigene Tags aus den Post-Daten.

SEO-Plugins: Kompatibilität sicherstellen, d.h. unser Theme soll keine Dinge tun, die Plugins stören. In der Regel überschreibt ein Plugin unsere Meta-Tags (Doppel-Tags sind unschön, aber meist harmlos). Falls nötig, könnte man eine Abfrage einbauen: if ( ! class_exists('WPSEO_Frontend') ) { output_og_tags(); }.

Breadcrumb Schema: Die Breadcrumbs-Ausgabe im Theme nutzt wahrscheinlich Microdata oder JSON-LD für Schema.org
GitHub
. Weiterhin ausgeben, da es SEO-technisch sinnvoll ist (Google zeigt evtl. Pfade in Suchergebnissen).

Weitere SEO-Punkte: Titel-Tags handhabt WP via Theme-Support automatisch. Eine XML-Sitemap liefert WP inzwischen auch out-of-the-box (inkl. CPTs). Wir sollten nur prüfen, ob evtl. Pagination korrekt noindex gesetzt wird (Standard bei WP okay).

Social Sharing Buttons: Im Customizer gibt es ein Modul für Social Sharing
GitHub
. Dieses fügt vermutlich Share-Buttons unter Posts hinzu. Die Einstellungen daraus (welche Netzwerke, wo anzeigen) sollten getestet werden. Social-Links (Links zu BG’s eigenen Social-Media) sind ebenfalls im Customizer pflegbar und werden im Header/Footer angezeigt – das ist auch Teil des neuen Themes.

Zusammenfassung: In diesem Meilenstein stellen wir sicher, dass das Theme sich an WordPress-Best-Practices hält und alle vorhandenen Features sauber integriert sind
GitHub
. Gleichzeitig werden Modernisierungen (Block-Support, modulare Struktur, Performance-Tweaks) eingebracht. Das Ergebnis ist ein technisch stabiles und erweiterbares Theme, das sowohl Redakteuren (durch vertraute WP-Oberfläche) als auch Nutzern (durch schnelle Ladezeiten und nützliche Funktionen) entgegenkommt.

Meilenstein 5: InfoTerminal-Produktseite umsetzen

Seite & Template einrichten: Für das Beyond Gotham InfoTerminal-Tool eine eigene Seite erstellen (z.B. "InfoTerminal") und das spezielle Template InfoTerminal zuweisen (im Theme als page-infoterminal.php)
GitHub
. So wird sichergestellt, dass diese Seite ein individuelles Layout erhält, unabhängig vom Standard-Page-Template.

Hero-Bereich: Im Template einen einladenden Header-Bereich gestalten
GitHub
:

Überschrift der Seite (Seitentitel) prominent anzeigen; darunter ein kurzer Einleitungstext (kann fest im Template stehen oder den Seiten-Auszug nutzen).

Zwei Call-to-Action Buttons einbauen: "Demo öffnen" (scrollt zur Demo-Sektion) und "Features entdecken" (scrollt zur Feature-Liste)
GitHub
.

Als besonderes Element zeigte das Legacy-Template einen Systemstatus-Block (Liste von Diensten mit Status/Latenz)
GitHub
. Dieser war dort eher als Platzhalter/Gag statisch implementiert und würde für eine echte Seite komplexe Live-Daten erfordern. Entscheidung: entweder diesen Teil weglassen im neuen Design oder durch eine statische Grafik/Illustration ersetzen, die das Tool symbolisiert (z.B. Screenshot oder Icon-Montage).

Demo-Embed Sektion: Hauptaugenmerk auf der Live-Demo-Einbettung des Tools:

Abschnitt mit einer bekannten ID (z.B. #infoterminal-demo), der einen <iframe> enthält
GitHub
. In diesem iframe soll die Web-Oberfläche von InfoTerminal geladen werden können.

Die URL für das iframe kommt aus einem Custom Field: Im alten Code per _bg_infoterminal_embed_url Meta-Feld konfiguriert. Das neue Theme übernimmt diesen Mechanismus:

Das Feld z.B. via add_post_meta beim Theme-Setup registrieren (nur für Seiten vom Typ InfoTerminal-Template) oder via Plugin (ACF) definieren. Bei Aufruf des Templates per get_post_meta( $post->ID, '_bg_infoterminal_embed_url', true ) abrufen.

Wenn eine URL vorhanden ist, iframe mit dieser src ausgeben; wenn nicht, stattdessen einen Platzhaltertext anzeigen (im Legacy-Code etwa "Please configure a Demo URL..." – das auf Deutsch formulieren)
GitHub
.

Responsives Verhalten: Das iframe im CSS auf volle Breite setzen und eine fixe Höhe (z.B. 600px) geben
GitHub
. Eventuell für mobile Geräte die Höhe reduzieren (z.B. via Media Query auf 400px), damit nicht der ganze Screen blockiert wird. Zusätzlich loading="lazy" setzen, damit das iframe erst lädt, wenn der User runterscrollt (bzw. nach dem Klick auf "Demo öffnen").

Scroll-Funktion: Implementieren, dass der "Demo öffnen" Button geschmeidig zu #infoterminal-demo scrollt (kann mit dem vorhandenen Smooth-Scroll-Skript oder window.scrollTo gemacht werden).

Feature-Liste: Sektion #infoterminal-features mit den Kernfunktionen des Tools:

Im Legacy-Code sind drei Features statisch definiert (Netzwerk-Visualisierung, Fall-Dossiers-Integration, Live-Datenimporte)
GitHub
 – jeweils mit Titel und Beschreibung, evtl. Icon.

Diese Feature-Punkte ins neue Template übernehmen, die Texte ggf. aktualisieren/erweitern (mit Team abstimmen, ob es mehr als drei gibt, was besonders hervorgehoben werden soll). Die Darstellung kann in einem dreispaltigen Grid erfolgen oder untereinander, je nach Design.

Hier könnte man überlegen, die Features pflegbar zu machen (z.B. als eigene Beitragstypen oder Felder). Aufgrund der begrenzten Anzahl und statischen Natur kann man aber zunächst hardcoden und später bei Bedarf dynamisieren.

"Features entdecken" Button aus dem Hero scrollt hierher – also sicherstellen, dass die ID stimmt.

Zusätzlicher Inhalt: Am Ende des Templates den regulären Seiteninhalt ausgeben (the_content())
GitHub
. Dadurch hat die Redaktion die Möglichkeit, unterhalb der vorgegebenen Sektionen weiteren Content einzufügen. Z.B. könnte man dort einen abschließenden Absatz, Bildergalerie, Kontaktformular o.ä. platzieren, ohne das Template ändern zu müssen.

Integration & Verlinkung:

Menü: Den Menüpunkt "InfoTerminal" im Hauptmenü einfügen (sofern nicht schon vorhanden) und auf diese Seite zeigen
GitHub
.

Quer-Verweise: Möglicherweise Teaser auf InfoTerminal an anderen Stellen einbauen (z.B. auf der Startseite ein Abschnitt "Eigenes Tool: InfoTerminal" mit Kurzbeschreibung und Link). Das erhöht die Sichtbarkeit des neuen Features.

Im InfoTerminal-Text selbst ggf. darauf hinweisen, dass dazu passende Artikel im Ressort OSINT/Reportagen existieren (da laut Legacy die Fälle darüber laufen)
GitHub
 – könnte man verlinken ("Siehe dazu unsere Dossiers").

CTA zum Kauf: Wenn InfoTerminal als Produkt verkauft werden soll, ein "Jetzt kaufen" oder "Lizenz anfragen" Button einbauen, der zum Shop oder Kontakt führt (mit Team klären, was das Conversion-Ziel ist).

Technische Feinheiten:

Sicherheit des iframes: Evtl. sandbox Attribute setzen, falls die externe URL nicht vollkommen vertraut ist – aber wenn es die eigene Subdomain mit der App ist, sollte das okay sein.

Performance: Das Einbetten eines evtl. schwergewichtigen Tools könnte Ladezeit kosten. Lazy-Loading und ein Hinweis an Nutzer ("Lädt...") könnten eingebaut werden, damit niemand irritiert wird, falls es 2-3 Sekunden dauert.

Übersetzbarkeit: Strings wie Button-Labels oder Platzhaltertexte im Template mit i18n-Funktionen versehen für mögliche Mehrsprachigkeit.

Test mit verschiedenen Browsern, ob das Einbetten reibungslos klappt (manche Browser blockieren Mixed Content, also sicherstellen Demo-URL ist HTTPS).

Ergebnis: Eine dedizierte Produktseite, die das InfoTerminal überzeugend präsentiert – optisch eingebettet ins Beyond Gotham-Design, inhaltlich aber mit eigenständiger Struktur (Hero, Demo, Features). Sie schlägt die Brücke zwischen dem redaktionellen Angebot (indem sie auf Cases in Artikelform verweist) und dem technischen Produkt, und kann sowohl interessierte Leser als auch potenzielle Kunden ansprechen
GitHub
.

Meilenstein 6: Shop-Integration (WooCommerce)

WooCommerce einbinden: Installation und Einrichtung des WooCommerce-Plugins, um Shop-Funktionalität bereitzustellen. Nach Aktivierung Standard-Prozess:

WooCommerce Einrichtungsassistent ausführen, um Seiten für Shop, Warenkorb, Kasse und Mein Konto anzulegen
GitHub
. Diese Seiten ggf. gleich ins Menü aufnehmen (zumindest Shop, evtl. Mein Konto für registrierte Nutzer).

In functions.php add_theme_support('woocommerce') ergänzen, damit WooCommerce unser Theme als kompatibel ansieht.

Grundeinstellungen prüfen: Währung Euro, Standort Deutschland, Maßeinheiten etc., passend zum Geschäft von Beyond Gotham. Steuer- und Versandoptionen erstmal basic lassen (kann später verfeinert werden).

Produktsortiment planen: Welche Artikel sollen im Shop verkauft werden?

InfoTerminal-Lizenz/Account: Wenn das OSINT-Tool als Produkt verkauft werden soll, als WooCommerce-Produkt anlegen (virtuelles Produkt, evtl. mit externer Weiterleitung falls Kauf nur eine Anfrage triggern soll)
GitHub
.

Merchandise/Bücher: Beyond Gotham könnte Merch (Shirts, Tassen) oder Publikationen (Reports, eBooks) verkaufen. Diese als Produkte einpflegen, Kategorien verwenden (z.B. Kategorie "Merch", "Publikationen").

Kurse verkaufen: Falls geplant, Kurse kostenpflichtig zu machen, wäre die Integration ins Shopsystem aufwändiger (Verknüpfung von Kurs-CPT mit WooCommerce Product) – das ist möglicherweise erst ein späterer Schritt, aber im Hinterkopf behalten.

Dummy-Produkte erstellen, um Layout & Checkout zu testen (z.B. "Demo-Produkt" für 1€).

Theme-Anpassungen für WooCommerce:

Template-Overrides: Im Theme-Ordner einen woocommerce/ Unterordner anlegen. Wichtige Templates von WooCommerce dort hineinkopieren und modifizieren:

woocommerce.php (optional): Ein generisches Template, das alle WooCommerce-Seiten umschließt. Kann man nutzen, um Header/Footer konsistent einzubinden. Alternativ die einzelnen Templates anpassen.

Shop-Seite (archive-product.php): Darstellung der Produktübersicht anpassen. Z.B. Seitentitel "Shop" einblenden oder über das WooCommerce-Setting steuern, Grid-Layout für Produkte definieren (Anzahl Spalten). Wenn wenige Produkte, evtl. direkt große Kacheln; bei vielen, Filter/Sortierung zeigen.

Produktdetail (single-product.php + Partials): Hier Branding anpassen: Produktbild, Titel, Preis, Beschreibung etc. in unserer Theme-Typografie darstellen
GitHub
. Ggf. Tabs (Beschreibung/Details/Bewertungen) umgestalten oder auf ein einfacheres Layout bringen. Sicherstellen, dass Upsells/Cross-sells passend aussehen oder abgeschaltet sind, je nach Bedürfnis.

Warenkorb (cart.php etc.): Überprüfen, ob der Warenkorb auf mobilen Geräten passt (ggf. via CSS scrollbare Tabellen). Buttons "Weiter einkaufen" und "Weiter zur Kasse" gut sichtbar machen, in unseren Farben.

Kasse (checkout.php etc.): Das Checkout-Formular soll übersichtlich sein – ggf. CSS nutzen, um Zweispaltigkeit zu erreichen oder zu verbessern. Falls benötigt, Felder entfernen (Woo hat Hooks, z.B. Rechnungsadresse bei digitalen Produkten minimal halten).

Mein Konto: Standard-Seite belassen, vielleicht nur CSS für Buttons/Links anpassen.

CSS-Integration: WooCommerce bringt eigenes CSS mit; wir entscheiden, ob wir es laden:

Vermutlich laden und darauf aufbauen, da es Grundlayouts bietet. In unserem style.css dann nach Bedarf überschreiben (z.B. .woocommerce .button Styles).

Buttons, Formularelemente, Meldungen (z.B. Fehler-/Erfolgsmeldungen) im WooCommerce-Kontext an unseren Style angleichen (Farben aus Styleguide, Fonts).

E-Mail-Templates (falls gewünscht) ebenfalls anpassen mit Logo/Farben – das geht im WooCommerce-Backend, nicht direkt im Theme.

Funktionale Einrichtung:

Zahlungsarten: PayPal, Stripe etc. einrichten und in Testmodus ausprobieren
GitHub
. Für den Launch mind. PayPal und Vorkasse anbieten; ggf. später Rechnungskauf oder Kreditkarte via Stripe.

Versand & Steuern: Wenn physische Artikel verkauft werden, Versandzonen und -kosten definieren (z.B. DE pauschal X€, EU Y€). Für digitale Produkte Versand deaktivieren. Steuersätze (MwSt.) konfigurieren falls nötig (B2C -> 19%).

Rechtliches: Seiten für AGB, Widerruf, Datenschutz (Shop-spezifisch) erstellen
GitHub
. WooCommerce generiert teils Muster-AGB/Widerruf – diese anpassen an Beyond Gotham und von einem Rechtsexperten abnehmen lassen. Sicherstellen, dass im Checkout auf AGB und Widerruf hingewiesen wird (Checkbox "AGB gelesen" etc. aktivieren).

Integration ins Site-Design:

Hauptmenü: "Shop" als neuen Menüpunkt einfügen (Position je nach Wichtigkeit; evtl. als letzter Punkt)
GitHub
.

Sichtbarkeit: Falls der Shop initial wenig Produkte hat, überlegen, ob man ihn direkt prominent verlinkt oder zunächst nur über InfoTerminal-Seite ("Jetzt kaufen") zugänglich macht, um Besucher nicht in einen leeren Shop zu führen.

Warenkorb in Header: UI-Detail, das Nutzerfeedback verbessert: Ein kleines Warenkorb-Icon mit Artikel-Anzahl oben rechts einbauen (z.B. neben Such-Icon). Über WooCommerce-Widget oder eine eigene kleine Funktion (WC()->cart->get_cart_contents_count()) darstellen. Klick darauf führt zum Warenkorb oder zeigt per Dropdown den Inhalt (Mini-Cart)
GitHub
.

Konsistenz: Auf Shop-Seiten den gleichen Header/Footer verwenden (dank Template-Overrides). Eventuell Breadcrumb-Navigation auch für Produkte aktivieren (WooCommerce hat eigene Breadcrumb-Funktion, kann durch unser Theme-Design ersetzt werden).

Tests & Feinschliff:

Dummy-Bestellung durchspielen (als Kunde): Produkt in den Warenkorb, zur Kasse, Testzahlung durchführen (z.B. PayPal Sandbox)
GitHub
. Sicherstellen, dass die Bestellbestätigungs-Seite erscheint und E-Mails ankommen (ggf. Mail-Log anschauen).

Edge Cases: Was passiert, wenn kein Produkt auf Lager (Lagerbestand verwalten oder deaktivieren), wie sehen Fehlermeldungen aus (z.B. "Bitte Zahlungsart wählen") – diese Texte ggf. via Loco Translate oder POEdit anpassen ins Deutsche, falls nötig.

Mobile Checkout: Die Formulare auf Smartphone durchgehen – Scrollen, Keyboard, Auswahlfelder etc. Checken, ob das "Adresszusatz" Feld etc. notwendig ist (kann man in DE oft rausnehmen).

Performance: WooCommerce kann die Seite etwas verlangsamen (zusätzliche JS/CSS). Mit dem Performance-Testing aus vorherigem Schritt nochmal gegenprüfen. Evtl. unnötige Scripts auf Non-Shop-Seiten dequeuen (z.B. WooCommerce lädt Kartenscript oder Lightbox überall – kann man auf Shop beschränken per Conditional).

Benefit: Durch die WooCommerce-Integration hat Beyond Gotham nun einen vollwertigen Online-Shop, ohne ein separates System entwickeln zu müssen. Das Team kann Produkte einstellen, Bestellungen verwalten und Zahlungen entgegennehmen, während Kunden eine vertraute E-Commerce-Erfahrung vorfinden. Wichtig ist, die Shop-Elemente optisch und inhaltlich ins Gesamtangebot einzubetten, damit Nutzer einen nahtlosen Übergang zwischen Magazin, Kursangebot und Shop erleben
GitHub
.

Meilenstein 7: Qualitätssicherung und Launch

Cross-Browser-Tests: Die fertige Website in allen gängigen Browsern testen (Chrome, Firefox, Safari, Edge)
GitHub
. Insbesondere auf unterschiedliche Rendering achten (Fonts, Flexbox, Grid) und JS-Funktionen (z.B. Menü-Toggle) überall prüfen. Auch ältere Browserversionen zumindest stichprobenartig testen, soweit verfügbar.

Responsive Tests: Umfassend auf verschiedenen Geräten/Viewport-Größen prüfen
GitHub
:

Mobile: Navigation (öffnet das Mobilmenü problemlos? schließen?), Lesbarkeit der Texte (nicht zu klein, keine Abschneidungen), Touch-Bedienung der Slider/iframed Demo etc.

Tablet: Zwischenzustände im Layout (z.B. 2-Spalten Grids), funktioniert das CSS Grid responsiv?

Hochkant/Querformat ausprobieren, insbesondere für das InfoTerminal-iframe – ggf. Höhe anpassen oder Scrollbalken zulassen.

Testen, ob keine horizontalen Scrollbars auftauchen (ein Indikator, dass irgendetwas zu breit aus dem Layout ragt).

Funktionstests: Alle interaktiven Features manuell durchgehen:

Kurs-Anmeldung: Formular ausfüllen und absenden. Erwartung: Meldung "Erfolgreich angemeldet" erscheint, E-Mail kommt an, in WP-Admin unter "Anmeldungen" neuer Eintrag
GitHub
. Falls Fehler (z.B. Pflichtfeld fehlt) auftreten, werden diese korrekt angezeigt? Mehrfach-Submit verhindern (im Code war Rate Limit 3 in 15 Min)
GitHub
 – versuchen, 3x schnell hintereinander zu senden um zu sehen, ob die Sperre greift.

Navigation & Links: Alle Menüpunkte anklicken – führen sie zur richtigen Seite? Breadcrumbs nachverfolgen (stimmen die Pfade?). Pagination auf Archivseiten nutzen (Seite 2 laden). Suchfunktion nutzen – z.B. nach "OSINT" suchen und schauen, ob Ergebnisseite vernünftig formatiert ist
GitHub
 (ggf. eigenes Template search.php schreiben, falls nötig).

Beiträge & Kategorien: Bei Artikeln prüfen: sind alle erwarteten Elemente da (Titel, Lesezeit, Autor, Teilen-Buttons via Customizer, Kommentare falls aktiviert)? Auf Kategorie-Seiten: Wird die Beschreibung angezeigt? Sind genug Beiträge gelistet?

InfoTerminal-Seite: Buttons "Demo öffnen"/"Features entdecken" testen – scrollt die Seite korrekt
GitHub
. Lädt die eingebettete Demo tatsächlich (ggf. auch mal mit einer Beispiel-URL)? Feature-Liste ok? Was passiert auf Mobile (iframe nutzbar?) – ggf. Timeout definieren, wann man die Demo nicht mehr lädt.

Shop & Checkout: Produkt in Warenkorb legen, zum Checkout gehen, Testkauf durchführen (siehe WooCommerce Tests oben)
GitHub
. Besonderes Augenmerk auf E-Mails: Bestellbestätigung erhalten? Deutschsprachig und inhaltlich korrekt? Auch "Abbrechen" einmal probieren (Zahlung abgebrochen) – kommt man zurück zum Shop? Kein toter Link?

Seiteninhalte: "Über uns", "Team", "Kontakt" etc. durchklicken, schauen ob alles richtig angezeigt wird (ggf. Standard-Page-Template-Layout prüfen, z.B. ist Sidebar da oder nicht). 404-Seite bewusst aufrufen (z.B. /asdf) und schauen, ob unsere 404.php greift und ein nützliches 404-Layout zeigt.

Performance & SEO Checks:

Mit Google Lighthouse / PageSpeed Insights einen Performance-Check durchführen
GitHub
. Ziel: mindestens im grünen Bereich auf Mobil & Desktop.

Falls die Startseite z.B. viele Bilder lädt, sicherstellen, dass sie ausreichend komprimiert sind (notfalls Plugins wie Smush/Lazy Load evaluieren, aber WP macht viel schon out-of-box).

Time To First Byte & Server: Sollte mit Caching okay sein; wenn nicht, Hosting prüfen.

Largest Contentful Paint: Sollte der Aufmacher sein – ggf. optimieren, indem kritisches CSS inline geladen wird (fortgeschritten).

SEO: Mit einem SEO-Plugin (falls installiert) oder manuell checken:

Jede Seite sollte einen unique Title und Meta Description haben. Die Startseite besonders (Beyond Gotham - Tagline).

Social Share Vorschau testen: z.B. einen Artikel-URL im Twitter Card Validator oder Facebook Debugger eingeben, schauen ob unser OG-Tag greift (Titel, Bild, Beschreibung).

Strukturierte Daten: Breadcrumbs Test mit Google Rich Results Test
GitHub
 – sollte "BreadcrumbList" ausgeben. Artikel könnten optional mit Article Schema ausgezeichnet werden (nicht Pflicht, aber z.B. WPSEO macht das).

Barrierefreiheit: Tools wie WAVE oder Lighthouse A11y-Report anschauen. Kontrastprobleme beheben (z.B. hellgrau auf weiß vermeiden). Alt-Texte zu wichtigen Bildern hinzufügen (Redaktion schulen). Fokus-Reihenfolge im Menü prüfen (Tabben durch Seite).

Content-Freeze & Launch-Vorbereitung:

Kurz vor Launch: Content ein letztes Mal abstimmen. Redaktion sollte jetzt finalen Inhalt in allen Bereichen eingepflegt haben (keine "Lorem Ipsum" mehr)
GitHub
. Wo erforderlich Dummy-Inhalte durch echte ersetzen (z.B. echte Kursdaten, echte Teamfotos).

Check: sind alle vier Hauptkategorien mit mind. einem Artikel gefüllt? Wenn nicht, vielleicht kurzfristig einen passenden Artikel aus dem Archiv nehmen oder einen Pressetext einfügen, damit nichts leer bleibt.

Medien: Alle Bilder optimiert? (Wenn Zeit, einmal Media Library durchgehen und grobe Ausreißer in Dateigröße komprimieren).

Sicherstellen, dass alle Links auf der Seite gültig sind (kein "Lorem Link"). Interne Verlinkungen, z.B. im Fließtext, überprüfen.

Deployment-Plan bereit halten: Wann (Uhrzeit) und wie der Umschalt auf das neue Theme erfolgt, und wer involviert ist.

Theme-Aktivierung & Nacharbeiten:

Das neue Theme auf der Live-Site aktivieren (ggf. in einer kurzen Wartungsmodus-Phase, um unschöne Zwischenschritte zu verbergen)
GitHub
.

Sofort danach Permalink-Einstellungen speichern
GitHub
, damit ggf. neue Rewrite Rules (für CPTs, Archives) greifen.

WooCommerce: prüfen, ob die Shop-Seiten korrekt zugewiesen sind (WC-Einstellungen -> Produkte/Erweitert). Manchmal muss man nach Theme-Switch die Seiten erneut zuordnen.

Plugin-Kompatibilität: Falls Caching/Minify-Plugins laufen, diese kurz deaktivieren oder neu konfigurieren, um sicherzustellen nichts bricht mit neuem HTML/CSS.

SMTP/Emails: Wenn im Dev-Setup Mails evtl. unterdrückt waren, in Produktion sicherstellen, dass ein Mailer eingerichtet ist (z.B. SMTP via Plugin)
GitHub
, damit Kurs-Anmeldungen und Bestellungen E-Mails verschicken können.

Sicherheit: In Prod den Datei-Editor deaktivieren (DISALLOW_FILE_EDIT in wp-config)
GitHub
, sicherstellen, dass keine Standard-Accounts wie "admin" aktiv sind, Passwörter stark etc. (Teils über Doku-Empfehlungen prüfen).

Analytics/Tracking: Falls Matomo/GA eingebunden werden sollen, vor Launch Code-Snippet einfügen oder Tag Manager einrichten, um ab Tag X Daten zu sammeln
GitHub
.

Nach dem Launch:

Engmaschiges Monitoring der Seite in den ersten Tagen: Error-Logs beobachten
GitHub
, PHP-Warnings oder JS-Fehler auswerten und schnell beheben. Auch WooCommerce Logs (z.B. Webhook-Fehler) prüfen, falls genutzt.

Performance nach Launch erneut testen (Production-Umgebung kann sich anders verhalten durch Server, CDN etc.). Ggf. Nachoptimierungen vornehmen (z.B. wenn realer Traffic zeigt, dass bestimmter Query langsam ist, diesen cachen).

Nutzerfeedback einholen: Sowohl vom internen Team (Redakteure, Kurs-Admins) als auch von einigen Endnutzern. Vielleicht einen Soft-Launch machen oder ausgewählten Lesern Zugriff geben, um UI/UX-Feedback zu sammeln.

Backlog erstellen für aufgefallene Kleinigkeiten: z.B. "Tooltip beim Überfahren von X fehlt" oder "Mobile Darstellung von Y könnte besser sein". Diese Punkte dann in den Wochen nach dem Launch iterativ abarbeiten.

Falls nicht schon getan, Routine-Wartung etablieren: z.B. Update-Strategie für Plugins/Core definieren, regelmäßige Backups, Monitoring (ein Uptime-Monitor und evtl. eine kleine Alerting-Integration für Fehler).

Ausblick

Mit dem erfolgreichen Relaunch verfügt Beyond Gotham über eine moderne, eigenständige Website, die investigativen Journalismus, Weiterbildung und Produktangebot unter einer konsistenten Benutzeroberfläche vereint. Zukünftig bieten sich diverse Weiterentwicklungen an, um die Plattform noch leistungsfähiger zu machen:

Erweiterte Shop- und Kurs-Funktionen: Perspektivisch könnte man Kurse direkt im Shop buchbar machen (Integration von WooCommerce mit dem Kurs-CPT, inkl. Online-Zahlung für Kursteilnahme). Auch der Verkauf weiterer digitaler Inhalte (exklusive Recherchen, Datenpakete) ist denkbar.

Neue Content-Formate: Entwicklung zusätzlicher Gutenberg-Blöcke oder Custom-Post-Types für spezielle Inhaltselemente, z.B. interaktive Timelines, Infografiken oder ein Team-Mitglieder-CPT für die Redaktion.

Automatisierung & Testing: Einführung automatisierter Tests (z.B. End-to-End-Tests für das Anmeldeformular und den Checkout)
GitHub
, um die Stabilität bei künftigen Updates zu gewährleisten. Zudem könnte Continuous Deployment mit Staging eingeführt werden, um Änderungen vorab zu prüfen.

Performance & SEO Optimierungen: Kontinuierliches Tuning der Ladezeiten (z.B. Einführung eines CDN, Bildoptimierung, HTTP/3) und Ausbau der SEO-Strategie (strukturierte Daten für Artikel, verbesserte Meta-Beschreibungen, eventuell ein SEO-Plugin nutzen) gehören zum kontinuierlichen Verbesserungsprozess.

Feedback und Analytics nutzen: Anhand von Nutzerstatistiken (Absprungraten, meistgelesene Artikel, Conversion-Rate im Shop) und Feedback das Angebot weiter anpassen. Vielleicht ergibt sich Bedarf für zusätzliche Kategorien oder Features (z.B. ein Forum für die Community, falls passend).

Dieser Plan dient als Entwickler-Dokumentation und Referenz für die Umsetzung des Beyond Gotham Relaunchs. Die einzelnen Meilensteine und Aufgabenpakete können nun gezielt abgearbeitet oder an Entwickler (bzw. KI-Codex/Claude-Prompts) weitergereicht werden, um die Realisierung Schritt für Schritt voranzutreiben. Am Ende steht ein zukunftsfähiges WordPress-Theme, das alle vorhandenen Stärken nutzt und die neuen Anforderungen bestmöglich umsetzt – eine robuste Basis für Beyond Gothams weiteres Wachstum
GitHub
.
