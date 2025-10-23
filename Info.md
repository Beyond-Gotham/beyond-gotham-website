Beyond Gotham – Organisation und InfoTerminal
Organisation Beyond-Gotham

Beyond-Gotham ist eine in Leipzig ansässige sozialunternehmerische Organisation, die Open-Source-Intelligence (OSINT), investigativen Journalismus, digitale Forensik und medizinische Ersthilfe in einem integrierten Modell vereint
GitHub
. Ihr Ziel ist es, in Krisen- und Konfliktregionen faktenbasierte Berichterstattung, Datenerfassung und humanitäre Unterstützung miteinander zu verbinden – ergänzt durch nachhaltigen Wissenstransfer mittels lokaler Ausbildung und Equipment-Spenden
GitHub
.

Leitgedanke: „Wir bringen Wahrheit, Technik und Hilfe dorthin, wo sie am dringendsten gebraucht werden.“ Dieser Leitspruch unterstreicht Beyond-Gothams Ausrichtung, Technologie und humanitäre Hilfe zusammenzubringen. Die Organisation kombiniert mehrere Aufgabenbereiche, um dieses Ziel umzusetzen:

OSINT & Datenanalyse: Verifikation von Informationen, Geo- und Zeit-Analysen sowie Fact-Checking digitaler Inhalte
GitHub
.

Investigativer Journalismus: Tiefgehende Recherche und Interviews unter strikter Einhaltung ethischer Standards und Veröffentlichung der Erkenntnisse
GitHub
.

Rettungsdienstliche Ersthilfe: Medizinische Versorgung und Nothilfe vor Ort in Krisengebieten
GitHub
.

Ausbildung & Empowerment: Schulungen für lokale Helfer, Bildungsprogramme und Aufbau lokaler Teams, um Wissen vor Ort zu verankern
GitHub
.

Beyond-Gotham führt Missionen direkt vor Ort durch. Diese dauern typischerweise 1–6 Monate und bestehen aus kleinen interdisziplinären Teams (etwa 2–4 Personen mit Expertise in Rettungsdienst, IT/Forensik und Journalismus/OSINT)
GitHub
. Ausgestattet mit einem mobilen Pressefahrzeug als Einsatzzentrale und einem Krankenwagen, sammeln sie vor Ort Daten, unterstützen mit medizinischer Hilfe und bauen lokale Strukturen auf
GitHub
. Am Ende einer Mission wird der vollständig ausgerüstete Krankenwagen als Spende vor Ort zurückgelassen, sodass lokale Partner die Arbeit fortführen können
GitHub
. Die Ergebnisse der Missionen umfassen verifizierte Dossiers, investigative Reportagen und evidenzbasierte Datenbanken, die zur Aufklärung und weiteren humanitären Nutzung beitragen
GitHub
.

Tool InfoTerminal

InfoTerminal ist eine von Beyond-Gotham entwickelte Open-Source-Intelligence-Plattform, die modular, sicher und erweiterbar aufgebaut ist
GitHub
. Sie versteht sich als offene, erweiterbare Alternative zu Palantir Gotham, konzipiert für Journalist·innen, Behörden, NGOs und Forschende
GitHub
. Die Plattform befähigt ihre Nutzer·innen, Daten aus verschiedensten Quellen zu sammeln, automatisiert auszuwerten und Erkenntnisse übersichtlich aufzubereiten. Konkret ermöglicht InfoTerminal es, Daten aus Newsfeeds, Social Media, offenen Daten, RSS-Feeds oder sogar Sensorstreams sicher und anonym zu erfassen
GitHub
. Darauf lassen sich Graph-Analysen, fortgeschrittene NLP-Verfahren (z.B. Named Entity Recognition) und Verifikations-Algorithmen anwenden, um Muster, Zusammenhänge und Faktenlage aufzudecken
GitHub
. Die Ergebnisse stellt die Plattform in Form von Dossiers, interaktiven Dashboards und kollaborativen Workflows bereit
GitHub
. Ein umfassender Security-Layer (Incognito-Modus mit Tor/VPN, isolierte Sandbox) und ein integrierter Verification-Layer mit KI-gestütztem Fact-Checking sorgen dafür, dass Recherche und Analyse sowohl anonym als auch verlässlich erfolgen
GitHub
.

