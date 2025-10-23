<?php
/**
 * Template Name: InfoTerminal Case Studies Archive
 * Description: Übersicht aller OSINT Case Studies mit Filterung
 * 
 * @package BeyondGotham
 */

get_header(); ?>

<main class="case-studies-archive" style="
    padding:60px 0;
    background:var(--bg, #0f0f0f);
    color:var(--fg, #e0e0e0);
    min-height:100vh;
">
    
    <!-- Header -->
    <section class="archive-header" style="
        padding:60px 0;
        background:linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-bottom:3px solid var(--accent, #00d4ff);
        margin-bottom:60px;
    ">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="12" y1="18" x2="12" y2="12"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
                <span style="
                    font-size:0.9rem;
                    color:var(--accent, #00d4ff);
                    font-weight:600;
                    letter-spacing:0.05em;
                    text-transform:uppercase;
                ">Real-World Cases</span>
            </div>
            
            <h1 style="
                margin:0 0 20px;
                font-size:clamp(2.5rem, 5vw, 4rem);
                line-height:1.1;
                font-weight:800;
            ">InfoTerminal Case Studies</h1>
            
            <p style="
                margin:0;
                font-size:1.3rem;
                color:var(--muted, #a0a0a0);
                max-width:700px;
            ">
                Lerne aus realen OSINT-Ermittlungen. Von Anfänger-Tutorials bis zu komplexen 
                investigativen Recherchen – alle mit vollständiger Dokumentation.
            </p>
        </div>
    </section>
    
    <!-- Filters -->
    <section class="filters-section" style="margin-bottom:60px;">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <div style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.1);
                border-radius:12px;
                padding:24px;
            ">
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;">
                    
                    <!-- Kategorie Filter -->
                    <div>
                        <label style="
                            display:block;
                            font-weight:600;
                            margin-bottom:8px;
                            color:var(--accent, #00d4ff);
                        ">Kategorie</label>
                        <select id="filter-category" style="
                            width:100%;
                            padding:10px;
                            background:rgba(0,0,0,0.5);
                            border:1px solid rgba(255,255,255,0.2);
                            border-radius:6px;
                            color:var(--fg, #e0e0e0);
                        ">
                            <option value="">Alle Kategorien</option>
                            <?php
                            $categories = get_terms(['taxonomy' => 'case_category', 'hide_empty' => true]);
                            foreach ($categories as $cat):
                            ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>">
                                <?php echo esc_html($cat->name); ?> (<?php echo $cat->count; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Schwierigkeit Filter -->
                    <div>
                        <label style="
                            display:block;
                            font-weight:600;
                            margin-bottom:8px;
                            color:var(--accent, #00d4ff);
                        ">Schwierigkeit</label>
                        <select id="filter-difficulty" style="
                            width:100%;
                            padding:10px;
                            background:rgba(0,0,0,0.5);
                            border:1px solid rgba(255,255,255,0.2);
                            border-radius:6px;
                            color:var(--fg, #e0e0e0);
                        ">
                            <option value="">Alle Level</option>
                            <?php
                            $difficulties = get_terms(['taxonomy' => 'case_difficulty', 'hide_empty' => true]);
                            foreach ($difficulties as $diff):
                            ?>
                            <option value="<?php echo esc_attr($diff->slug); ?>">
                                <?php echo esc_html($diff->name); ?> (<?php echo $diff->count; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Suche -->
                    <div>
                        <label style="
                            display:block;
                            font-weight:600;
                            margin-bottom:8px;
                            color:var(--accent, #00d4ff);
                        ">Suche</label>
                        <input type="text" id="search-cases" placeholder="Tools, Techniken..." style="
                            width:100%;
                            padding:10px;
                            background:rgba(0,0,0,0.5);
                            border:1px solid rgba(255,255,255,0.2);
                            border-radius:6px;
                            color:var(--fg, #e0e0e0);
                        ">
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- Case Studies Grid -->
    <section class="cases-grid">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            
            <?php
            $args = [
                'post_type' => 'it_case_study',
                'posts_per_page' => 12,
                'orderby' => 'date',
                'order' => 'DESC',
            ];
            
            $cases = new WP_Query($args);
            
            if ($cases->have_posts()):
            ?>
            
            <div id="cases-container" style="
                display:grid;
                grid-template-columns:repeat(auto-fill, minmax(350px, 1fr));
                gap:32px;
            ">
                
                <?php while ($cases->have_posts()): $cases->the_post();
                    $duration = get_post_meta(get_the_ID(), '_case_duration', true);
                    $difficulty = get_post_meta(get_the_ID(), '_case_difficulty', true);
                    $tools = get_post_meta(get_the_ID(), '_case_tools', true);
                    $techniques = get_post_meta(get_the_ID(), '_case_techniques', true);
                    
                    $difficulty_labels = [
                        'beginner' => ['label' => 'Anfänger', 'color' => '#00ff88'],
                        'intermediate' => ['label' => 'Fortgeschritten', 'color' => '#ffaa00'],
                        'advanced' => ['label' => 'Experte', 'color' => '#ff4444'],
                    ];
                    
                    $diff_info = $difficulty_labels[$difficulty] ?? ['label' => 'Unbekannt', 'color' => '#888'];
                ?>
                
                <article class="case-card" data-category="<?php echo esc_attr(get_the_terms(get_the_ID(), 'case_category')[0]->slug ?? ''); ?>" 
                         data-difficulty="<?php echo esc_attr($difficulty); ?>" 
                         style="
                    background:rgba(255,255,255,0.02);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:16px;
                    overflow:hidden;
                    transition:all 0.3s ease;
                    display:flex;
                    flex-direction:column;
                " onmouseover="this.style.borderColor='rgba(0, 212, 255, 0.5)';this.style.transform='translateY(-4px)';" 
                   onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.transform='translateY(0)';">
                    
                    <?php if (has_post_thumbnail()): ?>
                    <div class="case-thumbnail" style="
                        height:200px;
                        background:url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>') center/cover;
                        position:relative;
                    ">
                        <div style="
                            position:absolute;
                            top:12px;
                            right:12px;
                            background:<?php echo $diff_info['color']; ?>;
                            color:#000;
                            padding:6px 12px;
                            border-radius:6px;
                            font-size:0.8rem;
                            font-weight:600;
                        "><?php echo esc_html($diff_info['label']); ?></div>
                    </div>
                    <?php else: ?>
                    <div style="
                        height:200px;
                        background:linear-gradient(135deg, rgba(0, 212, 255, 0.1) 0%, rgba(0, 212, 255, 0.05) 100%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        position:relative;
                    ">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(0, 212, 255, 0.3)" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <div style="
                            position:absolute;
                            top:12px;
                            right:12px;
                            background:<?php echo $diff_info['color']; ?>;
                            color:#000;
                            padding:6px 12px;
                            border-radius:6px;
                            font-size:0.8rem;
                            font-weight:600;
                        "><?php echo esc_html($diff_info['label']); ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <div style="padding:24px;flex:1;display:flex;flex-direction:column;">
                        
                        <!-- Kategorie Badge -->
                        <?php
                        $categories = get_the_terms(get_the_ID(), 'case_category');
                        if ($categories && !is_wp_error($categories)):
                        ?>
                        <div style="margin-bottom:12px;">
                            <span style="
                                display:inline-block;
                                padding:4px 12px;
                                background:rgba(0, 212, 255, 0.1);
                                color:var(--accent, #00d4ff);
                                border-radius:6px;
                                font-size:0.8rem;
                                font-weight:600;
                            "><?php echo esc_html($categories[0]->name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Titel -->
                        <h3 style="
                            margin:0 0 12px;
                            font-size:1.3rem;
                            font-weight:700;
                            line-height:1.3;
                        ">
                            <a href="<?php the_permalink(); ?>" style="
                                color:var(--fg, #e0e0e0);
                                text-decoration:none;
                            " onmouseover="this.style.color='var(--accent, #00d4ff)';" 
                               onmouseout="this.style.color='var(--fg, #e0e0e0)';">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        <p style="
                            margin:0 0 16px;
                            color:var(--muted, #a0a0a0);
                            font-size:0.95rem;
                            line-height:1.5;
                            flex:1;
                        "><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        
                        <!-- Meta Info -->
                        <div style="
                            display:flex;
                            gap:16px;
                            padding-top:16px;
                            border-top:1px solid rgba(255,255,255,0.1);
                            font-size:0.85rem;
                            color:var(--muted, #a0a0a0);
                        ">
                            <?php if ($duration): ?>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <?php echo esc_html($duration); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($tools): ?>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                                </svg>
                                <?php echo count(explode(',', $tools)); ?> Tools
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- CTA -->
                        <a href="<?php the_permalink(); ?>" style="
                            display:inline-flex;
                            align-items:center;
                            gap:8px;
                            margin-top:16px;
                            color:var(--accent, #00d4ff);
                            text-decoration:none;
                            font-weight:600;
                            font-size:0.95rem;
                        " onmouseover="this.style.gap='12px';" onmouseout="this.style.gap='8px';">
                            Case Study lesen
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                    
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <?php wp_reset_postdata(); ?>
            
            <!-- Pagination -->
            <?php if ($cases->max_num_pages > 1): ?>
            <div style="margin-top:60px;text-align:center;">
                <div class="pagination" style="display:flex;gap:12px;justify-content:center;">
                    <?php
                    echo paginate_links([
                        'total' => $cases->max_num_pages,
                        'prev_text' => '←',
                        'next_text' => '→',
                    ]);
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php else: ?>
            
            <div style="text-align:center;padding:60px 24px;">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--muted, #a0a0a0)" stroke-width="1.5" style="margin-bottom:24px;">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <h3 style="margin:0 0 16px;font-size:1.5rem;">Keine Case Studies gefunden</h3>
                <p style="margin:0;color:var(--muted, #a0a0a0);">
                    Versuche andere Filter oder komm später wieder.
                </p>
            </div>
            
            <?php endif; ?>
            
        </div>
    </section>

</main>

<style>
.pagination a, .pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 6px;
    color: var(--fg, #e0e0e0);
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination a:hover {
    background: rgba(0, 212, 255, 0.1);
    border-color: var(--accent, #00d4ff);
    color: var(--accent, #00d4ff);
}

.pagination .current {
    background: var(--accent, #00d4ff);
    border-color: var(--accent, #00d4ff);
    color: #000;
    font-weight: 600;
}
</style>

<script>
// Live Filtering
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('filter-category');
    const difficultyFilter = document.getElementById('filter-difficulty');
    const searchInput = document.getElementById('search-cases');
    const casesContainer = document.getElementById('cases-container');
    const cases = casesContainer ? casesContainer.querySelectorAll('.case-card') : [];
    
    function filterCases() {
        const category = categoryFilter.value;
        const difficulty = difficultyFilter.value;
        const search = searchInput.value.toLowerCase();
        
        cases.forEach(caseCard => {
            const caseCategory = caseCard.dataset.category;
            const caseDifficulty = caseCard.dataset.difficulty;
            const caseText = caseCard.textContent.toLowerCase();
            
            const matchesCategory = !category || caseCategory === category;
            const matchesDifficulty = !difficulty || caseDifficulty === difficulty;
            const matchesSearch = !search || caseText.includes(search);
            
            if (matchesCategory && matchesDifficulty && matchesSearch) {
                caseCard.style.display = 'flex';
            } else {
                caseCard.style.display = 'none';
            }
        });
    }
    
    if (categoryFilter) categoryFilter.addEventListener('change', filterCases);
    if (difficultyFilter) difficultyFilter.addEventListener('change', filterCases);
    if (searchInput) searchInput.addEventListener('input', filterCases);
});
</script>

<?php get_footer(); ?>
