<?php
/**
 * Template Name: Team
 * Description: Vorstellung des Beyond_Gotham Teams
 */

get_header(); ?>

<main id="primary" class="site-main page-team" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <!-- Hero -->
    <section class="team-hero" style="
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
                Das Team hinter<br>Beyond_Gotham
            </h1>
            <p style="
                margin:0;
                font-size:1.4rem;
                color:var(--muted);
                max-width:800px;
                margin:0 auto;
                line-height:1.6;
            ">
                Investigative Journalist:innen, OSINT-Expert:innen,<br>
                Rettungssanitäter:innen und IT-Spezialist:innen
            </p>
        </div>
    </section>

    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">

        <!-- Kernteam -->
        <section class="core-team" style="margin-bottom:100px;">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2.5rem;
            ">
                Geschäftsführung & Leitung
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:48px;">
                
                <!-- Team Member 1 -->
                <article class="team-member" style="text-align:center;">
                    <div style="
                        width:200px;
                        height:200px;
                        margin:0 auto 24px;
                        border-radius:50%;
                        background:linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                        color:#001018;
                        font-weight:700;
                        border:4px solid var(--bg-2);
                    ">
                        JD
                    </div>

                    <h3 style="margin:0 0 8px;font-size:1.8rem;">
                        Dr. Jane Doe
                    </h3>

                    <div style="
                        display:inline-block;
                        padding:6px 16px;
                        background:var(--bg-2);
                        border:1px solid var(--line);
                        border-radius:20px;
                        font-size:14px;
                        color:var(--accent);
                        margin-bottom:16px;
                    ">
                        Geschäftsführerin & Gründerin
                    </div>

                    <p style="margin:0 0 24px;color:var(--muted);line-height:1.8;">
                        15+ Jahre investigativer Journalismus, spezialisiert auf Konfliktberichterstattung 
                        und OSINT-Methoden. Ausbildung an der Columbia School of Journalism, 
                        mehrfache Preisträgerin für investigative Recherchen.
                    </p>

                    <div style="display:flex;gap:12px;justify-content:center;">
                        <a href="https://linkedin.com/in/..." target="_blank" style="
                            width:40px;
                            height:40px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            in
                        </a>
                        <a href="https://twitter.com/..." target="_blank" style="
                            width:40px;
                            height:40px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            𝕏
                        </a>
                    </div>
                </article>

                <!-- Team Member 2 -->
                <article class="team-member" style="text-align:center;">
                    <div style="
                        width:200px;
                        height:200px;
                        margin:0 auto 24px;
                        border-radius:50%;
                        background:linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                        color:#001018;
                        font-weight:700;
                        border:4px solid var(--bg-2);
                    ">
                        MS
                    </div>

                    <h3 style="margin:0 0 8px;font-size:1.8rem;">
                        Max Schmidt
                    </h3>

                    <div style="
                        display:inline-block;
                        padding:6px 16px;
                        background:var(--bg-2);
                        border:1px solid var(--line);
                        border-radius:20px;
                        font-size:14px;
                        color:var(--accent);
                        margin-bottom:16px;
                    ">
                        CTO & OSINT-Leitung
                    </div>

                    <p style="margin:0 0 24px;color:var(--muted);line-height:1.8;">
                        IT-Security-Experte mit 10+ Jahren Erfahrung in digitaler Forensik 
                        und OSINT-Tooling. Entwickler der InfoTerminal-Plattform, 
                        LPIC-3 zertifiziert, ehemals bei Europol.
                    </p>

                    <div style="display:flex;gap:12px;justify-content:center;">
                        <a href="https://github.com/..." target="_blank" style="
                            width:40px;
                            height:40px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        <a href="https://linkedin.com/in/..." target="_blank" style="
                            width:40px;
                            height:40px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            in
                        </a>
                    </div>
                </article>

                <!-- Team Member 3 -->
                <article class="team-member" style="text-align:center;">
                    <div style="
                        width:200px;
                        height:200px;
                        margin:0 auto 24px;
                        border-radius:50%;
                        background:linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:4rem;
                        color:#001018;
                        font-weight:700;
                        border:4px solid var(--bg-2);
                    ">
                        LM
                    </div>

                    <h3 style="margin:0 0 8px;font-size:1.8rem;">
                        Dr. med. Lisa Müller
                    </h3>

                    <div style="
                        display:inline-block;
                        padding:6px 16px;
                        background:var(--bg-2);
                        border:1px solid var(--line);
                        border-radius:20px;
                        font-size:14px;
                        color:var(--accent);
                        margin-bottom:16px;
                    ">
                        Medizinische Leitung
                    </div>

                    <p style="margin:0 0 24px;color:var(--muted);line-height:1.8;">
                        Notärztin mit 12 Jahren Erfahrung in Krisengebieten, 
                        Ausbilder für Tactical Combat Casualty Care (TCCC), 
                        ehemalige MSF-Koordinatorin, Spezialisierung auf Katastrophenmedizin.
                    </p>

                    <div style="display:flex;gap:12px;justify-content:center;">
                        <a href="https://linkedin.com/in/..." target="_blank" style="
                            width:40px;
                            height:40px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            in
                        </a>
                    </div>
                </article>

            </div>
        </section>

        <!-- Missions-Teams -->
        <section class="field-teams" style="margin-bottom:100px;">
            <h2 style="
                text-align:center;
                margin:0 0 24px;
                font-size:2.5rem;
            ">
                Unsere Einsatz-Teams
            </h2>
            <p style="
                text-align:center;
                margin:0 0 48px;
                font-size:1.2rem;
                color:var(--muted);
                max-width:700px;
                margin-left:auto;
                margin-right:auto;
            ">
                Interdisziplinäre Spezialist:innen, die gemeinsam<br>
                in Krisen- und Konfliktregionen arbeiten
            </p>

            <div style="
                background:var(--bg-2);
                border:1px solid var(--line);
                border-radius:12px;
                padding:48px;
            ">
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:32px;text-align:center;">
                    
                    <div>
                        <div style="font-size:3rem;margin-bottom:12px;">🔍</div>
                        <h4 style="margin:0 0 8px;font-size:1.2rem;">OSINT-Analyst:innen</h4>
                        <div style="color:var(--muted);font-size:0.9rem;">8 Spezialist:innen</div>
                    </div>

                    <div>
                        <div style="font-size:3rem;margin-bottom:12px;">📝</div>
                        <h4 style="margin:0 0 8px;font-size:1.2rem;">Journalist:innen</h4>
                        <div style="color:var(--muted);font-size:0.9rem;">6 Reporter:innen</div>
                    </div>

                    <div>
                        <div style="font-size:3rem;margin-bottom:12px;">🚑</div>
                        <h4 style="margin:0 0 8px;font-size:1.2rem;">Rettungskräfte</h4>
                        <div style="color:var(--muted);font-size:0.9rem;">5 Sanitäter:innen</div>
                    </div>

                    <div>
                        <div style="font-size:3rem;margin-bottom:12px;">💻</div>
                        <h4 style="margin:0 0 8px;font-size:1.2rem;">IT-Expert:innen</h4>
                        <div style="color:var(--muted);font-size:0.9rem;">4 Spezialist:innen</div>
                    </div>

                    <div>
                        <div style="font-size:3rem;margin-bottom:12px;">🌍</div>
                        <h4 style="margin:0 0 8px;font-size:1.2rem;">Koordinator:innen</h4>
                        <div style="color:var(--muted);font-size:0.9rem;">3 Projektleiter:innen</div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Ausbilder:innen -->
        <section class="instructors" style="margin-bottom:100px;">
            <h2 style="
                text-align:center;
                margin:0 0 24px;
                font-size:2.5rem;
            ">
                Unsere Ausbilder:innen
            </h2>
            <p style="
                text-align:center;
                margin:0 0 48px;
                font-size:1.2rem;
                color:var(--muted);
            ">
                Erfahrene Praktiker:innen unterrichten in unseren Kursen
            </p>

            <?php
            // Dozenten aus CPT laden
            $instructors = get_posts([
                'post_type' => 'bg_instructor',
                'posts_per_page' => 6,
                'orderby' => 'title',
                'order' => 'ASC'
            ]);

            if ($instructors):
            ?>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:32px;">
                <?php foreach ($instructors as $instructor): 
                    $qualification = get_post_meta($instructor->ID, '_bg_qualification', true);
                    $experience = get_post_meta($instructor->ID, '_bg_experience', true);
                ?>
                <article style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:24px;
                    text-align:center;
                ">
                    <?php if (has_post_thumbnail($instructor->ID)): ?>
                        <div style="
                            width:120px;
                            height:120px;
                            margin:0 auto 16px;
                            border-radius:50%;
                            overflow:hidden;
                            border:3px solid var(--line);
                        ">
                            <?php echo get_the_post_thumbnail($instructor->ID, 'thumbnail', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                        </div>
                    <?php else: ?>
                        <div style="
                            width:120px;
                            height:120px;
                            margin:0 auto 16px;
                            border-radius:50%;
                            background:var(--accent);
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:2.5rem;
                            color:#001018;
                            font-weight:700;
                        ">
                            <?php echo substr($instructor->post_title, 0, 2); ?>
                        </div>
                    <?php endif; ?>

                    <h3 style="margin:0 0 8px;font-size:1.3rem;">
                        <?php echo esc_html($instructor->post_title); ?>
                    </h3>

                    <?php if ($qualification): ?>
                        <div style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            border-radius:12px;
                            font-size:12px;
                            color:var(--muted);
                            margin-bottom:12px;
                        ">
                            <?php echo esc_html($qualification); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($experience): ?>
                        <div style="color:var(--accent);font-size:0.9rem;margin-bottom:12px;">
                            <?php echo esc_html($experience); ?> Jahre Erfahrung
                        </div>
                    <?php endif; ?>

                    <p style="margin:0 0 16px;color:var(--muted);line-height:1.6;font-size:0.95rem;">
                        <?php echo wp_trim_words(get_post_field('post_content', $instructor->ID), 15); ?>
                    </p>

                    <a href="<?php echo get_permalink($instructor->ID); ?>" style="color:var(--accent);font-weight:600;">
                        Profil ansehen →
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="text-align:center;color:var(--muted);font-size:1.1rem;">
                Unsere Dozent:innen werden in Kürze vorgestellt.
            </p>
            <?php endif; ?>
        </section>

        <!-- Join Team CTA -->
        <section class="cta-section" style="
            background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
            border-radius:12px;
            padding:64px;
            text-align:center;
        ">
            <h2 style="margin:0 0 24px;font-size:2.5rem;">
                Werde Teil des Teams
            </h2>
            <p style="
                margin:0 0 32px;
                font-size:1.2rem;
                color:var(--muted);
                max-width:600px;
                margin-left:auto;
                margin-right:auto;
            ">
                Wir suchen laufend qualifizierte Journalist:innen,<br>
                OSINT-Expert:innen, IT-Spezialist:innen und Rettungskräfte.
            </p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="/karriere/" class="btn" style="
                    padding:16px 32px;
                    background:var(--accent);
                    color:#001018;
                    border-radius:6px;
                    font-weight:600;
                    text-decoration:none;
                ">
                    Offene Stellen
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
                    Ausbildung starten
                </a>
            </div>
        </section>

    </div>

</main>

<?php get_footer(); ?>
