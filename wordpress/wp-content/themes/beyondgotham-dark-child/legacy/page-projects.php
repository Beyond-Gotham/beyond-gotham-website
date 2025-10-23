<?php
/**
 * Template Name: Projekte / Missionen
 * Description: Übersicht laufender und abgeschlossener Missions-Projekte
 */

get_header(); ?>

<main id="primary" class="site-main page-projects" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <!-- Hero -->
    <section class="projects-hero" style="
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
                Unsere Projekte<br>& Missionen
            </h1>
            <p style="
                margin:0;
                font-size:1.4rem;
                color:var(--muted);
                max-width:800px;
                margin:0 auto;
                line-height:1.6;
            ">
                Investigative Recherchen und humanitäre Einsätze<br>
                in Krisen- und Konfliktregionen weltweit
            </p>
        </div>
    </section>

    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">

        <!-- Laufende Missionen -->
        <section class="active-missions" style="margin-bottom:80px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;">
                <h2 style="margin:0;font-size:2.5rem;">
                    Aktive Missionen
                </h2>
                <div style="
                    padding:8px 16px;
                    background:var(--accent);
                    color:#001018;
                    border-radius:20px;
                    font-size:14px;
                    font-weight:700;
                ">
                    🔴 Live
                </div>
            </div>

            <div style="display:grid;gap:32px;">
                
                <!-- Beispiel-Mission 1 -->
                <article style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    overflow:hidden;
                    display:grid;
                    grid-template-columns:400px 1fr;
                    gap:0;
                ">
                    <!-- Bild/Map Placeholder -->
                    <div style="
                        background:linear-gradient(135deg, #1a1f2e 0%, #0f1419 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                        color:var(--muted);
                    ">
                        🗺️
                    </div>

                    <!-- Content -->
                    <div style="padding:32px;">
                        <div style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--accent);
                            color:#001018;
                            border-radius:4px;
                            font-size:12px;
                            font-weight:700;
                            margin-bottom:16px;
                        ">
                            LAUFEND SEIT: JAN 2025
                        </div>

                        <h3 style="margin:0 0 12px;font-size:2rem;">
                            Mission Levante – Syrien/Türkei Grenzgebiet
                        </h3>

                        <p style="margin:0 0 24px;color:var(--muted);line-height:1.8;">
                            Dokumentation der humanitären Situation nach dem Erdbeben 2023, 
                            Verifikation von Wiederaufbau-Versprechen und medizinische Unterstützung 
                            für lokale NGOs. Team: 3 Personen (OSINT, Rettungssanitäter, Journalist).
                        </p>

                        <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;margin-bottom:24px;">
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Dauer</div>
                                <div style="font-weight:700;">4 Monate</div>
                            </div>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Team</div>
                                <div style="font-weight:700;">3 Personen</div>
                            </div>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Status</div>
                                <div style="font-weight:700;color:var(--accent);">🔴 Aktiv</div>
                            </div>
                        </div>

                        <div style="display:flex;gap:12px;">
                            <a href="#" class="btn" style="
                                padding:10px 20px;
                                background:var(--accent);
                                color:#001018;
                                border-radius:6px;
                                font-weight:600;
                                text-decoration:none;
                            ">
                                Live Updates
                            </a>
                            <a href="#" class="btn" style="
                                padding:10px 20px;
                                background:transparent;
                                color:var(--fg);
                                border:2px solid var(--line);
                                border-radius:6px;
                                font-weight:600;
                                text-decoration:none;
                            ">
                                Mehr erfahren
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Weitere aktive Missionen können hier hinzugefügt werden -->

            </div>
        </section>

        <!-- Abgeschlossene Projekte -->
        <section class="completed-projects" style="margin-bottom:80px;">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Abgeschlossene Projekte
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(350px, 1fr));gap:32px;">
                
                <!-- Projekt 1 -->
                <article style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    overflow:hidden;
                ">
                    <div style="
                        height:200px;
                        background:linear-gradient(135deg, #1a1f2e 0%, #0f1419 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                    ">
                        🇺🇦
                    </div>

                    <div style="padding:24px;">
                        <div style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            color:var(--muted);
                            border-radius:4px;
                            font-size:12px;
                            font-weight:700;
                            margin-bottom:12px;
                        ">
                            2024 • 6 MONATE
                        </div>

                        <h3 style="margin:0 0 12px;font-size:1.5rem;">
                            Mission Ukraine – Donbas
                        </h3>

                        <p style="margin:0 0 16px;color:var(--muted);line-height:1.6;">
                            OSINT-Verifikation von Kriegsverbrechen, medizinische Versorgung 
                            in Frontgebieten, Equipment-Spende an lokale Rettungsdienste.
                        </p>

                        <div style="margin-bottom:16px;">
                            <div style="font-size:0.9rem;color:var(--muted);margin-bottom:8px;">
                                Ergebnisse:
                            </div>
                            <ul style="list-style:none;padding:0;margin:0;color:var(--fg);">
                                <li style="padding:4px 0;">✓ 47 verifizierte Vorfälle</li>
                                <li style="padding:4px 0;">✓ 3 Dossiers veröffentlicht</li>
                                <li style="padding:4px 0;">✓ 2 Krankenwagen gespendet</li>
                            </ul>
                        </div>

                        <a href="#" style="color:var(--accent);font-weight:600;">
                            Dossiers ansehen →
                        </a>
                    </div>
                </article>

                <!-- Projekt 2 -->
                <article style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    overflow:hidden;
                ">
                    <div style="
                        height:200px;
                        background:linear-gradient(135deg, #2e1a1f 0%, #19140f 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                    ">
                        🇲🇲
                    </div>

                    <div style="padding:24px;">
                        <div style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            color:var(--muted);
                            border-radius:4px;
                            font-size:12px;
                            font-weight:700;
                            margin-bottom:12px;
                        ">
                            2023 • 3 MONATE
                        </div>

                        <h3 style="margin:0 0 12px;font-size:1.5rem;">
                            Myanmar Rohingya Crisis
                        </h3>

                        <p style="margin:0 0 16px;color:var(--muted);line-height:1.6;">
                            Dokumentation der Flüchtlingssituation an der Grenze zu Bangladesch, 
                            Ausbildung lokaler Helfer in Ersthilfe.
                        </p>

                        <div style="margin-bottom:16px;">
                            <div style="font-size:0.9rem;color:var(--muted);margin-bottom:8px;">
                                Ergebnisse:
                            </div>
                            <ul style="list-style:none;padding:0;margin:0;color:var(--fg);">
                                <li style="padding:4px 0;">✓ 120+ Interviews</li>
                                <li style="padding:4px 0;">✓ 2 investigative Reportagen</li>
                                <li style="padding:4px 0;">✓ 15 lokale Helfer ausgebildet</li>
                            </ul>
                        </div>

                        <a href="#" style="color:var(--accent);font-weight:600;">
                            Berichte lesen →
                        </a>
                    </div>
                </article>

                <!-- Projekt 3 -->
                <article style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    overflow:hidden;
                ">
                    <div style="
                        height:200px;
                        background:linear-gradient(135deg, #1f2e1a 0%, #14190f 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                    ">
                        🇸🇾
                    </div>

                    <div style="padding:24px;">
                        <div style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            color:var(--muted);
                            border-radius:4px;
                            font-size:12px;
                            font-weight:700;
                            margin-bottom:12px;
                        ">
                            2022 • 5 MONATE
                        </div>

                        <h3 style="margin:0 0 12px;font-size:1.5rem;">
                            Syria Chemical Weapons
                        </h3>

                        <p style="margin:0 0 16px;color:var(--muted);line-height:1.6;">
                            OSINT-Analyse mutmaßlicher Chemiewaffeneinsätze, Verifikation 
                            von Videomaterial, Unterstützung internationaler Ermittler.
                        </p>

                        <div style="margin-bottom:16px;">
                            <div style="font-size:0.9rem;color:var(--muted);margin-bottom:8px;">
                                Ergebnisse:
                            </div>
                            <ul style="list-style:none;padding:0;margin:0;color:var(--fg);">
                                <li style="padding:4px 0;">✓ 23 Vorfälle analysiert</li>
                                <li style="padding:4px 0;">✓ ICC-Dokumentation</li>
                                <li style="padding:4px 0;">✓ Internationale Anerkennung</li>
                            </ul>
                        </div>

                        <a href="#" style="color:var(--accent);font-weight:600;">
                            Details ansehen →
                        </a>
                    </div>
                </article>

            </div>
        </section>

        <!-- Impact Stats -->
        <section class="impact-stats" style="
            background:var(--bg-2);
            border:1px solid var(--line);
            border-radius:12px;
            padding:64px 48px;
            margin-bottom:80px;
        ">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Unser Impact
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:32px;text-align:center;">
                
                <div>
                    <div style="font-size:3rem;font-weight:800;color:var(--accent);margin-bottom:8px;">
                        18
                    </div>
                    <div style="font-size:1.1rem;color:var(--muted);">
                        Missionen<br>abgeschlossen
                    </div>
                </div>

                <div>
                    <div style="font-size:3rem;font-weight:800;color:var(--accent);margin-bottom:8px;">
                        12
                    </div>
                    <div style="font-size:1.1rem;color:var(--muted);">
                        Länder<br>weltweit
                    </div>
                </div>

                <div>
                    <div style="font-size:3rem;font-weight:800;color:var(--accent);margin-bottom:8px;">
                        156
                    </div>
                    <div style="font-size:1.1rem;color:var(--muted);">
                        Verifizierte<br>Dossiers
                    </div>
                </div>

                <div>
                    <div style="font-size:3rem;font-weight:800;color:var(--accent);margin-bottom:8px;">
                        24
                    </div>
                    <div style="font-size:1.1rem;color:var(--muted);">
                        Fahrzeuge<br>gespendet
                    </div>
                </div>

                <div>
                    <div style="font-size:3rem;font-weight:800;color:var(--accent);margin-bottom:8px;">
                        340+
                    </div>
                    <div style="font-size:1.1rem;color:var(--muted);">
                        Lokale Helfer<br>ausgebildet
                    </div>
                </div>

            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section" style="
            background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
            border-radius:12px;
            padding:64px;
            text-align:center;
        ">
            <h2 style="margin:0 0 24px;font-size:2.5rem;">
                Unterstütze unsere Arbeit
            </h2>
            <p style="
                margin:0 0 32px;
                font-size:1.2rem;
                color:var(--muted);
                max-width:600px;
                margin-left:auto;
                margin-right:auto;
            ">
                Werde Teil unserer Missionen als Spender, Partner<br>
                oder absolviere eine Ausbildung bei uns.
            </p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="/spenden/" class="btn" style="
                    padding:16px 32px;
                    background:var(--accent);
                    color:#001018;
                    border-radius:6px;
                    font-weight:600;
                    text-decoration:none;
                ">
                    Jetzt spenden
                </a>
                <a href="/kurse/" class="btn" style="
                    padding:16px 32px;
                    background:transparent;
                    color:var(--fg);
                    border:2px solid var(--line);
                    border-radius:6px;
                    font-weight:600;
                    text-decoration:none;
                ">
                    Kurse entdecken
                </a>
            </div>
        </section>

    </div>

</main>

<?php get_footer(); ?>