Nachfolgend die technische Architektur und Hauptkomponenten von InfoTerminal im Überblick:

Daten-Ingestion: Über anpassbare Pipelines (u.a. Apache NiFi) können diverse Eingänge angebunden werden – z.B. RSS-Feeds, APIs, Dateien/Dokumente (mit OCR) für Nachrichtenquellen, Web-Scraper für Social Media (Telegram, Reddit, Mastodon, Blogs) oder Streaming-Daten (Sensoren, Echtzeitfeeds)
GitHub
. Selbst Videodaten lassen sich verarbeiten (NiFi → FFmpeg → ML-Pipeline für Gesichts-/Objekterkennung), inklusive automatischer Geo-Kodierung von Ortsangaben
GitHub
.

Speicherung & Analyse: Die Plattform speichert und indexiert Informationen in spezialisierten Backends. Ein OpenSearch-Cluster ermöglicht Volltextsuche (inkl. semantische Embeddings und Ranking), während ein Neo4j-Graphdatenbankdienst Entitäten und Beziehungen für Netzwerkanalysen bereitstellt
GitHub
. Zusätzlich hält PostgreSQL aggregierte Sichten für Business-Intelligence bereit (etwa via Superset/Grafana)
GitHub
. Ein eigener NLP-Dienst (doc-entities) extrahiert aus Dokumenten Personen, Orte, Beziehungen und fasst Texte zusammen
GitHub
.

Verifikations-Layer: Ein zentrales Merkmal ist die KI-gestützte Verifikation von Informationen in Echtzeit. InfoTerminal kann Behauptungen automatisch extrahieren und clustern, relevante Belege aus den Daten abrufen (Evidence Retrieval mit Suchalgorithmen wie BM25 + semantischem Reranking) und die Stimmigkeit von Aussagen prüfen (z.B. mittels Text-Entailment/KI-Stance-Detection)
GitHub
. Zusätzlich erfolgen geo-zeitliche Plausibilitätschecks (Abgleich von Ortsangaben, Zeitstempeln) und Media-Forensik für Bilder/Videos (z.B. Reverse Image Search, Vergleich von Hashes, EXIF-Daten)
GitHub
. Die Resultate fließen in einen Veracity Score ein, der die Glaubwürdigkeit anzeigt, wobei ein Human-in-the-Loop-Prinzip gilt (Analyst·innen überprüfen kritische Fälle)
GitHub
.

Security-Layer: Für sichere, anonyme Recherche bringt InfoTerminal ein mehrschichtiges Sicherheitskonzept mit. Ein Egress-Gateway leitet sämtlichen Datenverkehr über Tor/VPN/Proxy und bietet Notabschaltung und DNS-Sinkhole, um Tracking zu verhindern
GitHub
. Ein ephemeres Dateisystem stellt einen Inkognito-Modus sicher, indem lokale Spuren automatisch gelöscht werden
GitHub
. Geheimnisse und Schlüssel werden über Vault sicher verwaltet
GitHub
. Weiterhin gibt es einen Pool ferngesteuerter Browser mit unterschiedlichen Fingerprints für Web-Recherchen sowie eine isolierte Plugin-Sandbox (via gVisor/Kata Containers und Policy-Validation) für die gefahrlose Ausführung von externen Tools
GitHub
.

