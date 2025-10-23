<?php
/**
 * Single Course Template
 * Detailseite für einzelne Kurse
 */

get_header();

while (have_posts()): the_post();
    $duration = get_post_meta(get_the_ID(), '_bg_duration', true);
    $price = get_post_meta(get_the_ID(), '_bg_price', true);
    $start_date = get_post_meta(get_the_ID(), '_bg_start_date', true);
    $end_date = get_post_meta(get_the_ID(), '_bg_end_date', true);
    $max_participants = get_post_meta(get_the_ID(), '_bg_max_participants', true);
    $bildungsgutschein = get_post_meta(get_the_ID(), '_bg_bildungsgutschein', true);
    $azav_id = get_post_meta(get_the_ID(), '_bg_azav_id', true);
    $instructor_id = get_post_meta(get_the_ID(), '_bg_instructor_id', true);
    
    $categories = get_the_terms(get_the_ID(), 'course_category');
    $levels = get_the_terms(get_the_ID(), 'course_level');
?>

<main id="primary" class="site-main single-course" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb" style="margin-bottom:32px;font-size:0.9rem;color:var(--muted);">
            <a href="/" style="color:var(--accent);">Home</a> / 
            <a href="/kurse/" style="color:var(--accent);">Kurse</a> / 
            <span><?php the_title(); ?></span>
        </div>

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:48px;">
            
            <!-- Main Content -->
            <div class="course-main">
                
                <!-- Header -->
                <header class="course-header" style="margin-bottom:32px;">
                    
                    <?php if ($categories && !is_wp_error($categories)): ?>
                        <div class="course-category" style="
                            display:inline-block;
                            padding:6px 16px;
                            background:var(--bg-2);
                            border:1px solid var(--line);
                            border-radius:4px;
                            font-size:14px;
                            color:var(--accent);
                            margin-bottom:16px;
                        ">
                            <?php echo esc_html($categories[0]->name); ?>
                        </div>
                    <?php endif; ?>

                    <h1 style="
                        margin:0 0 16px;
                        font-size:3rem;
                        line-height:1.2;
                    ">
                        <?php the_title(); ?>
                    </h1>

                    <?php if (has_excerpt()): ?>
                        <p class="lead" style="
                            font-size:1.3rem;
                            color:var(--muted);
                            line-height:1.6;
                            margin:0 0 24px;
                        ">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Meta Grid -->
                    <div class="course-meta-grid" style="
                        display:grid;
                        grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));
                        gap:16px;
                        padding:24px;
                        background:var(--bg-2);
                        border:1px solid var(--line);
                        border-radius:8px;
                    ">
                        <?php if ($duration): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Dauer</div>
                                <div style="font-size:1.1rem;font-weight:700;"><?php echo esc_html($duration); ?> Wochen</div>
                            </div>
                        <?php endif; ?>

                        <?php if ($start_date): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Start</div>
                                <div style="font-size:1.1rem;font-weight:700;"><?php echo date_i18n('d.m.Y', strtotime($start_date)); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($levels && !is_wp_error($levels)): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Level</div>
                                <div style="font-size:1.1rem;font-weight:700;"><?php echo esc_html($levels[0]->name); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($max_participants): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Max. TN</div>
                                <div style="font-size:1.1rem;font-weight:700;"><?php echo esc_html($max_participants); ?> Plätze</div>
                            </div>
                        <?php endif; ?>
                    </div>

                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()): ?>
                    <div class="course-image" style="
                        margin-bottom:32px;
                        border-radius:12px;
                        overflow:hidden;
                        border:1px solid var(--line);
                    ">
                        <?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto;display:block;']); ?>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="course-content" style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                    margin-bottom:32px;
                    line-height:1.8;
                ">
                    <?php the_content(); ?>
                </div>

                <!-- Instructor -->
                <?php if ($instructor_id): ?>
                    <div class="course-instructor" style="
                        background:var(--bg-2);
                        border:1px solid var(--line);
                        border-radius:12px;
                        padding:32px;
                        margin-bottom:32px;
                    ">
                        <h3 style="margin:0 0 24px;font-size:1.5rem;">Dein Dozent</h3>
                        
                        <div style="display:flex;gap:24px;align-items:start;">
                            <?php if (has_post_thumbnail($instructor_id)): ?>
                                <div style="
                                    width:120px;
                                    height:120px;
                                    border-radius:50%;
                                    overflow:hidden;
                                    flex-shrink:0;
                                ">
                                    <?php echo get_the_post_thumbnail($instructor_id, 'thumbnail', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                                </div>
                            <?php endif; ?>

                            <div style="flex:1;">
                                <h4 style="margin:0 0 8px;font-size:1.3rem;">
                                    <a href="<?php echo get_permalink($instructor_id); ?>" style="color:var(--fg);">
                                        <?php echo get_the_title($instructor_id); ?>
                                    </a>
                                </h4>
                                
                                <?php
                                $qualification = get_post_meta($instructor_id, '_bg_qualification', true);
                                $experience = get_post_meta($instructor_id, '_bg_experience', true);
                                ?>
                                
                                <?php if ($qualification): ?>
                                    <div style="color:var(--muted);margin-bottom:4px;">
                                        <strong>Qualifikation:</strong> <?php echo esc_html($qualification); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($experience): ?>
                                    <div style="color:var(--muted);margin-bottom:16px;">
                                        <strong>Erfahrung:</strong> <?php echo esc_html($experience); ?> Jahre
                                    </div>
                                <?php endif; ?>
                                
                                <div style="color:var(--fg);">
                                    <?php echo wp_trim_words(get_post_field('post_content', $instructor_id), 40); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Sidebar -->
            <aside class="course-sidebar">
                
                <!-- CTA Card -->
                <div class="course-cta-card" style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                    position:sticky;
                    top:24px;
                ">
                    <?php if ($bildungsgutschein): ?>
                        <div class="badge" style="
                            display:inline-block;
                            padding:8px 16px;
                            background:var(--accent);
                            color:#001018;
                            font-size:14px;
                            font-weight:700;
                            border-radius:6px;
                            margin-bottom:16px;
                        ">
                            ✅ Bildungsgutschein möglich
                        </div>
                    <?php endif; ?>

                    <?php if ($price): ?>
                        <div style="margin-bottom:24px;">
                            <div style="font-size:0.9rem;color:var(--muted);">Kursgebühr</div>
                            <div style="
                                font-size:2.5rem;
                                font-weight:800;
                                color:var(--accent);
                                line-height:1;
                            ">
                                <?php echo number_format($price, 2, ',', '.'); ?> €
                            </div>
                            <?php if ($bildungsgutschein): ?>
                                <div style="font-size:0.85rem;color:var(--muted);margin-top:8px;">
                                    * Mit Bildungsgutschein kostenlos
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($azav_id): ?>
                        <div style="
                            padding:12px;
                            background:var(--bg-3);
                            border-radius:6px;
                            margin-bottom:24px;
                            font-size:0.9rem;
                        ">
                            <strong>AZAV-ID:</strong> <?php echo esc_html($azav_id); ?>
                        </div>
                    <?php endif; ?>

                    <a href="#anmeldung" class="btn-primary" style="
                        display:block;
                        padding:16px;
                        background:var(--accent);
                        color:#001018;
                        text-align:center;
                        border-radius:8px;
                        font-weight:700;
                        font-size:1.1rem;
                        text-decoration:none;
                        margin-bottom:16px;
                    " onclick="document.getElementById('anmeldung').scrollIntoView({behavior:'smooth'})">
                        Jetzt anmelden
                    </a>

                    <a href="/kontakt/" class="btn-secondary" style="
                        display:block;
                        padding:16px;
                        background:transparent;
                        color:var(--fg);
                        text-align:center;
                        border:2px solid var(--line);
                        border-radius:8px;
                        font-weight:600;
                        text-decoration:none;
                    ">
                        Beratung anfragen
                    </a>

                    <!-- Info List -->
                    <div style="margin-top:32px;padding-top:32px;border-top:1px solid var(--line);">
                        <ul style="list-style:none;padding:0;margin:0;">
                            <li style="padding:8px 0;display:flex;align-items:start;gap:12px;">
                                <span style="color:var(--accent);">✓</span>
                                <span>Zertifikat am Ende</span>
                            </li>
                            <li style="padding:8px 0;display:flex;align-items:start;gap:12px;">
                                <span style="color:var(--accent);">✓</span>
                                <span>Praxisnahe Projekte</span>
                            </li>
                            <li style="padding:8px 0;display:flex;align-items:start;gap:12px;">
                                <span style="color:var(--accent);">✓</span>
                                <span>Expert:innen als Dozenten</span>
                            </li>
                            <li style="padding:8px 0;display:flex;align-items:start;gap:12px;">
                                <span style="color:var(--accent);">✓</span>
                                <span>Alumni-Netzwerk</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </aside>

        </div>

        <!-- Enrollment Form -->
        <div id="anmeldung" style="margin-top:64px;scroll-margin-top:80px;">
            <h2 style="text-align:center;margin-bottom:32px;font-size:2.5rem;">
                Jetzt anmelden
            </h2>
            <?php echo do_shortcode('[bg_course_enrollment course_id="' . get_the_ID() . '"]'); ?>
        </div>

    </div>

</main>

<?php
endwhile;
get_footer();
?>
