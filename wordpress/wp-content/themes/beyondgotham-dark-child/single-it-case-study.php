<?php
/**
 * Single Case Study Template
 * 
 * @package BeyondGotham
 */

get_header();

while (have_posts()): the_post();
    $duration = get_post_meta(get_the_ID(), '_case_duration', true);
    $difficulty = get_post_meta(get_the_ID(), '_case_difficulty', true);
    $tools = get_post_meta(get_the_ID(), '_case_tools', true);
    $techniques = get_post_meta(get_the_ID(), '_case_techniques', true);
    $outcome = get_post_meta(get_the_ID(), '_case_outcome', true);
    
    $difficulty_labels = [
        'beginner' => ['label' => 'Anfänger', 'color' => '#00ff88'],
        'intermediate' => ['label' => 'Fortgeschritten', 'color' => '#ffaa00'],
        'advanced' => ['label' => 'Experte', 'color' => '#ff4444'],
    ];
    
    $diff_info = $difficulty_labels[$difficulty] ?? ['label' => 'Unbekannt', 'color' => '#888'];
?>

<article class="single-case-study" style="
    background:var(--bg, #0f0f0f);
    color:var(--fg, #e0e0e0);
    min-height:100vh;
">
    
    <!-- Hero Header -->
    <header class="case-header" style="
        padding:80px 0 60px;
        background:linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-bottom:3px solid var(--accent, #00d4ff);
        position:relative;
        overflow:hidden;
    ">
        <div style="
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            opacity:0.05;
            background:url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Ccircle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;25&quot; stroke=&quot;%2300d4ff&quot; stroke-width=&quot;0.5&quot; fill=&quot;none&quot;/%3E%3C/svg%3E');
        "></div>
        
        <div class="container" style="max-width:900px;margin:0 auto;padding:0 24px;position:relative;">
            
            <!-- Breadcrumb -->
            <nav style="margin-bottom:24px;">
                <a href="<?php echo esc_url(home_url('/infoterminal/cases')); ?>" style="
                    color:var(--muted, #a0a0a0);
                    text-decoration:none;
                    display:inline-flex;
                    align-items:center;
                    gap:8px;
                " onmouseover="this.style.color='var(--accent, #00d4ff)';" 
                   onmouseout="this.style.color='var(--muted, #a0a0a0)';">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Zurück zur Übersicht
                </a>
            </nav>
            
            <!-- Category & Difficulty -->
            <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
                <?php
                $categories = get_the_terms(get_the_ID(), 'case_category');
                if ($categories && !is_wp_error($categories)):
                    foreach ($categories as $cat):
                ?>
                <span style="
                    padding:6px 14px;
                    background:rgba(0, 212, 255, 0.1);
                    color:var(--accent, #00d4ff);
                    border:1px solid rgba(0, 212, 255, 0.3);
                    border-radius:6px;
                    font-size:0.85rem;
                    font-weight:600;
                "><?php echo esc_html($cat->name); ?></span>
                <?php
                    endforeach;
                endif;
                ?>
                
                <span style="
                    padding:6px 14px;
                    background:<?php echo $diff_info['color']; ?>;
                    color:#000;
                    border-radius:6px;
                    font-size:0.85rem;
                    font-weight:600;
                "><?php echo esc_html($diff_info['label']); ?></span>
            </div>
            
            <!-- Title -->
            <h1 style="
                margin:0 0 24px;
                font-size:clamp(2rem, 5vw, 3.5rem);
                line-height:1.1;
                font-weight:800;
            "><?php the_title(); ?></h1>
            
            <!-- Meta Info -->
            <div style="
                display:flex;
                gap:32px;
                flex-wrap:wrap;
                padding:20px 0;
                border-top:1px solid rgba(255,255,255,0.1);
                border-bottom:1px solid rgba(255,255,255,0.1);
            ">
                <?php if ($duration): ?>
                <div style="display:flex;align-items:center;gap:10px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <div>
                        <div style="font-size:0.8rem;color:var(--muted, #a0a0a0);">Dauer</div>
                        <div style="font-weight:600;"><?php echo esc_html($duration); ?></div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($tools): ?>
                <div style="display:flex;align-items:center;gap:10px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                    <div>
                        <div style="font-size:0.8rem;color:var(--muted, #a0a0a0);">Tools</div>
                        <div style="font-weight:600;"><?php echo count(explode(',', $tools)); ?> verwendet</div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div style="display:flex;align-items:center;gap:10px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <div>
                        <div style="font-size:0.8rem;color:var(--muted, #a0a0a0);">Veröffentlicht</div>
                        <div style="font-weight:600;"><?php echo get_the_date(); ?></div>
                    </div>
                </div>
            </div>
            
        </div>
    </header>
    
    <!-- Main Content -->
    <main style="padding:60px 0;">
        <div class="container" style="max-width:900px;margin:0 auto;padding:0 24px;">
            
            <!-- Tools & Techniques Sidebar (Fixed on Desktop) -->
            <div style="display:grid;grid-template-columns:1fr 280px;gap:40px;align-items:start;">
                
                <!-- Content Column -->
                <div class="case-content" style="
                    font-size:1.1rem;
                    line-height:1.8;
                ">
                    <?php the_content(); ?>
                    
                    <!-- Outcome Box -->
                    <?php if ($outcome): ?>
                    <div style="
                        margin:40px 0;
                        padding:24px;
                        background:rgba(0, 255, 136, 0.05);
                        border-left:4px solid #00ff88;
                        border-radius:8px;
                    ">
                        <h4 style="
                            margin:0 0 12px;
                            font-size:1.2rem;
                            color:#00ff88;
                            display:flex;
                            align-items:center;
                            gap:10px;
                        ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Ergebnis
                        </h4>
                        <p style="margin:0;color:var(--fg, #e0e0e0);">
                            <?php echo esc_html($outcome); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- Sidebar -->
                <aside class="case-sidebar" style="position:sticky;top:100px;">
                    
                    <!-- Tools Used -->
                    <?php if ($tools): ?>
                    <div style="
                        margin-bottom:32px;
                        padding:20px;
                        background:rgba(255,255,255,0.02);
                        border:1px solid rgba(255,255,255,0.1);
                        border-radius:12px;
                    ">
                        <h4 style="
                            margin:0 0 16px;
                            font-size:1rem;
                            color:var(--accent, #00d4ff);
                            display:flex;
                            align-items:center;
                            gap:8px;
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                            Verwendete Tools
                        </h4>
                        <ul style="
                            margin:0;
                            padding:0;
                            list-style:none;
                            display:flex;
                            flex-direction:column;
                            gap:8px;
                        ">
                            <?php
                            $tools_array = array_map('trim', explode(',', $tools));
                            foreach ($tools_array as $tool):
                            ?>
                            <li style="
                                padding:8px 12px;
                                background:rgba(0,0,0,0.3);
                                border-radius:6px;
                                font-size:0.9rem;
                            "><?php echo esc_html($tool); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Techniques -->
                    <?php if ($techniques): ?>
                    <div style="
                        margin-bottom:32px;
                        padding:20px;
                        background:rgba(255,255,255,0.02);
                        border:1px solid rgba(255,255,255,0.1);
                        border-radius:12px;
                    ">
                        <h4 style="
                            margin:0 0 16px;
                            font-size:1rem;
                            color:var(--accent, #00d4ff);
                            display:flex;
                            align-items:center;
                            gap:8px;
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                            OSINT-Techniken
                        </h4>
                        <ul style="
                            margin:0;
                            padding:0;
                            list-style:none;
                            display:flex;
                            flex-direction:column;
                            gap:8px;
                        ">
                            <?php
                            $techniques_array = array_map('trim', explode(',', $techniques));
                            foreach ($techniques_array as $tech):
                            ?>
                            <li style="
                                padding:8px 12px;
                                background:rgba(0,0,0,0.3);
                                border-radius:6px;
                                font-size:0.9rem;
                            "><?php echo esc_html($tech); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <!-- CTA Box -->
                    <div style="
                        padding:20px;
                        background:linear-gradient(135deg, rgba(0, 212, 255, 0.1) 0%, rgba(0, 212, 255, 0.05) 100%);
                        border:1px solid rgba(0, 212, 255, 0.3);
                        border-radius:12px;
                        text-align:center;
                    ">
                        <h4 style="margin:0 0 12px;font-size:1.1rem;">
                            Interesse geweckt?
                        </h4>
                        <p style="margin:0 0 20px;font-size:0.9rem;color:var(--muted, #a0a0a0);">
                            Lerne in unseren Kursen, wie du solche Analysen selbst durchführst.
                        </p>
                        <a href="<?php echo esc_url(home_url('/kurse')); ?>" style="
                            display:inline-block;
                            padding:12px 24px;
                            background:var(--accent, #00d4ff);
                            color:#000;
                            border-radius:8px;
                            text-decoration:none;
                            font-weight:600;
                            transition:all 0.3s ease;
                        " onmouseover="this.style.transform='translateY(-2px)';" 
                           onmouseout="this.style.transform='translateY(0)';">
                            Kurse ansehen
                        </a>
                    </div>
                    
                </aside>
                
            </div>
            
        </div>
    </main>
    
    <!-- Related Cases -->
    <section style="
        padding:60px 0;
        background:rgba(255,255,255,0.02);
        border-top:1px solid rgba(255,255,255,0.1);
    ">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            
            <h3 style="margin:0 0 40px;font-size:2rem;font-weight:700;text-align:center;">
                Ähnliche Case Studies
            </h3>
            
            <div style="
                display:grid;
                grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));
                gap:32px;
            ">
                
                <?php
                // Get related cases from same category
                $current_categories = wp_get_post_terms(get_the_ID(), 'case_category', ['fields' => 'ids']);
                
                $related_args = [
                    'post_type' => 'it_case_study',
                    'posts_per_page' => 3,
                    'post__not_in' => [get_the_ID()],
                    'tax_query' => [
                        [
                            'taxonomy' => 'case_category',
                            'field' => 'term_id',
                            'terms' => $current_categories,
                        ],
                    ],
                ];
                
                $related = new WP_Query($related_args);
                
                if ($related->have_posts()):
                    while ($related->have_posts()): $related->the_post();
                        $rel_difficulty = get_post_meta(get_the_ID(), '_case_difficulty', true);
                        $rel_diff_info = $difficulty_labels[$rel_difficulty] ?? ['label' => 'Unbekannt', 'color' => '#888'];
                ?>
                
                <article style="
                    background:rgba(255,255,255,0.02);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:12px;
                    padding:24px;
                    transition:all 0.3s ease;
                " onmouseover="this.style.borderColor='rgba(0, 212, 255, 0.5)';" 
                   onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';">
                    
                    <div style="
                        display:inline-block;
                        padding:4px 10px;
                        background:<?php echo $rel_diff_info['color']; ?>;
                        color:#000;
                        border-radius:6px;
                        font-size:0.75rem;
                        font-weight:600;
                        margin-bottom:12px;
                    "><?php echo esc_html($rel_diff_info['label']); ?></div>
                    
                    <h4 style="margin:0 0 12px;font-size:1.2rem;line-height:1.3;">
                        <a href="<?php the_permalink(); ?>" style="
                            color:var(--fg, #e0e0e0);
                            text-decoration:none;
                        " onmouseover="this.style.color='var(--accent, #00d4ff)';" 
                           onmouseout="this.style.color='var(--fg, #e0e0e0)';">
                            <?php the_title(); ?>
                        </a>
                    </h4>
                    
                    <p style="margin:0;color:var(--muted, #a0a0a0);font-size:0.9rem;">
                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                    </p>
                </article>
                
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                ?>
                <p style="color:var(--muted, #a0a0a0);text-align:center;grid-column:1/-1;">
                    Keine weiteren Case Studies in dieser Kategorie verfügbar.
                </p>
                <?php endif; ?>
                
            </div>
            
        </div>
    </section>

</article>

<style>
/* Responsive adjustments */
@media (max-width: 768px) {
    .case-content {
        grid-template-columns: 1fr !important;
    }
    
    .case-sidebar {
        position: static !important;
    }
}

/* Code blocks */
.case-content pre {
    background: rgba(0,0,0,0.8);
    border: 1px solid rgba(0, 212, 255, 0.3);
    border-radius: 8px;
    padding: 20px;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
}

.case-content code {
    color: #00ff88;
}

/* Headings in content */
.case-content h2 {
    margin: 40px 0 20px;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--accent, #00d4ff);
}

.case-content h3 {
    margin: 30px 0 15px;
    font-size: 1.4rem;
    font-weight: 600;
}

/* Lists */
.case-content ul, .case-content ol {
    margin: 20px 0;
    padding-left: 24px;
}

.case-content li {
    margin-bottom: 12px;
}

/* Links */
.case-content a {
    color: var(--accent, #00d4ff);
    text-decoration: underline;
    transition: opacity 0.3s ease;
}

.case-content a:hover {
    opacity: 0.8;
}
</style>

<?php endwhile; ?>

<?php get_footer(); ?>
