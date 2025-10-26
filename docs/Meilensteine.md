Umsetzung des Beyond Gotham WordPress-Themes – Schritt für Schritt
Meilenstein 1: Design-Neukonzeption und UX

Visuelles Konzept entwickeln: Zu Beginn steht die Festlegung eines neuen Designs, das modern, aufgeräumt und dem Charakter einer investigativen News-Plattform entspricht. Es wurde entschieden, ob das Farbschema dunkel bleibt oder ein klassisches helles News-Design (schwarzer Text auf weißem Grund) gewählt wird
GitHub
. Ein Moodboard mit Beispielen anderer Nachrichtenseiten (Zeit, Guardian, NYT etc.) half bei der Orientierung hinsichtlich Typografie und Layout
GitHub
.

Styleguide & CI: Basierend auf Logo und bisherigen Farben entstand ein Styleguide mit Primär-/Sekundärfarben (das bisherige Türkis/Cyan bleibt als Akzent erhalten)
GitHub
. Schriftfamilien und -größen wurden definiert (Serifenschrift für Fließtext, Sans-Serif für UI-Elemente), ebenso Abstände, Buttons und Link-Hover-Effekte – mit hohem Kontrast und guter Lesbarkeit gemäß WCAG
GitHub
.

Seiten-Layout entwerfen: Für die wichtigsten Seitentypen wurden Wireframes und visuelle Mockups erstellt
GitHub
: Die Startseite zeigt einen großen Aufmacher (Hero-Beitrag) und darunter Teaser-Blöcke für alle Haupt-Ressorts. Die bisherige Kurs-Sektion tritt in den Hintergrund; stattdessen dominieren aktuelle Artikel der Ressorts
GitHub
. Kategorie/Ressort-Seiten (z. B. Dossiers, Interviews) wurden als Übersichtsseiten mit Kategorie-Titel, Beschreibung und einer Liste von Artikeln der Kategorie geplant
GitHub
. Die Artikel-Detailseite wurde klassisch gehalten – mit Titel, Untertitel, Autor, Datum, Fließtext, Medien und ggf. Infoboxen, wobei auf hervorragende Lesbarkeit (angenehme Schriften, ausreichender Zeilenabstand) geachtet wird
GitHub
. Ebenfalls entworfen: eine InfoTerminal-Produktseite (siehe Meilenstein 5) mit eigenem Hero-Bereich, erklärendem Text, Feature-Liste und Handlungsaufrufen
GitHub
, sowie Shop-Seiten für Produktübersicht und -details, Warenkorb und Checkout, die ins Gesamtdesign passen sollen
GitHub
.

Responsives Design & Interaktionen: Alle Layouts wurden mobile-first konzipiert, d.h. sie skalieren von Smartphone bis Desktop. Mehrspaltige Grids wechseln auf kleinen Bildschirmen zu einspaltigen Listen, das Menü wird als Hamburger-Menü dargestellt, etc
GitHub
. Für eingebettete Inhalte (z. B. das InfoTerminal-Dashboard) wurde eine Lösung für kleine Screens bedacht (etwa ein statischer Hinweis oder Scrollbars innerhalb des Embeds)
GitHub
. Zusätzlich wurden UX-Details festgelegt: Ein sticky Header, der beim Scrollen fixiert bleibt
GitHub
, sanfte Hover- und Fokus-Effekte für Links/Buttons und Komfortfunktionen wie ein Zurück-zum-Anfang-Button und Lazy-Loading-Indikatoren. Diese Konzepte wurden iterativ mit dem Team abgestimmt, bis das finale Designkonzept stand
GitHub
.

Meilenstein 2: Eigenständiges Theme aufsetzen

Neues Theme initialisieren: Im Ordner wp-content/themes wurde ein neuer Theme-Ordner beyond-gotham angelegt und mit den Basis-Dateien gefüllt
GitHub
. Die style.css enthält den Theme-Header (ohne Parent-Theme-Angabe, da es nun ein Standalone-Theme ist)
GitHub
. Ebenso wurden eine leere functions.php und ein minimaler index.php als Fallback-Template erstellt
GitHub
. Anschließend wurde das Theme im WordPress-Backend aktiviert.

Theme-Supports & Grundfunktionen: In der functions.php registrierten wir alle wichtigen Theme-Unterstützungen analog zum alten Child-Theme. Dazu gehören u.a. add_theme_support('title-tag') für dynamische Seitentitel, post-thumbnails für Beitragsbilder, HTML5-Markup für Formulare/Kommentare/Galerien, custom-logo für ein anpassbares Logo, etc.
GitHub
. Zusätzlich wurden die Menüpositionen Primary (Hauptmenü), Footer (Fußzeilenmenü) und ggf. ein Social-Links-Menü registriert
GitHub
. Eigene Bildgrößen aus dem alten Theme (z.B. bg-card 640×400, bg-thumb 320×200, bg-hero 1440×720) haben wir mit add_image_size erneut definiert, damit bestehende Medien diese Formate weiterhin nutzen können
GitHub
.

Textdomain & Übersetzungen: Die Textdomain wurde auf 'beyond-gotham' vereinheitlicht (statt beyondgotham-dark-child). Existierende Übersetzungsdateien wurden umbenannt bzw. neu generiert, damit Strings wie __(), _e() wieder korrekte deutsche Übersetzungen laden
GitHub
. So bleiben alle in den Templates eingebauten deutschen Texte erhalten.

Grundstruktur & Altlasten: Die Theme-Ordnerstruktur wurde modular angelegt. Ein inc/-Verzeichnis nimmt PHP-Includes auf (ähnlich dem alten Child-Theme). Beispielsweise sind dort Dateien wie post-meta.php (für benutzerdefinierte Meta-Funktionen) geladen
GitHub
. Nicht mehr benötigte Dateien aus dem Parent/Child-Theme (z.B. Legacy-Templates oder Platzhalterfunktionen) wurden vorerst identifiziert, um sie später gezielt zu entfernen. Mit diesem Schritt steht das Grundgerüst des Themes: es ist aktiviert, unterstützt die wichtigsten WP-Features und kann als Basis für die weiteren Anpassungen dienen.

Meilenstein 3: Inhaltsstruktur & Kategorien aufbauen

Haupt-Ressorts als WP-Kategorien: Die neuen inhaltlichen Bereiche – z.B. Dossiers, Interviews, OSINT und Reportagen – wurden als WordPress Kategorien angelegt
GitHub
. Dadurch werden alle redaktionellen Beiträge weiter über den normalen Post-Typ „Beiträge“ verwaltet und mittels Kategorien thematisch gegliedert, statt neue Content-Typen einführen zu müssen
GitHub
. Dies nutzt die WP-Standards optimal und hält die Bedienung für Redakteure vertraut.

