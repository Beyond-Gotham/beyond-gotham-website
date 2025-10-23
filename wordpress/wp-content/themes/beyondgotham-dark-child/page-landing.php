<?php
/**
 * Template Name: Landing Page (Hero)
 * Description: Conversion-optimierte Startseite mit Hero-Section
 */

get_header(); ?>

<main id="primary" class="site-main landing-page" style="padding:0;background:var(--bg);color:var(--fg);">

<!-- ================================
     HERO SECTION
     ================================ -->
<section class="hero-section" style="
    position:relative;
    min-height:90vh;
    display:flex;
    align-items:center;
    background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg) 100%);
    overflow:hidden;
">
    <!-- Animated Background -->
    <div class="hero-bg" style="
        position:absolute;
        top:0;left:0;right:0;bottom:0;
        opacity:0.1;
        background-image:
            radial-gradient(circle at 20% 50%, var(--accent) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, var(--accent-2) 0%, transparent 50%);
        animation:pulse 8s ease-in-out infinite;
    "></div>

    <div class="container" style="position:relative;z-index:10;max-width:1200px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;">
            
            <!-- Left: Content -->
            <div class="hero-content">
                <div class="hero-badge" style="
                    display:inline-block;
                    padding:8px 16px;
                    background:var(--bg-3);
                    border:1px solid var(--line);
                    border-radius:20px;
                    margin-bottom:24px;
                    font-size:14px;
                    color:var(--accent);
                ">
                    🚀 AZAV-zertifizierte Ausbildung
                </div>

                <h1 style="
                    margin:0 0 24px;
                    font-size:clamp(2.5rem, 5vw, 4rem);
                    line-height:1.1;
                    font-weight:800;
                    background:linear-gradient(135deg, var(--fg) 0%, var(--accent) 100%);
                    -webkit-background-clip:text;
                    -webkit-text-fill-color:transparent;
                    background-clip:text;
                ">
                    Investigativer<br>Journalismus<br>neu gedacht
                </h1>

                <p style="
                    margin:0 0 32px;
                    font-size:1.25rem;
                    line-height:1.6;
                    color:var(--muted);
                    max-width:540px;
                ">
                    Wir vereinen <strong style="color:var(--accent);">OSINT</strong>, 
                    <strong style="color:var(--accent);">Datenanalyse</strong> und 
                    <strong style="color:var(--accent);">humanitäre Ersthilfe</strong> 
                    in einem einzigartigen Ausbildungskonzept.
                </p>

                <div class="hero-cta" style="display:flex;gap:16px;flex-wrap:wrap;">
                    <a href="/kurse/" class="btn btn--cta">
                        Kurse entdecken
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <a href="/infoterminal/" class="btn btn--cta btn--outline">
                        InfoTerminal testen
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="trust-indicators" style="
                    margin-top:48px;
                    display:flex;
                    gap:32px;
                    padding-top:32px;
                    border-top:1px solid var(--line);
                ">
                    <div class="indicator">
                        <div style="font-size:2rem;font-weight:800;color:var(--accent);">500+</div>
                        <div style="font-size:0.9rem;color:var(--muted);">Absolventen</div>
                    </div>
                    <div class="indicator">
                        <div style="font-size:2rem;font-weight:800;color:var(--accent);">95%</div>
                        <div style="font-size:0.9rem;color:var(--muted);">Zufriedenheit</div>
                    </div>
                    <div class="indicator">
                        <div style="font-size:2rem;font-weight:800;color:var(--accent);">12+</div>
                        <div style="font-size:0.9rem;color:var(--muted);">Partner</div>
                    </div>
                </div>
            </div>

            <!-- Right: Visual -->
            <div class="hero-visual" style="position:relative;">
                <!-- Placeholder: Hier kann später ein Video/Animation/Screenshot -->
                <div style="
                    position:relative;
                    background:var(--bg-3);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                    box-shadow:0 20px 60px rgba(0,0,0,0.4);
                ">
                    <!-- Terminal-Style Preview -->
                    <div class="terminal-preview" style="
                        background:#0a0e14;
                        border-radius:8px;
                        padding:16px;
                        font-family:'Monaco','Courier New',monospace;
                        font-size:14px;
                        line-height:1.6;
                        color:#4caf50;
                    ">
                        <div style="color:#888;margin-bottom:8px;">$ it up --preset journalism</div>
                        <div style="color:#33d1ff;">✓ OpenSearch ready</div>
                        <div style="color:#33d1ff;">✓ Neo4j graph online</div>
                        <div style="color:#33d1ff;">✓ Verification layer active</div>
                        <div style="margin-top:12px;color:#4caf50;">
                            > InfoTerminal ready on<br>
                            > http://localhost:3411
                        </div>
                        <div style="margin-top:12px;color:#888;">_</div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div style="
                    position:absolute;
                    top:-20px;
                    right:-20px;
                    width:100px;
                    height:100px;
                    background:var(--accent);
                    opacity:0.1;
                    border-radius:50%;
                    animation:float 6s ease-in-out infinite;
                "></div>
            </div>

        </div>
    </div>
