<?php
/**
 * Template Name: InfoTerminal Demo
 * Description: Embed the static InfoTerminal React demo via iframe.
 *
 * @package BeyondGotham
 */

get_header();
?>

<main id="infoterminal-demo" class="page-infoterminal" style="
    padding:0;
    background:var(--bg-darker, #0b0b0f);
    color:var(--fg, #f5f5f5);
    min-height:100vh;
">
    <section style="padding:80px 0 40px; text-align:center;">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <header style="margin-bottom:40px;">
                <p style="
                    margin:0 0 12px;
                    font-size:0.95rem;
                    letter-spacing:0.08em;
                    text-transform:uppercase;
                    color:var(--accent, #00d4ff);
                    font-weight:600;
                ">
                    React / TypeScript Showcase
                </p>
                <h1 style="
                    margin:0 0 16px;
                    font-size:clamp(2.5rem, 6vw, 3.5rem);
                    font-weight:800;
                    letter-spacing:-0.02em;
                ">
                    InfoTerminal Demo
                </h1>
                <p style="
                    margin:0 auto;
                    max-width:720px;
                    font-size:1.1rem;
                    line-height:1.7;
                    color:var(--muted, #a0a0a0);
                ">
                    Diese Einbettung zeigt die aktuelle React/TypeScript-Version des InfoTerminal-Frontends.
                    Die Anwendung wird komplett statisch ausgeliefert und läuft vollständig im Browser.
                </p>
            </header>
        </div>
    </section>

    <section style="padding:0 0 120px;">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <div style="
                position:relative;
                border-radius:18px;
                overflow:hidden;
                background:#111;
                box-shadow:0 30px 80px rgba(0, 0, 0, 0.45);
                border:1px solid rgba(255,255,255,0.08);
            ">
                <iframe
                    src="/infoterminal-demo/index.html"
                    width="100%"
                    height="900px"
                    style="border: none; background: #111; display:block; width:100%;"
                    title="InfoTerminal React Demo"
                    loading="lazy"
                ></iframe>
            </div>
            <p style="
                margin:24px auto 0;
                max-width:680px;
                text-align:center;
                font-size:0.95rem;
                color:var(--muted, #8a8a8a);
            ">
                Hinweis: Die Demo ist als statischer Build eingebunden. Bei Änderungen am Frontend muss der Build
                erneut erzeugt und in das <code>infoterminal-demo</code>-Verzeichnis kopiert werden.
            </p>
        </div>
    </section>
</main>

<?php
get_footer();