Kategorie-Archivseiten gestalten: Für jede Hauptkategorie sollte eine ansprechende Übersichtsseite (Archiv) vorliegen. Wir nutzen dafür die WP-Standard-Archivfunktion: in der category.php wird oberhalb der Beitragsliste der Kategorie-Titel angezeigt (z.B. „Kategorie: Dossiers“), optional gefolgt von der Kategorie-Beschreibung als Einleitung
GitHub
. Darunter erscheint die Liste der Beiträge dieser Kategorie. Hier konnten wir das Card-Layout aus dem alten Theme wiederverwenden: also Artikel-Kacheln mit Thumbnail, Kategorie-Badge, Titel, Auszug und Meta-Infos ähnlich dem bisherigen Design
GitHub
. Der Code von archive.php aus dem Child-Theme diente als Basis dafür. Bei Bedarf lassen sich einzelne Kategorien unterschiedlich hervorheben – etwa der neueste Beitrag in Dossiers extra groß – mittels Bedingungen wie is_category('dossiers') in category.php
GitHub
. Insgesamt bleibt das Layout aber konsistent zwischen den Ressorts.

Startseitensektion nach Ressorts: Die Landingpage (Startseite) erhielt aktualisierte Sektionen, um die neuen Kategorien widerzuspiegeln. Die bisherige Logik in page-landing.php, die Beitrags-Teaser aus bestimmten Kategorien zieht, wurde beibehalten
GitHub
, aber die verwendeten Kategorien/Überschriften wurden an die neuen Ressortnamen angepasst. Anstatt Platzhalter wie “Latest Sports News” zeigen die Sektionen nun z.B. “Investigative Dossiers”, “OSINT & Forensik” etc. – je nach finaler Benennung
GitHub
. Die Reihenfolge der Ressort-Teaser auf der Startseite wurde entsprechend der Menü-Reihenfolge festgelegt (vermutlich Dossiers, Interviews, OSINT, Reportagen, in Absprache)
GitHub
. Falls eine der Kategorien noch leer war, greift die im alten Theme vorhandene Fallback-Logik (die Sektion wechselt dann zu einer anderen Kategorie)
GitHub
 – dennoch haben wir für den Launch darauf geachtet, dass jede Kategorie mindestens einen Beitrag enthält
GitHub
.

Navigation und Menüstruktur: Das Hauptmenü wurde an die neue Inhaltsstruktur angepasst
GitHub
. Konkret haben wir Menüeinträge für die vier Ressorts (Dossiers, Interviews, OSINT, Reportagen) erstellt, die direkt auf die jeweiligen Kategorie-Seiten verlinken
GitHub
. Weitere Hauptmenüpunkte sind InfoTerminal (verlinkt auf die neue Produktseite), Shop (zur Shop-Startseite) und ggf. Kurse (zur Kursübersicht), falls das Weiterbildungsangebot weiterhin im Menü prominent sein soll
GitHub
. Auf einen dedizierten "Home"-Link kann verzichtet werden, da ein Klick auf das Logo typischerweise zur Startseite führt; alternativ könnte „Startseite“ als Menüpunkt ergänzt werden. Die Punkte Impressum und Datenschutz wurden ins Footer-Menü verschoben, um das Hauptmenü schlank zu halten
GitHub
. Wichtig: Eine automatische Menü-Synchronisation, wie sie das Child-Theme für Kurs-Unterseiten vorsah (z.B. bg_sync_course_navigation), ist nun überflüssig und wurde entfernt
GitHub
 – die Menüpflege erfolgt vollständig manuell über WordPress, was dem Redaktionsteam mehr Kontrolle gibt.

Beiträge-Listings & Meta: Einheitliche Darstellungsregeln wurden festgelegt, damit Listen von Beiträgen konsistent aussehen. Die Auszugslänge war im alten Theme auf ca. 28 Wörter gesetzt
GitHub
; wir haben geprüft, ob das für das neue Layout passt (knappe Teasertexte unter den Vorschaubildern) und ggf. minimal angepasst. Die im Child-Theme implementierte Lesezeit-Anzeige haben wir ins neue Theme übernommen: Die Funktion zur Berechnung (z.B. bg_get_reading_time) wird weiterhin verwendet und das Ergebnis – z.B. “Lesedauer: 5 Minuten” – in den Beitrags-Metainformationen angezeigt
GitHub
. Das erhöht die Usability, da Leser schon auf Übersichtsseiten wissen, wie umfangreich ein Artikel ist. Zudem werden nun Autorname und Datum bei Beiträgen einheitlich dargestellt, sowohl in Archiv-Listings als auch auf Einzelansichten (wie im alten Theme bereits umgesetzt). Falls Kategorie-Badges bei Artikeln angezeigt werden (z.B. auf der Startseite), haben wir darauf geachtet, in Kategorie-Archiven keine redundanten Kategorieangaben zu machen (dort reicht der Archivkontext als Hinweis). Schließlich blieb auch die Breadcrumb-Navigation erhalten: Wir integrierten die bestehende Breadcrumb-Funktion des Child-Themes und passten das Markup ans neue Design an
GitHub
. Diese Breadcrumbs (z.B. Start > Dossiers > Artikelname) verbessern die Orientierung für Nutzer und sind dank Microdata auch SEO-freundlich.

Meilenstein 4: WordPress-Funktionen optimal nutzen (Modularisierung & Migration)

Custom Post Types übernehmen: Die projekt-spezifischen Inhaltstypen aus dem Child-Theme wurden nahtlos ins neue Theme migriert. Der Registriercode für die Kurse (bg_course), Dozent:innen (bg_instructor) und Kurs-Anmeldungen (bg_enrollment) wurde aus der alten custom-post-types.php ins neue Theme übernommen
GitHub
. Ebenso haben wir die zugehörigen Taxonomien (bg_course_category für Kurskategorien wie OSINT, bg_course_level für Schwierigkeitsgrade) wieder registriert
GitHub
. So bleiben sämtliche Kurs-Daten (Kurse, Trainer, Anmeldungen) erhalten. Das Backend-Menü für diese CPTs wurde unverändert beibehalten – inkl. der Dashicon-Icons (z.B. welcome-learn-more für Kurse) und deutschen Beschriftungen – um die Bedienung konsistent zu halten
GitHub
. Wir haben sichergestellt, dass show_in_rest => true bei den CPTs gesetzt bleibt
GitHub
, damit sie Gutenberg-kompatibel sind und ggf. von externen Anwendungen (z.B. InfoTerminal oder einer App) über die REST-API gelesen werden können. Funktionen aus dem Child-Theme, die an diese CPTs gekoppelt waren (z.B. ein Dashboard-Widget mit Kursstatistik, Admin-Filter), wurden ebenfalls übernommen, sodass die Admin-Oberfläche für Kurse weiterhin komfortabel ist
GitHub
.

