<?php
/**
 * Single template for bg_course.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $course_id        = get_the_ID();
    $total_spots      = bg_get_course_total_spots($course_id);
    $available_spots  = bg_get_course_available_spots($course_id);
    $is_waitlist      = $total_spots > 0 && 0 === $available_spots;
    $start_date       = get_post_meta($course_id, '_bg_start_date', true);
    $end_date         = get_post_meta($course_id, '_bg_end_date', true);
    $duration         = get_post_meta($course_id, '_bg_duration', true);
    $language         = get_post_meta($course_id, '_bg_language', true);
    $location         = get_post_meta($course_id, '_bg_location', true);
    $delivery         = get_post_meta($course_id, '_bg_delivery_mode', true);
    $voucher          = get_post_meta($course_id, '_bg_bildungsgutschein', true);
    $instructor_id    = (int) get_post_meta($course_id, '_bg_instructor_id', true);
    $price            = get_post_meta($course_id, '_bg_price', true);
    $level_terms      = wp_get_post_terms($course_id, 'bg_course_level');
    $category_terms   = wp_get_post_terms($course_id, 'bg_course_category');
    $level_label      = (!empty($level_terms) && !is_wp_error($level_terms)) ? $level_terms[0]->name : '';
    $category_label   = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
    $permalink        = get_permalink();
    $share_title      = rawurlencode(get_the_title());
    $share_url        = rawurlencode($permalink);
    $share_links      = [
        [
            'label' => __('LinkedIn', 'beyondgotham-dark-child'),
            'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=' . $share_title,
        ],
        [
            'label' => __('X (Twitter)', 'beyondgotham-dark-child'),
            'url'   => 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title,
        ],
        [
            'label' => __('E-Mail', 'beyondgotham-dark-child'),
            'url'   => 'mailto:?subject=' . $share_title . '&body=' . $share_url,
        ],
    ];
    ?>
    <main class="course" id="main">
        <header class="course-hero" data-bg-animate>
            <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--light']); ?>
            <div class="course-hero__content">
                <?php if ($category_label) : ?>
                    <span class="course-hero__tag"><?php echo esc_html($category_label); ?></span>
                <?php endif; ?>
                <h1 class="course-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="course-hero__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
                <dl class="course-hero__meta">
                    <?php if ($level_label) : ?>
                        <div>
                            <dt><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></dt>
                            <dd><?php echo esc_html($level_label); ?></dd>
                        </div>
                    <?php endif; ?>
                    <?php if ($duration) : ?>
                        <div>
                            <dt><?php esc_html_e('Dauer', 'beyondgotham-dark-child'); ?></dt>
                            <dd><?php echo esc_html($duration); ?> <?php esc_html_e('Wochen', 'beyondgotham-dark-child'); ?></dd>
                        </div>
                    <?php endif; ?>
                    <?php if ($start_date) : ?>
                        <div>
                            <dt><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></dt>
                            <dd><?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></dd>
                        </div>
                    <?php endif; ?>
                    <?php if ($price) : ?>
                        <div>
                            <dt><?php esc_html_e('Gebühr', 'beyondgotham-dark-child'); ?></dt>
                            <dd><?php echo esc_html(number_format_i18n((float) $price, 2)); ?> €</dd>
                        </div>
                    <?php endif; ?>
                </dl>
                <div class="course-hero__actions">
                    <a class="bg-button bg-button--primary" data-bg-scroll="#course-enrollment" href="#course-enrollment"><?php esc_html_e('Jetzt anmelden', 'beyondgotham-dark-child'); ?></a>
                    <?php if ($is_waitlist) : ?>
                        <span class="course-hero__status"><?php esc_html_e('Warteliste aktiv', 'beyondgotham-dark-child'); ?></span>
                    <?php endif; ?>
                </div>
                <ul class="course-hero__share" aria-label="<?php esc_attr_e('Kurs teilen', 'beyondgotham-dark-child'); ?>">
                    <?php foreach ($share_links as $share_link) : ?>
                        <li>
                            <a href="<?php echo esc_url($share_link['url']); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html($share_link['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if (has_post_thumbnail()) : ?>
                <div class="course-hero__image" data-bg-animate>
                    <?php the_post_thumbnail('bg-hero', ['class' => 'course-hero__media']); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="course-layout">
            <aside class="course-sidebar" data-bg-animate>
                <section class="course-sidebar__card course-sidebar__card--details">
                    <h2 class="course-sidebar__title"><?php esc_html_e('Kursdetails', 'beyondgotham-dark-child'); ?></h2>
                    <dl class="course-details">
                        <?php if ($start_date) : ?>
                            <div>
                                <dt><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($end_date) : ?>
                            <div>
                                <dt><?php esc_html_e('Ende', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html(date_i18n('d.m.Y', strtotime($end_date))); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($duration) : ?>
                            <div>
                                <dt><?php esc_html_e('Umfang', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html($duration); ?> <?php esc_html_e('Wochen', 'beyondgotham-dark-child'); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($location) : ?>
                            <div>
                                <dt><?php esc_html_e('Ort/Modus', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html($location); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($delivery) : ?>
                            <div>
                                <dt><?php esc_html_e('Format', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html(ucfirst($delivery)); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($language) : ?>
                            <div>
                                <dt><?php esc_html_e('Sprache', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html($language); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($voucher) : ?>
                            <div>
                                <dt><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php esc_html_e('Bildungsgutschein möglich', 'beyondgotham-dark-child'); ?></dd>
                            </div>
                        <?php endif; ?>
                        <div>
                            <dt><?php esc_html_e('Plätze', 'beyondgotham-dark-child'); ?></dt>
                            <dd>
                                <?php
                                if ($total_spots > 0) {
                                    printf(esc_html__('%1$d von %2$d frei', 'beyondgotham-dark-child'), (int) $available_spots, (int) $total_spots);
                                } else {
                                    esc_html_e('Flexible Kapazität', 'beyondgotham-dark-child');
                                }
                                ?>
                            </dd>
                        </div>
                    </dl>
                    <nav class="course-toc" aria-label="<?php esc_attr_e('Inhaltsverzeichnis', 'beyondgotham-dark-child'); ?>">
                        <ul>
                            <li><a href="#course-overview"><?php esc_html_e('Überblick', 'beyondgotham-dark-child'); ?></a></li>
                            <li><a href="#course-content"><?php esc_html_e('Inhalte & Module', 'beyondgotham-dark-child'); ?></a></li>
                            <li><a href="#course-enrollment"><?php esc_html_e('Anmeldung', 'beyondgotham-dark-child'); ?></a></li>
                        </ul>
                    </nav>
                </section>
                <?php if ($instructor_id) :
                    $instructor = get_post($instructor_id);
                    if ($instructor instanceof WP_Post) :
                        $experience    = get_post_meta($instructor_id, '_bg_experience', true);
                        $qualification = get_post_meta($instructor_id, '_bg_qualification', true);
                        ?>
                        <section class="course-sidebar__card course-sidebar__card--instructor">
                            <h2 class="course-sidebar__title"><?php esc_html_e('Dozent:in', 'beyondgotham-dark-child'); ?></h2>
                            <div class="course-instructor">
                                <?php if (has_post_thumbnail($instructor_id)) : ?>
                                    <div class="course-instructor__image">
                                        <?php echo get_the_post_thumbnail($instructor_id, 'bg-thumb'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="course-instructor__details">
                                    <h3 class="course-instructor__name"><?php echo esc_html(get_the_title($instructor_id)); ?></h3>
                                    <?php if ($qualification) : ?>
                                        <p class="course-instructor__meta"><strong><?php esc_html_e('Qualifikation:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($qualification); ?></p>
                                    <?php endif; ?>
                                    <?php if ($experience) : ?>
                                        <p class="course-instructor__meta"><strong><?php esc_html_e('Erfahrung:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($experience); ?> <?php esc_html_e('Jahre', 'beyondgotham-dark-child'); ?></p>
                                    <?php endif; ?>
                                    <a class="course-instructor__link" href="<?php echo esc_url(get_permalink($instructor_id)); ?>"><?php esc_html_e('Profil anzeigen', 'beyondgotham-dark-child'); ?></a>
                                </div>
                            </div>
                        </section>
                    <?php endif; endif; ?>

                <section class="course-sidebar__card course-sidebar__card--form" id="course-enrollment">
                    <h2 class="course-sidebar__title"><?php esc_html_e('Jetzt anmelden', 'beyondgotham-dark-child'); ?></h2>
                    <?php echo do_shortcode('[bg_course_enrollment course_id="' . absint($course_id) . '"]'); ?>
                </section>
            </aside>

            <article class="course-content" data-bg-animate>
                <section class="course-section" id="course-overview">
                    <h2 class="course-section__title"><?php esc_html_e('Kursüberblick', 'beyondgotham-dark-child'); ?></h2>
                    <div class="course-section__body">
                        <?php the_content(); ?>
                    </div>
                </section>

                <?php if (function_exists('have_rows') && have_rows('bg_course_modules')) : ?>
                    <section class="course-section" id="course-content">
                        <h2 class="course-section__title"><?php esc_html_e('Inhalte & Module', 'beyondgotham-dark-child'); ?></h2>
                        <div class="course-section__body">
                            <ul class="course-modules">
                                <?php while (have_rows('bg_course_modules')) : the_row(); ?>
                                    <li>
                                        <h3><?php echo esc_html(get_sub_field('title')); ?></h3>
                                        <p><?php echo esc_html(get_sub_field('description')); ?></p>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </section>
                <?php else : ?>
                    <section class="course-section" id="course-content">
                        <h2 class="course-section__title"><?php esc_html_e('Inhalte & Module', 'beyondgotham-dark-child'); ?></h2>
                        <div class="course-section__body">
                            <p><?php esc_html_e('Detaillierte Modulübersichten folgen in Kürze.', 'beyondgotham-dark-child'); ?></p>
                        </div>
                    </section>
                <?php endif; ?>
            </article>
        </div>
        <?php
        $related_args = [
            'post_type'      => 'bg_course',
            'posts_per_page' => 3,
            'post__not_in'   => [$course_id],
            'orderby'        => 'rand',
        ];

        if (!empty($category_terms) && !is_wp_error($category_terms)) {
            $related_args['tax_query'] = [
                [
                    'taxonomy' => 'bg_course_category',
                    'field'    => 'term_id',
                    'terms'    => wp_list_pluck($category_terms, 'term_id'),
                ],
            ];
        }

        $related_courses = new WP_Query($related_args);

        if ($related_courses->have_posts()) :
            ?>
            <section class="course-related" aria-label="<?php esc_attr_e('Weitere Kurse', 'beyondgotham-dark-child'); ?>">
                <div class="course-related__inner" data-bg-animate>
                    <h2 class="course-related__title"><?php esc_html_e('Weitere Kurse', 'beyondgotham-dark-child'); ?></h2>
                    <div class="course-related__grid bg-grid">
                        <?php
                        while ($related_courses->have_posts()) :
                            $related_courses->the_post();
                            ?>
                            <article class="bg-card course-related__card">
                                <a class="bg-card__media" href="<?php the_permalink(); ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('bg-card', ['class' => 'bg-card__image']);
                                    } else {
                                        echo '<span class="bg-card__placeholder" aria-hidden="true"></span>';
                                    }
                                    ?>
                                </a>
                                <div class="bg-card__body">
                                    <h3 class="bg-card__title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p class="bg-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>
                </div>
            </section>
            <?php
            wp_reset_postdata();
        endif;
        ?>
    </main>

    <?php
endwhile;

get_footer();