Frontend & Auswertung: Die Benutzeroberfläche von InfoTerminal ist als Web-Frontend umgesetzt. Sie bietet u.a. eine Suchseite mit Filter- und Rankingfunktionen, eine Graph-Visualisierung (mit Geo-Kartenintegration) zur Exploration von Netzwerken, sowie einen Dossier-Builder, mit dem Analyst·innen per Drag-and-Drop Berichte erstellen können
GitHub
. Kollaborative Funktionen (geteilte Notizen, gleichzeitiges Arbeiten via CRDT, Audit-Logs) ermöglichen Teamarbeit direkt in der Plattform
GitHub
. Als Ergebnis können Dossiers/Reports für verschiedene Anwendungsfälle (Legal, Desinformation, Finanzen, Krisen etc.) generiert und als PDF oder Markdown exportiert werden
GitHub
. Auch interaktive Dashboards stehen zur Verfügung – beispielsweise über Apache Superset für analytische Auswertungen oder Grafana für technische Metriken
GitHub
.

CLI & Erweiterbarkeit: Die primäre Steuerung erfolgt über ein eigenes Kommandozeilen-Tool infoterminal-cli, das als zentraler Zugang dient
GitHub
. Darüber lässt sich die komplette Infrastruktur starten/stoppen (it up/down für Docker-Services), der Systemstatus prüfen, Logs einsehen und Daten exportieren
GitHub
. Die CLI ermöglicht auch das Ausführen von Plugins/Tools (z.B. Kali Linux Tools wie nmap, exiftool) sowie das Laden vorkonfigurierter Presets (Startprofile wie --preset journalism für typische Use-Cases)
GitHub
. Die Architektur ist bewusst modular gehalten: Über eine Plugin-Architektur können externe Werkzeuge und eigene Skripte integriert werden, und sogenannte “Intelligence Packs” erweitern das System um vordefinierte Module für spezielle Anwendungsfelder (z.B. Desinformation, Klima, Finanz oder **Terrorismus-Analyse)
GitHub
GitHub
.

Einsatzszenarien: InfoTerminal kann in vielfältigen Kontexten eingesetzt werden – vom Journalismus (Fake-News erkennen, Narrative analysieren) über Behörden/Unternehmen (Compliance-Verstöße aufdecken, Lieferkettenrisiken modellieren) bis hin zu Forschung und NGOs (humanitäre Krisen monitoren, Klimarisiken simulieren)
GitHub
. Durch das Ethical by Design-Prinzip (Bias-Checks, Transparenz der Algorithmen) und den Open-Source-Ansatz bietet InfoTerminal eine nachhaltige Alternative zu proprietären Geheimdienstplattformen, ohne auf leistungsfähige Analyse-Tools zu verzichten
GitHub
.

WordPress-Website für Beyond-Gotham (FreeNews-Theme)

Im Folgenden wird die geplante WordPress-Website für Beyond-Gotham beschrieben – einschließlich Zweck, inhaltlicher Struktur und technischer Umsetzungsschritte. Die Website basiert auf dem WordPress-Theme FreeNews (Nachrichten-/Magazin-Theme) mit einem individuell gestalteten Child-Theme „BeyondGotham Dark“, das ein modernes dunkles News-Layout verwendet
GitHub
. Zusätzlich wird eine Demo des InfoTerminal-Tools in die Seite integriert
GitHub
.

Zweck und Ziel der Website

Die Beyond-Gotham-Webseite dient als zentraler Informations- und Publikationskanal der Organisation. Sie soll die Mission und Aktivitäten von Beyond-Gotham der Öffentlichkeit vermitteln und als Plattform für investigative Berichte und Projektvorstellungen fungieren. Als Nachrichtenagentur-ähnliches Portal präsentiert die Seite faktenbasierte Inhalte aus Krisengebieten, Einblicke in OSINT-Analysen und Erfolge der humanitären Einsätze. Darüber hinaus werden mögliche Unterstützer, Partner und interessierte Fachleute angesprochen: Die Website informiert über Mitwirkungsmöglichkeiten, Schulungsprogramme und zeigt die technische Innovation (InfoTerminal) der Organisation. Zusammenfassend verfolgt die Website folgende Ziele:

Aufklärung & Transparenz: Präsentation der Rechercheergebnisse, verifizierten Berichte und Projekte von Beyond-Gotham, um Vertrauen in die Arbeit der Organisation zu schaffen.