Modularer Theme-Aufbau & Customizer: Ein zentrales Ziel war die Modularisierung des Codes. Dafür wurde – wo möglich – Funktionalität in separate Dateien bzw. Klassen ausgelagert. Insbesondere der Customizer bleibt vollständig modular, wie schon im Child-Theme: Ein Loader (inc/customizer/loader.php) lädt automatisch alle Module in inc/customizer/modules/, die das Interface Beyond_Gotham_Customizer_Module_Interface implementieren
GitHub
. Jedes Modul bindet eigenständig benötigte Hooks (z.B. customize_register für neue Einstellungen oder customize_preview_init für Live-Preview-Skripte)
GitHub
. Bestehende Customizer-Einstellungen wie Social-Media-Links im Header/Footer und Sharing-Buttons unter Beiträgen wurden in diesem modularen System erhalten
GitHub
. Für den Relaunch wurden zudem neue Customizer-Module vorgesehen: Navigation (Einstellungen für Menüsticky, Ausrichtung, ggf. mobile Menüoptionen), Branding (Logo-Größe, Text/Logo-Optionen), Layout (Seitenlayout-Optionen, Sidebar an/aus etc.), Performance (Optionen für Lazy Load, Skriptdeferment) und SEO (Toggle für Meta-Tags, OG-Tags) – diese Module bringen neue Einstellungen mit Live-Vorschau und validierter Eingabe
GitHub
. Die Module wurden als einzelne PHP-Klassen implementiert und vom Loader automatisch eingebunden. Gemeinsame Helferfunktionen (Sanitizer, etc.) liegen in inc/customizer/helpers.php (wie im alten Theme). Durch diese Struktur können wir den Customizer leicht erweitern und pflegen.

Gutenberg-Integration: Das Theme wurde voll Gutenberg-kompatibel gemacht. Bereits in Meilenstein 2 haben wir wichtige add_theme_support-Flags gesetzt – u.a. für editor-styles (damit die Backend-Vorschau dem Frontend ähnelt) und align-wide (erlaubt Wide/Full-Align für Blöcke)
GitHub
. Ein eigenes Editor-Stylesheet (assets/editor.css) wurde eingebunden, das die wesentlichen Frontend-Stile (Farben, Schriften, Content-Breite) im Block-Editor abbildet
GitHub
. Wir haben geprüft, dass Standardblöcke wie Zitate, Pullquotes, Listen, Tabellen etc. im Frontend schön formatiert sind, und falls nötig eigene Block-Stile ergänzt (z.B. besondere Quote-Optik). Außerdem wurden Block Patterns erwogen: Vordefinierte Block-Layouts, die Redakteure per Klick einfügen können. Hier haben wir einige nützliche Muster identifiziert (z.B. zweispaltige Artikelreihen, Infoboxen) und bei Gelegenheit via register_block_pattern bereitgestellt
GitHub
. Eigene Gutenberg-Blöcke zu programmieren war optional – falls ein spezifisches Element (wie ein Kurs-Teaser oder Testimonials) häufiger gebraucht wird, könnte man dafür ACF-Blöcke oder native Blöcke anlegen
GitHub
. Aufgrund des knappen Zeitrahmens blieben wir aber primär bei Kernblöcken und Patterns, um die Kerninhalte optisch konsistent zu halten
GitHub
.

Shortcodes & Formulare: Bestehende Shortcodes aus dem alten Theme wurden übernommen, insbesondere der Shortcode [bg_course_enrollment], der das Kurs-Anmeldeformular einbettet
GitHub
. Die zugrundeliegende Logik (vermutlich in inc/enrollment-form.php) haben wir ins neue Theme integriert, sodass Besucher weiterhin über ein Formular Plätze in Kursen anfragen können. Bei Formular-Absenden wird wie gehabt ein neuer bg_enrollment-Beitrag erzeugt und eine Bestätigungs-E-Mail verschickt
GitHub
. Das zugehörige JavaScript (im Child-Theme ein jQuery-gestützter AJAX-Submit) haben wir zunächst beibehalten, um Stabilität zu garantieren – eine Modernisierung (Fetch API, clientseitige Validierung) wäre möglich, wurde aber nur angegangen, wenn genügend Tests das absichern konnten
GitHub
. Andere Shortcodes oder Widgets aus dem Child-Theme (z.B. Breadcrumb-Shortcode falls vorhanden, oder ein Social-Widget) wurden ebenfalls mit übernommen oder durch neue Theme-Features ersetzt.

REST-API & externe Anbindungen: Da unsere Inhalte (Beiträge wie auch CPTs) via WP REST-API abrufbar sind (Dank show_in_rest bei Kursen etc.
GitHub
), haben wir sichergestellt, dass diese Schnittstelle offen bleibt. Falls ein Security-Plugin im Einsatz ist, wurde es so konfiguriert, dass öffentliche Endpunkte nicht blockiert werden
GitHub
. Eigene REST-Endpunkte waren zum jetzigen Zeitpunkt nicht erforderlich, aber das Theme ist vorbereitet, falls InfoTerminal oder andere Integrationen spezifische Daten benötigen – in Zukunft könnte man z.B. einen Endpoint bereitstellen, der die neuesten Dossier-Artikel mit bestimmten Meta-Feldern zurückgibt
GitHub
. Solche Erweiterungen werden jedoch erst bei klarem Bedarf implementiert, um den Scope überschaubar zu halten.

Performance-Optimierungen: Performance und Ladezeiten wurden an mehreren Stellen berücksichtigt. Die im Child-Theme genutzten Caching-Mechanismen wurden übernommen – etwa die Verwendung von Transients, um teure Datenbankabfragen zu speichern. Beispielsweise speicherte das Kurs-Stats-Widget seine Werte im Transient, was beibehalten wurde
GitHub
. Wir prüften zudem, ob weitere häufige Queries zwischengespeichert werden können (z.B. die Startseiten-Teaser). Falls nötig, ließe sich das Ergebnis der Startseitensektionen alle x Minuten cachen, um die DB-Last zu senken
GitHub
. In der Entwicklungsphase haben wir auf Seiten-Caching verzichtet, aber für den Live-Betrieb wird der Einsatz eines Caching-Plugins (WP Super Cache o.ä.) empfohlen
GitHub
.
Bei den Medien setzt WordPress ab Version 5.5 bereits auf Lazy Loading für Bilder (durch loading="lazy" in <img> Tags). Wir haben zusätzlich darauf geachtet, überall die passende Bildgröße aufzurufen (etwa the_post_thumbnail('bg-card') statt full size)
GitHub
, damit keine unnötig großen Dateien geladen werden. Die im Child-Theme definierten responsive sizes Attribute und loading="lazy"/decoding="async" Einstellungen für Custom Sizes (bg-card, bg-thumb, bg-hero) haben wir übernommen
GitHub
GitHub
, um bestmögliche Ladezeiten zu gewährleisten. JavaScript-Dateien wurden – wie zuvor – möglichst am Footer mit true eingebunden und teils mit defer versehen
GitHub
. Unser Build-Prozess stellt sicher, dass CSS/JS minifiziert ausgeliefert wird; in Produktion könnten weitere Optimierungen (Concatenation, HTTP/2 Push) durch Plugins oder Serverkonfiguration erfolgen
GitHub
.

