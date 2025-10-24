Entwicklungsplan für die Beyond-Gotham Website
1. Analyse der bestehenden Codebasis

Die aktuelle Beyond-Gotham-Website läuft als WordPress 6.x Installation mit dem kommerziellen FreeNews Theme als Parent-Theme und einem eigenen Child-Theme namens “beyondgotham-dark-child”
GitHub
. Dieses Child-Theme ist in PHP 8 und modernem JS/SCSS geschrieben und erweitert WordPress um spezielle Funktionen für das Beyond-Gotham-Projekt. Wichtige Bestandteile der aktuellen Codebasis sind:

Custom Post Types (CPTs): Das Theme definiert drei eigene Beitragstypen – bg_course (Kurse), bg_instructor (Dozent:innen) und bg_enrollment (Anmeldungen) – inklusive zugehöriger Custom-Taxonomien (bg_course_category für Kurskategorien wie z. B. OSINT, und bg_course_level für Schwierigkeitsgrade)
GitHub
. Diese CPTs dienen der Verwaltung eines Kursangebots: Kurse mit Details (Dauer, Termine, Plätze, etc.), Dozentenprofile und Kurs-Anmeldungen. Entsprechende Meta-Boxen zur Eingabe dieser Felder sowie Anpassungen der Admin-Listen sind im Theme implementiert
GitHub
. Die CPTs sind von Anfang an REST-API- und Gutenberg-kompatibel (z.B. durch show_in_rest => true in der Registrierung)
GitHub
, was die Nutzung im Block-Editor und via WP-REST-API ermöglicht.

Landing Page & Vorlagen: Als Startseite gibt es ein spezielles Template “Landing Page” (page-landing.php). Diese Landingpage ist aktuell auf Conversion für die Weiterbildung zugeschnitten (Hero-Section mit Claim, Statistiken, Call-to-Action „Kurse entdecken“, Newsletter-Anmeldung, Social-Media-Links etc.). Zudem blendet die Landingpage bereits Inhalte in klassischem Nachrichten-Stil ein: Sie definiert mehrere Bereichs-Sektionen, die Beiträge aus bestimmten Kategorien anzeigen
GitHub
. Im Code sind hier z.B. Reportagen (slug: reportagen), Interviews (slug: interviews) und Dossiers (fallback: dossiers) als Kategorien vorgesehen
GitHub
. Dies deutet darauf hin, dass die Website neben Kursen auch redaktionelle Beiträge in diesen Kategorien einbindet – genau die Ausrichtung einer “klassischen Newspaper-Website”, die nun ausgebaut werden soll. Zusätzlich existieren Template-Dateien für eine Kursübersicht (page-courses.php) – welche Filter nach Kategorie, Level und Förderung für Kursangebote bietet – sowie für Kurs-Detailseiten (single-bg_course.php inklusive Anmeldeformular)
GitHub
. Standard-Templates wie archive.php und 404.php sind ebenfalls im Child-Theme vorhanden, während andere Templates (z.B. single.php für Blog-Beiträge) bisher vom Parent-Theme geerbt wurden.

Funktionalitäten & Scripts: In der functions.php des Child-Themes werden diverse Theme-Features registriert (u.a. Menüs, Thumbnails, Custom Logo)
GitHub
, sowie CSS/JS eingebunden. Auffällig ist, dass dabei das CSS des Parent-Themes FreeNews mit geladen wird
GitHub
 – das Child-Theme nutzt also das Styling des Parent-Themes als Grundlage und ergänzt eigene Styles (frontend.css) und Scripts (frontend.js und ui.js)
GitHub
. Weiter stellt das Theme u.a. Breadcrumb-Navigation, Anpassungen für Menü-Ausgabe, Lazy-Loading von Bildern, Open-Graph/Twitter-Meta-Fallbacks und ein Dashboard-Widget für Kurs-Statistiken bereit. Ein wesentlicher Bestandteil ist das AJAX-gestützte Anmeldeformular ([bg_course_enrollment] Shortcode), dessen Logik in inc/enrollment-form.php steckt
GitHub
: Dieses verarbeitet Frontend-Einsendungen, versendet Bestätigungs-E-Mails und verwaltet Wartelistenplätze für ausgebuchte Kurse.

Insgesamt befindet sich die Codebasis in einem fortgeschrittenen Zustand für das Weiterbildungsangebot. Für die geplante Neuentwicklung hin zu einer Nachrichten-/Magazin-Website mit zusätzlichen Seiten (Dossiers, Interviews, OSINT, Reportagen, Produktseite InfoTerminal und Shop) bedeutet dies, dass wir auf einem soliden Fundament aufbauen können. Wir müssen jedoch das Theme technologisch neu aufstellen, da das bisherige ein Child-Theme ist. Ziel ist es, ein eigenständiges Theme zu schaffen, das nicht mehr vom FreeNews-Parent abhängig ist und ein vollständig neu gedachtes Design umsetzt, während die vorhandenen Funktionalitäten (CPTs, Formular, etc.) sinnvoll integriert bleiben.

2. Design-Neugestaltung und UX-Konzept

Als erstes sollte ein neues Designkonzept für Beyond-Gotham erstellt werden, um die Seite modern, übersichtlich und dem Charakter einer hochwertigen Nachrichten-Plattform entsprechend zu gestalten. Bisher folgte das Design dem dunklen, editorialen Stil des FreeNews-Themes. Für den Relaunch ist zu entscheiden, ob weiterhin ein „Dark Theme” beibehalten werden soll oder ob ein helleres, klassisches Newsportal-Design (schwarzer Text auf weißem Hintergrund, klare Strukturen) besser passt – wichtig ist vor allem, dass die Seite „ordentlich und modern” wirkt und zur Marke Beyond Gotham passt.

Empfohlene Schritte im Designprozess:

Moodboard und Benchmarking: Beispiele für klassische Zeitungswebsites sammeln (z. B. Zeit, Guardian, NY Times oder moderne Magazine) und schauen, welche Elemente (Typografie, Layout-Raster, Farbgebung) für Beyond Gotham relevant sind. Beyond Gotham hat einen Schwerpunkt auf investigativem Journalismus, OSINT und Daten – das Design sollte diese Themen widerspiegeln (z. B. seriös und sachlich, aber mit modernen Akzenten).

Styleguide und CI: Basierend auf dem bestehenden Logo/Farbschema von Beyond Gotham einen Styleguide erstellen. Dieser definiert Farben (Primär-/Sekundärfarben, ggf. dunkler Hintergrundton falls beibehalten, Akzentfarben), Schrifttypen (gut lesbare Serif-/Sans-Serif-Kombination wie es für Zeitungen üblich ist), Abstände und UI-Elemente (Buttons, Links, Zitat-Styles etc.). Auch neue Icons (z.B. für Kategorien oder Social Media) können gestaltet werden, passend zum investigativen Thema.

Layout-Entwürfe (Wireframes bis Mockups): Für die wichtigsten Seitentypen sollten Wireframes gezeichnet und anschließend visuelle Mockups erstellt werden:

Landingpage (Homepage): Überblick über Top-Storys und aktuelle Artikel aus den verschiedenen Kategorien (Dossiers, Interviews, OSINT, Reportagen), sowie Highlights wie z.B. ein Aufmacher-Artikel mit großem Bild und Schlagzeile, Teaser für Unterbereiche, evtl. ein Bereich für Kursangebote falls diese weiterhin beworben werden sollen. Die bisherige Landingpage mit ihrem Hero für das Kursprogramm wird vermutlich umgestaltet zu einem News-Aufmacher, kann aber z.B. eine Sektion “Weiterbildung” behalten, nur weiter unten.

Kategorie-Seiten (Dossiers, Interviews, OSINT, Reportagen): Layout ähnlich einer Ressortseite bei einer Zeitung. Oben Titel des Bereichs, ggf. eine Beschreibung, dann Liste/Grid von Artikeln in dieser Kategorie (mit Bildern, Titeln, Auszügen). Evtl. können wichtige Artikel hervorgehoben angezeigt werden (z.B. der neueste Dossier-Artikel größer dargestellt).

Artikel-Detailseite (Single Post): Klassischer Artikel-Layout mit Titel, Autor, Datum, Haupttext, Bildern/Multimedia und ggf. Infoboxen. Hier sollte auch das Leseerlebnis optimiert werden (gute Typografie für lange Texte, Möglichkeit für Sidebars mit weiteren Infos, etc.).

InfoTerminal Produktseite: Design eines Produkt- oder Projekt-Showcase (siehe unten für Inhalt), vermutlich mit Hero-Section, Beschreibung, Screenshot/Embed der Anwendung, Feature-Liste, usw.

Shop-Seiten: Seiten für Shop-Übersicht (Produktliste) und Produktdetail, Warenkorb und Checkout im gleichen Look&Feel wie der Rest der Seite, obwohl sie technisch von WooCommerce geliefert werden (Designanpassung via Templates/CSS – siehe Shop-Integration).

Responsives Design: Alle Entwürfe sind so zu gestalten, dass sie auf verschiedenen Bildschirmgrößen funktionieren. Eine Nachrichtenwebsite wird viel auf Mobilgeräten gelesen – daher mobile-first denken: das Layout der Startseite und Kategorie-Seiten sollte auf Smartphones immer noch übersichtlich sein (z.B. Umschaltung von mehrspaltigem Grid zu einspaltiger Liste, Navigationsmenü als Burger-Menü etc.). Auch das InfoTerminal-Produkt (wenn z.B. ein eingebettetes Dashboard) muss mobil bedienbar sein, oder es wird für Mobilgeräte ein Hinweis gezeigt.

UX-Details: Geplante Interaktionen festlegen, z.B.:

Sticky-Header mit Navigationsmenü, der beim Scrollen sichtbar bleibt (im aktuellen Theme bereits als “bg-has-sticky-header” Body-Klasse berücksichtigt
GitHub
).

Klar sichtbare Suchfunktion (wichtig bei Nachrichtenseiten, evtl. als Lupe-Icon in der Navigation).

Breadcrumbs zur Orientierung (im aktuellen Theme schon vorhanden
GitHub
, sollte beibehalten werden für die Hierarchie Startseite > Kategorie > Beitrag).

Paginierung für Beiträge in Listen (auch hier existiert schon ein Template-Code für Pagination im Archiv
GitHub
).

Zugänglichkeit (accessibility): z.B. ausreichende Kontraste, Bildschirmleser-Texte für Icons, Fokus-States – einige davon wurden im aktuellen Theme beachtet (Skip-Link in Header
GitHub
, aria-label in Navs etc.), dies muss im neuen Design ebenfalls priorisiert werden.

Sobald diese Design-Aspekte abgestimmt und in Form von Mockups vorliegen, kann die eigentliche Theme-Entwicklung beginnen. Das neue Design fließt dann in CSS/SCSS-Styles und ggf. in die Struktur der Theme-Templates ein. Wichtig ist, das Designkonzept früh mit der Redaktion abzustimmen, damit z.B. Kategorie-Aufteilungen (Dossiers, Interviews etc.) und Seiteninhalte klar definiert sind, bevor entwickelt wird.

3. Eigenständiges WordPress-Theme aufsetzen

Statt weiterhin ein Child-Theme von FreeNews zu verwenden, wird nun ein eigenes Theme für Beyond-Gotham erstellt. Die Entwicklung startet mit dem Aufsetzen der Grundstruktur des Themes:

Neues Theme initialisieren: Im Verzeichnis wp-content/themes wird ein neuer Theme-Ordner angelegt, z.B. beyondgotham (oder beyondgotham-theme). Dort erstellt man die erforderlichen Basisdateien: style.css (mit Theme-Header und Basis-CSS), eine leere functions.php, sowie index.php als Fallback-Template. In der style.css sollte als Template kein Parent-Theme mehr referenziert werden, da es ein Standalone-Theme ist. Anschließend das Theme im WP-Backend aktivieren (es erscheint dann als eigenes Theme).

Theme-Features registrieren: In der neuen functions.php werden ähnliche Initialisierungen vorgenommen wie zuvor im Child-Theme, jedoch ohne Abhängigkeiten vom Parent:

Aufrufen von add_theme_support(...) für Dinge wie title-tag, post-thumbnails, html5 (für Formulare, Kommentare), custom-logo, etc., analog zu bisher
GitHub
.

Registrieren der benötigten Menü-Locations (Hauptmenü, Footer-Menü, Social-Links-Menü)
GitHub
.

Definieren benutzerdefinierter Bildgrößen (z.B. bg-card, bg-thumb, bg-hero wie im Child-Theme
GitHub
), falls weiterhin relevant fürs Layout.

Laden der Theme-Textdomain für Übersetzungen (bisher beyondgotham-dark-child), vermutlich umbenennen in beyondgotham und sicherstellen, dass Sprachdateien entsprechend angepasst werden.

CSS und JS einbinden: Da kein Parent-Theme mehr vorhanden ist, entfällt das Enqueueing des FreeNews-Styles. Stattdessen wird das neue Theme eigene Styles laden:

Man übernimmt den bisherigen SCSS/CSS-Code (frontend.css), passt ihn ans Redesign an und bindet ihn als Haupt-Stylesheet ein. In der functions.php z.B. via wp_enqueue_style('beyondgotham-style', get_stylesheet_directory_uri().'/assets/css/frontend.css', [], $version). (Die Einbindung des Parent-Styles freenews/style.css
GitHub
 wird entfernt.)

Ebenso überführt man die JS-Funktionen aus frontend.js und ui.js. Diese Dateien können ins neue Theme übernommen werden und ggf. umbenannt oder modularisiert werden. Mit wp_enqueue_script werden sie mit den nötigen Abhängigkeiten (jQuery falls benötigt) registriert
GitHub
. Wichtig: weiter bestehende Funktionalitäten wie das JavaScript für das Filterformular oder Smooth-Scroll etc. müssen wieder ausgeliefert werden. Auch das Lokalisieren von AJAX-URL und Texten (wp_localize_script('bg-frontend', 'BG_AJAX', {...})
GitHub
) sollte im neuen Theme beibehalten werden, damit das Kurs-Anmeldeformular und ähnliche AJAX-Features funktionieren.

Template-Dateien portieren: Im Child-Theme waren einige Templates bereits definiert (Landing Page, Kursübersicht, Kurs-Einzelseite, Archive, 404). Diese sollten in das neue Theme migriert werden:

Header und Footer: Im Child-Theme war header.php überschrieben, footer.php eventuell nicht (wenn nicht vorhanden, müsste man den Footer von FreeNews reproduzieren oder neu gestalten). Für das neue Theme erstellt man eigene header.php und footer.php nach den neuen Designentwürfen. Der Header enthält Logo/Site-Title, Navigationsmenü und ggf. Suche; der Footer enthält z.B. Copyright, Links (Impressum/Datenschutz), evtl. Newsletter-Feld oder Social-Links. Die bisherigen Child-Theme-Strukturen (z.B. Skip-Link, die Navigationsausgabe mit wp_nav_menu inkl. Social-Menu) können als Ausgangspunkt dienen
GitHub
GitHub
, aber werden optisch neu gestaltet.

Index- und Archiv-Templates: Ein index.php als Fallback wird benötigt – dieser kann ähnlich wie das aktuelle archive.php Beiträge in einem Grid oder einer Liste darstellen. Besser noch: individuelle Templates für Blog-Archiv (home.php oder index.php für die Posts-Seite) und Kategorie-Archiv (category.php) anlegen, um die Ausgabe für Kategorien feinzusteuern. Das Child-Theme hatte ein generisches archive.php für alle Archives (inkl. CPT und Kategorien)
GitHub
. Für mehr Kontrolle könnten wir separate Dateien anlegen, z.B. category-dossiers.php etc., falls bestimmte Kategorien abweichende Layouts bekommen sollen. Allerdings kann man vieles auch bedingt innerhalb category.php lösen (z.B. andere Überschrift oder Sektionstexte je Kategorie).

Seiten-Templates: Die spezialisierten Page-Templates aus dem Child-Theme werden übernommen und aktualisiert:

Landing Page: Übernehmen von page-landing.php und Anpassen an das neue Design. Die dort implementierte Logik für Abschnittsweise Anzeige von Kategorien
GitHub
 ist sinnvoll und kann bleiben – evtl. passen wir die Reihenfolge oder Benennung der Bereiche an (in Code standen “Latest Sports News” und “Local News” als Platzhalter-Titel
GitHub
, das werden wir in z.B. “Aktuelle Reportagen” etc. ändern). Die Section-Logik kann auch dynamischer gestaltet werden, etwa konfigurierbar via Customizer oder Options, aber initial ist Hardcoding ok. Wichtig: Die Landingpage wird vom WP-Admin als Startseite gesetzt (wie bereits dokumentiert
GitHub
).

Kursübersicht: page-courses.php wird ebenfalls übernommen. Dieser Template-Code bietet bereits Filter (per GET-Parametern) auf Kurskategorie, Level und Förderung und listet Kurse entsprechend auf
GitHub
GitHub
. Das kann größtenteils so bleiben, nur designmäßig anpassen (ggf. Filterschalter als Dropdowns im neuen Style etc.). Da das Kursmodul weiter genutzt werden soll (sofern Beyond Gotham weiterhin Weiterbildungen anbietet), ist es gut, diese Funktion zu erhalten.

Kurs-Detail: single-bg_course.php – enthält Kursbeschreibung und das Anmeldeformular (Shortcode). Auch das bleibt relevant, muss aber optisch ans neue Theme angepasst werden. Prüfen, ob wir ggf. Gutenberg-Blöcke in Kursbeschreibungen nutzen wollen; die CPT ist ja REST-fähig, daher blockfähig.

Sonstige Seiten: Im Repo liegen im Ordner legacy/ weitere Page-Templates (Impressum, Kontakt, Team, About, Projects, Infoterminal, Datenschutz). Diese deuten an, dass es statische Inhaltsseiten gab/gibt. Wir sollten für Impressum und Datenschutz keine eigenen Templates benötigen – eine normale WordPress-Seite reicht, Layout durch den Block-Editor. Kontakt/Team/About könnten als normale Seiten gepflegt werden, evtl. mit individuellen Blöcken statt separater PHP-Templates. Falls nötig, integrieren wir diese Inhalte ins neue Theme (z.B. Team-Seite via Custom Post Type “Team Member” oder einfach Gutenberg-Blöcke).

Parent-Theme Abhängigkeiten lösen: Einige Funktionen könnten bislang implizit vom FreeNews-Parent gekommen sein, z.B. globale Styles für die generelle Typografie, oder PHP-Funktionen. Wir müssen sicherstellen, dass im neuen Theme nichts Wichtiges fehlt. Konkret:

Alle Style-Regeln für Standard-HTML-Elemente (Body, Headers, Paragraphs, Lists, Forms) müssen im neuen Theme definiert sein, da wir das CSS neu schreiben oder vom Child übernehmen. Das Child-Theme-CSS frontend.css enthielt vor allem überschreibende Styles (z.B. .bg-card Klassen für Artikel-Kacheln, etc.), während Grundgerüst vom Parent kam. Daher ist es ratsam, ggf. im FreeNews-Theme nachzusehen, welche wesentlichen Layout-CSS-Klassen benutzt wurden, und diese ins eigene CSS zu übernehmen oder neu zu definieren.

Pagination, Search-Form, Comment-Form etc.: Der Child-Code ruft z.B. get_search_form() auf (das vermutlich auf ein FreeNews-Template zeigte)
GitHub
. Wir sollten eigene searchform.php im Theme haben, um die Sucheingabe zu kontrollieren (z.B. ein einfaches Formular mit Input und Button). Gleiches für Kommentare: ein comments.php Template, falls nötig, gestalten.

Widgets/Sidebars: Das aktuelle Theme nutzt eine Sidebar im Archiv (für Kategorienliste, neueste Beiträge)
GitHub
. In WordPress kann man Sidebars als Widget-Areas definieren. Für Flexibilität könnten wir z.B. eine Sidebar-Area registrieren und im Template füllen. Alternativ belassen wir es hardcodiert wie bisher (statische Ausgabe von Kategorien und “Neueste Beiträge”). Evtl. moderner: diese Sektionen als Block-Areas im Full-Site-Editing Sinn – aber da wir klassische PHP-Themes beibehalten, bleiben wir dabei.

Übersetzungen: Das Projekt scheint mehrsprachig vorbereitet (deutsche Strings mit __('txt','beyondgotham-dark-child')). Im neuen Theme ändern wir den Textdomain-Namen und stellen sicher, dass .pot/.mo Dateien aktualisiert sind. Dann funktionieren __() und esc_html_e() weiterhin.

Zusammengefasst besteht dieser Schritt darin, das Grundgerüst des neuen Themes vollständig zu erstellen und alle bisher vorhandenen Features eins zu eins (oder verbessert) zu integrieren, ohne dass irgendwo noch auf das FreeNews-Parent zurückgegriffen wird. Damit schaffen wir eine saubere Basis, um im nächsten Schritt die inhaltlichen Neuerungen anzugehen.

4. Inhaltsstruktur und Kategorien aufbauen

Ein Kernziel der Neuentwicklung ist, die Beyond-Gotham-Seite zu einer “klassischen Newspaper-Website” zu machen, was vor allem bedeutet: Klar gegliederte Inhaltsbereiche für unterschiedliche Berichtstypen. Konkret sollen die vier Kategorien Dossiers, Interviews, OSINT und Reportagen jeweils eigene Seiten bzw. Sektionen erhalten. Die Planung hierzu umfasst:

WordPress-Kategorien nutzen: Statt für jeden Bereich separate CPTs zu definieren, ist es sinnvoll, diese Begriffe als normale Kategorien im bestehenden WordPress-Posts-System zu führen. Das hat den Vorteil, dass alle Artikel zentral unter “Beiträge” erstellt werden, Redakteure kein neues System lernen müssen und die WP-Standards (Archive, RSS, Kategorien-Widgets etc.) genutzt werden können. Im Code ist schon angelegt, dass “Dossiers”, “Interviews” und “Reportagen” als Kategorien existieren bzw. vorgesehen sind
GitHub
. Diese Kategorien sollten wir im WP-Backend anlegen (falls nicht schon durch Demo-Inhalte geschehen) und ihnen ggf. Beschreibungen und Bilder zuweisen, falls für die Darstellung benötigt.

Kategorie-Seiten gestalten: Für jede dieser Hauptkategorien wird eine Seite analog einem Ressort gestaltet:

Im einfachsten Fall können wir die Kategorie-Archivseiten von WordPress verwenden (URL z.B. /category/dossiers). Diese greifen auf das Template category.php (oder spez. category-dossiers.php) zurück. Dort kann man den Kategorie-Namen als Überschrift ausgeben (the_archive_title() liefert z.B. “Kategorie: Dossiers”) und die Artikel-Liste darunter darstellen. Das Child-Theme-Archiv-Template zeigt bereits, wie pro Beitrag ein Card-Layout mit Thumbnail, Kategorie-Badge, Titel, Auszug und Meta (Datum, Lesezeit) realisiert wurde
GitHub
GitHub
. Das können wir wiederverwenden. Zusätzlich können wir auf Kategorie-Seiten evtl. einen Intro-Text anzeigen (category_description()), um den Bereich zu beschreiben.

Möglich ist es auch, anstatt der nativen Kategorie-Archive eigene Seiten mit individuellen Templates zu nutzen, um mehr Kontrolle über das Layout zu haben. Beispielsweise könnte man für die Startseiten der Ressorts eigene Page-Templates erstellen (ähnlich page-courses.php, aber für Beiträge). Doch das ist meist unnötig, da WP-Kategorien flexibel genug sind. Mit Conditional Tags im Template könnte man z.B. sagen: “Wenn Kategorie = Dossiers, dann anderes Layout (z.B. erster Artikel groß als Featured News, Rest in zwei Spalten)”. Falls also das Design vorsieht, dass z.B. Dossiers als Schwerpunkt lange investigative Artikel hat, könnte man diese anders listen als Interviews, kann man das im Code differenzieren.

Wichtig ist, dass auf der Startseite (Landingpage) schon Teaser zu diesen Kategorien vorhanden sind. Das macht das Template page-landing.php ja bereits: Es zeigt je Kategorie ein Karussell oder Grid der letzten Beiträge und einen “Mehr”-Link zur Kategorie-Seite
GitHub
GitHub
. Diese Logik bleibt erhalten. Wir werden nur die $landing_sections entsprechend final anpassen: vermutlich statt “Latest Sports News” (Platzhalter) kommt dort “OSINT/Forensik News” rein, und statt “Arts & Culture” z.B. “Interviews & Analysen” – das werden wir mit dem Redaktionsteam definieren. Technisch kann diese Sektion so bleiben, nur mit anderen Slugs/Titles.

Beiträge anlegen und migrieren: Falls bereits Inhalte existieren (z.B. Blogposts), sollten sie den neuen Kategorien zugeordnet werden. Außerdem sollten Beispiel-Artikel für jede Kategorie erstellt werden, um die Darstellung zu testen. Die Kategorien OSINT und Reportagen tauchen z.B. auch im InfoTerminal-Kontext auf – in der InfoTerminal-Seite wird erwähnt, dass alle Fälle über WP-Kategorien wie “Dossiers” oder “Reportagen” laufen
GitHub
. Das heißt, es gibt wahrscheinlich schon Posts, die diese Kategorien tragen (oder es ist zumindest konzeptionell vorgesehen). Wir sollten also die Datenbank prüfen bzw. vorbereiten: Kategorie-Taxonomie an Beiträgen prüfen, ggf. Inhalte zuordnen.

Custom Taxonomies vs. Kategorien: Beachte, dass im aktuellen Child-Theme die Taxonomie bg_course_category existiert (für Kurskategorien, mit Beispiel OSINT)
GitHub
. Nicht zu verwechseln: Diese Taxonomie bezieht sich nur auf Kurs-CPT und hat mit den redaktionellen Kategorien nichts zu tun. Im InfoTerminal-Template wird jedoch erwähnt, dass “Cases” jetzt über reguläre WP-Kategorien wie Dossiers/Reportagen laufen
GitHub
. Das bestärkt die Entscheidung, die redaktionellen Inhalte ganz normal als Beiträge in Standard-Kategorien zu behandeln, um sie auch für Tools wie InfoTerminal verfügbar zu machen. Die Custom Taxonomy bg_course_category bleibt separat für Kursangebote (dort könnte z.B. Werte wie “OSINT-Weiterbildung”, “Digitale Forensik” genutzt werden, wie im Code auto-angelegt
GitHub
).

Navigationsstruktur: Mit den neuen Kategorien sollte auch die Menüführung angepasst werden. Im Hauptmenü (Primary Navigation) sollten direkte Links zu Dossiers, Interviews, OSINT, Reportagen, InfoTerminal, Shop usw. vorhanden sein, damit Nutzer schnell in die jeweiligen Bereiche springen können. WordPress-Menüs kann man im Backend anlegen; das Theme unterstützt bereits ein primary Menü
GitHub
. Nach Theme-Aktivierung wird ggf. ein Menü neu erstellt/zugewiesen. Evtl. hilft es, im Theme-Setup sicherzustellen, dass die wichtigen Seiten automatisch im Menü landen. Das Child-Theme hatte dazu sogar eine Funktion bg_sync_course_navigation() um Kurs-Seiten ins Menü einzufügen
GitHub
GitHub
 – etwas Vergleichbares könnten wir für die Hauptkategorien nicht brauchen, da wir sie manuell verwalten können. Aber wir sollten dokumentieren, welche Menüpunkte vorgesehen sind:

“Home” (Startseite)

“Dossiers”, “Interviews”, “OSINT”, “Reportagen” (verlinkt auf Kategorie-Archive)

“InfoTerminal” (verlinkt auf die Produktseite)

“Shop” (verlinkt auf Shop-Übersicht)

Evtl. “Kurse” (wenn das Angebot weiter prominent sein soll, Link auf Kursübersicht /kurse/)

“Über uns” oder “Team” oder “Kontakt” falls gewünscht (Impressum/Datenschutz kommen eher ins Footer-Menü).