Außenwirkung & Vernetzung: Darstellung der Ziele, Werte und des Teams, um Partner und Förderer zu gewinnen und die Bekanntheit der Initiative zu steigern.

Wissensvermittlung: Bereitstellung von Hintergrundinformationen zu OSINT, digitaler Forensik und den Einsatzgebieten, ggf. in Blog-Artikeln, um das Thema einer breiteren Öffentlichkeit zugänglich zu machen.

Technologie-Demonstration: Integration des InfoTerminal (als interaktive Demo oder Showcase) auf der Website, um das technologische Alleinstellungsmerkmal von Beyond-Gotham hervorzuheben und zu zeigen, wie die Plattform funktioniert.

Seitenstruktur und Inhalte

Eine klare Seitenstruktur stellt sicher, dass Besucher schnell die gewünschten Informationen finden. Geplant ist folgender Aufbau mit Hauptseiten und deren Kerninhalten:

Startseite: Übersichtsseite mit einem prägnanten Header (Logo, Claim „Investigative Intelligence · Humanitarian Impact · Verified Truth“), einer Kurzvorstellung der Organisation und aktuellen Highlights. Mögliche Elemente: Teaser der neuesten Blog-Artikel/News aus den Einsatzgebieten, Hinweis auf das InfoTerminal (z.B. „Entdecken Sie unsere OSINT-Plattform“), sowie Logos von Partnern oder Förderern.

Projekte/Missionen: Seite, die laufende und abgeschlossene Projekte oder Missionen von Beyond-Gotham vorstellt. Für jede Mission können ein Kurzprofil (Ort, Dauer, Teamgröße), Ziele, Ergebnisse (z.B. veröffentlichte Dossiers) und ggf. Fotos oder Videos präsentiert werden. Dies kann als Überblicksliste mit Links zu detaillierten Unterseiten umgesetzt werden, falls viele Projekte vorhanden sind.

Team & Organisation: Vorstellungsseite für das Team hinter Beyond-Gotham. Hier werden Schlüsselpersonen (Geschäftsführung, Redaktion, technische Leitung, etc.) mit Foto, Name, Rolle und kurzem Profil vorgestellt. Ebenso kann die Organisationsstruktur bzw. Partnernetzwerk erwähnt werden (z.B. in Form von Logos oder einer kurzen Beschreibung der Partnerinstitutionen).

Blog/News: Ein Blog-Bereich für regelmäßige Beiträge und News. Hier können investigative Artikel, Einsatzberichte, Erfolgsgeschichten oder technische Insights veröffentlicht werden. Die FreeNews-Theme-Struktur (Kategorie-Übersichten, Schlagzeilen, etc.) kann genutzt werden, um diese Beiträge ansprechend darzustellen. Kategorien könnten z.B. nach Themen (OSINT-Analysen, Humanitäre Hilfe, Projekte, Pressemitteilungen) gegliedert sein.

InfoTerminal (Demo): Eine spezielle Seite oder Sektion, die das InfoTerminal-Tool vorstellt. Inhalt: Erklärung, was InfoTerminal ist (Funktion und Nutzen, evtl. auszugsweise aus obiger Beschreibung), und Einbindung der Demo. Die Demo könnte entweder als eingebettete Web-App (via <iframe> oder im Theme-Template integriert) oder als externer Link (z.B. Öffnen in einem neuen Tab) bereitgestellt werden. Ziel ist es, Besuchern einen Eindruck der Benutzeroberfläche und Funktionen von InfoTerminal zu geben – z.B. durch interaktive Suche/Graph-Demo oder zumindest Screenshots/Videos, falls eine Live-Demo technisch eingeschränkt ist.

Kontakt: Kontaktseite mit Kontaktformular (z.B. für Presseanfragen, Partnerinteresse) und den relevanten Kontaktinformationen (E-Mail, ggf. Telefonnummer, Postadresse). Zusätzlich können Social-Media-Links und ein eingebettetes Kartenwidget für den Standort Leipzig stehen. Ein Impressum und Datenschutz-Seite (rechtlich erforderlich in DE) werden im Footer verlinkt.