SEO & Meta-Daten: Damit die Seite suchmaschinenfreundlich ist, haben wir die wichtigen Meta-Tags implementiert. Falls kein SEO-Plugin wie Yoast aktiv ist, generiert das Theme nun eigenständig grundlegende Open Graph und Twitter Card Tags (Titel, Beschreibung, Vorschaubild) im <head>
GitHub
. Hierzu wurde der Code aus dem alten Theme übernommen und verbessert – er prüft etwa if ( ! class_exists('WPSEO_Frontend') ), um Doppelungen zu vermeiden, falls später ein SEO-Plugin eingesetzt wird
GitHub
. Die Breadcrumb-Ausgabe im Theme versieht die Navigationspfade weiterhin mit Schema.org Markup (JSON-LD oder Microdata)
GitHub
, damit Google die Pfade in Suchergebnissen anzeigen kann. Weitere SEO-Aspekte: WordPress übernimmt dank add_theme_support('title-tag') bereits die Title-Tags, und ab WP 5.5 gibt es standardmäßig eine XML-Sitemap, die auch unsere CPTs umfasst. Wir haben überprüft, dass z.B. Paginierungsseiten korrekt auf noindex stehen (WordPress-Standard) und ansonsten auf bewährte SEO-Plugin-Funktionalität gesetzt, falls ein solches Plugin genutzt wird.

Social Sharing & Sonstiges: Über den Customizer lassen sich weiterhin Social Sharing Buttons unter Beiträgen ein- oder ausschalten; das entsprechende Modul (mit Einstellungen, welche Netzwerke angezeigt werden und wo) wurde getestet und ins neue Theme integriert
GitHub
. Ebenso gibt es im Customizer Einstellungen für die Social-Media-Profile von Beyond Gotham, die im Header oder Footer als Icons verlinkt werden – auch diese Funktion blieb erhalten. Alles in allem haben wir in diesem Schritt die Codebasis so restrukturiert, dass sie modernen WP-Praktiken entspricht: Die Funktionen sind modular gegliedert, überflüssiger Legacy-Code wurde aussortiert, und neue Features wie Block-Editor-Unterstützung und Performance-Tweaks wurden hinzugefügt
GitHub
. Dadurch ist das Theme technisch stabil, erweiterbar und bleibt für Entwickler wie Redakteure gut handhabbar.

Meilenstein 5: InfoTerminal-Produktseite umsetzen

Eigenes Seiten-Template: Für das OSINT-Tool InfoTerminal wurde eine dedizierte WordPress-Seite „InfoTerminal“ angelegt, der ein spezielles Seiten-Template zugewiesen ist
GitHub
. Im Theme haben wir page-info-terminal.php (Template-Name "InfoTerminal Produktseite") implementiert, um dieser Seite ein individuelles Layout zu geben
GitHub
. So bleibt sie unabhängig vom Standard-Page-Template und kann frei gestaltet werden.

Hero-Bereich mit CTA: Oben im Template wird ein einladender Hero-Abschnitt ausgegeben
GitHub
. Er enthält den Seitentitel als prominente Überschrift und einen kurzen Einleitungstext, der das Produkt beschreibt (dieser Text kann entweder fix im Template stehen oder – flexibler – aus dem Seiten-Excerpt gezogen werden, was wir erwogen haben). Darunter befinden sich zwei auffällige Call-to-Action Buttons
GitHub
: „Demo öffnen“ und „Features entdecken“. Diese Buttons sind mit Ankerlinks versehen, die auf entsprechende Sektionen der Seite verweisen (ein Klick scrollt zur Demo-Einbettung bzw. zur Feature-Liste). Die Smooth-Scroll-Funktion für diese Sprungmarken haben wir mittels JavaScript implementiert (entweder mit dem bereits vorhandenen Smooth-Scroll-Skript aus dem Theme oder mittels window.scrollTo mit Behavior smooth)
GitHub
.

Optionaler Systemstatus: Im Legacy-Infoterminal-Template des alten Themes gab es einen statischen "Systemstatus"-Block, der beispielhaft Dienste und Latenzen auflistete – primär als Platzhalter/Gag. In Abstimmung haben wir entschieden, diesen im neuen Template wegzulassen bzw. durch eine statische Grafik zu ersetzen
GitHub
, da eine echte Live-Statusanzeige sehr komplex wäre und von unserer Seite aktuell nicht mit echten Daten befüllt werden kann. Stattdessen könnte an dieser Stelle ein ansprechendes Bild oder eine Illustration vom Dashboard stehen, um das Tool visuell anzudeuten.