Beiträge präsentieren: Die neuen Kategorie-/Beitragsseiten sollen natürlich das neue Design widerspiegeln. Sobald Templates und Styling stehen, sollten wir exemplarisch prüfen, ob z.B. Auszüge passend gekürzt sind (im Code war excerpt_length je nach Kontext gefiltert: 28 Wörter für Posts/Archiv
GitHub
). Diese Filter können wir anpassen, falls Design längere/kleinere Teasertexte vorsieht. Auch die Lesezeit-Anzeige (bg_get_reading_time) ist ein nettes Feature des aktuellen Themes
GitHub
GitHub
, das wir übernehmen, da es Nutzerbindung erhöht. Das wird dann in Beitrags-Meta angezeigt (ist im Card und im Artikel vorgesehen
GitHub
).

Zusammenfassend planen wir hier die inhaltliche Gliederung so zu strukturieren, dass alle redaktionellen Inhalte über die vier Hauptkategorien laufen und attraktiv dargestellt werden. Das schafft die gewünschte Zeitungsoptik mit Ressorts. Die technischen Grundlagen (Kategorie-Archive, Template pro Kategorie oder bedingte Layouts) werden im neuen Theme gelegt, und die Redakteure können dann die Inhalte entsprechend einpflegen.

5. Nutzung von WordPress-Funktionen (CPT, Blöcke, REST)

Bei der Neuentwicklung bleiben wir nah an WordPress-Standards und -Funktionen, um Zukunftssicherheit und leichte Pflege zu gewährleisten. Insbesondere werden folgende Aspekte berücksichtigt:

Beibehaltung der Custom Post Types: Die bestehenden CPTs bg_course, bg_instructor, bg_enrollment werden ins neue Theme übernommen (durch Kopieren von custom-post-types.php Logik in unsere functions.php oder ein Include). Diese sind für Beyond Gotham wertvoll, falls das Weiterbildungsangebot fortgeführt wird. Wir planen daher, die CPT-Registrierung unverändert zu lassen
GitHub
, inkl. der Taxonomien bg_course_category und bg_course_level. Damit bleiben alle Kurs-Daten und -Funktionen einsatzbereit. Wir müssen lediglich prüfen, ob Bezeichnungen oder Icons geändert werden sollen (aktuell sind Menü-Icons gesetzt: z.B. Dashicon “welcome-learn-more” für Kurse
GitHub
 – das kann bleiben). Auch die Admin-Anpassungen (Dashboard-Statistik-Widget
GitHub
GitHub
 etc.) werden wir weiter nutzen, um Redakteuren einen Überblick zu geben.

Gutenberg-Unterstützung und Blöcke: Das neue Theme wird sicherstellen, dass es voll kompatibel mit dem Gutenberg-Blockeditor ist. Das bedeutet: Wir aktivieren add_theme_support('align-wide') und ähnliche Optionen, falls wir sie brauchen, damit z.B. breite/volle Breite Blöcke im Editor erlaubt sind. Außerdem definieren wir im Theme evtl. eigene Editor-Stile (per add_editor_style) damit der Backend-Editor die neuen Fonts/Styles zeigt.

Eigene Blöcke: Es kann sinnvoll sein, für bestimmte wiederkehrende Inhaltselemente Custom Blocks zu bauen. Denkbar wären z.B. ein “Feature-Highlight”-Block für die Startseite, um kuratierte Artikel mit Bild/Überschrift anzeigen zu können, oder ein “Testimonials”-Block für die Alumni-Stimmen (die momentan in page-landing als PHP-Array hinterlegt sind
GitHub
GitHub
). Solche Blöcke könnte man mit register_block_type() in PHP (Server-Side) oder komplett in React (Full Gutenberg) entwickeln. Angesichts der Zeit könnte man aber auch auf ACF-Blocks oder das Pattern-System zurückgreifen.

Block Patterns: Vielleicht bietet es sich an, vordefinierte Layout-Snippets als Block Pattern zu registrieren (z.B. ein Pattern für “Zwei Beiträge nebeneinander” oder ein Pattern für “Infobox” etc.), um Redakteuren das Bauen von abwechslungsreichen Seiten (wie About/Team) zu erleichtern.

Da der Fokus der Seite auf standardisierten Kategorie-Layouts liegt, müssen wir nicht übermäßig viele eigene Blöcke bauen – meist reichen die Core-Blöcke (Überschrift, Absatz, Bild, Galerie, Zitat etc.). Allerdings könnten wir z.B. für die InfoTerminal-Seite spezielle Darstellungen als Blöcke realisieren (z.B. die Liste von Feature-Artikeln mit Icon und Text dort).

Weiterentwicklung des Enrollment-Forms: Das Anmeldeformular für Kurse ist über AJAX (admin-ajax.php) implementiert und sollte weiter funktionieren. Wir lassen den Shortcode [bg_course_enrollment] bestehen
GitHub
. Eine mögliche Verbesserung: Das Formular könnte in einen Gutenberg-Block umgewandelt werden, so dass man es auch per Block einfügen kann. Aber als Shortcode eingebunden in die Kurs-Template ist es ok. Wichtig ist, WP-Funktionen wie wp_mail funktionieren weiter; evtl. richten wir – wie in Doku empfohlen – ein SMTP-Plugin ein (konfigurieren in Produktion)
GitHub
.

Falls wir mehr Zeit haben, könnte man stattdessen auf die neuere WP REST API setzen für Form-Submit, aber admin-ajax ist solide. Evtl. nur den JavaScript-Teil modernisieren (Fetch API statt jQuery AJAX, etc., jedoch nicht zwingend nötig).

REST API und externe Nutzung: Die WP REST API ist standardmäßig aktiv und wir haben unsere CPTs so registriert, dass sie darüber auslesbar sind (show_in_rest => true)
GitHub
. Das ist insbesondere für InfoTerminal relevant: Sollte die InfoTerminal-Anwendung eigenständig laufen (z.B. als React-App), kann sie über REST-Endpunkte Daten aus WordPress abrufen, z.B. Beiträge der Kategorie “Dossiers” laden als Fälle. Wir werden also darauf achten, dass alle notwendigen Daten verfügbar sind:

Beiträge (Posts) inklusive Kategorien, Bilder, Custom Fields – WP gibt das über /wp-json/wp/v2/posts etc. aus.

Ggf. spezielle Endpoints: Wenn InfoTerminal z.B. Filter oder Suchen benötigt, kann man WP-Query-Parameter nutzen oder im Bedarf eigene Endpoints via register_rest_route schreiben.

Unser Theme sollte zudem keine REST-Endpunkte blockieren (manchmal machen Security-Plugins das) – hier nichts Besonderes zu tun, nur Bewusstsein.

Performance & Caching: Eine moderne Seite muss effizient sein. Wir nutzen WordPress-Caching (Transients, WP Cron) schon an Stellen (z.B. Kurs-Statistik Dashboard-Widget cacht die Zahlen in einem Transient bg_course_stats_widget
GitHub
GitHub
). Wir sollten das im neuen Theme beibehalten oder sogar ausbauen:

Z.B. für die Startseite: wenn dort viele DB-Abfragen (für jede Kategorie 6 Artikel) passieren, könnte man ein transientes Caching überlegen, das alle 5 Minuten aktualisiert wird. Allerdings zunächst mal implementieren und messen.

