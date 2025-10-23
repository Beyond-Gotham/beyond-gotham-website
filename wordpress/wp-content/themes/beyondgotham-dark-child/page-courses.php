<?php
/**
 * Template Name: Kursübersicht
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();

$selected_category = isset($_GET['category']) ? sanitize_text_field(wp_unslash($_GET['category'])) : '';
$selected_level    = isset($_GET['level']) ? sanitize_text_field(wp_unslash($_GET['level'])) : '';
$selected_voucher  = isset($_GET['voucher']) ? sanitize_text_field(wp_unslash($_GET['voucher'])) : '';

$paged = max(1, get_query_var('paged', 1));

$args = [
    'post_type'      => 'bg_course',
    'paged'          => $paged,
    'posts_per_page' => 9,
    'orderby'        => 'meta_value',
    'meta_key'       => '_bg_start_date',
    'order'          => 'ASC',
];

$tax_query = [];
if ($selected_category) {
    $tax_query[] = [
        'taxonomy' => 'bg_course_category',
        'field'    => 'slug',
        'terms'    => $selected_category,
    ];
}
if ($selected_level) {
    $tax_query[] = [
        'taxonomy' => 'bg_course_level',
        'field'    => 'slug',
        'terms'    => $selected_level,
    ];
}
if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

if ('1' === $selected_voucher) {
    $args['meta_query'][] = [
        'key'   => '_bg_bildungsgutschein',
        'value' => '1',
    ];
}

$courses = new WP_Query($args);
?>

<main class="courses" id="primary">
    <header class="courses__header" data-bg-animate>
        <h1 class="courses__title"><?php esc_html_e('Unsere Weiterbildungen', 'beyondgotham-dark-child'); ?></h1>
        <p class="courses__intro"><?php esc_html_e('Finde den passenden Kurs nach Kategorie, Level oder Fördermöglichkeit.', 'beyondgotham-dark-child'); ?></p>
    </header>

    <section class="courses__filters" data-bg-animate>
        <form class="courses-filter" method="get">
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-category"><?php esc_html_e('Kategorie', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-category" name="category">
                    <option value=""><?php esc_html_e('Alle Kategorien', 'beyondgotham-dark-child'); ?></option>
                    <?php
                    $categories = get_terms([
                        'taxonomy'   => 'bg_course_category',
                        'hide_empty' => false,
                    ]);
                    foreach ($categories as $category) {
                        printf('<option value="%1$s" %2$s>%3$s</option>', esc_attr($category->slug), selected($selected_category, $category->slug, false), esc_html($category->name));
                    }
                    ?>
                </select>
            </div>
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-level"><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-level" name="level">
                    <option value=""><?php esc_html_e('Alle Level', 'beyondgotham-dark-child'); ?></option>
                    <?php
                    $levels = get_terms([
                        'taxonomy'   => 'bg_course_level',
                        'hide_empty' => false,
                    ]);
                    foreach ($levels as $level) {
                        printf('<option value="%1$s" %2$s>%3$s</option>', esc_attr($level->slug), selected($selected_level, $level->slug, false), esc_html($level->name));
                    }
                    ?>
                </select>
            </div>
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-voucher"><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-voucher" name="voucher">
                    <option value=""><?php esc_html_e('Alle', 'beyondgotham-dark-child'); ?></option>
                    <option value="1" <?php selected($selected_voucher, '1'); ?>><?php esc_html_e('Bildungsgutschein', 'beyondgotham-dark-child'); ?></option>
                </select>
            </div>
            <div class="courses-filter__actions">
                <button class="bg-button bg-button--primary" type="submit"><?php esc_html_e('Filtern', 'beyondgotham-dark-child'); ?></button>
                <?php if ($selected_category || $selected_level || $selected_voucher) : ?>
                    <a class="courses-filter__reset" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Filter zurücksetzen', 'beyondgotham-dark-child'); ?></a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <section class="courses__list" aria-live="polite">
        <?php if ($courses->have_posts()) : ?>
            <div class="course-grid">
                <?php
                while ($courses->have_posts()) :
                    $courses->the_post();
                    $course_id = get_the_ID();

                    $total_spots     = bg_get_course_total_spots($course_id);
                    $available_spots = bg_get_course_available_spots($course_id);
                    $is_waitlist     = $total_spots > 0 && 0 === $available_spots;

                    $start_date = get_post_meta($course_id, '_bg_start_date', true);
                    $language   = get_post_meta($course_id, '_bg_language', true);
                    $location   = get_post_meta($course_id, '_bg_location', true);
                    $level      = wp_get_post_terms($course_id, 'bg_course_level');
                    $voucher    = get_post_meta($course_id, '_bg_bildungsgutschein', true);
                    ?>
                    <article class="course-card<?php echo $is_waitlist ? ' course-card--waitlist' : ''; ?>" data-bg-animate>
                        <header class="course-card__header">
                            <?php if (!empty($level) && !is_wp_error($level)) : ?>
                                <span class="course-card__badge"><?php echo esc_html($level[0]->name); ?></span>
                            <?php endif; ?>
                            <h2 class="course-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </header>
                        <div class="course-card__body">
                            <p class="course-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 26); ?></p>
                            <dl class="course-card__meta">
                                <?php if ($start_date) : ?>
                                    <div>
                                        <dt><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></dt>
                                        <dd><?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if ($language) : ?>
                                    <div>
                                        <dt><?php esc_html_e('Sprache', 'beyondgotham-dark-child'); ?></dt>
                                        <dd><?php echo esc_html($language); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if ($location) : ?>
                                    <div>
                                        <dt><?php esc_html_e('Ort', 'beyondgotham-dark-child'); ?></dt>
                                        <dd><?php echo esc_html($location); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if ($voucher) : ?>
                                    <div>
                                        <dt><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></dt>
                                        <dd><?php esc_html_e('Bildungsgutschein', 'beyondgotham-dark-child'); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                        <footer class="course-card__footer">
                            <span class="course-card__spots">
                                <?php
                                if ($total_spots > 0) {
                                    printf(
                                        esc_html(_n('%d Platz frei', '%d Plätze frei', $available_spots, 'beyondgotham-dark-child')),
                                        intval($available_spots)
                                    );
                                } else {
                                    esc_html_e('Flexible Teilnehmerzahl', 'beyondgotham-dark-child');
                                }
                                ?>
                            </span>
                            <?php if ($is_waitlist) : ?>
                                <span class="course-card__status course-card__status--waitlist"><?php esc_html_e('Warteliste', 'beyondgotham-dark-child'); ?></span>
                            <?php endif; ?>
                            <a class="bg-button bg-button--secondary" href="<?php the_permalink(); ?>"><?php esc_html_e('Details & Anmeldung', 'beyondgotham-dark-child'); ?></a>
                        </footer>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            $pagination = paginate_links([
                'total'   => $courses->max_num_pages,
                'current' => $paged,
                'type'    => 'array',
            ]);

            if (!empty($pagination)) :
                ?>
                <nav class="courses__pagination" aria-label="<?php esc_attr_e('Kursnavigation', 'beyondgotham-dark-child'); ?>">
                    <ul class="pagination">
                        <?php foreach ($pagination as $page_link) : ?>
                            <li class="pagination__item"><?php echo wp_kses_post($page_link); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php
            endif;
            ?>
        <?php else : ?>
            <p class="courses__empty" data-bg-animate><?php esc_html_e('Keine Kurse gefunden. Bitte passen Sie Ihre Filter an.', 'beyondgotham-dark-child'); ?></p>
        <?php endif; ?>
    </section>
</main>

<?php
wp_reset_postdata();
get_footer();
