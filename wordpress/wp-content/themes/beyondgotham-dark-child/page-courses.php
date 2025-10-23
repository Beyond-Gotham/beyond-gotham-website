<?php
/**
 * Template Name: Kursübersicht
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();

$selected_category = isset($_GET['cat']) ? sanitize_text_field(wp_unslash($_GET['cat'])) : '';
$selected_level    = isset($_GET['level']) ? sanitize_text_field(wp_unslash($_GET['level'])) : '';
$selected_funding  = isset($_GET['funding']) ? sanitize_text_field(wp_unslash($_GET['funding'])) : '';

$paged = max(1, get_query_var('paged', 1));

$base_query_args = [
    'post_type'      => 'bg_course',
    'posts_per_page' => 9,
    'paged'          => $paged,
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
    $base_query_args['tax_query'] = $tax_query;
}

if ($selected_funding) {
    $base_query_args['meta_query'] = [
        [
            'key'     => 'bg_course_funding',
            'value'   => $selected_funding,
            'compare' => '=',
        ],
    ];
}

$courses = new WP_Query($base_query_args);

$all_course_ids = get_posts([
    'post_type'      => 'bg_course',
    'fields'         => 'ids',
    'posts_per_page' => -1,
    'no_found_rows'  => true,
]);

$category_counts = [];
$level_counts    = [];
$funding_counts  = [];
$available_funding_options = [];

foreach ($all_course_ids as $course_id) {
    $course_categories = wp_get_post_terms($course_id, 'bg_course_category', ['fields' => 'slugs']);
    $course_levels     = wp_get_post_terms($course_id, 'bg_course_level', ['fields' => 'slugs']);
    $course_funding    = sanitize_text_field(get_post_meta($course_id, 'bg_course_funding', true));

    $matches_level    = !$selected_level || (is_array($course_levels) && in_array($selected_level, $course_levels, true));
    $matches_category = !$selected_category || (is_array($course_categories) && in_array($selected_category, $course_categories, true));
    $matches_funding  = !$selected_funding || ($course_funding && $selected_funding === $course_funding);

    if ($matches_level && $matches_funding && !empty($course_categories)) {
        foreach ((array) $course_categories as $slug) {
            if (!isset($category_counts[$slug])) {
                $category_counts[$slug] = 0;
            }
            $category_counts[$slug]++;
        }
    }

    if ($matches_category && $matches_funding && !empty($course_levels)) {
        foreach ((array) $course_levels as $slug) {
            if (!isset($level_counts[$slug])) {
                $level_counts[$slug] = 0;
            }
            $level_counts[$slug]++;
        }
    }

    if ($matches_category && $matches_level && $course_funding) {
        if (!isset($funding_counts[$course_funding])) {
            $funding_counts[$course_funding] = 0;
        }
        $funding_counts[$course_funding]++;
    }

    if ($course_funding) {
        $available_funding_options[$course_funding] = true;
    }
}

ksort($funding_counts, SORT_NATURAL | SORT_FLAG_CASE);
ksort($available_funding_options, SORT_NATURAL | SORT_FLAG_CASE);

$categories = get_terms([
    'taxonomy'   => 'bg_course_category',
    'hide_empty' => false,
]);
$levels = get_terms([
    'taxonomy'   => 'bg_course_level',
    'hide_empty' => false,
]);
?>

<main class="courses" id="main">
    <header class="courses__header" data-bg-animate>
        <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--compact']); ?>
        <h1 class="courses__title"><?php esc_html_e('Unsere Weiterbildungen', 'beyondgotham-dark-child'); ?></h1>
        <p class="courses__intro"><?php esc_html_e('Finde den passenden Kurs nach Kategorie, Level oder Fördermöglichkeit.', 'beyondgotham-dark-child'); ?></p>
    </header>

    <section class="courses__filters" role="region" aria-label="<?php esc_attr_e('Kursfilter', 'beyondgotham-dark-child'); ?>">
        <form class="courses-filter" method="get" data-bg-filter-form action="<?php echo esc_url(get_permalink()); ?>">
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-category"><?php esc_html_e('Kategorie', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-category" name="cat" data-bg-filter-select>
                    <option value=""<?php selected('', $selected_category); ?>><?php esc_html_e('Alle Kategorien', 'beyondgotham-dark-child'); ?></option>
                    <?php foreach ($categories as $category) :
                        $count = isset($category_counts[$category->slug]) ? $category_counts[$category->slug] : 0;
                        ?>
                        <option value="<?php echo esc_attr($category->slug); ?>" <?php selected($selected_category, $category->slug); ?>>
                            <?php echo esc_html(sprintf('%1$s (%2$d)', $category->name, $count)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-level"><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-level" name="level" data-bg-filter-select>
                    <option value=""<?php selected('', $selected_level); ?>><?php esc_html_e('Alle Level', 'beyondgotham-dark-child'); ?></option>
                    <?php foreach ($levels as $level) :
                        $count = isset($level_counts[$level->slug]) ? $level_counts[$level->slug] : 0;
                        ?>
                        <option value="<?php echo esc_attr($level->slug); ?>" <?php selected($selected_level, $level->slug); ?>>
                            <?php echo esc_html(sprintf('%1$s (%2$d)', $level->name, $count)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="courses-filter__group">
                <label class="courses-filter__label" for="courses-funding"><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></label>
                <select class="courses-filter__select" id="courses-funding" name="funding" data-bg-filter-select>
                    <option value=""<?php selected('', $selected_funding); ?>><?php esc_html_e('Alle Förderungen', 'beyondgotham-dark-child'); ?></option>
                    <?php foreach (array_keys($available_funding_options) as $funding_option) :
                        $count = isset($funding_counts[$funding_option]) ? $funding_counts[$funding_option] : 0;
                        ?>
                        <option value="<?php echo esc_attr($funding_option); ?>" <?php selected($selected_funding, $funding_option); ?>>
                            <?php echo esc_html(sprintf('%1$s (%2$d)', $funding_option, $count)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="courses-filter__actions">
                <button class="bg-button bg-button--secondary" type="button" data-bg-filter-reset><?php esc_html_e('Zurücksetzen', 'beyondgotham-dark-child'); ?></button>
            </div>
        </form>
    </section>

    <section class="courses__list" role="region" aria-live="polite" aria-label="<?php esc_attr_e('Kursangebote', 'beyondgotham-dark-child'); ?>">
        <div class="course-grid course-grid--skeleton" data-bg-skeleton aria-hidden="true">
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <article class="course-card course-card--skeleton">
                    <div class="course-card__media skeleton skeleton--thumb"></div>
                    <div class="course-card__body">
                        <div class="skeleton skeleton--badge"></div>
                        <div class="skeleton skeleton--title"></div>
                        <div class="skeleton skeleton--text"></div>
                        <div class="skeleton skeleton--text"></div>
                        <div class="skeleton skeleton--pill-row"></div>
                    </div>
                </article>
            <?php endfor; ?>
        </div>

        <?php if ($courses->have_posts()) : ?>
            <div class="course-grid bg-grid" data-bg-animate>
                <?php
                while ($courses->have_posts()) :
                    $courses->the_post();
                    $course_id = get_the_ID();

                    $total_spots     = bg_get_course_total_spots($course_id);
                    $available_spots = bg_get_course_available_spots($course_id);
                    $start_date      = get_post_meta($course_id, '_bg_start_date', true);
                    $location        = get_post_meta($course_id, '_bg_location', true);
                    $language        = get_post_meta($course_id, '_bg_language', true);
                    $funding_label   = get_post_meta($course_id, 'bg_course_funding', true);
                    $level_terms     = wp_get_post_terms($course_id, 'bg_course_level');
                    $level_label     = (!empty($level_terms) && !is_wp_error($level_terms)) ? $level_terms[0]->name : '';
                    ?>
                    <article class="course-card bg-card" data-bg-animate>
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
                            <?php if ($level_label) : ?>
                                <span class="bg-card__badge"><?php echo esc_html($level_label); ?></span>
                            <?php endif; ?>
                            <h3 class="bg-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="bg-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
                            <ul class="course-card__meta">
                                <?php if ($start_date) : ?>
                                    <li class="meta-pill">
                                        <span class="meta-pill__label"><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></span>
                                        <time datetime="<?php echo esc_attr(gmdate('c', strtotime($start_date))); ?>"><?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?></time>
                                    </li>
                                <?php endif; ?>
                                <?php if ($location) : ?>
                                    <li class="meta-pill">
                                        <span class="meta-pill__label"><?php esc_html_e('Ort', 'beyondgotham-dark-child'); ?></span>
                                        <span><?php echo esc_html($location); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if ($language) : ?>
                                    <li class="meta-pill">
                                        <span class="meta-pill__label"><?php esc_html_e('Sprache', 'beyondgotham-dark-child'); ?></span>
                                        <span><?php echo esc_html($language); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if ($funding_label) : ?>
                                    <li class="meta-pill">
                                        <span class="meta-pill__label"><?php esc_html_e('Förderung', 'beyondgotham-dark-child'); ?></span>
                                        <span><?php echo esc_html($funding_label); ?></span>
                                    </li>
                                <?php endif; ?>
                                <li class="meta-pill">
                                    <span class="meta-pill__label"><?php esc_html_e('Plätze', 'beyondgotham-dark-child'); ?></span>
                                    <span>
                                        <?php
                                        if ($total_spots > 0) {
                                            printf(esc_html__('%1$d von %2$d frei', 'beyondgotham-dark-child'), (int) $available_spots, (int) $total_spots);
                                        } else {
                                            esc_html_e('Flexible Kapazität', 'beyondgotham-dark-child');
                                        }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                            <div class="course-card__cta">
                                <a class="bg-button bg-button--primary" href="<?php the_permalink(); ?>"><?php esc_html_e('Details', 'beyondgotham-dark-child'); ?></a>
                            </div>
                        </div>
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
                'add_args'=> array_filter([
                    'cat'     => $selected_category,
                    'level'   => $selected_level,
                    'funding' => $selected_funding,
                ]),
            ]);

            if (!empty($pagination)) :
                ?>
                <nav class="courses__pagination" aria-label="<?php esc_attr_e('Weitere Kursseiten', 'beyondgotham-dark-child'); ?>">
                    <ul class="pagination">
                        <?php foreach ($pagination as $page_link) : ?>
                            <li class="pagination__item"><?php echo wp_kses_post($page_link); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else : ?>
            <div class="courses__empty" data-bg-animate>
                <p><?php esc_html_e('Keine Kurse gefunden. Passen Sie die Filter an oder setzen Sie sie zurück.', 'beyondgotham-dark-child'); ?></p>
                <button class="bg-button bg-button--secondary" type="button" data-bg-filter-reset><?php esc_html_e('Filter zurücksetzen', 'beyondgotham-dark-child'); ?></button>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
wp_reset_postdata();
get_footer();
