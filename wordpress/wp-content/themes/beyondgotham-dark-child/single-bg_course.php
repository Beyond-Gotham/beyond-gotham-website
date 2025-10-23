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
?>

<main class="course" id="primary">
    <header class="course-hero" data-bg-animate>
        <div class="course-hero__content">
            <nav class="course-hero__breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'beyondgotham-dark-child'); ?>">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></a>
                <span aria-hidden="true">/</span>
                <a href="<?php echo esc_url(home_url('/kurse/')); ?>"><?php esc_html_e('Kurse', 'beyondgotham-dark-child'); ?></a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>
            <?php if (!empty($category_terms) && !is_wp_error($category_terms)) : ?>
                <span class="course-hero__tag"><?php echo esc_html($category_terms[0]->name); ?></span>
            <?php endif; ?>
            <h1 class="course-hero__title"><?php the_title(); ?></h1>
            <?php if (has_excerpt()) : ?>
                <p class="course-hero__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
            <?php endif; ?>
            <dl class="course-hero__meta">
                <?php if (!empty($level_terms) && !is_wp_error($level_terms)) : ?>
                    <div>
                        <dt><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></dt>
                        <dd><?php echo esc_html($level_terms[0]->name); ?></dd>
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
                <?php if ($voucher) : ?>
                    <div>
                        <dt><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></dt>
                        <dd><?php esc_html_e('Bildungsgutschein', 'beyondgotham-dark-child'); ?></dd>
                    </div>
                <?php endif; ?>
            </dl>
            <div class="course-hero__actions">
                <a class="bg-button bg-button--primary" data-bg-scroll="#course-enrollment" href="#course-enrollment"><?php esc_html_e('Jetzt anmelden', 'beyondgotham-dark-child'); ?></a>
                <?php if ($is_waitlist) : ?>
                    <span class="course-hero__status"><?php esc_html_e('Warteliste aktiv', 'beyondgotham-dark-child'); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php if (has_post_thumbnail()) : ?>
            <div class="course-hero__image" data-bg-animate>
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="course-layout">
        <article class="course-content" data-bg-animate>
            <section class="course-section">
                <h2 class="course-section__title"><?php esc_html_e('Kursüberblick', 'beyondgotham-dark-child'); ?></h2>
                <div class="course-section__body">
                    <?php the_content(); ?>
                </div>
            </section>

            <?php if ($instructor_id) :
                $instructor = get_post($instructor_id);
                if ($instructor instanceof WP_Post) :
                    $experience  = get_post_meta($instructor_id, '_bg_experience', true);
                    $qualification = get_post_meta($instructor_id, '_bg_qualification', true);
                    ?>
                    <section class="course-section" data-bg-animate>
                        <h2 class="course-section__title"><?php esc_html_e('Dozent:in', 'beyondgotham-dark-child'); ?></h2>
                        <div class="course-instructor">
                            <?php if (has_post_thumbnail($instructor_id)) : ?>
                                <div class="course-instructor__image">
                                    <?php echo get_the_post_thumbnail($instructor_id, 'medium'); ?>
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
                                <p class="course-instructor__bio"><?php echo esc_html(wp_trim_words(strip_shortcodes($instructor->post_content), 50)); ?></p>
                                <a class="course-instructor__link" href="<?php echo esc_url(get_permalink($instructor_id)); ?>"><?php esc_html_e('Profil anzeigen', 'beyondgotham-dark-child'); ?></a>
                            </div>
                        </div>
                    </section>
                <?php endif; endif; ?>
        </article>

        <aside class="course-sidebar" data-bg-animate>
            <section class="course-sidebar__card">
                <h2 class="course-sidebar__title"><?php esc_html_e('Kursdetails', 'beyondgotham-dark-child'); ?></h2>
                <ul class="course-sidebar__list">
                    <?php if ($start_date) : ?>
                        <li><strong><?php esc_html_e('Start:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></li>
                    <?php endif; ?>
                    <?php if ($end_date) : ?>
                        <li><strong><?php esc_html_e('Ende:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html(date_i18n('d.m.Y', strtotime($end_date))); ?></li>
                    <?php endif; ?>
                    <?php if ($duration) : ?>
                        <li><strong><?php esc_html_e('Dauer:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($duration); ?> <?php esc_html_e('Wochen', 'beyondgotham-dark-child'); ?></li>
                    <?php endif; ?>
                    <?php if ($location) : ?>
                        <li><strong><?php esc_html_e('Ort / Remote:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($location); ?></li>
                    <?php endif; ?>
                    <?php if ($delivery) : ?>
                        <li><strong><?php esc_html_e('Format:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html(ucfirst($delivery)); ?></li>
                    <?php endif; ?>
                    <?php if ($total_spots > 0) : ?>
                        <li><strong><?php esc_html_e('Plätze frei:', 'beyondgotham-dark-child'); ?></strong> <?php echo esc_html($available_spots); ?> / <?php echo esc_html($total_spots); ?></li>
                    <?php endif; ?>
                </ul>
                <a class="bg-button bg-button--secondary" data-bg-scroll="#course-enrollment" href="#course-enrollment"><?php esc_html_e('Zum Formular', 'beyondgotham-dark-child'); ?></a>
            </section>

            <section class="course-sidebar__card course-sidebar__card--form" id="course-enrollment">
                <?php echo do_shortcode('[bg_course_enrollment course_id="' . absint($course_id) . '"]'); ?>
            </section>
        </aside>
    </div>
</main>

<?php
endwhile;

get_footer();