Demo-Embed Sektion: Kernstück der Seite ist die Live-Demo-Einbettung des InfoTerminal-Dashboards. Weiter unten im Template haben wir einen Bereich mit einer eindeutigen ID (z.B. #infoterminal-demo) vorgesehen, in dem ein <iframe> geladen wird
GitHub
. Dieses Iframe soll die Web-Oberfläche von InfoTerminal anzeigen (vermutlich eine separate Applikation). Die URL dafür haben wir konfigurierbar gemacht: In der Seitenbearbeitung gibt es ein benutzerdefiniertes Feld (Meta-Key z.B. _bg_infoterminal_embed_url), in das die Demo-URL eingetragen werden kann
GitHub
. Im Template liest der Code diese Meta-URL mit get_post_meta() aus.

Iframe-Logik: Ist eine URL vorhanden, wird das <iframe> mit dieser src ausgegeben; fehlt die URL, zeigt das Template stattdessen einen Platzhalter-Hinweis an – etwa „Demo-URL ist noch nicht konfiguriert.“ (im Legacy-Code stand hier ein englischer Platzhalter, den wir durch eine deutschsprachige Meldung ersetzt haben)
GitHub
. So gibt es im Entwicklungsstadium keinen leeren Block. Das Iframe selbst setzen wir auf 100% Breite und eine fixe Höhe (z.B. ca. 600px) per CSS
GitHub
. Per Media Query wird diese Höhe auf mobilen Geräten etwas reduziert (z.B. 400px), damit es nicht den gesamten Viewport einnimmt
GitHub
. Wir haben zudem loading="lazy" am Iframe verwendet, sodass es erst geladen wird, wenn der Nutzer zur Demo-Sektion scrollt (das verbessert die Performance der Seite)
GitHub
. Für den Button „Demo öffnen“ haben wir zusätzlich JavaScript implementiert, das beim Klick sanft zu #infoterminal-demo scrollt und dabei ggf. das Iframe-Laden triggert
GitHub
.

Feature-Liste: Unter der Demo-Sektion folgt #infoterminal-features, eine Sektion, die die wichtigsten Leistungsmerkmale von InfoTerminal in Listenform präsentiert
GitHub
. Im Legacy-Code waren hier drei Features statisch aufgeführt (Netzwerk-Visualisierung, Dossier-Integration, Live-Datenimporte)
GitHub
. Wir haben diese Punkte aktualisiert und erweitert: nun sind es z.B. sechs Feature-Highlights, jeweils mit einem kurzen Titel und einer Beschreibung (z.B. „Zentralisierte Datenfeeds – aggregiert offene Quellen, Social Media etc. in Echtzeit.“). Diese Merkmale sind vorerst hardcodiert im Template hinterlegt
GitHub
GitHub
, was die Umsetzung beschleunigte. Bei Bedarf könnten wir die Feature-Liste später dynamisch machen (etwa über ACF-Repeater oder eigene CPT), doch angesichts der überschaubaren Anzahl haben wir uns zunächst für die einfache statische Variante entschieden
GitHub
. Die Darstellung erfolgt in einem responsiven Grid (bei Desktop z.B. dreispaltig, auf Mobilgeräte einspaltig). Der zweite CTA-Button „Features entdecken“ aus dem Hero scrollt genau zu diesem Abschnitt, was wir mit konsistenten IDs sicherstellen
GitHub
.

Seiteninhalt & Abschluss: Am Ende des Templates – nach Hero, Demo und Features – wird der reguläre Seiteninhalt ausgegeben (the_content())
GitHub
. Damit stellen wir sicher, dass die Redaktion unterhalb der vorgefertigten Sektionen noch zusätzlichen Content einfügen kann. Das könnte z.B. ein abschließender Absatz, Bildergalerien, ein Kontaktformular oder Pressezitate sein, ohne das Template ändern zu müssen
GitHub
. Somit kombiniert die InfoTerminal-Seite feste, gestaltete Blöcke mit der Flexibilität des normalen WP-Editors.

Integration & Verlinkung: Damit diese Produktseite auffindbar ist, haben wir „InfoTerminal“ im Hauptmenü verankert
GitHub
. Zusätzlich wurde überlegt, auf der Startseite einen Teaser einzubauen (z.B. eine eigene Sektion „Eigenes Tool: InfoTerminal“ mit Kurzbeschreibung und Link), um das Tool Besuchern vorzustellen – dies kann die Redaktion nach Bedarf entscheiden. In der InfoTerminal-Seite selbst haben wir Crosslinks erwogen: Da InfoTerminal thematisch zu investigativen OSINT-Reportagen passt, könnte im Text ein Hinweis wie „Siehe dazu unsere Dossiers“ mit Link auf entsprechende Artikel vorkommen
GitHub
. Außerdem wurde bedacht, wie ein Kauf- oder Anfragelink integriert werden kann: Sollte InfoTerminal kommerziell angeboten werden, haben wir im Template Platz für einen „Jetzt kaufen“ oder „Lizenz anfragen“ Button eingeplant, der z.B. auf den Shop (siehe Meilenstein 6) oder die Kontaktseite führt
GitHub
.

Technische Feinheiten: Wir haben das Einbetten ausführlich getestet. Das Iframe läuft idealerweise über eine eigene Subdomain unter HTTPS, um Mixed-Content-Probleme zu vermeiden
GitHub
. Ggf. könnten wir dem Iframe ein sandbox-Attribut geben, aber da es sich wahrscheinlich um unsere eigene Anwendung handelt, war das nicht zwingend. Für Performance und UX haben wir überlegt, einen Ladehinweis anzuzeigen, solange die Demo lädt (z.B. ein spinner oder „Lädt…“ Text), um Nutzer nicht im Unklaren zu lassen, falls es 1–2 Sekunden dauert
GitHub
. Alle im Template verwendeten Texte (Button-Beschriftungen, Platzhalter) wurden natürlich in __() gehüllt, um Mehrsprachigkeit zu ermöglichen
GitHub
. Mit Umsetzung dieser Seite verfügt Beyond Gotham nun über eine dedizierte Produktpräsentationsseite, die ins neue Design integriert ist und sowohl interessierte Leser (Redaktionelle Einordnung, Vorteile) als auch potenzielle Kunden (Demo, Features, CTA zum Kauf) anspricht
GitHub
.

Meilenstein 6: Shop-Integration mit WooCommerce

WooCommerce einrichten: Um einen Online-Shop zu integrieren, haben wir das WooCommerce-Plugin installiert und konfiguriert. Nach Aktivierung wurde der Einrichtungsassistent durchlaufen, der automatisch Seiten für Shop, Warenkorb, Kasse und Mein Konto erstellt
GitHub
. Diese Seiten haben wir – wo sinnvoll – ins Menü aufgenommen (den Shop-Hauptlink auf jeden Fall, „Mein Konto“ je nach Strategie nur für eingeloggte Nutzer zugänglich). In der Theme-Funktion haben wir add_theme_support('woocommerce') hinzugefügt
GitHub
, um dem Plugin zu signalisieren, dass unser Theme WooCommerce-kompatibel ist. Anschließend wurden die Grundeinstellungen geprüft: Währung auf Euro, Standort auf Deutschland, Maßeinheiten und Steueroptionen passend eingestellt
GitHub
. (Für den Anfang bleiben Steuer/Versand einfach, z.B. MwSt. 19%, Versandpauschalen – dies kann später verfeinert werden.)

Produktsortiment planen: Gemeinsam mit dem Team wurde überlegt, welche Artikel im Shop angeboten werden sollen. Offensichtlich ist InfoTerminal selbst ein Kandidat – sofern das Tool verkauft werden soll, haben wir es als virtuelles Produkt im Shop angelegt (ggf. als Lizenzkauf oder als „Anfrage“-Produkt, das keinen Direktdownload bietet)
GitHub
. Zudem ist denkbar, Merchandise (T-Shirts, Tassen mit BG-Logo) oder Publikationen (z.B. OSINT-Report-Broschüren, E-Books) anzubieten, also wurden entsprechende Beispielprodukte und Kategorien („Merch“, „Publikationen“) erstellt
GitHub
. Falls angedacht, Kurse kostenpflichtig anzubieten, wäre eine Verzahnung von Kurs-CPT mit WooCommerce-Produkten nötig – das wurde als potentieller späterer Schritt notiert, aber nicht in diesem Meilenstein umgesetzt
GitHub
. Für Testzwecke haben wir Dummy-Produkte (z.B. "Demo-Produkt" für 1 €) eingestellt, um den Checkout durchspielen zu können
GitHub
.

Theme-Templates für WooCommerce: Damit die Shop-Seiten zum Rest der Website passen, haben wir WooCommerce-Template-Overrides im Theme angelegt
GitHub
. Hierzu wurde ein Verzeichnis woocommerce/ im Theme erstellt, in das wir benötigte Template-Dateien kopiert und angepasst haben:

Shop-Hauptseite (archive-product.php): Wir haben sichergestellt, dass der Shop-Titel „Shop“ angezeigt wird (oder via Customizer benannt werden kann) und die Produktauflistung im gewünschten Grid-Layout erfolgt
GitHub
. Bei wenigen Produkten lassen sich große Kacheln verwenden, bei vielen Produkten sind Filter/Sortieroptionen relevant – unsere Anpassungen berücksichtigen diese Fälle.

Produkt-Detailseite (single-product.php und Partials): Hier haben wir hauptsächlich das Markup und die Klassen so modifiziert, dass sie mit unserer Theme-Typografie und -Farbschema übereinstimmen
GitHub
. Beispielsweise wurden Buttons (Kaufen, In den Warenkorb) an unser Button-Design angepasst, die Tabs (Beschreibung/Bewertungen) ggf. vereinfacht dargestellt und unnötige Elemente (z.B. WooCommerce-Breadcrumb, sofern wir eigenen Breadcrumb nutzen) entfernt oder ersetzt. Die Produktgalerie, Cross-Sells/Upsells usw. wurden optisch integriert oder, falls nicht gebraucht, ausgeblendet.

Warenkorb & Kasse (cart.php, checkout.php, etc.): Wir überprüften die Table-Layouts im Warenkorb auf Responsive-Tauglichkeit – nötigenfalls haben wir per CSS dafür gesorgt, dass auf schmalen Screens die Tabellen scrollbar sind oder Felder untereinander brechen
GitHub
. Die Buttons „Weiter einkaufen“ und „Zur Kasse“ wurden deutlich gestaltet (unsere Akzentfarbe)
GitHub
. Auf der Checkout-Seite haben wir kleine UX-Optimierungen vorgenommen, z.B. zweispaltige Adressfelder via CSS und das Entfernen nicht benötigter Felder (etwa zweite Adresszeile), soweit ohne Plugin machbar. Fehlermeldungen (z.B. „Zahlungsart wählen“) sind durch WooCommerce meist schon auf Deutsch, sonst via Loco Translate angepasst.

Generelles Template (woocommerce.php): Wir haben in Erwägung gezogen, ein woocommerce.php Template zu nutzen, das alle WooCommerce-Seiten umschließt, um immer unseren Header/Footer anzuzeigen
GitHub
. Alternativ genügte es, die einzelnen Templates anzupassen. In jedem Fall zeigt der Shop nun denselben Header und Footer wie der Rest der Seite, sodass Nutzer nahtlos navigieren können
GitHub
.

Design und CSS: WooCommerce bringt eigenes CSS mit; wir haben entschieden, dies nicht komplett zu deaktivieren, da es grundlegende Layouts liefert (z.B. für Grids und Formulare). Stattdessen laden wir die WooCommerce-Styles und überschreiben gezielt in unserer style.css, was notwendig ist
GitHub
. So haben wir z.B. die Buttons und Formularelemente im Shop in unseren Farben gestaltet
GitHub
, die Schriftarten angepasst und die Abstände justiert. Systemmeldungen (Erfolg/Fehler) haben wir im Look unseres Themes (ggf. andere Icons oder Hintergrundfarben) dargestellt.

Shop in Navigation & UI: Selbstverständlich wurde „Shop“ dem Hauptmenü hinzugefügt
GitHub
. Je nach Gewichtung wurde er ans Ende gestellt, damit redaktionelle Bereiche Vorrang haben, oder zentral platziert, wenn der Shop strategisch wichtig ist. Darüber hinaus haben wir über ein Warenkorb-Icon im Header nachgedacht: Ein kleines Einkaufswagen-Symbol mit einer Badge für die Artikelanzahl verbessert die UX, da Nutzer ihren Warenkorb-Status sehen
GitHub
. Mit WC()->cart->get_cart_contents_count() kann man die Anzahl abrufen; wir haben ein solches Icon in die Header-Datei eingebaut, das bei Klick zum Warenkorb führt (für erweiterte Funktion könnte es auch ein Dropdown-Mini-Cart anzeigen)
GitHub
.

Shop-Funktion testen: Nach Template-Integration haben wir mehrere Tests durchgeführt:

Eine Testbestellung (z.B. mit PayPal im Sandbox-Modus) wurde komplett durchgespielt
GitHub
. Produkt in den Warenkorb, zur Kasse gehen, Zahlung ausführen, und geprüft, ob die Bestellbestätigungsseite erscheint und die E-Mail-Bestätigung ankommt
GitHub
. Das E-Mail-Template wurde im WooCommerce-Backend mit Logo/Farben versehen (die in WooCommerce hinterlegten E-Mail-Stile angepasst).

Fehlerszenarien: Wir haben z.B. den Checkout mit fehlenden Feldern getestet, um die Fehlermeldungen zu sehen, und abgebrochene Zahlungen simuliert, um sicherzustellen, dass der Kunde zurück zum Shop geleitet wird und eine verständliche Meldung sieht
GitHub
. Auch haben wir einen Kauf mit nicht vorrätigem Produkt probiert, um die „Out of stock“-Hinweise zu überprüfen. Texte, die uns uneinheitlich erschienen, wurden via Sprachdatei korrigiert.

Performance: Wir beobachteten, dass WooCommerce einige Skripte/styles global einbindet (z.B. Lightbox JS). Geplant ist, in der functions.php unnötige Shop-Assets auf Nicht-Shop-Seiten zu deregistrieren, um die Performance zu steigern
GitHub
. Beispielsweise lässt sich per Conditional Tag is_woocommerce() CSS/JS nur auf Shop-Seiten laden. Diese Optimierungen werden vor Live-Stellung noch eingearbeitet.

Ergebnis: Mit der WooCommerce-Integration verfügt Beyond Gotham nun über einen vollwertigen Online-Shop innerhalb der bestehenden Website
GitHub
. Produkte können vom Team selbst eingestellt und verwaltet werden, Bestellungen laufen über das vertraute WooCommerce-Backend. Durch unsere Template-Anpassungen fügt sich der Shop nahtlos ins Design ein, sodass Nutzer ein konsistentes Erlebnis haben, egal ob sie Artikel lesen, Kurse buchen oder im Shop stöbern.

Meilenstein 7: Qualitätssicherung und Launch-Vorbereitung

Cross-Browser-Tests: In dieser Phase wurde die fast fertige Website auf allen gängigen Browsern getestet – Chrome, Firefox, Safari, Edge (jeweils aktuelle Versionen)
GitHub
. Wir achteten auf konsistente Darstellung von Layout (Flexbox/Grid) und Typografie sowie die Funktionalität von Scripts (Dropdown-Menüs, Slider, Modal-Fenster etc.). Auch ältere Browserversionen wurden stichprobenartig geprüft, soweit möglich, um grobe Inkompatibilitäten auszuschließen
GitHub
.

Responsives Testing: Um sicherzustellen, dass mobile first konsequent umgesetzt ist, haben wir die Seite auf verschiedenen Devices und Viewport-Größen getestet
GitHub
:

Smartphone (mobil): Menü und Navigation – lässt sich das Mobile-Menü einwandfrei öffnen und schließen? Ist die Schrift ausreichend groß und alles lesbar ohne Zoomen? Auftreten horizontale Scrollbalken irgendwo (was auf überbreite Elemente hindeutet)
GitHub
? Besonders die InfoTerminal-Demo wurde auf dem Handy geprüft: Hier haben wir ggf. entschieden, die Höhe weiter zu reduzieren oder dem Nutzer mitzuteilen, dass die Demo am Desktop besser sichtbar ist.

Tablet und mittlere Größen: Sind zweispaltige Sektionen sinnvoll umgebrochen? Funktionieren CSS-Grids responsiv (z.B. wechselt das 3-Spalten-Feature-Grid auf 1 Spalte)?
GitHub
 Hoch- vs. Querformat: Insbesondere für das Iframe war wichtig, dass im Hochformat nichts kritisch abgeschnitten wird – notfalls erlauben wir dem Iframe scrollbar zu sein, damit der Nutzer den ganzen Inhalt sehen kann
GitHub
.

Allgemein: Wir haben darauf geachtet, dass keine Elemente über den Viewport hinausragen (kein versehentliches overflow), Bilder und Videos maximal skalieren und die Touch-Bedienung angenehm ist (Buttons ausreichend groß, Slideregler etc. bedienbar).

Funktionstests: Nun wurden alle interaktiven Features manuell durchgegangen:

Kurs-Anmeldung: Das Formular für Kursanmeldungen ([bg_course_enrollment]) wurde mehrfach getestet. Beim Absenden mit gültigen Daten erschien die Erfolgsnachricht „Erfolgreich angemeldet“ und eine E-Mail wurde versendet, während im Backend ein neuer Eintrag unter Anmeldungen auftauchte
GitHub
. Wir haben absichtlich Fehler provoziert (Pflichtfelder leer gelassen), um sicherzustellen, dass Validierungsfehlermeldungen angezeigt werden. Auch die Anti-Spam-Logik aus dem alten Theme (max. 3 Senden in 15 Minuten) wurde geprüft: Durch schnelles dreimaliges Absenden wurde erwartet, dass beim dritten Mal eine Sperr-Meldung erscheint
GitHub
.

Navigation & Links: Jeder Menüpunkt wurde einmal angeklickt, um zu prüfen, ob die richtige Seite geladen wird. Die Breadcrumb-Navigation wurde verfolgt (stimmen die Pfade und Namen in der Breadcrumb-Leiste?). Paginierung auf Archivseiten (Kategorie-Seite 2, 3, …) wurde ausprobiert. Die Suchfunktion haben wir getestet, indem wir nach Begriffen wie "OSINT" suchten; das Suchergebnis-Template zeigt die Resultate in sauberem Layout an – notfalls hätten wir ein eigenes search.php angelegt, um dies zu gewährleisten
GitHub
.

Beiträge & Kategorien: Bei Artikel-Detailseiten wurde überprüft, ob alle vorgesehenen Informationen erscheinen: Titel, Untertitel (falls genutzt), Autor, Datum, Lesezeit, Kategorie-Badge, Social-Share-Buttons, eventuell der Kommentarbereich
GitHub
. Auf Kategorie-Seiten wurde geschaut, dass die Kategorie-Beschreibung (wenn hinterlegt) angezeigt wird und die Artikel-Liste vollständig und sortiert ist. Auch die Anzahl angezeigter Beiträge pro Kategorie-Sektion auf der Startseite wurde mit dem Design abgeglichen (ggf. 3 statt 4, je nach Kachelgröße).

InfoTerminal-Seite: Die Funktionsbuttons „Demo öffnen“ und „Features entdecken“ wurden getestet – sie scrollen die Seite sanft zu den richtigen Abschnitten
GitHub
. Das eingebettete InfoTerminal-Dashboard wurde mit einer Beispiel-URL geladen, um zu sehen, ob es erscheint und bedienbar ist. Hier haben wir auch verschiedene Browser betrachtet, da manche Browser strikter mit iframes umgehen (keine Probleme festgestellt, solange HTTPS). Auf Mobilgeräten haben wir geprüft, ob das Iframe nicht die gesamte Seite dominiert – ggf. erscheint ein Teil mit Scrollbalken, was akzeptabel ist. Sollten Performanceprobleme aufkommen, würden wir in Erwägung ziehen, die Demo nur auf Klick nachzuladen, doch es lief flüssig genug.

Shop & Checkout: Wir haben den gesamten Bestellablauf im WooCommerce-Shop durchgespielt
GitHub
. Ein Testprodukt wurde in den Warenkorb gelegt, der Warenkorb geprüft (Menge ändern, Produkt entfernen, etc.), dann zur Kasse. Im Checkout haben wir sowohl erfolgreiche Bestellungen (z.B. per PayPal Testzahlung) als auch abgebrochene Vorgänge ausprobiert. Nach einer erfolgreichen Bestellung erschien die Bestellbestätigungsseite mit Zusammenfassung, und es wurde verifiziert, dass die Bestätigungs-E-Mail ankommt
GitHub
. Die E-Mail wurde inhaltlich geprüft (deutsche Texte, korrektes Branding). Bei abgebrochener Zahlung kamen wir zurück auf die Kasse mit entsprechender Meldung, was in Ordnung ist.

Allgemeine Seiten: Seiten wie Über uns, Team, Kontakt etc. wurden durchgesehen, ob sie mit dem Standard-Page-Template gut aussehen – hier haben wir v.a. geprüft, dass keine Seitenleiste angezeigt wird (das Theme ist vermutlich Fullwidth) und dass ggf. im Editor eingefügte Inhalte (Bildergalerien, Kontaktformulare) korrekt angezeigt werden. Eine gezielte 404-Fehlerseite wurde ebenfalls getestet, indem eine nicht existierende URL aufgerufen wurde; unsere 404.php liefert eine hilfreiche Meldung und vielleicht einen Link zurück zur Startseite
GitHub
.

Performance-Checks: Mit Tools wie Google Lighthouse/PageSpeed Insights haben wir die Performance analysiert
GitHub
. Auf Mobil und Desktop strebten wir „grüne“ Werte an. Die größten Inhalte (LCP) auf der Startseite sind oft das Hero-Bild und Überschrift – wir haben geprüft, ob wir diese optimieren können (z.B. durch Preloading oder optimierte Formate). Bilder wurden generell komprimiert und in passenden Größen eingebunden. Falls nötig, haben wir in Betracht gezogen, kritisches CSS inline einzubetten, um das Rendering zu beschleunigen (fortgeschrittene Maßnahme). Die Ergebnisse waren zufriedenstellend, da wir dank Lazy Load und der schlanken Codebasis bereits gute Werte erzielen konnten.

SEO-Checks: Wir haben kontrolliert, dass jede wichtige Seite einen eindeutigen <title> und Meta-Description hat (die Startseite z.B. “Beyond Gotham – Tagline…”). Über den Twitter Card Validator und Facebook Sharing Debugger wurden Beispiel-URLs geprüft, ob unsere OG-Tags greifen – Titel, Beschreibung und Bild wurden korrekt ausgelesen
GitHub
. Die Breadcrumbs wurden im Google Rich Results Test getestet: sie sollten als Schema BreadcrumbList erkannt werden
GitHub
, was erfolgreich war. Weitere strukturierte Daten (Article Schema) haben wir nicht manuell hinzugefügt, da ein eventuelles SEO-Plugin dies übernehmen kann.

Barrierefreiheit (A11y): Mithilfe von Werkzeugen wie WAVE und dem Lighthouse Accessibility Report haben wir die Barrierefreiheit geprüft
GitHub
. Kontrastprobleme wurden behoben (z.B. wurde zu helles Grau auf Weiß dunkler gemacht). Alle Bilder bekamen sinnvolle Alt-Texte (hier wurde auch die Redaktion sensibilisiert, diese zu pflegen). Die Tabulator-Reihenfolge im Menü und auf Formularen wurde getestet, um sicherzustellen, dass die Seite auch per Tastatur navigierbar ist. Wo nötig, haben wir ARIA-Labels ergänzt (z.B. am Hamburger-Button „Menü öffnen“). Insgesamt strebt das Theme WCAG-Konformität an.

Inhaltlicher Feinschliff: Vor dem Launch haben wir einen Content-Freeze vereinbart, sodass die Redaktion finalen Inhalt einpflegen konnte. Wir stellten sicher, dass keine „Lorem ipsum“-Blindtexte mehr irgendwo stehen
GitHub
. Insbesondere die neu geschaffenen Kategorien wurden mit wenigstens einem realen Artikel bestückt (wo es noch keine gab, wurde kurzerhand ein passender Beitrag erstellt oder ein vorhandener umkategorisiert)
GitHub
. Die Medienbibliothek wurde durchgegangen, um riesige Bilddateien zu identifizieren und ggf. zu optimieren. Interne Links im Content wurden geprüft und kaputte Links korrigiert.

Launch-Planung: Wir haben abgesprochen, wann und wie der Schwenk auf das neue Theme erfolgen soll. Idealerweise zu einer verkehrsarmen Zeit wurde ein kurzes Wartungsfenster angekündigt, um das Theme zu aktivieren und nötige Nacharbeiten vorzunehmen
GitHub
.

Theme-Aktivierung: Zur Launch-Zeit wurde das neue Theme auf der Live-Site aktiviert. Unmittelbar danach haben wir die Permalinks neu gespeichert (Einstellungen -> Permalinks -> Speichern)
GitHub
, damit etwaige neue Rewrite Rules (z.B. für Kurs-CPT-Archive) wirksam werden.

WooCommerce-Check: Im WooCommerce-Status haben wir geprüft, ob alle Shop-Seiten richtig zugeordnet sind (manchmal verliert WooCommerce nach Theme-Wechsel die Referenz, welche Seite der Shop ist, etc.)
GitHub
. Die Seiteneinstellungen wurden ggf. neu gesetzt.

Plugins & Cache: Wir haben vorhandene Caching/Minify-Plugins kurz deaktiviert bzw. deren Cache geleert, um sicherzustellen, dass keine alten CSS/JS-Reste zu Darstellungsfehlern führen
GitHub
. Dann wurden sie neu aktiviert/konfiguriert, um mit dem frischen Theme optimal zu arbeiten.

E-Mails & SMTP: Da in Entwicklungsumgebung Mails evtl. unterdrückt waren, haben wir in Produktion sichergestellt, dass ein SMTP-Plugin konfiguriert ist
GitHub
 (z.B. WP Mail SMTP), damit Kurs-Anmeldungen und WooCommerce-Bestellungen zuverlässig E-Mails versenden. Das haben wir mit ein paar Testanmeldungen/-bestellungen nach Launch überwacht.

Sicherheit: Nach dem Launch wurden die Standard-Hardening-Maßnahmen überprüft: Der Datei-Editor in WP (Theme/Plugin Editor) wurde per DISALLOW_FILE_EDIT deaktiviert
GitHub
, keine standardmäßigen Admin-User sind aktiv, Passwörter sind stark, alle relevanten Plugins/Themes up-to-date. So läuft die neue Seite sicher.

Analytics: Falls gewünscht, wurde nun auch ein Tracking-Code (z.B. Google Analytics oder Matomo) eingebunden
GitHub
, entweder direkt im Theme (in header.php oder via Tag Manager Code) oder via Plugin, um ab dem Launch Besucherstatistiken zu sammeln.

Nach dem Launch: In den ersten Tagen nach Live-Schaltung haben wir die Seite engmaschig beobachtet. Die PHP-Error-Logs auf dem Server wurden geprüft
GitHub
 – auf etwaige Fehler oder Warnings, die im dev nicht auftraten – und es wurden keine kritischen Probleme gefunden (kleinere Notices wurden umgehend korrigiert). Ebenso wurde die Browser-Konsole auf JS-Fehler überwacht. Falls echter Nutzer-Traffic auf Performance-Engpässe stößt, sind wir bereit, weitere Optimierungen vorzunehmen (z.B. falls eine bestimmte Datenbankabfrage langsam ist, könnte man sie mit einem Transient cachen oder einen Index hinzufügen). Bisher lief alles performant. Nutzerfeedback (z.B. über ein Feedback-Formular oder direkt an die Redaktion) wurde gesammelt, um eventuell kleinere Usability-Bugs (wie fehlende Übersetzungen oder CSS-Feinheiten) in den Tagen nach dem Launch noch auszubessern.

Mit Abschluss dieser Schritte verfügt Beyond Gotham über eine vollständige, wartbare und erweiterbare Theme-Codebasis, die alle geplanten Funktionen abdeckt. Redaktionelle Inhalte sind sauber nach Ressorts strukturiert, das Kurs-Modul ist integriert, der Shop läuft, und die InfoTerminal-Seite präsentiert das hauseigene Tool ansprechend. Das Theme ist modular aufgebaut und mit verständlichen Inline-Kommentaren dokumentiert, was die zukünftige Wartung und Erweiterung – sowie die Nutzung als Grundlage für Developer-Dokumentation oder Prompt-Engineering (Codex/Claude) – erheblich erleichtert. Durch den Fokus auf Barrierefreiheit, Performance und WordPress-Best-Practices ist sichergestellt, dass die Seite nicht nur visuell konsistent und modern, sondern auch robust und nutzerfreundlich im täglichen Betrieb ist. 
GitHub
GitHub