</section>


<!-- ================================
     FEATURES SECTION
     ================================ -->
<section class="features-section" style="
    padding:120px 0;
    background:var(--bg-2);
">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
        
        <div class="section-header" style="text-align:center;margin-bottom:64px;">
            <h2 style="
                margin:0 0 16px;
                font-size:2.5rem;
                font-weight:700;
            ">
                Was macht uns einzigartig?
            </h2>
            <p style="
                margin:0;
                font-size:1.2rem;
                color:var(--muted);
                max-width:600px;
                margin:0 auto;
            ">
                Die Kombination aus Theorie, Praxis und echten Einsätzen
            </p>
        </div>

        <div class="features-grid" style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));
            gap:32px;
        ">
            
            <?php
            $features = [
                [
                    'icon' => '🔍',
                    'title' => 'OSINT & Verifikation',
                    'desc' => 'Professionelle Open-Source Intelligence Methoden, Fact-Checking und digitale Forensik',
                ],
                [
                    'icon' => '🚑',
                    'title' => 'Medizinische Ersthilfe',
                    'desc' => 'Rettungssanitäter-Ausbildung für sichere Einsätze in Krisengebieten',
                ],
                [
                    'icon' => '💻',
                    'title' => 'IT Security',
                    'desc' => 'Linux Administration, Netzwerksicherheit und OPSEC für Recherche-Teams',
                ],
                [
                    'icon' => '📰',
                    'title' => 'Investigativer Journalismus',
                    'desc' => 'Datenanalyse, Storytelling und ethische Standards für moderne Berichterstattung',
                ],
                [
                    'icon' => '🌍',
                    'title' => 'Praxis-Missionen',
                    'desc' => '1-6 monatige Einsätze mit echten Rechercheprojekten und lokalem Impact',
                ],
                [
                    'icon' => '🎓',
                    'title' => 'AZAV-Zertifiziert',
                    'desc' => 'Bildungsgutschein-fähig, staatlich anerkannt und arbeitsmarktnah',
                ],
            ];

            foreach ($features as $feature):
            ?>
            <div class="feature-card" style="
                background:var(--bg);
                border:1px solid var(--line);
                border-radius:12px;
                padding:32px;
                transition:transform 0.3s, box-shadow 0.3s, border-color 0.3s;
            " onmouseover="this.style.transform='translateY(-8px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.3)';this.style.borderColor='var(--accent)'" onmouseout="this.style.transform='';this.style.boxShadow='';this.style.borderColor='var(--line)'">
                <div style="font-size:3rem;margin-bottom:16px;"><?php echo $feature['icon']; ?></div>
                <h3 style="margin:0 0 12px;font-size:1.5rem;color:var(--fg);"><?php echo $feature['title']; ?></h3>
                <p style="margin:0;color:var(--muted);line-height:1.6;"><?php echo $feature['desc']; ?></p>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>


<!-- ================================
     TESTIMONIALS SECTION
     ================================ -->
<section class="testimonials-section" style="
    padding:120px 0;
    background:var(--bg);
