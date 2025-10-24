<?php
/**
 * Single template for bg_instructor.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $instructor_id = get_the_ID();
    $qualification = get_post_meta($instructor_id, '_bg_qualification', true);
    $experience    = get_post_meta($instructor_id, '_bg_experience', true);
    $email         = get_post_meta($instructor_id, '_bg_email', true);
    $linkedin      = get_post_meta($instructor_id, '_bg_linkedin', true);

    $courses = new WP_Query([
        'post_type'      => 'bg_course',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'   => '_bg_instructor_id',
                'value' => $instructor_id,
            ],
        ],
        'orderby'        => 'meta_value',
        'meta_key'       => '_bg_start_date',
        'order'          => 'ASC',
    ]);
    ?>
    <main class="instructor" id="main">
        <article <?php post_class('instructor-profile'); ?>>
            <header class="instructor-profile__header" data-bg-animate>
                <?php if (function_exists('bg_breadcrumbs')) : ?>
                    <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--compact']); ?>
                <?php endif; ?>
                <div class="instructor-profile__intro">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="instructor-profile__portrait">
                            <?php the_post_thumbnail('large', ['class' => 'instructor-profile__image']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="instructor-profile__headline">
                        <h1 class="instructor-profile__name"><?php the_title(); ?></h1>
                        <?php if ($qualification) : ?>
                            <p class="instructor-profile__qualification"><?php echo esc_html($qualification); ?></p>
                        <?php endif; ?>
                        <?php if ($experience) : ?>
                            <p class="instructor-profile__experience">
                                <?php
                                printf(
                                    /* translators: %s: years of experience */
                                    esc_html__('%s Jahre Erfahrung', 'beyondgotham-dark-child'),
                                    esc_html($experience)
                                );
                                ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($email || $linkedin) : ?>
                            <ul class="instructor-profile__contact">
                                <?php if ($email) : ?>
                                    <li>
                                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($linkedin) : ?>
                                    <li>
                                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener">
                                            <?php esc_html_e('LinkedIn-Profil', 'beyondgotham-dark-child'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <section class="instructor-profile__bio" data-bg-animate>
                <h2 class="instructor-profile__section-title"><?php esc_html_e('Über die Dozent:in', 'beyondgotham-dark-child'); ?></h2>
                <div class="instructor-profile__text">
                    <?php the_content(); ?>
                </div>
            </section>

            <section class="instructor-profile__courses" aria-live="polite" data-bg-animate>
                <h2 class="instructor-profile__section-title"><?php esc_html_e('Kurse mit dieser Dozent:in', 'beyondgotham-dark-child'); ?></h2>
                <?php if ($courses->have_posts()) : ?>
                    <div class="course-grid bg-grid">
                        <?php
                        while ($courses->have_posts()) :
                            $courses->the_post();
                            get_template_part('template-parts/course-card');
                        endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <p class="instructor-profile__empty"><?php esc_html_e('Aktuell sind keine Kurse zugewiesen.', 'beyondgotham-dark-child'); ?></p>
                <?php endif; ?>
            </section>
        </article>
    </main>
    <?php
    wp_reset_postdata();
endwhile;

get_footer();