Falls die Seite große Last erfährt, werden wir auf serverseitiges Caching (WP Super Cache / Varnish etc.) setzen, was aber außerhalb des Theme-Scopes liegt. Im Theme selbst vermeiden wir unnötige komplexe Loops und laden Medien in passenden Größen (die Custom-Image-Sizes helfen dabei). Lazy Loading ist bereits Standard für Images (WP 5.5+), im Code wird es auch forciert für eigene Sizes
GitHub
.

SEO und Social Sharing: Im aktuellen Theme gibt es eine Funktion, die Open Graph und Twitter Card Meta-Tags ausgibt, wenn kein SEO-Plugin aktiv ist
GitHub
GitHub
. Diese würde im neuen Theme ebenfalls integriert werden, sodass z.B. beim Teilen eines Artikels ein Vorschaubild und Beschreibung vorhanden sind. Alternativ kann ein Plugin wie Yoast installiert werden – da sollten wir kompatibel sein (meistens überschreibt das Plugin dann unsere Meta-Tags, was okay ist).

Ebenso bleiben die Breadcrumbs mit Schema.org Markup erhalten
GitHub
GitHub
, was SEO-technisch gut für Rich Snippets ist.

Kurz gesagt, WordPress-Best-Practices werden weiterhin verfolgt: Wir stützen uns auf vorhandene Core-Features (Posts, Kategorien, Seiten) für die inhaltliche Struktur, behalten die projektspezifischen CPTs bei, nutzen den Gutenberg-Editor intensiv für Content-Aufbau und halten die Seite offen für externe Anbindungen via REST API. Damit ist das System zukunftssicher, erweiterbar und für Redakteure komfortabel.

6. InfoTerminal-Produktseite umsetzen

Ein wichtiges neues Element ist die Produktseite für “InfoTerminal”, die das gleichnamige OSINT-Tool von Beyond Gotham präsentieren soll. Hierbei können wir uns am bereits vorhandenen Template page-infoterminal.php orientieren, das im Legacy-Ordner liegt. Dieses Template liefert wertvolle Hinweise auf den gewünschten Inhalt und Aufbau:

Ziel der Seite: Die InfoTerminal-Seite soll einerseits Marketing für das Tool machen (Features auflisten, zur Demo einladen) und andererseits offenbar eine eingebettete Demo des Tools bieten. Im Legacy-Template wird ein iframe vorgesehen, das eine Demo-URL lädt
GitHub
. Über ein Custom Field _bg_infoterminal_embed_url kann die URL im Backend hinterlegt werden – ist diese gesetzt, wird die Live-Demo eingebettet; ansonsten wird ein Platzhaltertext angezeigt
GitHub
. Diesen Mechanismus können wir direkt übernehmen. Konkret: Wir registrieren für Seiten (oder spezifisch für die InfoTerminal-Seite via Template-Erkennung) ein benutzerdefiniertes Feld “Embed URL”, z.B. mittels add_post_meta oder ACF (falls ACF Plugin genutzt werden darf, ansonsten core-Funktion). Im Template bauen wir analog das <iframe> ein. So kann man künftig z.B. eine öffentlich zugängliche Demo (vielleicht gehostet unter einer Subdomain oder als Web-App) dort anzeigen.

Inhaltliche Sektionen: Laut Template gliedert sich die InfoTerminal-Seite in mehrere Abschnitte:

Hero-Bereich: Titel der Seite (InfoTerminal), ein Untertitel/Lead (entweder aus dem Excerpt der Seite oder fest definiert) und zwei Call-to-Action Buttons – einer, um nach unten zur Demo zu scrollen (“Demo öffnen”), einer für “Features entdecken”
GitHub
GitHub
. Außerdem zeigt die Hero-Section im Template einen Systemstatus (Liste von Diensten mit Latenzen)
GitHub
. Diese Liste ist statisch im Code als Array eingetragen (API Gateway, Graph DB, Query Engine, Frontend Renderer mit Beispielwerten)
GitHub
. Das wirkt wie ein Gag oder als Demo-Platzhalter. Wir müssen entscheiden, ob wir so einen Systemstatus wirklich einbauen (evtl. als dynamische Werte via API, was komplex wäre) – ggf. vereinfachen wir das. Möglicherweise reicht es, im Redesign einfach eine Grafik oder Illustration des Tools im Hero rechts zu platzieren, statt dieses Status-Widgets.

Demo-Embed-Bereich: Abschnitt mit id="infoterminal-demo", der das iFrame enthält
GitHub
. Dieser soll idealerweise groß (fullscreen Breite) dargestellt werden, damit die Nutzer direkt die Anwendung sehen. Wir müssen sicherstellen, dass das umgebende Layout flexibel ist (im Template gibt es .bg-container Wrapper dafür).

Feature-Liste: Ein Abschnitt id="infoterminal-features" listet mehrere Kernfeatures des InfoTerminal auf
GitHub
. Im Code sind drei Feature-Artikel statisch hinterlegt:

Netzwerk-Visualisierung (Beschreibung der Graphen-Funktion),

Fall-Dossiers (Hinweis, dass alle Cases jetzt über WP-Kategorien wie Dossiers/Reportagen laufen – interessanter Punkt, zeigt Integration in Redaktions-Workflow)
GitHub
,

Live-Datenimporte (Beschreibung der Datenaktualisierung in Echtzeit)
GitHub
.

Diese Punkte stammen wahrscheinlich aus der Produktbeschreibung von InfoTerminal. Wir sollten sie übernehmen, aber vielleicht erweitern (waren da nur 3, eventuell gibt es mehr Features zu nennen). Wir können diese Feature-Liste als statisches HTML belassen, oder eleganter: als Gutenberg-Blocks pflegbar machen. Z.B. könnte jeder Feature-Punkt ein Icon + Überschrift + Text Block sein. Alternativ belässt man es hartcodiert und ändert nur Texte direkt im Template.

Zusätzlicher Inhaltsbereich: Im Template wird am Ende geprüft, ob der reguläre Seiteninhalt (im Editor) nicht leer ist – falls ja, wird er unter dem Abschnitt “infoterminal-content” ausgegeben
GitHub
. Das bedeutet, Redakteure können in WP im Editor der Seite InfoTerminal noch beliebigen Inhalt eingeben (z.B. weiterführende Infos, Screenshots, Kontaktformular etc.), der dann unterhalb der Feature-Grid angezeigt würde. Diese Logik ist gut, denn so ist die Seite flexibel. Wir übernehmen sie: d.h. im neuen Template der InfoTerminal-Seite fügen wir the_content() ein am Ende, damit das Team dort Inhalte bearbeiten kann ohne Code-Anpassung.

Integration ins Menü und Siteflow: Die InfoTerminal-Seite wird über das Hauptmenü zugänglich sein (siehe Punkt Navigationsstruktur oben). Zudem können wir von anderen Stellen darauf verlinken (z.B. ein Teaser auf der Startseite falls gewünscht: “Jetzt neu: InfoTerminal – unsere OSINT-Plattform”). Da InfoTerminal ein zentrales Produkt ist, könnte man es auch optisch hervorheben (z.B. Label “Neu” am Menüpunkt).

