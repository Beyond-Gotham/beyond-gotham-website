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
    $duration         = get_post_meta($course_id, '_bg_duration', true);
    $start_date       = get_post_meta($course_id, '_bg_start_date', true);
    $end_date         = get_post_meta($course_id, '_bg_end_date', true);
    $language         = get_post_meta($course_id, '_bg_language', true);
    $location         = get_post_meta($course_id, '_bg_location', true);
    $delivery         = get_post_meta($course_id, '_bg_delivery_mode', true);
    $voucher          = get_post_meta($course_id, '_bg_bildungsgutschein', true);
    $price            = get_post_meta($course_id, '_bg_price', true);
    $instructor_id    = (int) get_post_meta($course_id, '_bg_instructor_id', true);
    $level_terms      = wp_get_post_terms($course_id, 'bg_course_level');
    $category_terms   = wp_get_post_terms($course_id, 'bg_course_category');
    $level_label      = (!empty($level_terms) && !is_wp_error($level_terms)) ? $level_terms[0]->name : '';
    $category_label   = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';

    $spots_label = __('Platzanzahl nicht verfügbar', 'beyondgotham-dark-child');
    if ($total_spots > 0) {
        $spots_label = sprintf(
            /* translators: 1: available spots, 2: total spots */
            __('%1$d von %2$d frei', 'beyondgotham-dark-child'),
            (int) $available_spots,
            (int) $total_spots
        );
    } elseif (0 === (int) $total_spots) {
        $spots_label = __('Flexible Kapazität', 'beyondgotham-dark-child');
    }

    $is_waitlist = $total_spots > 0 && 0 === (int) $available_spots;
    ?>
    <main class="course-detail" id="main">
        <article <?php post_class('course-detail__article'); ?>>
            <header class="course-header" data-bg-animate>
                <?php if (function_exists('bg_breadcrumbs')) : ?>
                    <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--light']); ?>
                <?php endif; ?>
                <div class="course-header__content">
                    <?php if ($category_label) : ?>
                        <span class="course-header__badge"><?php echo esc_html($category_label); ?></span>
                    <?php endif; ?>
                    <h1 class="course-header__title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="course-header__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>
                    <ul class="course-header__meta">
                        <?php if ($level_label) : ?>
                            <li>
                                <span class="course-header__meta-label"><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></span>
                                <span><?php echo esc_html($level_label); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($duration) : ?>
                            <li>
                                <span class="course-header__meta-label"><?php esc_html_e('Dauer', 'beyondgotham-dark-child'); ?></span>
                                <span><?php echo esc_html($duration); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($start_date) : ?>
                            <li>
                                <span class="course-header__meta-label"><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></span>
                                <time datetime="<?php echo esc_attr(gmdate('c', strtotime($start_date))); ?>"><?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></time>
                            </li>
                        <?php endif; ?>
                        <li>
                            <span class="course-header__meta-label"><?php esc_html_e('Plätze', 'beyondgotham-dark-child'); ?></span>
                            <span><?php echo esc_html($spots_label); ?></span>
                        </li>
                    </ul>
                    <a class="bg-button bg-button--primary" href="#course-registration" data-bg-scroll>
                        <?php echo $is_waitlist ? esc_html__('Auf Warteliste setzen', 'beyondgotham-dark-child') : esc_html__('Jetzt anmelden', 'beyondgotham-dark-child'); ?>
                    </a>
                    <?php if ($is_waitlist) : ?>
                        <p class="course-header__status"><?php esc_html_e('Aktuell nur Warteliste verfügbar.', 'beyondgotham-dark-child'); ?></p>
                    <?php endif; ?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="course-header__media" data-bg-animate>
                        <?php the_post_thumbnail('bg-hero', ['class' => 'course-header__image']); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="course-detail__layout">
                <div class="course-detail__main" data-bg-animate>
                    <section class="course-section" id="course-overview">
                        <h2 class="course-section__title"><?php esc_html_e('Kursüberblick', 'beyondgotham-dark-child'); ?></h2>
                        <div class="course-section__body">
                            <?php the_content(); ?>
                        </div>
                    </section>

                    <section class="course-section" id="course-content">
                        <h2 class="course-section__title"><?php esc_html_e('Inhalte & Module', 'beyondgotham-dark-child'); ?></h2>
                        <div class="course-section__body">
                            <?php if (function_exists('have_rows') && have_rows('bg_course_modules')) : ?>
                                <ul class="course-modules">
                                    <?php while (have_rows('bg_course_modules')) : the_row(); ?>
                                        <li>
                                            <h3><?php echo esc_html(get_sub_field('title')); ?></h3>
                                            <p><?php echo esc_html(get_sub_field('description')); ?></p>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else : ?>
                                <p><?php esc_html_e('Detaillierte Modulübersichten folgen in Kürze.', 'beyondgotham-dark-child'); ?></p>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>

                <aside class="course-detail__sidebar" data-bg-animate>
                    <section class="course-meta">
                        <h2 class="course-meta__title"><?php esc_html_e('Kursdetails', 'beyondgotham-dark-child'); ?></h2>
                        <dl class="course-meta__list">
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
                                    <dt><?php esc_html_e('Dauer', 'beyondgotham-dark-child'); ?></dt>
                                    <dd><?php echo esc_html($duration); ?></dd>
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
                            <?php if ($price) : ?>
                                <div>
                                    <dt><?php esc_html_e('Teilnahmegebühr', 'beyondgotham-dark-child'); ?></dt>
                                    <dd><?php echo esc_html(number_format_i18n((float) $price, 2)); ?> €</dd>
                                </div>
                            <?php endif; ?>
                            <div>
                                <dt><?php esc_html_e('Verfügbarkeit', 'beyondgotham-dark-child'); ?></dt>
                                <dd><?php echo esc_html($spots_label); ?></dd>
                            </div>
                        </dl>
                    </section>

                    <?php if ($instructor_id) :
                        $instructor = get_post($instructor_id);
                        if ($instructor instanceof WP_Post) :
                            $experience    = get_post_meta($instructor_id, '_bg_experience', true);
                            $qualification = get_post_meta($instructor_id, '_bg_qualification', true);
                            ?>
                            <section class="instructor-profile">
                                <h2 class="instructor-profile__title"><?php esc_html_e('Dozent:innen', 'beyondgotham-dark-child'); ?></h2>
                                <div class="instructor-profile__inner">
                                    <?php if (has_post_thumbnail($instructor_id)) : ?>
                                        <div class="instructor-profile__media">
                                            <?php echo get_the_post_thumbnail($instructor_id, 'bg-thumb'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="instructor-profile__content">
                                        <h3 class="instructor-profile__name"><?php echo esc_html(get_the_title($instructor_id)); ?></h3>
                                        <?php if ($qualification) : ?>
                                            <p class="instructor-profile__meta"><strong><?php esc_html_e('Qualifikation:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($qualification); ?></p>
                                        <?php endif; ?>
                                        <?php if ($experience) : ?>
                                            <p class="instructor-profile__meta"><strong><?php esc_html_e('Erfahrung:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($experience); ?> <?php esc_html_e('Jahre', 'beyondgotham-dark-child'); ?></p>
                                        <?php endif; ?>
                                        <a class="instructor-profile__link" href="<?php echo esc_url(get_permalink($instructor_id)); ?>"><?php esc_html_e('Profil anzeigen', 'beyondgotham-dark-child'); ?></a>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>
                    <?php endif; ?>

                    <section class="course-register" id="course-registration">
                        <h2 class="course-register__title"><?php esc_html_e('Jetzt anmelden', 'beyondgotham-dark-child'); ?></h2>
                        <?php echo do_shortcode('[bg_course_enrollment course_id="' . absint($course_id) . '"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php if ($is_waitlist) : ?>
                            <p class="course-register__notice"><?php esc_html_e('Wir setzen uns mit dir in Verbindung, sobald ein Platz frei wird.', 'beyondgotham-dark-child'); ?></p>
                        <?php endif; ?>
                    </section>
                </aside>
            </div>
        </article>

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
                    <div class="course-related__grid course-grid bg-grid">
                        <?php
                        while ($related_courses->have_posts()) :
                            $related_courses->the_post();
                            get_template_part('template-parts/course-card');
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