(Optional: Über uns/Mission: Falls nicht bereits auf Startseite oder Team-Seite abgedeckt, könnte eine eigene Seite die Entstehungsgeschichte von Beyond-Gotham, Vision und Leitbild ausführlicher schildern. Alternativ kann dieser Inhalt auf der Startseite oder Team-Seite mit eingebunden werden.)*

Die Navigationsleiste der Website beinhaltet die Hauptseiten (Startseite, Projekte, Team, Blog, InfoTerminal, Kontakt). Eine klare Informationsarchitektur sorgt dafür, dass User intuitiv zwischen den Bereichen wechseln können. Zudem sollten an passenden Stellen Querverlinkungen vorhanden sein (z.B. Blog-Artikel zu relevanten Projekten, Hinweis „Mehr über unser Team“ am Ende der Startseite, etc.).

Integration des InfoTerminal

Ein besonderer Bestandteil der Website ist die Einbindung von InfoTerminal. Da InfoTerminal eine komplexe Anwendung ist, präsentiert die Seite eine kuratierte Showcase-Ansicht mitsamt optionalem Live-Embed. Technisch wird dies nun vollständig innerhalb des Child-Themes umgesetzt:

- Das Template `page-infoterminal.php` liefert einen Hero-Bereich, Feature-Beschreibungen und Platz für redaktionelle Inhalte.
- Über das benutzerdefinierte Feld `_bg_infoterminal_embed_url` kann – falls verfügbar – eine eigenständige Demo-Instanz (z.B. von einem separaten Server) per `<iframe>` eingebettet werden.
- Wird kein Embed hinterlegt, zeigt die Seite erklärende Texte und Call-to-Actions, sodass keine leeren Bereiche entstehen.

Leistungsaspekt: Da die Server-Komponenten von InfoTerminal (Datenbanken, APIs) nicht auf dem Shared-Webhosting laufen können, empfiehlt es sich weiterhin, für die Einbettung Mock-Daten oder einen extern gehosteten Read-only-Dienst zu nutzen. Die WordPress-Integration konzentriert sich auf die Präsentationsebene, kann aber perspektivisch per API ausgebaut werden.

Sicherheit & UX: Beim Einbinden externer Demos sollten Content-Security-Policies und Datenschutzhinweise geprüft werden. Zudem sollte klar kommuniziert werden, dass es sich um eine Demo handelt (z.B. Hinweistext über dem Embed) und welche Funktionen die Besucher testen können.

Durch diese Integration wird die technologische Kompetenz von Beyond-Gotham sichtbar: Besucher können das Look-and-Feel der OSINT-Plattform erleben, was Vertrauen schafft und Interesse weckt. Sollte die Demo nicht live interaktiv sein, könnten alternativ Screenshots, animierte GIFs oder ein Erklärvideo des InfoTerminal die Seite bereichern.

Technische Anforderungen und Schnittstellen

Die Umsetzung der Website erfordert einige technische Vorkehrungen und die Auswahl geeigneter Tools/Plugins, um alle Anforderungen abzudecken:

WordPress + FreeNews-Theme: Zunächst ist eine aktuelle WordPress-Installation nötig, in die das FreeNews-Parent-Theme und das „BeyondGotham Dark“ Child-Theme eingebunden werden
GitHub
. Das Child-Theme enthält Styles für das dunkle Farbschema und ggf. Template-Anpassungen für spezielle Bereiche.

Plugin für Kontaktformular: Zur Realisierung der Kontaktseite sollte ein bewährtes Plugin wie Contact Form 7 oder WPForms installiert werden. Dieses ermöglicht ein einfaches Formular, dessen Einsendungen per Mail an Beyond-Gotham gehen.

SEO-Plugin: Um die Sichtbarkeit der Seite zu erhöhen, empfiehlt sich ein SEO-Plugin (z.B. Yoast SEO). Damit können Meta-Tags, Social-Media-Vorschau und Sitemap gepflegt werden, was insbesondere für die Reichweite der Blogartikel wichtig ist.

