<?php
/**
 * Template Name: Kursübersicht
 * Description: Zeigt alle verfügbaren Kurse mit Filteroptionen
 */

get_header(); ?>

<main id="primary" class="site-main courses-archive" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <div class="container" style="max-width:1400px;margin:0 auto;padding:0 24px;">
        
        <!-- Header -->
        <div class="page-header" style="text-align:center;margin-bottom:64px;">
            <h1 style="
                margin:0 0 16px;
                font-size:3rem;
                font-weight:700;
            ">
                Unsere Kurse
            </h1>
            <p style="
                margin:0;
                font-size:1.2rem;
                color:var(--muted);
                max-width:700px;
                margin:0 auto;
            ">
                AZAV-zertifizierte Ausbildungen für investigativen Journalismus,<br>
                OSINT, IT-Security und Rettungsdienst
            </p>
        </div>

        <!-- Filter -->
        <div class="course-filters" style="
            background:var(--bg-2);
            border:1px solid var(--line);
            border-radius:12px;
            padding:24px;
            margin-bottom:48px;
        ">
            <form method="get" action="" id="course-filter-form">
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;">
                    
                    <!-- Kategorie -->
                    <div class="filter-group">
                        <label style="display:block;margin-bottom:8px;font-weight:600;">Kategorie</label>
                        <select name="category" style="
                            width:100%;
                            padding:10px;
                            background:var(--bg);
                            border:1px solid var(--line);
                            border-radius:6px;
                            color:var(--fg);
                        ">
                            <option value="">Alle Kategorien</option>
                            <?php
                            $categories = get_terms(['taxonomy' => 'course_category', 'hide_empty' => false]);
                            foreach ($categories as $cat):
                            ?>
                                <option value="<?php echo $cat->slug; ?>" <?php selected(isset($_GET['category']) && $_GET['category'] === $cat->slug); ?>>
                                    <?php echo $cat->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Level -->
                    <div class="filter-group">
                        <label style="display:block;margin-bottom:8px;font-weight:600;">Level</label>
                        <select name="level" style="
                            width:100%;
                            padding:10px;
                            background:var(--bg);
                            border:1px solid var(--line);
                            border-radius:6px;
                            color:var(--fg);
                        ">
                            <option value="">Alle Level</option>
                            <?php
                            $levels = get_terms(['taxonomy' => 'course_level', 'hide_empty' => false]);
                            foreach ($levels as $level):
                            ?>
                                <option value="<?php echo $level->slug; ?>" <?php selected(isset($_GET['level']) && $_GET['level'] === $level->slug); ?>>
                                    <?php echo $level->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Bildungsgutschein -->
                    <div class="filter-group">
                        <label style="display:block;margin-bottom:8px;font-weight:600;">Förderung</label>
                        <select name="bildungsgutschein" style="
                            width:100%;
                            padding:10px;
                            background:var(--bg);
                            border:1px solid var(--line);
                            border-radius:6px;
                            color:var(--fg);
                        ">
                            <option value="">Alle</option>
                            <option value="1" <?php selected(isset($_GET['bildungsgutschein']) && $_GET['bildungsgutschein'] === '1'); ?>>
                                Bildungsgutschein
                            </option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="filter-group" style="display:flex;align-items:flex-end;">
                        <button type="submit" style="
                            width:100%;
                            padding:10px 24px;
                            background:var(--accent);
                            color:#001018;
                            border:none;
                            border-radius:6px;
                            font-weight:600;
                            cursor:pointer;
                        ">
                            Filter anwenden
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <!-- Kursliste -->
        <div class="courses-grid" style="
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(380px, 1fr));
            gap:32px;
        ">
            
            <?php
            // Query-Argumente
            $args = [
                'post_type' => 'bg_course',
                'posts_per_page' => -1,
                'orderby' => 'meta_value',
                'meta_key' => '_bg_start_date',
                'order' => 'ASC',
            ];

            // Filter: Kategorie
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'course_category',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['category']),
                ];
            }

            // Filter: Level
            if (isset($_GET['level']) && !empty($_GET['level'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'course_level',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['level']),
                ];
            }

            // Filter: Bildungsgutschein
            if (isset($_GET['bildungsgutschein']) && $_GET['bildungsgutschein'] === '1') {
                $args['meta_query'][] = [
                    'key' => '_bg_bildungsgutschein',
                    'value' => '1',
                ];
            }

            $courses = new WP_Query($args);

            if ($courses->have_posts()):
                while ($courses->have_posts()): $courses->the_post();
                    
                    $duration = get_post_meta(get_the_ID(), '_bg_duration', true);
                    $price = get_post_meta(get_the_ID(), '_bg_price', true);
                    $start_date = get_post_meta(get_the_ID(), '_bg_start_date', true);
                    $max_participants = get_post_meta(get_the_ID(), '_bg_max_participants', true);
                    $bildungsgutschein = get_post_meta(get_the_ID(), '_bg_bildungsgutschein', true);
                    $instructor_id = get_post_meta(get_the_ID(), '_bg_instructor_id', true);
                    
                    // Anzahl Anmeldungen
                    $enrollments = new WP_Query([
                        'post_type' => 'bg_enrollment',
                        'meta_query' => [
                            ['key' => '_bg_course_id', 'value' => get_the_ID()],
                            ['key' => '_bg_status', 'value' => ['confirmed', 'pending'], 'compare' => 'IN'],
                        ],
                        'posts_per_page' => -1,
                    ]);
                    $enrolled = $enrollments->found_posts;
                    $spots_left = $max_participants ? max(0, intval($max_participants) - $enrolled) : 99;
                    $is_full = $max_participants && $enrolled >= intval($max_participants);
                    
                    $categories = get_the_terms(get_the_ID(), 'course_category');
                    $category_name = $categories && !is_wp_error($categories) ? $categories[0]->name : '';
            ?>
            
            <article class="course-card" style="
                background:var(--bg-2);
                border:1px solid var(--line);
                border-radius:12px;
                overflow:hidden;
                transition:transform 0.3s, box-shadow 0.3s;
                display:flex;
                flex-direction:column;
            " onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                
                <!-- Thumbnail -->
                <?php if (has_post_thumbnail()): ?>
                    <div class="course-thumbnail" style="
                        height:200px;
                        background-image:url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>');
                        background-size:cover;
                        background-position:center;
                        position:relative;
                    ">
                        <?php if ($bildungsgutschein): ?>
                            <div class="badge" style="
                                position:absolute;
                                top:12px;
                                right:12px;
                                padding:6px 12px;
                                background:var(--accent);
                                color:#001018;
                                font-size:12px;
                                font-weight:700;
                                border-radius:4px;
                            ">
                                Bildungsgutschein
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($is_full): ?>
                            <div class="badge" style="
                                position:absolute;
                                top:12px;
                                left:12px;
                                padding:6px 12px;
                                background:#f44336;
                                color:#fff;
                                font-size:12px;
                                font-weight:700;
                                border-radius:4px;
                            ">
                                Ausgebucht
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="course-content" style="padding:24px;flex:1;display:flex;flex-direction:column;">
                    
                    <!-- Category -->
                    <?php if ($category_name): ?>
                        <div class="course-category" style="
                            display:inline-block;
                            padding:4px 12px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            border-radius:4px;
                            font-size:12px;
                            color:var(--accent);
                            margin-bottom:12px;
                            width:fit-content;
                        ">
                            <?php echo esc_html($category_name); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <h3 style="
                        margin:0 0 12px;
                        font-size:1.5rem;
                        line-height:1.3;
                    ">
                        <a href="<?php the_permalink(); ?>" style="color:var(--fg);text-decoration:none;">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <!-- Excerpt -->
                    <p style="
                        margin:0 0 auto;
                        color:var(--muted);
                        line-height:1.6;
                    ">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <!-- Meta -->
                    <div class="course-meta" style="
                        display:grid;
                        grid-template-columns:repeat(2, 1fr);
                        gap:12px;
                        margin-top:16px;
                        padding-top:16px;
                        border-top:1px solid var(--line);
                    ">
                        <?php if ($duration): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);">Dauer</div>
                                <div style="font-weight:600;"><?php echo esc_html($duration); ?> Wochen</div>
                            </div>
                        <?php endif; ?>

                        <?php if ($start_date): ?>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);">Start</div>
                                <div style="font-weight:600;"><?php echo date_i18n('d.m.Y', strtotime($start_date)); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Spots -->
                    <?php if ($max_participants): ?>
                        <div style="
                            margin-top:12px;
                            padding:8px 12px;
                            background:var(--bg-3);
                            border-radius:6px;
                            font-size:0.9rem;
                            color:<?php echo $is_full ? '#f44336' : 'var(--accent)'; ?>;
                        ">
                            <?php if ($is_full): ?>
                                Warteliste verfügbar
                            <?php else: ?>
                                Noch <?php echo $spots_left; ?> Plätze frei
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA -->
                    <a href="<?php the_permalink(); ?>" style="
                        display:block;
                        margin-top:16px;
                        padding:12px;
                        background:var(--accent);
                        color:#001018;
                        text-align:center;
                        border-radius:6px;
                        font-weight:600;
                        text-decoration:none;
                        transition:filter 0.2s;
                    " onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        <?php echo $is_full ? 'Zur Warteliste' : 'Jetzt anmelden'; ?>
                    </a>

                </div>

            </article>

            <?php
                endwhile;
                wp_reset_postdata();
            else:
            ?>
                <div style="grid-column:1/-1;text-align:center;padding:64px 24px;">
                    <p style="font-size:1.2rem;color:var(--muted);">
                        Keine Kurse gefunden. Bitte passen Sie die Filter an.
                    </p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</main>

<?php get_footer(); ?>