Zielgruppenansprache: Inhaltlich sollte die Produktseite sowohl Journalisten/Redakteure (die die Cases lesen) als auch potenzielle Kunden/Nutzer des Tools ansprechen. Das heißt, wir sollten die Texte ansprechend gestalten, evtl. Success-Stories oder Screenshots einbauen. Dies kann das Team beisteuern; unsere Aufgabe ist das Template so flexibel wie nötig zu gestalten (was durch den abschließenden frei bearbeitbaren Content-Block gegeben ist).

Technische Umsetzung Besonderheiten:

Wir müssen das Custom Field _bg_infoterminal_embed_url verfügbar machen. Das kann man simpel halten: In der Seite InfoTerminal im Backend erscheint es, wenn wir mit register_post_meta das Feld registrieren (mit show_in_rest => true falls Editor-Integration nötig) oder mittels PHP-Meta-Box (so wie bei Kursen, aber das lohnt für ein Feld kaum). Zur Not kann man auch auf ACF zurückgreifen, falls erlaubt, aber vermutlich nicht nötig.

Das Template kommt ins neue Theme, eventuell benennen wir es um (Template Name: "InfoTerminal"). Wir testen nach Umsetzung: Wenn man eine Seite “InfoTerminal” erstellt und das Template zuweist, sollte alles erscheinen.

Darauf achten, dass das <iframe> responsive dargestellt wird (im Code ist es inside einer .infoterminal-demo__frame Div – das CSS müssen wir entsprechend schreiben, z.B. iframe { width:100%; height: 600px; } oder so, und evtl. bei kleineren Screens eine geringere Höhe).

Falls keine Live-Demo-URL eingebunden wird, soll der Platzhaltertext die Redaktion anleiten, wie sie eine URL hinterlegen kann
GitHub
 – den Text können wir in Deutsch belassen, evtl. etwas weniger technisch formulieren.

Am Ende erhalten wir eine dedizierte Produktseite, die dem Nutzer das Look-and-Feel von InfoTerminal nahebringt und Interesse weckt. Sie ist zugleich verknüpft mit dem redaktionellen Teil (durch die Dossiers/Reportagen, die ja als Inhalte aus WP stammen). Somit schlägt diese Seite die Brücke zwischen dem Produkt und dem Content von Beyond Gotham.

7. Shop-Integration für Beyond Gotham

Die Website soll außerdem einen Shop enthalten. Vermutlich sollen hier Produkte oder Dienstleistungen von Beyond Gotham verkauft werden – naheliegend ist z.B. der Verkauf des InfoTerminal-Produkts (als Lizenz) oder Merchandise/Bücher, oder auch Kursbuchungen gegen Bezahlung (falls man Kurse kostenpflichtig direkt vertreiben will). Um einen Shop umzusetzen, greifen wir auf eine bewährte Lösung zurück: WooCommerce.

Im internen Projektdokument wurde die WooCommerce-Integration bereits als nächster Schritt erwähnt
GitHub
, was bestätigt, dass dieses Plugin vorgesehen ist. Der Entwicklungsplan für den Shop umfasst:

WooCommerce Einbindung: Zunächst wird das WooCommerce-Plugin installiert und konfiguriert. WooCommerce registriert eigene CPTs für Produkte, Bestellungen etc. und erstellt Seiten (Shop, Warenkorb, Kasse, Mein Konto). Wir müssen sicherstellen, dass diese Seiten nach Theme-Aktivierung vorhanden sind (WooCommerce Setup-Assistent ausführen).

Produktsortiment planen: Definieren, was verkauft wird:

Ist InfoTerminal selbst ein Produkt? Evtl. ja (z.B. eine Jahreslizenz), dann wird es als einzelnes Produkt angelegt. Die InfoTerminal-Seite könnte dann einen “Kaufen”-Button haben, der zum Produkt im Shop führt.

Andere Produkte: Vielleicht Kursbuchungen? (Aber Kurse werden bisher kostenlos mit Formular verwaltet; eine Umstellung auf bezahlte Kurse wäre größerer Umbau, wahrscheinlich nicht sofort.) Oder Bücher/Reports?

Gegebenenfalls erstellt das Team einige Demo-Produkte um den Shop zu testen.

Theme-Kompatibilität: Das neue Beyond-Gotham Theme muss WooCommerce unterstützen. Dazu fügt man in functions.php add_theme_support('woocommerce') hinzu. Weiterhin sollen die Templates von WooCommerce ans Theme angepasst werden:

WooCommerce hat Standard-Templates für Shop-Seite (Produktarchiv) und Produktdetail. Wir werden diese overriden, indem wir im Theme einen Ordner woocommerce/ erstellen und dort z.B. archive-product.php, single-product.php etc. kopieren und modifizieren. Ziel: Das Aussehen passt zu unserem Theme (z.B. gleiche Header/Footer, gleiche Fonts). Oft muss man gar nicht alles neu schreiben – CSS-Anpassungen reichen, aber manchmal ist Template-Eingriff nötig für z.B. Umschalten der Sidebar.

Insbesondere achten wir auf den Shop-Startseite (Produkt-Übersicht): Wir möchten hier ein ansprechendes Grid der Produkte, vielleicht mit Kategoriefiltern falls mehrere Produktkategorien existieren. Wenn nur ein Produkt (InfoTerminal) verkauft wird, könnte man die Shop-Seite auch skippen und direkt zum Produkt verlinken. Aber wir planen mal generisch.

Produktseite: Hier sollte Produktbild, Beschreibung, Preis, “In den Warenkorb” Button schön dargestellt sein. Evtl. wollen wir die Tabs (Beschreibung/Bewertungen) anders gestalten oder die Sidebar mit verwandten Produkten einblenden – je nach Design.

Warenkorb/Checkout: Diese Seiten müssen vor allem funktional sein; wir sorgen dafür, dass z.B. Buttons im richtigen Theme-Stil erscheinen (evtl. via CSS). Auch die Formulare (Rechnungsadresse etc.) sollen übersichtlich sein. WooCommerce bringt eigene CSS mit – wir können entscheiden, dieses zu nutzen (lassen sich meist via woocommerce.css anpassen) oder wir überschreiben viel. Da “ordentlich und modern” gefordert ist, könnten wir z.B. die Kasse auf einer einzigen Seite als One-Page-Checkout umstellen – aber das ist optional und oft pluginbasiert. Initial belassen wir Standard-Checkout mit eventuell kleinen CSS-Tweaks.

Zahlungs- und Versand-Setup: In WooCommerce müssen Payment-Gateways eingerichtet werden (PayPal, Kreditkarte via Stripe etc.) – das ist eher Konfiguration als Entwicklung, aber Teil des Projekts. Ebenso Versandregeln falls physische Produkte, was eher unwahrscheinlich hier ist (InfoTerminal wäre digital). Diese Aufgaben sind administrativ, aber sollten im Plan erwähnt sein, damit der Shop am Ende funktional ist.

Test und rechtliche Aspekte: Wir testen den gesamten Checkout mit Test-Zahlungen. Außerdem beachten wir rechtliche Anforderungen (gerade in DE wichtig): Impressum/Datenschutz müssen um Shop-Punkte ergänzt werden (z.B. Widerrufsbelehrung, AGB-Seite). WooCommerce erzeugt teils Vorlagen dafür, die wir anpassen. Diese Seiten dann im Footer verlinken.