Caching & Performance: Für kurze Ladezeiten sollte ein Caching-Plugin eingesetzt werden (z.B. WP Super Cache oder W3 Total Cache), da das FreeNews-Theme viele Inhalte (Bilder, Artikel-Teaser) lädt. Zusätzlich sind Bildoptimierungs-Plugins oder CDN-Integration sinnvoll, um die Medien performant auszuliefern.

Analytics & Tracking: Falls gewünscht, kann Google Analytics oder eine datenschutzfreundliche Alternative (Matomo, Plausible) eingebunden werden, um Besucherstatistiken zu erfassen. Dies erfordert das Einbinden des Tracking-Codes und einen entsprechenden Cookie-Hinweis/Banner (DSGVO-Konformität).

Datenquellen & Schnittstellen: Die Inhalte der Website (Texte, Artikel, Projekte) werden größtenteils redaktionell von Beyond-Gotham erstellt und direkt im WP eingegeben. Sollte eine automatisierte Einbindung externer Daten gewünscht sein, könnte die WP-REST-API oder Feeds genutzt werden. Beispiele: automatisches Ausspielen von Social-Media Posts (via Plugin oder Embedded Timeline), Einbindung eines RSS-Feeds externer Nachrichten auf der Startseite, oder – perspektivisch – Abruf von InfoTerminal-Ergebnissen über eine REST-Schnittstelle. Für Letzteres müsste InfoTerminal eine öffentliche API bereitstellen, über die z.B. bestimmte verifizierte News oder Grafiken abgefragt und auf der WP-Seite angezeigt werden können. In der aktuellen Phase bleibt dies aber optional und konzeptionell; prioritär ist die statische Demo-Integration.

Sicherheit: Als NGO-Seite mit möglicherweise sensiblen Inhalten ist auf Sicherheit zu achten. Regelmäßige Updates von WP, Themes und Plugins sind Pflicht. Zusätzlich könnten Plugins wie Wordfence für Firewall/Scan oder Login-Schutz eingesetzt werden. Da die Seite bei IONOS gehostet wird (laut Repository), muss auch dort für SSL-Verschlüsselung (HTTPS) gesorgt werden – etwa via Let’s Encrypt oder IONOS-eigenes SSL.

Rechtliches: Installation von Plugins für Cookie Consent (um Besucher über Cookies/Tracking zu informieren und Zustimmung einzuholen) sowie das Anlegen der gesetzlich erforderlichen Seiten Impressum und Datenschutzerklärung sind erforderlich (können im Footer verlinkt werden).

Umsetzungsschritte für die Entwicklung

Abschließend die konkreten Aufgaben für die Umsetzung der Website, sowohl inhaltlich als auch technisch. Diese Schritte sollten in der Projektplanung berücksichtigt werden:

Setup der Entwicklungsumgebung: Aufsetzen einer lokalen WordPress-Installation oder Staging-Umgebung. Installation des FreeNews-Themes (als Parent) und Aktivierung des Child-Themes BeyondGotham Dark. Überprüfen, ob alle Theme-Abhängigkeiten erfüllt sind (ggf. werden vom Theme bestimmte Plugins vorgeschlagen).

Theme-Anpassungen (Child-Theme): Anpassung des Designs gemäß Beyond-Gotham-CI. Das beinhaltet Logo/Branding einbinden, Farbschema kontrollieren (laut Child-Theme sind Farben bereits definiert) und ggf. zusätzliches CSS für Feinheiten. Falls nötig, Templates anpassen: z.B. eigenes Template für Startseite oder InfoTerminal-Seite (um z.B. ein anderes Layout oder Vollbreite für die Demo zu ermöglichen).

Inhalte einpflegen: Struktur gemäß oben genannter Seiten erstellen. Platzhaltertext durch echte Inhalte ersetzen:

Startseitentexte (Einführung, aktuelle Meldungen),

Projektbeschreibungen verfassen und mit Bildern/Videos bestücken,

