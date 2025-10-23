<?php
/**
 * Template Name: Über uns / Mission
 * Description: Vorstellung der Beyond_Gotham Organisation, Mission und Werte
 */

get_header(); ?>

<main id="primary" class="site-main page-about" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <!-- Hero Section -->
    <section class="about-hero" style="
        padding:80px 0;
        background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
        text-align:center;
        margin-bottom:80px;
    ">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <h1 style="
                margin:0 0 24px;
                font-size:clamp(2.5rem, 5vw, 4rem);
                line-height:1.1;
                font-weight:800;
            ">
                Wahrheit, Technik<br>und Hilfe vereint
            </h1>
            <p style="
                margin:0;
                font-size:1.4rem;
                color:var(--muted);
                max-width:800px;
                margin:0 auto;
                line-height:1.6;
            ">
                Beyond_Gotham ist eine sozialunternehmerische Organisation aus Leipzig,<br>
                die investigativen Journalismus, OSINT-Analyse und humanitäre Hilfe<br>
                in Krisen- und Konfliktregionen zusammenführt.
            </p>
        </div>
    </section>

    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">

        <!-- Mission Statement -->
        <section class="mission-section" style="margin-bottom:80px;">
            <div style="
                background:var(--bg-2);
                border:1px solid var(--line);
                border-left:4px solid var(--accent);
                border-radius:12px;
                padding:48px;
            ">
                <div style="display:flex;align-items:start;gap:24px;">
                    <div style="font-size:4rem;line-height:1;">🎯</div>
                    <div>
                        <h2 style="margin:0 0 16px;font-size:2rem;">Unsere Mission</h2>
                        <p style="
                            margin:0;
                            font-size:1.3rem;
                            line-height:1.8;
                            color:var(--fg);
                        ">
                            <strong style="color:var(--accent);">„Wir bringen Wahrheit, Technik und Hilfe dorthin, wo sie am dringendsten gebraucht werden."</strong>
                        </p>
                        <p style="margin:16px 0 0;font-size:1.1rem;line-height:1.8;color:var(--muted);">
                            Wir kombinieren OSINT-Verifikation, investigativen Journalismus und medizinische Ersthilfe 
                            in einem einzigartigen Ansatz. Unsere interdisziplinären Teams führen Recherche-Missionen 
                            vor Ort durch und hinterlassen nachhaltige Strukturen durch lokale Ausbildung und Equipment-Spenden.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Was wir tun -->
        <section class="what-we-do" style="margin-bottom:80px;">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Was wir tun
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:32px;">
                
                <!-- OSINT & Datenanalyse -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                ">
                    <div style="font-size:3rem;margin-bottom:16px;">🔍</div>
                    <h3 style="margin:0 0 12px;font-size:1.5rem;">OSINT & Datenanalyse</h3>
                    <ul style="list-style:none;padding:0;margin:0;color:var(--muted);line-height:1.8;">
                        <li>✓ Verifikation von Informationen</li>
                        <li>✓ Geo- und Zeitanalysen</li>
                        <li>✓ Digitale Forensik</li>
                        <li>✓ Fact-Checking</li>
                    </ul>
                </div>

                <!-- Investigativer Journalismus -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                ">
                    <div style="font-size:3rem;margin-bottom:16px;">📰</div>
                    <h3 style="margin:0 0 12px;font-size:1.5rem;">Investigativer Journalismus</h3>
                    <ul style="list-style:none;padding:0;margin:0;color:var(--muted);line-height:1.8;">
                        <li>✓ Tiefgehende Recherche</li>
                        <li>✓ Interviews vor Ort</li>
                        <li>✓ Ethische Standards</li>
                        <li>✓ Veröffentlichung von Dossiers</li>
                    </ul>
                </div>

                <!-- Medizinische Ersthilfe -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                ">
                    <div style="font-size:3rem;margin-bottom:16px;">🚑</div>
                    <h3 style="margin:0 0 12px;font-size:1.5rem;">Medizinische Ersthilfe</h3>
                    <ul style="list-style:none;padding:0;margin:0;color:var(--muted);line-height:1.8;">
                        <li>✓ Notfallversorgung</li>
                        <li>✓ Sanitätsdienste</li>
                        <li>✓ Medizinische Ausbildung</li>
                        <li>✓ Equipment-Spenden</li>
                    </ul>
                </div>

                <!-- Ausbildung & Empowerment -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                ">
                    <div style="font-size:3rem;margin-bottom:16px;">🎓</div>
                    <h3 style="margin:0 0 12px;font-size:1.5rem;">Ausbildung & Empowerment</h3>
                    <ul style="list-style:none;padding:0;margin:0;color:var(--muted);line-height:1.8;">
                        <li>✓ Schulungen für lokale Teams</li>
                        <li>✓ Wissenstransfer</li>
                        <li>✓ Bildungsprogramme</li>
                        <li>✓ Nachhaltige Strukturen</li>
                    </ul>
                </div>

            </div>
        </section>

        <!-- Wie wir arbeiten -->
        <section class="how-we-work" style="margin-bottom:80px;">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Wie wir arbeiten
            </h2>

            <div style="
                background:var(--bg-2);
                border:1px solid var(--line);
                border-radius:12px;
                padding:48px;
            ">
                <div style="display:grid;gap:32px;">
                    
                    <!-- Mission 1-6 Monate -->
                    <div style="display:grid;grid-template-columns:80px 1fr;gap:24px;align-items:start;">
                        <div style="
                            width:80px;
                            height:80px;
                            background:var(--accent);
                            color:#001018;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:2rem;
                            font-weight:700;
                        ">1</div>
                        <div>
                            <h3 style="margin:0 0 8px;font-size:1.5rem;">Missions-Planung</h3>
                            <p style="margin:0;color:var(--muted);line-height:1.8;">
                                Interdisziplinäre Teams (2-4 Personen) mit Expertise in Rettungsdienst, 
                                IT/Forensik und Journalismus/OSINT bereiten sich auf 1-6-monatige Einsätze vor.
                            </p>
                        </div>
                    </div>

                    <!-- Vor Ort -->
                    <div style="display:grid;grid-template-columns:80px 1fr;gap:24px;align-items:start;">
                        <div style="
                            width:80px;
                            height:80px;
                            background:var(--accent);
                            color:#001018;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:2rem;
                            font-weight:700;
                        ">2</div>
                        <div>
                            <h3 style="margin:0 0 8px;font-size:1.5rem;">Einsatz vor Ort</h3>
                            <p style="margin:0;color:var(--muted);line-height:1.8;">
                                Mit mobilem Pressefahrzeug und Krankenwagen sammeln wir Daten, 
                                leisten medizinische Hilfe und bauen lokale Strukturen auf.
                            </p>
                        </div>
                    </div>

                    <!-- Equipment-Spende -->
                    <div style="display:grid;grid-template-columns:80px 1fr;gap:24px;align-items:start;">
                        <div style="
                            width:80px;
                            height:80px;
                            background:var(--accent);
                            color:#001018;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:2rem;
                            font-weight:700;
                        ">3</div>
                        <div>
                            <h3 style="margin:0 0 8px;font-size:1.5rem;">Nachhaltige Übergabe</h3>
                            <p style="margin:0;color:var(--muted);line-height:1.8;">
                                Am Ende jeder Mission bleibt der vollständig ausgestattete Krankenwagen 
                                als Spende vor Ort, damit lokale Partner die Arbeit fortführen können.
                            </p>
                        </div>
                    </div>

                    <!-- Veröffentlichung -->
                    <div style="display:grid;grid-template-columns:80px 1fr;gap:24px;align-items:start;">
                        <div style="
                            width:80px;
                            height:80px;
                            background:var(--accent);
                            color:#001018;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:2rem;
                            font-weight:700;
                        ">4</div>
                        <div>
                            <h3 style="margin:0 0 8px;font-size:1.5rem;">Veröffentlichung & Impact</h3>
                            <p style="margin:0;color:var(--muted);line-height:1.8;">
                                Die Ergebnisse fließen in verifizierte Dossiers, investigative Reportagen 
                                und evidenzbasierte Datenbanken zur Aufklärung und weiteren humanitären Nutzung.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Unsere Werte -->
        <section class="values" style="margin-bottom:80px;">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Unsere Werte
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:24px;">
                
                <div style="text-align:center;padding:32px;">
                    <div style="font-size:3rem;margin-bottom:16px;">🎯</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Faktentreue</h3>
                    <p style="margin:0;color:var(--muted);">Verifizierte Informationen, keine Spekulation</p>
                </div>

                <div style="text-align:center;padding:32px;">
                    <div style="font-size:3rem;margin-bottom:16px;">🤝</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Humanität</h3>
                    <p style="margin:0;color:var(--muted);">Menschen vor Profit, Hilfe vor Headlines</p>
                </div>

                <div style="text-align:center;padding:32px;">
                    <div style="font-size:3rem;margin-bottom:16px;">🔓</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Transparenz</h3>
                    <p style="margin:0;color:var(--muted);">Open-Source-Prinzipien, offene Methoden</p>
                </div>

                <div style="text-align:center;padding:32px;">
                    <div style="font-size:3rem;margin-bottom:16px;">⚖️</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Ethik</h3>
                    <p style="margin:0;color:var(--muted);">Strikte ethische Standards bei jeder Recherche</p>
                </div>

            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section" style="
            background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
            border-radius:12px;
            padding:64px;
            text-align:center;
        ">
            <h2 style="margin:0 0 24px;font-size:2.5rem;">
                Werde Teil der Mission
            </h2>
            <p style="
                margin:0 0 32px;
                font-size:1.2rem;
                color:var(--muted);
                max-width:600px;
                margin-left:auto;
                margin-right:auto;
            ">
                Ob als Kursteilnehmer, Partner oder Unterstützer –<br>
                gemeinsam machen wir einen Unterschied.
            </p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="/kurse/" class="btn" style="
                    padding:16px 32px;
                    background:var(--accent);
                    color:#001018;
                    border-radius:6px;
                    font-weight:600;
                    text-decoration:none;
                ">
                    Unsere Kurse
                </a>
                <a href="/kontakt/" class="btn" style="
                    padding:16px 32px;
                    background:transparent;
                    color:var(--fg);
                    border:2px solid var(--line);
                    border-radius:6px;
                    font-weight:600;
                    text-decoration:none;
                ">
                    Kontakt aufnehmen
                </a>
            </div>
        </section>

    </div>

</main>

<?php get_footer(); ?>