Verknüpfung mit restlicher Seite: Der Shop sollte nicht isoliert wirken. Z.B. könnte auf der InfoTerminal-Seite ein “Jetzt kaufen”-Button zum Shop führen. Oder in der Navigation könnte ein Warenkorb-Icon mit Artikelanzahl auftauchen (WooCommerce bietet Widgets hierfür). Im Theme können wir z.B. im Header einen kleinen Warenkorb-Button integrieren, der mittels woocommerce_mini_cart() den Inhalt zeigt. Solche Details würden wir nach Grundintegration umsetzen, um eine nahtlose User Experience zu garantieren.

Durch die WooCommerce-Einbindung erhält Beyond-Gotham eine vollwertige Shop-Funktion, ohne dass wir alles neu entwickeln müssen. Wichtig ist, dass das Design konsistent bleibt – hier fließt ein großer Teil der Arbeit rein (Styling der Shop-Templates). Dank der starken WP-Integration von WooCommerce halten wir uns auch hier an das Motto, WP-Core-Funktionalität zu nutzen, statt Eigenbauten.

8. Qualitätssicherung, Launch und Ausblick

Sobald Entwicklung und Integration der obigen Punkte erfolgt sind, folgen umfassende Tests und Feinschliff vor dem Launch:

Cross-Browser und Responsive Testing: Überprüfen der Website in aktuellen Versionen von Chrome, Firefox, Safari, Edge sowie auf verschiedenen Gerätegrößen (Desktop, Tablet, Smartphone). Insbesondere das neue Layout der Startseite und Kategorie-Seiten muss sich dynamisch anpassen; auch das InfoTerminal-Embed soll auf gängigen mobilen Auflösungen anzeigbar sein (ggf. mit Scrollen innerhalb des iFrames). Identifizierte Darstellungsfehler werden in CSS korrigiert.

Funktionstests: Jede Kernfunktion wird manuell getestet:

Kurs-Anmeldung: Formular ausfüllen, schauen ob Eintrag in “Anmeldungen” CPT erscheint, E-Mails ankommen (ggf. in SMTP-Log)
GitHub
. Auch Grenzfälle wie Rate-Limit prüfen (im Code max. 3 Submits/15 Min. getestet)
GitHub
.

Navigation: Menü-Links klicken, Breadcrumbs prüfen, Pagination der Archive durchblättern.

Suche: Stichwortsuche durchführen, Suchergebnisseite beurteilen (ggf. eigenes Template search.php erstellen falls nötig, sonst Standard).

Shop: Produkt in Warenkorb legen, Checkout bis zur Zahlungsseite (Testmodus) durchspielen. E-Mails vom Shop (Bestellbestätigung) testen.

InfoTerminal: Button “Demo öffnen” klick scrollt zum iFrame, funktioniert der Embed (lädt z.B. die Demo-Anwendung)? Feature-Links scrollen? Falls InfoTerminal-Demo selbst interaktiv ist, das Nutzererlebnis prüfen.

Performance und SEO-Check: Google Lighthouse oder PageSpeed Insights laufen lassen, um Performance-Bottlenecks zu finden (Bilder optimieren, ggf. Lazy-Load für iframes – loading="lazy" ist gesetzt
GitHub
, prüfen ob das passt). SEO: Prüfen, ob Meta-Tags vorhanden (falls kein SEO-Plugin, unsere bg_output_social_meta sorgt für OG tags
GitHub
). Ggf. strukturiertes Daten-Markup mit dem Google Test-Tool validieren (Breadcrumb Schema ausgeben – ist im Code, das testen
GitHub
GitHub
).

Inhalte einpflegen: Vor dem Launch werden realistische Inhalte eingestellt. Redaktion schreibt erste Dossier-/Reportagen-Artikel, befüllt die InfoTerminal-Seite (Excerpt, Fließtext, ggf. Screenshot-Bilder via Editor). Wir stellen sicher, dass z.B. eine Startseiten-Sektion nicht leer bleibt – der Code im Landing-Template springt ja auf Fallback-Kategorie um, falls primäre Kategorie leer ist
GitHub
. Trotzdem sollte zum Launch jeder Bereich wenigstens einen Beitrag haben, damit es gefüllt aussieht.

Redakteursschulung: Da das System einige spezifische Features hat (CPTs für Kurse, Shortcode für Formular, Einbettung via Custom Field, WooCommerce-Bestellverwaltung), werden wir das Team schulen. Ein kurzes Handbuch oder eine Session, in der erklärt wird:

Wie man einen Artikel erstellt und der richtigen Kategorie zuweist.

Wie man Kurse anlegt und veröffentlicht (Menü “Kurse” etc.)
GitHub
.

Wie das InfoTerminal-Embed aktualisiert wird (z.B. neue Demo-URL eintragen über Custom Field).

Wie Shop-Bestellungen zu verwalten sind (WooCommerce Backend).

Launch-Vorbereitung: Entspricht den Deployment-Hinweisen aus dem Repo:

Theme-Code via Git oder SFTP auf den Server übertragen
GitHub
.

In der Live-WordPress-Instanz das Theme aktivieren. Direkt danach Permalinks speichern (wichtig wegen neuer Rewrite-Rules, v.a. CPTs)
GitHub
.

Caching-Lösungen leeren (sofortige Anzeige der Änderungen).

Funktionaler Test in Produktionsumgebung (v.a. E-Mails, Cronjobs für wp_mail wenn nötig)
GitHub
.

SMTP einrichten, falls noch nicht (damit Mails zuverlässig rausgehen)
GitHub
.

Prüfen von sicherheitsrelevanten Einstellungen: Dateibearbeitung in wp-admin deaktivieren, Admin-Benutzer prüfen etc. (wie in Doku empfohlen
GitHub
).

Nach dem Launch:

Weiteres Monitoring einplanen (Error-Logs beobachten, eventuell ein Monitoring-Tool).

Feedback-Runde mit Redaktion und ggf. Testnutzern, um letzte Usability-Verbesserungen einzuarbeiten.

Einrichtung von Analytics (z.B. Matomo oder GA, falls gewünscht, DSGVO-konform) – war auch als nächster Schritt angedacht
GitHub
.

Geplante zukünftige Erweiterungen im Auge behalten, z.B. mehr WooCommerce (Bezahlprozesse für Kurse) oder automatisierte Tests für das Formular
GitHub
.

Mit diesem Plan gehen wir schrittweise vor: Zuerst die Grundlage (neues Theme + Design) schaffen, dann Inhaltsstruktur mit Kategorien aufbauen, danach InfoTerminal-Seite und Shop integrieren, und schließlich ausgiebig testen. So entsteht eine runde, moderne Website, die Beyond Gotham als investigatives Nachrichtenportal mit Schulungsangebot und eigenem OSINT-Tool professionell repräsentiert.

Alle vorhandenen Stärken der aktuellen Codebasis (modulare PHP-Lösungen, WP-Standards, Performance-Tricks) werden wir hinüberretten, während wir optisch und strukturell einen großen Sprung nach vorne machen. Mit dem fertigen System kann Beyond Gotham seine Leser mit spannenden Dossiers und Berichten versorgen, Teilnehmer für Kurse gewinnen und sein InfoTerminal-Produkt überzeugend präsentieren – alles unter einem Dach. 
GitHub
GitHub
