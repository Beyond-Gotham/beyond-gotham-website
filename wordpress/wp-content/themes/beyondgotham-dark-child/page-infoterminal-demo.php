<?php
/**
 * Template Name: InfoTerminal Demo
 * Description: Embed the static InfoTerminal React demo via iframe.
 *
 * @package BeyondGotham
 */

get_header();
?>

<main id="primary" class="site-main" style="padding:0; background:#111; color:#f5f5f5; min-height:100vh;">
    <article class="page type-page infoterminal-demo" style="margin:0;">
        <header class="page-header" style="padding:80px 0 32px; text-align:center;">
            <div class="container" style="max-width:960px; margin:0 auto; padding:0 24px;">
                <h1 class="page-title" style="margin:0 0 16px; font-size:clamp(2.5rem, 6vw, 3.5rem); font-weight:800; letter-spacing:-0.02em;">
                    InfoTerminal Demo
                </h1>
                <p style="margin:0 auto; max-width:720px; font-size:1.05rem; line-height:1.7; color:#c8c8c8;">
                    Diese Seite bindet den statischen Build der React/TypeScript-Anwendung InfoTerminal ein.
                    Die Demo wird ohne Backend vollständig im Browser ausgeführt.
                </p>
            </div>
        </header>

        <div class="page-content" style="padding:0 0 120px;">
            <div class="container" style="max-width:1200px; margin:0 auto; padding:0 24px;">
                <div style="border-radius:18px; overflow:hidden; box-shadow:0 30px 80px rgba(0,0,0,0.45); border:1px solid rgba(255,255,255,0.08);">
                    <iframe 
                      src="/infoterminal-demo/index.html" 
                      width="100%" 
                      height="900px" 
                      style="border: none; background: #111;">
                    </iframe>
                </div>
            </div>
        </div>
    </article>
</main>

<?php
get_footer();