Teammitglieder-Profile schreiben und Fotos hinzufügen,

erste Blog-Artikel erstellen (evtl. vorhandene Berichte ausarbeiten und veröffentlichen),

Kontaktinformationen zusammentragen.
Hierbei auch passende Kategorien und Tags für Blogposts anlegen (z.B. Themengebiete) und Menüs navigationsfreundlich einrichten.

Integration der InfoTerminal-Demo: Die WordPress-Seite "InfoTerminal" nutzt jetzt das Template `page-infoterminal.php`. Darüber lassen sich Features redaktionell beschreiben und – falls gewünscht – eine externe Demo via benutzerdefiniertem Feld `_bg_infoterminal_embed_url` per `<iframe>` einbinden. Nach dem Hinterlegen der Ziel-URL sollte die Einbettung auf verschiedenen Geräten getestet werden (Ladezeit, Responsivität, Datenschutz-Hinweis).

Responsives Design testen: Die Website auf verschiedenen Bildschirmgrößen (Desktop, Tablet, Smartphone) prüfen. Das FreeNews-Theme ist von Haus aus responsiv, dennoch müssen die Anpassungen (z.B. eingefügte iframes, Tabellen oder Medien in Blogposts) auf kleinen Displays gut funktionieren. Gegebenenfalls CSS-Media-Queries im Child-Theme ergänzen, um z.B. Schriftgrößen oder Abstände mobil zu optimieren.

Plugin-Setup und Konfiguration: Installierte Plugins einrichten:

Kontaktformular testen (Testmail versenden, Spamschutz aktivieren z.B. via Captcha),

SEO-Plugin konfigurieren (Seitentitel, Meta-Beschreibungen für Hauptseiten verfassen, Social Sharing Bilder definieren),

Caching einrichten (Cache pre-loaden, Regeln für wann Cache invalidiert wird bei neuen Posts),

Cookie-Consent-Banner gestalten mit korrekten Texten (zweisprachig Deutsch/Englisch falls nötig).

Performance-Optimierung: Vor Launch die Ladezeiten analysieren. Bilder mit geeigneter Auflösung/Webformaten einsetzen (ggf. mit Plugin optimieren), unnötige Plugins vermeiden, Google Fonts lokal hosten (falls Theme welche nutzt, um DSGVO zu entsprechen), und prüfen, ob die InfoTerminal-Demo das Laden der Seite verlangsamt. Falls ja, evtl. die Demo-Seite von bestimmten Scripts der Hauptseite entkoppeln.

Testing & Go-Live: Umfassende Tests durchführen – Funktionalität aller Links, Formulare (erhält Team die Kontakt-Anfragen per Mail?), Darstellung in verschiedenen Browsern (Chrome, Firefox, Safari, Edge), sowie grundlegende SEO-Checks (erscheinen Seiten korrekt in Google-Suchergebnissen, sind noindex-Tags entfernt für Live?). Bei erfolgreichem Testen Deployment auf den Live-Server (bei IONOS) durchführen, z.B. mittels der konfigurierten GitHub Actions für SFTP-Upload
GitHub
. Anschließend letzte Prüfungen direkt auf der Live-Seite (HTTPS, Performance unter realen Bedingungen) vornehmen.

Durch diese Schritte entsteht eine professionelle Webpräsenz, die sowohl inhaltlich die Arbeit von Beyond-Gotham präsentiert, als auch technisch stabil und zukunftssicher läuft. Die Kombination aus einem ansprechenden Nachrichten-Layout und der Integration des innovativen InfoTerminal-Demos vermittelt den Besuchern ein klares Bild von Beyond-Gothams Kompetenz und Mission. Mit fortlaufender Pflege – regelmäßige Blog-Updates, Sicherheitsupdates und ggf. Erweiterungen (etwa Einbindung neuer InfoTerminal-Funktionen) – wird die Website zu einem lebendigen Dreh- und Angelpunkt für alle, die sich für “Investigative Intelligence” und humanitäre Wirkung interessieren.