">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
        
        <div class="section-header" style="text-align:center;margin-bottom:64px;">
            <h2 style="
                margin:0 0 16px;
                font-size:2.5rem;
                font-weight:700;
            ">
                Was unsere Absolventen sagen
            </h2>
        </div>

        <div class="testimonials-grid" style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
            gap:32px;
        ">
            
            <?php
            $testimonials = [
                [
                    'name' => 'Sarah M.',
                    'role' => 'OSINT-Analystin',
                    'text' => 'Die Kombination aus Theorie und echten Rechercheprojekten hat mich perfekt auf meinen Job vorbereitet. Das InfoTerminal nutze ich heute täglich.',
                    'rating' => 5,
                ],
                [
                    'name' => 'Marcus K.',
                    'role' => 'Investigativ-Journalist',
                    'text' => 'Beyond_Gotham war mein Sprungbrett in den investigativen Journalismus. Die Dozenten sind Top-Praktiker, keine theoretischen Akademiker.',
                    'rating' => 5,
                ],
                [
                    'name' => 'Lisa T.',
                    'role' => 'IT-Security Specialist',
                    'text' => 'Dank der LPIC-Ausbildung und der OSINT-Komponente habe ich einen einzigartigen Skill-Mix, der mich auf dem Arbeitsmarkt hervorhebt.',
                    'rating' => 5,
                ],
            ];

            foreach ($testimonials as $testimonial):
            ?>
            <div class="testimonial-card" style="
                background:var(--bg-2);
                border:1px solid var(--line);
                border-radius:12px;
                padding:32px;
            ">
                <!-- Stars -->
                <div style="margin-bottom:16px;color:var(--accent);">
                    <?php for ($i = 0; $i < $testimonial['rating']; $i++) echo '★'; ?>
                </div>

                <!-- Quote -->
                <p style="
                    margin:0 0 24px;
                    font-size:1.1rem;
                    line-height:1.6;
                    color:var(--fg);
                    font-style:italic;
                ">
                    "<?php echo $testimonial['text']; ?>"
                </p>

                <!-- Author -->
                <div style="
                    display:flex;
                    align-items:center;
                    gap:16px;
                    padding-top:16px;
                    border-top:1px solid var(--line);
                ">
                    <div style="
                        width:48px;
                        height:48px;
                        border-radius:50%;
                        background:var(--accent);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-weight:700;
                        color:#001018;
                    ">
                        <?php echo substr($testimonial['name'], 0, 1); ?>
                    </div>
                    <div>
                        <div style="font-weight:600;color:var(--fg);"><?php echo $testimonial['name']; ?></div>
                        <div style="font-size:0.9rem;color:var(--muted);"><?php echo $testimonial['role']; ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>


<!-- ================================
     CTA SECTION
     ================================ -->
<section class="cta-section" style="
    padding:120px 0;
    background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
    text-align:center;
">
    <div class="container" style="max-width:800px;margin:0 auto;padding:0 24px;">
        
        <h2 style="
            margin:0 0 24px;
            font-size:3rem;
            font-weight:700;
            line-height:1.2;
        ">
            Bereit für den nächsten<br>Karriereschritt?
        </h2>

        <p style="
            margin:0 0 40px;
            font-size:1.3rem;
            color:var(--muted);
            line-height:1.6;
        ">
            Starte deine Ausbildung mit Bildungsgutschein oder buche ein<br>
            kostenloses Beratungsgespräch mit unserem Team.
        </p>

        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="/kurse/" class="btn" style="
                padding:16px 40px;
                background:var(--accent);
                color:#001018;
                border:none;
                border-radius:6px;
                font-weight:600;
                font-size:1.2rem;
                text-decoration:none;
            ">
                Kursübersicht ansehen
            </a>

            <a href="/kontakt/" class="btn" style="
                padding:16px 40px;
                background:transparent;
                color:var(--fg);
                border:2px solid var(--line);
                border-radius:6px;
                font-weight:600;
                font-size:1.2rem;
                text-decoration:none;
            ">
                Beratung vereinbaren
            </a>
        </div>

        <!-- Newsletter -->
        <div style="
            margin-top:64px;
            padding:40px;
            background:var(--bg);
            border:1px solid var(--line);
            border-radius:12px;
        ">
            <h3 style="margin:0 0 16px;">Newsletter abonnieren</h3>
            <p style="margin:0 0 24px;color:var(--muted);">
                Erhalte Updates zu neuen Kursen, Events und OSINT-Ressourcen
            </p>
            <form method="post" action="/newsletter/" style="
                display:flex;
                gap:12px;
                max-width:500px;
                margin:0 auto;
            ">
                <input type="email" name="email" placeholder="deine@email.de" required style="
                    flex:1;
                    padding:12px 16px;
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:6px;
                    color:var(--fg);
                ">
                <button type="submit" style="
                    padding:12px 24px;
                    background:var(--accent);
                    color:#001018;
                    border:none;
                    border-radius:6px;
                    font-weight:600;
                    cursor:pointer;
                ">
                    Anmelden
                </button>
            </form>
        </div>

    </div>
</section>


<!-- CSS Animations -->
<style>
@keyframes pulse {
    0%, 100% { opacity: 0.05; }
    50% { opacity: 0.15; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@media (max-width: 768px) {
    .hero-section > .container > div {
        grid-template-columns: 1fr !important;
        gap: 32px !important;
    }
    
    .hero-content h1 {
        font-size: 2rem !important;
    }
    
    .trust-indicators {
        flex-direction: column !important;
        gap: 16px !important;
    }
}
</style>

</main>

<?php get_footer(); ?>
